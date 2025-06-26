@if (Webkul\Product\Helpers\ProductType::hasVariants($product->type))
    {!! view_render_event('bagisto.shop.products.view.configurable-options.before', ['product' => $product]) !!}

    <v-product-configurable-options :errors="errors"></v-product-configurable-options>

    {!! view_render_event('bagisto.shop.products.view.configurable-options.after', ['product' => $product]) !!}

    @php
        $config = app('Webkul\Product\Helpers\ConfigurableOption')->getConfigurationConfig($product);
    @endphp
    @push('scripts')
        <script
            type="text/x-template"
            id="v-product-configurable-options-template"
        >
        <div v-if="selectedVariantName" class="mt-6 text-base font-semibold text-gray-800">
            <span class="text-gray-600">Selected Variant:</span>
            <span class="ml-3 text-black">@{{ selectedVariantName }}</span>
        </div>
        
            <div class="w-full">
                <input
                    type="hidden"
                    name="selected_configurable_option"
                    id="selected_configurable_option"
                    :value="selectedOptionVariant"
                    ref="selected_configurable_option"
                >
                <div
                    class="mt-5"
                    v-for='(attribute, index) in childAttributes'
                >
                    <table class="w-full text-sm text-left border border-gray-200 shadow-sm rounded-lg overflow-hidden">
                        <thead class="bg-gray-50 text-gray-700 font-medium">
                            <tr>
                                <th class="px-4 py-3">Pack Size</th>
                                <th class="px-4 py-3">Unit Price</th>
                                <th class="px-4 py-3">Total Price</th>
                                <th class="px-4 py-3">Quantity</th>
                                <th class="px-4 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(option, index) in attribute.options"
                                :key="index"
                                class="bg-white border-t hover:bg-gray-50 transition"
                            >
                                <td class="px-4 py-3 text-gray-800">
                                    <span v-if="option.allowedProducts?.length === 1">
                                        @{{ config.variant_names[option.allowedProducts[0]] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    <span v-if="option.allowedProducts?.length === 1">
                                        @{{ config.variant_prices[option.allowedProducts[0]]?.formatted_unit_price || '—' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    <span v-if="option.allowedProducts?.length === 1">
                                        @{{ config.variant_prices[option.allowedProducts[0]]?.final.formatted_price || '—' }}
                                    </span>
                                    <span v-else>—</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div
                                        v-if="option.allowedProducts && option.allowedProducts.length === 1"
                                        class="flex items-center space-x-2"
                                    >
                                        <button
                                            type="button"
                                            class="px-2 py-1 border rounded-md text-sm bg-gray-100 hover:bg-gray-200"
                                            @click="decreaseQuantity(option.allowedProducts[0])"
                                        >
                                            −
                                        </button>
                                        <input
                                            type="number"
                                            :id="'quantity' + option.allowedProducts[0]"
                                            :value="quantities[option.allowedProducts[0]] || 1"
                                            min="1"
                                            readonly
                                            class="w-16 text-center px-2 py-1 border rounded-md text-sm text-gray-700 focus:outline-none"
                                        />
                                        <button
                                            type="button"
                                            class="px-2 py-1 border rounded-md text-sm bg-gray-100 hover:bg-gray-200"
                                            @click="increaseQuantity(option.allowedProducts[0])"
                                        >
                                            +
                                        </button>
                                    </div>
                                </td>

                                <td class="px-4 py-2">
                                    <button
                                        type="button"
                                        class="secondary-button max-w-[120px] py-1.5 max-md:py-1 max-sm:rounded-sm max-sm:py-0.5 text-xs"
                                        @click="addToCart({ productId: {{$product->id}}, optionId: option.id ,attribute:attribute })"
                                    >
                                        Add to Cart
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <v-error-message
                        :name="'super_attribute[' + attribute.id + ']'"
                        v-slot="{ message }"
                    >
                        <p class="mt-1 text-xs italic text-red-500">
                            @{{ message }}
                        </p>
                    </v-error-message>
                </div>
            </div>
        </script>

        <script type="module">
            let galleryImages = @json(product_image()->getGalleryImages($product));

            app.component('v-product-configurable-options', {
                template: '#v-product-configurable-options-template',

                props: ['errors'],

                data() {
                    return {
                        config: @json(app('Webkul\Product\Helpers\ConfigurableOption')->getConfigurationConfig($product)),

                        childAttributes: [],

                        quantities: {},

                        possibleOptionVariant: null,

                        selectedOptionVariant: '',

                        selectedVariantName: '',

                        galleryImages: [],
                    }
                },

                mounted() {
                    let attributes = JSON.parse(JSON.stringify(this.config)).attributes.slice();
                     console.log(attributes);
                    console.log(attributes[0].options);
                    
                    let index = attributes.length;

                    while (index--) {
                        let attribute = attributes[index];

                        attribute.options = [];

                        if (index) {
                            attribute.disabled = true;
                        } else {
                            this.fillAttributeOptions(attribute);
                        }

                        attribute = Object.assign(attribute, {
                            childAttributes: this.childAttributes.slice(),
                            prevAttribute: attributes[index - 1],
                            nextAttribute: attributes[index + 1]
                        });

                        this.childAttributes.unshift(attribute);
                    }
                },

                methods: {
                     increaseQuantity(productId) {
                        if (!this.quantities[productId]) {
                            this.quantities[productId] = 1;
                        }
                        this.quantities[productId]++;
                    },
                    decreaseQuantity(productId) {
                        if (!this.quantities[productId] || this.quantities[productId] <= 1) {
                            this.quantities[productId] = 1;
                        } else {
                            this.quantities[productId]--;
                        }
                    },
                    configure(attribute, optionId) {
                
                        this.possibleOptionVariant = this.getPossibleOptionVariant(attribute, optionId);

                        if (optionId) {
                            attribute.selectedValue = optionId;

                            if (attribute.nextAttribute) {
                                attribute.nextAttribute.disabled = false;

                                this.clearAttributeSelection(attribute.nextAttribute);

                                this.fillAttributeOptions(attribute.nextAttribute);

                                this.resetChildAttributes(attribute.nextAttribute);
                            } else {
                                this.selectedOptionVariant = this.possibleOptionVariant;
                                this.selectedVariantName = this.config.variant_names[this.possibleOptionVariant] || ''; // ✅ added

                            }
                        } else {
                            this.clearAttributeSelection(attribute);
                            this.clearAttributeSelection(attribute.nextAttribute);
                            this.resetChildAttributes(attribute);
                            this.selectedVariantName = '';
                        }

                        this.reloadPrice();
                        this.reloadImages();
                    },
                    addToCart(params) {
                        this.possibleOptionVariant = this.getPossibleOptionVariant(params.attribute, params.optionId);
                        let quantity = document.querySelector('#quantity'+this.possibleOptionVariant).value;

                        const operation = this.is_buy_now ? 'buyNow' : 'addToCart';

                        let formData = new FormData();
                        formData.append('product_id', params.productId);
                        formData.append('quantity', quantity || 1);
                        formData.append('selected_configurable_option', this.possibleOptionVariant);
                        formData.append('is_buy_now', this.is_buy_now ? 1 : 0);

                        this.$axios.post('{{ route("shop.api.checkout.cart.store") }}', formData, {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            })
                            .then(response => {
                                if (response.data.message) {
                                    this.$emitter.emit('update-mini-cart', response.data.data);

                                    this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                    if (response.data.redirect) {
                                        window.location.href= response.data.redirect;
                                    }
                                } else {
                                    this.$emitter.emit('add-flash', { type: 'warning', message: response.data.data.message });
                                }

                                this.isStoring[operation] = false;
                            })
                            .catch(error => {

                                this.$emitter.emit('add-flash', { type: 'warning', message: error.response.data.message });
                            });
                    },
                    getPossibleOptionVariant(attribute, optionId) {
                        let matchedOptions = attribute.options.filter(option => option.id == optionId);

                        if (matchedOptions[0]?.allowedProducts) {
                            return matchedOptions[0].allowedProducts[0];
                        }

                        return undefined;
                    },

                    fillAttributeOptions(attribute) {
                        let options = this.config.attributes.find(tempAttribute => tempAttribute.id === attribute.id)?.options;

                        if (! options) {
                            return;
                        }

                        let prevAttributeSelectedOption = attribute.prevAttribute?.options.find(option => option.id == attribute.prevAttribute.selectedValue);

                        let index = 0;

                        for (let i = 0; i < options.length; i++) {
                            let allowedProducts = [];

                            if (prevAttributeSelectedOption) {
                                for (let j = 0; j < options[i].products.length; j++) {
                                    if (prevAttributeSelectedOption.allowedProducts && prevAttributeSelectedOption.allowedProducts.includes(options[i].products[j])) {
                                        allowedProducts.push(options[i].products[j]);
                                    }
                                }
                            } else {
                                allowedProducts = options[i].products.slice(0);
                            }

                            if (allowedProducts.length > 0) {
                                options[i].allowedProducts = allowedProducts;

                                attribute.options[index++] = options[i];
                            }
                        }
                    },
                    resetChildAttributes(attribute) {
                        if (! attribute.childAttributes) return;

                        attribute.childAttributes.forEach(set => {
                            set.selectedValue = null;
                            set.disabled = true;
                        });
                    },

                    clearAttributeSelection(attribute) {
                        if (! attribute) return;

                        attribute.selectedValue = null;
                        this.selectedOptionVariant = null;
                    },

                    reloadPrice(attribute) {
                        let selectedOptionCount = this.childAttributes.filter(attribute => attribute.selectedValue).length;

                        let finalPrice = document.querySelector('.final-price');
                        let regularPrice = document.querySelector('.regular-price');

                        let configVariant = this.config.variant_prices[this.possibleOptionVariant];

                        if (this.childAttributes.length == selectedOptionCount) {
                            document.querySelector('.price-label').style.display = 'none';
                            let vname = this.selectedVariantName.split('x')[0]
                            if(vname != undefined && vname != null && vname != '') {
                            

                                let numericVname = parseFloat(vname) || 1; // Ensure vname is numeric or default to 1
                                 var updatedPrice = Math.round(configVariant.regular.price / numericVname);
                                 var updatedPriceFormated = configVariant.final.formatted_price.replace(/\d+/, updatedPrice);
  
                            }
                            
                            if (parseInt(configVariant.regular.price) > parseInt(configVariant.final.price)) {
                                regularPrice.style.display = 'block';
                                finalPrice.innerHTML = updatedPrice ? updatedPriceFormated :configVariant.final.formatted_price;
                                regularPrice.innerHTML = updatedPriceFormated?updatedPriceFormated: configVariant.regular.formatted_price;
                            } else {
                                 
                                finalPrice.innerHTML = updatedPriceFormated?updatedPriceFormated:configVariant.regular.formatted_price;
                                regularPrice.style.display = 'none';
                            }

                            this.$emitter.emit('configurable-variant-selected-event', this.possibleOptionVariant);
                        } else {
                            document.querySelector('.price-label').style.display = 'inline-block';
                            finalPrice.innerHTML = this.config.regular.formatted_price;

                            this.$emitter.emit('configurable-variant-selected-event', 0);
                        }
                    },

                    reloadImages() {
                        galleryImages.splice(0, galleryImages.length);

                        if (this.possibleOptionVariant) {
                            this.config.variant_images[this.possibleOptionVariant].forEach(image => galleryImages.push(image));
                            this.config.variant_videos[this.possibleOptionVariant].forEach(video => galleryImages.push(video));
                        }

                        this.galleryImages.forEach(image => galleryImages.push(image));

                        if (galleryImages.length) {
                            this.$parent.$parent.$refs.gallery.media.images = [...galleryImages];
                        }

                        this.$emitter.emit('configurable-variant-update-images-event', galleryImages);
                    },
                }
            });
        </script>
    @endpush
@endif