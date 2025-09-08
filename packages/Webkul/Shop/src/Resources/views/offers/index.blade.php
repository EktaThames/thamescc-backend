<x-shop::layouts>
    <x-slot:title>
        {{ __('Special Offers') }}
    </x-slot:title>

    <div class="container px-[60px] max-lg:px-8 max-sm:px-4 py-8">
        <div class="flex items-center justify-between mb-6 max-sm:mb-4">
            <h1 class="text-2xl font-bold max-sm:text-base">
                {{ __('Special Offers') }}
            </h1>

            <a href="{{ route('shop.offers.pdf') }}" target="_blank"
                class="secondary-button block w-max rounded-2xl px-11 py-3 text-center text-base max-md:rounded-lg max-md:text-sm max-sm:px-7 max-sm:py-2">
                <i class="icon download-icon"></i> {{ __('Download Offers as PDF') }}
            </a>
        </div>
    </div>

    <!-- Offers Listing -->
    <v-offers :initial-products='@json($initialProducts)'></v-offers>
   @push('styles')
<style>
     
    /* Hide hover overlay by default */
    .product-card .absolute {
        position: absolute !important;
        inset: 0;
        background: rgba(255, 255, 255, 0.0) !important; /* transparent */
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }

    /* Show only on hover */
    .product-card:hover .absolute {
        opacity: 1;
    }

    /* Ensure overlay stays inside image wrapper only */
    .product-card .image-wrapper {
        position: relative;
        overflow: hidden;
    }
     /* Remove the heart/wishlist icon inside the product image */
    .product-card .product-actions,
    .product-card .wishlist-btn,
    .product-card .compare-btn,
    .product-card button[title="Add to Wishlist"],
    .product-card button[aria-label*="wishlist"],
    .product-card button[aria-label*="compare"] {
        display: none !important;
    }
</style>
@endpush





    @pushOnce('scripts')
        <script type="text/x-template" id="v-offers-template">
            <div class="container px-[60px] max-lg:px-8 max-sm:px-4">
                <div>
                    <!-- Desktop Toolbar (inside component to capture filter events) -->
                    <div class="max-md:hidden">
                        @include('shop::categories.toolbar')
                    </div>

                    <!-- Product List Card Container -->
                    <div
                        class="mt-8 grid grid-cols-1 gap-6"
                        v-if="filters.toolbar.mode === 'list'"
                    >
                        <!-- Product Card Shimmer Effect -->
                        <template v-if="isLoading">
                            <x-shop::shimmer.products.cards.list count="12" />
                        </template>

                        <!-- Product Card Listing -->
                        <template v-else>
                            <template v-if="products.length">
                                <x-shop::products.card
                                    ::mode="'list'"
                                    v-for="product in products"
                                />
                            </template>

                            <!-- Empty Products Container -->
                            <template v-else>
                                <div class="m-auto grid w-full place-content-center items-center justify-items-center py-32 text-center">
                                    <img
                                        class="max-sm:h-[100px] max-sm:w-[100px]"
                                        src="{{ bagisto_asset('images/thank-you.png') }}"
                                        alt="Empty result"
                                    />

                                    <p
                                        class="text-xl max-sm:text-sm"
                                        role="heading"
                                    >
                                        @lang('shop::app.categories.view.empty')
                                    </p>
                                </div>
                            </template>
                        </template>
                    </div>

                    <!-- Product Grid Card Container -->
                    <div v-else>
                        <!-- Product Card Shimmer Effect -->
                        <template v-if="isLoading">
                            <div class="mt-8 grid grid-cols-3 gap-8 max-1060:grid-cols-2 max-md:gap-x-4 max-sm:mt-5 max-sm:justify-items-center max-sm:gap-y-5">
                                <x-shop::shimmer.products.cards.grid count="12" />
                            </div>
                        </template>

                        <!-- Product Card Listing -->
                        <template v-else>
                            <template v-if="products.length">
                                <div class="mt-8 grid grid-cols-3 gap-8 max-1060:grid-cols-2 max-md:mt-5 max-md:justify-items-center max-md:gap-x-4 max-md:gap-y-5">
   <div v-for="product in products" :key="product.id" class="product-card relative group overflow-hidden rounded-2xl">
    
    <div class="image-wrapper relative">
        <x-shop::products.card
            ::mode="'grid'"
            :navigation-link="route('shop.search.index')"
        />
    </div>

</div>

</div>



                            </template>

                            <!-- Empty Products Container -->
                            <template v-else>
                                <div class="m-auto grid w-full place-content-center items-center justify-items-center py-32 text-center">
                                    <img
                                        class="max-sm:h-[100px] max-sm:w-[100px]"
                                        src="{{ bagisto_asset('images/thank-you.png') }}"
                                        alt="Empty result"
                                    />

                                    <p
                                        class="text-xl max-sm:text-sm"
                                        role="heading"
                                    >
                                        @lang('shop::app.categories.view.empty')
                                    </p>
                                </div>
                            </template>
                        </template>
                    </div>

                    <!-- Load More Button -->
                    <button
                        class="secondary-button mx-auto mt-[60px] block w-max rounded-2xl px-11 py-3 text-center text-base max-md:rounded-lg max-md:text-sm max-sm:mt-7 max-sm:px-7 max-sm:py-2"
                        @click="loadMore"
                        v-if="links.next"
                    >
                        @lang('shop::app.categories.view.load-more')
                    </button>
                </div>
            </div>
        </script>

        <script type="module">
            app.component('v-offers', {
                template: '#v-offers-template',

                props: {
                    initialProducts: {
                        type: Array,
                        default: () => [],
                    },
                },

                data() {
                    return {
                        isMobile: window.innerWidth <= 767,
                        isLoading: true,
                        products: [...this.initialProducts],
                        links: {},
                        filters: {
                            toolbar: {},

                            filter: {},
                        },
                    };
                },

                computed: {
                    queryParams() {
                        return this.removeJsonEmptyValues({
                            ...this.filters.toolbar
                        });
                    },

                    queryString() {
                        return this.jsonToQueryString(this.queryParams);
                    },
                },

                watch: {
                    queryParams: {
                        deep: true,
                        handler() {
                            this.getProducts();
                        },
                    },

                    queryString() {
                        window.history.pushState({}, '', '?' + this.queryString);
                    },
                },

                mounted() {
                    this.getProducts(true);
                },

                methods: {
                    setFilters(type, payload) {
                        this.filters[type] = payload;
                    },

                    getProducts(isFirstLoad = false) {
                        this.isLoading = true;

                        this.$axios.get("{{ route('shop.api.offers.index') }}", {
                                params: this.queryParams,
                            })
                            .then((response) => {
                                this.links = response.data.links;

                                if (isFirstLoad && this.products.length) {
                                    this.isLoading = false;
                                    return;
                                }

                                this.products = response.data.data;
                            })
                            .finally(() => (this.isLoading = false));
                    },

                    loadMore() {
                        if (!this.links.next) return;

                        this.$axios.get(this.links.next)
                            .then((response) => {
                                this.products = [...this.products, ...response.data.data];
                                this.links = response.data.links;
                            })
                            .catch((error) => console.log(error));
                    },

                    removeJsonEmptyValues(params) {
                        const clone = {
                            ...params
                        };
                        Object.keys(clone).forEach((key) => {
                            if ((!clone[key] && clone[key] !== undefined)) {
                                delete clone[key];
                            }

                            if (Array.isArray(clone[key])) {
                                clone[key] = clone[key].join(',');
                            }
                        });
                        return clone;
                    },

                    jsonToQueryString(params) {
                        const p = new URLSearchParams();
                        for (const key in params) {
                            p.append(key, params[key]);
                        }
                        return p.toString();
                    },
                },
            });
        </script>
        
    @endPushOnce
</x-shop::layouts>
