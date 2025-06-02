<!-- SEO Meta Content -->
@push('meta')
    <meta
        name="description"
        content="@lang('shop::app.customers.signup-form.page-title')"
    />

    <meta
        name="keywords"
        content="@lang('shop::app.customers.signup-form.page-title')"
    />
@endPush

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.signup-form.page-title')
    </x-slot>

	<div class="container mt-20 max-1180:px-5 max-md:mt-12">
        {!! view_render_event('bagisto.shop.customers.sign-up.logo.before') !!}

        <!-- Company Logo -->
        <div class="flex items-center gap-x-14 max-[1180px]:gap-x-9">
            <a
                href="{{ route('shop.home.index') }}"
                class="m-[0_auto_20px_auto]"
                aria-label="@lang('shop::app.customers.signup-form.bagisto')"
            >
                <img
                    src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                    alt="{{ config('app.name') }}"
                    width="131"
                    height="29"
                >
            </a>
        </div>

        {!! view_render_event('bagisto.shop.customers.sign-up.logo.before') !!}

        <!-- Form Container -->
		<div class="m-auto w-full max-w-[870px] rounded-xl border border-zinc-200 p-16 px-[90px] max-md:px-8 max-md:py-8 max-sm:border-none max-sm:p-0">
			<h1 class="font-dmserif text-4xl max-md:text-3xl max-sm:text-xl">
                @lang('shop::app.customers.signup-form.page-title')
            </h1>

			<p class="mt-4 text-xl text-zinc-500 max-sm:mt-0 max-sm:text-sm">
                @lang('shop::app.customers.signup-form.form-signup-text')
            </p>

            <div class="mt-14 rounded max-sm:mt-8">
                <x-shop::form :action="route('shop.customers.register.store')">
                    {!! view_render_event('bagisto.shop.customers.signup_form_controls.before') !!}

                    <!-- First Name -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required">
                            @lang('shop::app.customers.signup-form.first-name')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="text"
                            class="px-6 py-4 max-md:py-3 max-sm:py-2"
                            name="first_name"
                            rules="required"
                            :value="old('first_name')"
                            :label="trans('shop::app.customers.signup-form.first-name')"
                            :placeholder="trans('shop::app.customers.signup-form.first-name')"
                            :aria-label="trans('shop::app.customers.signup-form.first-name')"
                            aria-required="true"
                        />

                        <x-shop::form.control-group.error control-name="first_name" />
                    </x-shop::form.control-group>

                    {!! view_render_event('bagisto.shop.customers.signup_form.first_name.after') !!}

                    <!-- Last Name -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required">
                            @lang('shop::app.customers.signup-form.last-name')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="text"
                            class="px-6 py-4 max-md:py-3 max-sm:py-2"
                            name="last_name"
                            rules="required"
                            :value="old('last_name')"
                            :label="trans('shop::app.customers.signup-form.last-name')"
                            :placeholder="trans('shop::app.customers.signup-form.last-name')"
                            :aria-label="trans('shop::app.customers.signup-form.last-name')"
                            aria-required="true"
                        />

                        <x-shop::form.control-group.error control-name="last_name" />
                    </x-shop::form.control-group>

                    {!! view_render_event('bagisto.shop.customers.signup_form.last_name.after') !!}

                    <!-- Email -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required">
                            @lang('shop::app.customers.signup-form.email')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="email"
                            class="px-6 py-4 max-md:py-3 max-sm:py-2"
                            name="email"
                            rules="required|email"
                            :value="old('email')"
                            :label="trans('shop::app.customers.signup-form.email')"
                            placeholder="email@example.com"
                            :aria-label="trans('shop::app.customers.signup-form.email')"
                            aria-required="true"
                        />

                        <x-shop::form.control-group.error control-name="email" />
                    </x-shop::form.control-group>

                    {!! view_render_event('bagisto.shop.customers.signup_form.email.after') !!}

                    <!-- Password -->
                    <x-shop::form.control-group class="mb-6">
                        <x-shop::form.control-group.label class="required">
                            @lang('shop::app.customers.signup-form.password')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="password"
                            class="px-6 py-4 max-md:py-3 max-sm:py-2"
                            name="password"
                            rules="required|min:6"
                            :value="old('password')"
                            :label="trans('shop::app.customers.signup-form.password')"
                            :placeholder="trans('shop::app.customers.signup-form.password')"
                            ref="password"
                            :aria-label="trans('shop::app.customers.signup-form.password')"
                            aria-required="true"
                        />

                        <x-shop::form.control-group.error control-name="password" />
                    </x-shop::form.control-group>

                    {!! view_render_event('bagisto.shop.customers.signup_form.password.after') !!}

                    <!-- Confirm Password -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label>
                            @lang('shop::app.customers.signup-form.confirm-pass')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="password"
                            class="px-6 py-4 max-md:py-3 max-sm:py-2"
                            name="password_confirmation"
                            rules="confirmed:@password"
                            value=""
                            :label="trans('shop::app.customers.signup-form.password')"
                            :placeholder="trans('shop::app.customers.signup-form.confirm-pass')"
                            :aria-label="trans('shop::app.customers.signup-form.confirm-pass')"
                            aria-required="true"
                        />

                        <x-shop::form.control-group.error control-name="password_confirmation" />
                    </x-shop::form.control-group>
                    

                    {!! view_render_event('bagisto.shop.customers.signup_form.password_confirmation.after') !!}
                    <!-- Trade Customer Fields -->

                    {{-- Business Trading Name --}}
<x-shop::form.control-group>
    <x-shop::form.control-group.label class="required">Business Trading Name</x-shop::form.control-group.label>

    <x-shop::form.control-group.control
        type="text"
        name="business_trading_name"
        class="px-6 py-4"
        rules="required"
        :value="old('business_trading_name', $customer->business_trading_name ?? '')"
    />

    <x-shop::form.control-group.error control-name="business_trading_name" />
</x-shop::form.control-group>

{{-- Type of Business --}}
<x-shop::form.control-group>
    <x-shop::form.control-group.label class="required">Type of Business</x-shop::form.control-group.label>

    <select name="type_of_business" class="form-control px-6 py-4" required>
        <option value="">-- Select --</option>
        <option value="Off license" {{ old('type_of_business', $customer->type_of_business ?? '') == 'Off license' ? 'selected' : '' }}>Off license</option>
        <option value="Supermarket" {{ old('type_of_business', $customer->type_of_business ?? '') == 'Supermarket' ? 'selected' : '' }}>Supermarket</option>
        <option value="Restaurant or Pub" {{ old('type_of_business', $customer->type_of_business ?? '') == 'Restaurant or Pub' ? 'selected' : '' }}>Restaurant or Pub</option>
        <option value="Grocers" {{ old('type_of_business', $customer->type_of_business ?? '') == 'Grocers' ? 'selected' : '' }}>Grocers</option>
        <option value="Other" {{ old('type_of_business', $customer->type_of_business ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
    </select>
</x-shop::form.control-group>

{{-- Entity Type --}}
<x-shop::form.control-group>
    <x-shop::form.control-group.label class="required">Entity Type</x-shop::form.control-group.label>

    <select name="entity" class="form-control px-6 py-4" required>
        <option value="">-- Select --</option>
        <option value="Limited Company" {{ old('entity', $customer->entity ?? '') == 'Limited Company' ? 'selected' : '' }}>Limited Company</option>
        <option value="Sole Proprietorship" {{ old('entity', $customer->entity ?? '') == 'Sole Proprietorship' ? 'selected' : '' }}>Sole Proprietorship</option>
        <option value="Partnership" {{ old('entity', $customer->entity ?? '') == 'Partnership' ? 'selected' : '' }}>Partnership</option>
    </select>
</x-shop::form.control-group>

{{-- Trading Address --}}
<x-shop::form.control-group>
    <x-shop::form.control-group.label class="required">Street Address</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="text"
        name="trading_street"
        rules="required"
        :value="old('trading_street', $customer->trading_street ?? '')"
    />
</x-shop::form.control-group>

<x-shop::form.control-group>
    <x-shop::form.control-group.label>Address Line 2</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="text"
        name="trading_address_line_2"
        :value="old('trading_address_line_2', $customer->trading_address_line_2 ?? '')"
    />
</x-shop::form.control-group>

<x-shop::form.control-group>
    <x-shop::form.control-group.label class="required">City</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="text"
        name="trading_city"
        rules="required"
        :value="old('trading_city', $customer->trading_city ?? '')"
    />
</x-shop::form.control-group>

<x-shop::form.control-group>
    <x-shop::form.control-group.label class="required">Postal Code</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="text"
        name="trading_postal_code"
        rules="required"
        :value="old('trading_postal_code', $customer->trading_postal_code ?? '')"
    />
</x-shop::form.control-group>

<x-shop::form.control-group>
    <x-shop::form.control-group.label class="required">Country</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="text"
        name="trading_country"
        rules="required"
        :value="old('trading_country', $customer->trading_country ?? '')"
    />
</x-shop::form.control-group>

<x-shop::form.control-group>
    <x-shop::form.control-group.label class="required">Phone</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="text"
        name="trading_phone"
        rules="required"
        :value="old('trading_phone', $customer->trading_phone ?? '')"
    />
</x-shop::form.control-group>

<x-shop::form.control-group>
    <x-shop::form.control-group.label class="required">Trading Email</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="email"
        name="trading_email"
        rules="required|email"
        :value="old('trading_email', $customer->trading_email ?? '')"
    />
</x-shop::form.control-group>

{{-- Owner Name --}}
<x-shop::form.control-group>
    <x-shop::form.control-group.label>Owner First Name</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="text"
        name="owner_first_name"
        :value="old('owner_first_name', $customer->owner_first_name ?? '')"
    />
</x-shop::form.control-group>

<x-shop::form.control-group>
    <x-shop::form.control-group.label>Owner Last Name</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="text"
        name="owner_last_name"
        :value="old('owner_last_name', $customer->owner_last_name ?? '')"
    />
</x-shop::form.control-group>

{{-- Owner Address (if different) --}}
<x-shop::form.control-group>
    <x-shop::form.control-group.label>Owner Street Address</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="text"
        name="owner_street"
        :value="old('owner_street', $customer->owner_street ?? '')"
    />
</x-shop::form.control-group>

<x-shop::form.control-group>
    <x-shop::form.control-group.label>Owner Address Line 2</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="text"
        name="owner_address_line_2"
        :value="old('owner_address_line_2', $customer->owner_address_line_2 ?? '')"
    />
</x-shop::form.control-group>

<x-shop::form.control-group>
    <x-shop::form.control-group.label>Owner City</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="text"
        name="owner_city"
        :value="old('owner_city', $customer->owner_city ?? '')"
    />
</x-shop::form.control-group>

<x-shop::form.control-group>
    <x-shop::form.control-group.label>Owner Postal Code</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="text"
        name="owner_postal_code"
        :value="old('owner_postal_code', $customer->owner_postal_code ?? '')"
    />
</x-shop::form.control-group>

<x-shop::form.control-group>
    <x-shop::form.control-group.label>Owner Country</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="text"
        name="owner_country"
        :value="old('owner_country', $customer->owner_country ?? '')"
    />
</x-shop::form.control-group>

<x-shop::form.control-group>
    <x-shop::form.control-group.label class="required">Owner Phone</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="text"
        name="owner_phone"
        rules="required"
        :value="old('owner_phone', $customer->owner_phone ?? '')"
    />
</x-shop::form.control-group>

<x-shop::form.control-group>
    <x-shop::form.control-group.label class="required">Owner Email</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="email"
        name="owner_email"
        rules="required|email"
        :value="old('owner_email', $customer->owner_email ?? '')"
    />
</x-shop::form.control-group>

<x-shop::form.control-group>
    <x-shop::form.control-group.label class="required">VAT Registration Number</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="text"
        name="vat_number"
        rules="required"
        :value="old('vat_number', $customer->vat_number ?? '')"
    />
</x-shop::form.control-group>

<x-shop::form.control-group>
    <label>
        <input type="checkbox" name="not_vat_registered" value="1" {{ old('not_vat_registered', $customer->not_vat_registered ?? false) ? 'checked' : '' }} />
        I'm not VAT registered
    </label>
</x-shop::form.control-group>

<x-shop::form.control-group>
    <x-shop::form.control-group.label>EOID</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="text"
        name="eoid"
        :value="old('eoid', $customer->eoid ?? '')"
    />
</x-shop::form.control-group>

<x-shop::form.control-group>
    <x-shop::form.control-group.label>FID</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="text"
        name="fid"
        :value="old('fid', $customer->fid ?? '')"
    />
</x-shop::form.control-group>

<x-shop::form.control-group>
    <x-shop::form.control-group.label>Company Registration Number</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="text"
        name="company_registration_number"
        :value="old('company_registration_number', $customer->company_registration_number ?? '')"
    />
</x-shop::form.control-group>

<x-shop::form.control-group>
    <x-shop::form.control-group.label>Company Registered Street Address</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="text"
        name="registered_street"
        :value="old('registered_street', $customer->registered_street ?? '')"
    />
</x-shop::form.control-group>

<x-shop::form.control-group>
    <x-shop::form.control-group.label>Apartment</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="text"
        name="registered_apartment"
        :value="old('registered_apartment', $customer->registered_apartment ?? '')"
    />
</x-shop::form.control-group>

<x-shop::form.control-group>
    <x-shop::form.control-group.label>City</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="text"
        name="registered_city"
        :value="old('registered_city', $customer->registered_city ?? '')"
    />
</x-shop::form.control-group>

<x-shop::form.control-group>
    <x-shop::form.control-group.label>Postal Code</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="text"
        name="registered_postal"
        :value="old('registered_postal', $customer->registered_postal ?? '')"
    />
</x-shop::form.control-group>

<x-shop::form.control-group>
    <x-shop::form.control-group.label>Country</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="text"
        name="registered_country"
        :value="old('registered_country', $customer->registered_country ?? '')"
    />
</x-shop::form.control-group>

<x-shop::form.control-group>
    <x-shop::form.control-group.label class="required">Referred By</x-shop::form.control-group.label>
    <x-shop::form.control-group.control
        type="text"
        name="referred_by"
        rules="required"
        :value="old('referred_by', $customer->referred_by ?? '')"
    />
</x-shop::form.control-group>

<x-shop::form.control-group>
    <label>
        <input type="hidden" name="id_address_proof" value="0" />
        <input type="checkbox" name="id_address_proof" value="1" required {{ old('id_address_proof', $customer->id_address_proof ?? false) ? 'checked' : '' }} />
        ID & Address proof (required)
    </label>
</x-shop::form.control-group>

<x-shop::form.control-group>
    <label>
        <input type="hidden" name="accept_terms" value="0" />
        <input type="checkbox" name="accept_terms" value="1" required {{ old('accept_terms', $customer->accept_terms ?? false) ? 'checked' : '' }} />
        By submitting, I have read and accepted the terms & conditions and privacy policy and confirm that I am the authorized signatory.
    </label>
</x-shop::form.control-group>

<x-shop::form.control-group>
    <label>
        <input type="hidden" name="accept_processing" value="0" />
        <input type="checkbox" name="accept_processing" value="1" required {{ old('accept_processing', $customer->accept_processing ?? false) ? 'checked' : '' }} />
        I agree for my personal info to be used to process purchases with Thames C&C Ltd.
    </label>
</x-shop::form.control-group>

<x-shop::form.control-group>
    <label>
        <input type="hidden" name="accept_marketing" value="0" />
        <input type="checkbox" name="accept_marketing" value="1" {{ old('accept_marketing', $customer->accept_marketing ?? false) ? 'checked' : '' }} />
        I accept to receive marketing info and can opt out later.
    </label>
</x-shop::form.control-group>




                    @if (core()->getConfigData('customer.captcha.credentials.status'))
                        <div class="mb-5 flex">
                            {!! \Webkul\Customer\Facades\Captcha::render() !!}
                        </div>
                    @endif

                    <!-- Subscribed Button -->
                    @if (core()->getConfigData('customer.settings.create_new_account_options.news_letter'))
                        <div class="mb-5 flex select-none items-center gap-1.5">
                            <input
                                type="checkbox"
                                name="is_subscribed"
                                id="is-subscribed"
                                class="peer hidden"
                            />

                            <label
                                class="icon-uncheck peer-checked:icon-check-box cursor-pointer text-2xl text-navyBlue peer-checked:text-navyBlue"
                                for="is-subscribed"
                            ></label>

                            <label
                                class="cursor-pointer select-none text-base text-zinc-500 max-sm:text-sm ltr:pl-0 rtl:pr-0"
                                for="is-subscribed"
                            >
                                @lang('shop::app.customers.signup-form.subscribe-to-newsletter')
                            </label>
                        </div>
                    @endif

                    {!! view_render_event('bagisto.shop.customers.signup_form.newsletter_subscription.after') !!}

                    @if(
                        core()->getConfigData('general.gdpr.settings.enabled')
                        && core()->getConfigData('general.gdpr.agreement.enabled')
                    )
                        <div class="mb-2 flex select-none items-center gap-1.5">
                            <x-shop::form.control-group.control
                                type="checkbox"
                                name="agreement"
                                id="agreement"
                                value="0"
                                rules="required"
                                for="agreement"
                            />

                            <label
                                class="cursor-pointer select-none text-base text-zinc-500 max-sm:text-sm"
                                for="agreement"
                            >
                                {{ core()->getConfigData('general.gdpr.agreement.agreement_label') }}
                            </label>

                            @if (core()->getConfigData('general.gdpr.agreement.agreement_content'))
                                <span
                                    class="cursor-pointer text-base text-navyBlue max-sm:text-sm"
                                    @click="$refs.termsModal.open()"
                                >
                                    @lang('shop::app.customers.signup-form.click-here')
                                </span>
                            @endif
                        </div>

                        <x-shop::form.control-group.error control-name="agreement" />
                    @endif

                    <div class="mt-8 flex flex-wrap items-center gap-9 max-sm:justify-center max-sm:gap-5">
                        <!-- Save Button -->
                        <button
                            class="primary-button m-0 mx-auto block w-full max-w-[374px] rounded-2xl px-11 py-4 text-center text-base max-md:max-w-full max-md:rounded-lg max-md:py-3 max-sm:py-1.5 ltr:ml-0 rtl:mr-0"
                            type="submit"
                        >
                            @lang('shop::app.customers.signup-form.button-title')
                        </button>

                        <div class="flex flex-wrap gap-4">
                            {!! view_render_event('bagisto.shop.customers.login_form_controls.after') !!}
                        </div>
                    </div>

                    {!! view_render_event('bagisto.shop.customers.signup_form_controls.after') !!}

                </x-shop::form>
            </div>

			<p class="mt-5 font-medium text-zinc-500 max-sm:text-center max-sm:text-sm">
                @lang('shop::app.customers.signup-form.account-exists')

                <a class="text-navyBlue"
                    href="{{ route('shop.customer.session.index') }}"
                >
                    @lang('shop::app.customers.signup-form.sign-in-button')
                </a>
            </p>
		</div>

        <p class="mb-4 mt-8 text-center text-xs text-zinc-500">
            @lang('shop::app.customers.signup-form.footer', ['current_year'=> date('Y') ])
        </p>
	</div>

    @push('scripts')
        {!! \Webkul\Customer\Facades\Captcha::renderJS() !!}
    @endpush

    <!-- Terms & Conditions Modal -->
    <x-shop::modal ref="termsModal">
        <x-slot:toggle></x-slot>

        <x-slot:header class="!p-5">
            <p>@lang('shop::app.customers.signup-form.terms-conditions')</p>
        </x-slot>

        <x-slot:content class="!p-5">
            <div class="max-h-[500px] overflow-auto">
                {!! core()->getConfigData('general.gdpr.agreement.agreement_content') !!}
            </div>
        </x-slot>
    </x-admin::modal>
</x-shop::layouts>
