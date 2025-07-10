<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.footer-settings.edit.title')
    </x-slot>

    {!! view_render_event('bagisto.admin.footer-settings.edit.before', ['footer' => $footer]) !!}

    <x-admin::form 
        method="POST" 
        action="{{ route('admin.footer-settings.update') }}"
        enctype="multipart/form-data"
    >
        @csrf

        {!! view_render_event('bagisto.admin.footer-settings.edit.edit_form_controls.before', ['footer' => $footer]) !!}

        <!-- Page Header -->
        <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
            <div class="grid gap-1.5">
                <p class="text-xl font-bold leading-6 text-gray-800 dark:text-white">
                    @lang('admin::app.footer-settings.edit.title')
                </p>
                
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    @lang('admin::app.footer-settings.edit.description')
                </p>
            </div>

            <div class="flex items-center gap-x-2.5">
                <button 
                    type="submit" 
                    class="primary-button"
                    aria-label="@lang('admin::app.footer-settings.edit.save-btn')"
                >
                    @lang('admin::app.footer-settings.edit.save-btn')
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="mt-3.5 flex gap-2.5 max-xl:flex-wrap">
            <!-- Left Panel -->
            <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
                
                {!! view_render_event('bagisto.admin.footer-settings.edit.card.about.before', ['footer' => $footer]) !!}

                <!-- About Section -->
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <div class="mb-4 flex items-center gap-2">
                        <div class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900">
                            <i class="icon-information text-blue-600 dark:text-blue-400"></i>
                        </div>
                        
                        <p class="text-base font-semibold text-gray-800 dark:text-white">
                            @lang('admin::app.footer-settings.edit.about')
                        </p>
                    </div>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('admin::app.footer-settings.edit.about-text')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="textarea"
                            name="about_text"
                            id="about_text"
                            rules="required"
                            :value="old('about_text', $footer?->about_text)"
                            :label="trans('admin::app.footer-settings.edit.about-text')"
                            :placeholder="trans('admin::app.footer-settings.edit.about-text-placeholder')"
                            rows="4"
                        />

                        <x-admin::form.control-group.error control-name="about_text" />
                    </x-admin::form.control-group>
                </div>

                {!! view_render_event('bagisto.admin.footer-settings.edit.card.socials.before', ['footer' => $footer]) !!}

                <!-- Social Media Section -->
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <div class="mb-4 flex items-center gap-2">
                        <div class="flex h-6 w-6 items-center justify-center rounded-full bg-green-100 dark:bg-green-900">
                            <i class="icon-share text-green-600 dark:text-green-400"></i>
                        </div>
                        
                        <p class="text-base font-semibold text-gray-800 dark:text-white">
                            @lang('admin::app.footer-settings.edit.social-media')
                        </p>
                    </div>

                    <div class="grid gap-4 md:grid-cols-3">
                        @foreach (['twitter', 'instagram', 'facebook'] as $social)
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label>
                                    <div class="flex items-center gap-2">
                                        <i class="icon-{{ $social }} text-gray-500"></i>
                                        {{ ucfirst($social) }} URL
                                    </div>
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="text"
                                    name="{{ $social }}"
                                    id="{{ $social }}"
                                    rules="url"
                                    :value="old($social, $footer?->$social)"
                                    :label="trans('admin::app.footer-settings.edit.' . $social . '-url')"
                                    :placeholder="trans('admin::app.footer-settings.edit.' . $social . '-url-placeholder')"
                                />

                                <x-admin::form.control-group.error control-name="{{ $social }}" />
                            </x-admin::form.control-group>
                        @endforeach
                    </div>
                </div>

                {!! view_render_event('bagisto.admin.footer-settings.edit.card.contact.before', ['footer' => $footer]) !!}

                <!-- Contact Information Section -->
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <div class="mb-4 flex items-center gap-2">
                        <div class="flex h-6 w-6 items-center justify-center rounded-full bg-red-100 dark:bg-green-900">
                            <i class="icon-contact text-green-600 dark:text-green-400"></i>
                        </div>
                        
                        <p class="text-base font-semibold text-gray-800 dark:text-white">
                            @lang('admin::app.footer-settings.edit.contact-information')
                        </p>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label>
                                @lang('admin::app.footer-settings.edit.contact-address')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="textarea"
                                name="contact_address"
                                id="contact_address"
                                :value="old('contact_address', $footer?->contact_address)"
                                :label="trans('admin::app.footer-settings.edit.contact-address')"
                                :placeholder="trans('admin::app.footer-settings.edit.contact-address-placeholder')"
                                rows="3"
                            />

                            <x-admin::form.control-group.error control-name="contact_address" />
                        </x-admin::form.control-group>

                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label>
                                @lang('admin::app.footer-settings.edit.contact-phone')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="contact_phone"
                                id="contact_phone"
                                :value="old('contact_phone', $footer?->contact_phone)"
                                :label="trans('admin::app.footer-settings.edit.contact-phone')"
                                :placeholder="trans('admin::app.footer-settings.edit.contact-phone-placeholder')"
                            />

                            <x-admin::form.control-group.error control-name="contact_phone" />
                        </x-admin::form.control-group>

                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label>
                                @lang('admin::app.footer-settings.edit.contact-email')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="email"
                                name="contact_email"
                                id="contact_email"
                                rules="email"
                                :value="old('contact_email', $footer?->contact_email)"
                                :label="trans('admin::app.footer-settings.edit.contact-email')"
                                :placeholder="trans('admin::app.footer-settings.edit.contact-email-placeholder')"
                            />

                            <x-admin::form.control-group.error control-name="contact_email" />
                        </x-admin::form.control-group>
                    </div>
                </div>

                {!! view_render_event('bagisto.admin.footer-settings.edit.card.copyright.before', ['footer' => $footer]) !!}

                <!-- Copyright Section -->
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <div class="mb-4 flex items-center gap-2">
                        <div class="flex h-6 w-6 items-center justify-center rounded-full bg-red-100 dark:bg-green-900">
                            <i class="icon-contact text-green-600 dark:text-green-400"></i>
                        </div>
                        
                        <p class="text-base font-semibold text-gray-800 dark:text-white">
                            @lang('admin::app.footer-settings.edit.copyright')
                        </p>
                    </div>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('admin::app.footer-settings.edit.copyright-text')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="copyright_text"
                            id="copyright_text"
                            :value="old('copyright_text', $footer?->copyright_text)"
                            :label="trans('admin::app.footer-settings.edit.copyright-text')"
                            :placeholder="trans('admin::app.footer-settings.edit.copyright-text-placeholder')"
                        />

                        <x-admin::form.control-group.error control-name="copyright_text" />
                    </x-admin::form.control-group>
                </div>
            </div>

            <!-- Right Panel -->
            <div class="flex w-[360px] max-w-full flex-col gap-2 max-sm:w-full">
                
                {!! view_render_event('bagisto.admin.footer-settings.edit.card.links.before', ['footer' => $footer]) !!}

                <!-- Help Links Section -->
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <div class="mb-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900">
                                <i class="icon-help text-blue-600 dark:text-blue-400"></i>
                            </div>
                            
                            <p class="text-base font-semibold text-gray-800 dark:text-white">
                                @lang('admin::app.footer-settings.edit.help-links')
                            </p>
                        </div>

                        <button 
                            type="button" 
                            class="secondary-button"
                            onclick="addHelpLink()"
                        >
                            <i class="icon-plus text-sm"></i>
                            @lang('admin::app.footer-settings.edit.add-link')
                        </button>
                    </div>

                    <div id="help-links-wrapper" class="space-y-3">
                        @php $helpLinks = old('help_links', $footer?->help_links ?? []); @endphp
                        @for ($i = 0; $i < max(1, count($helpLinks)); $i++)
                            <div class="help-link-item flex items-center gap-2 rounded-md border border-gray-200 bg-gray-50 p-3 dark:border-gray-700 dark:bg-gray-800">
                                <div class="flex flex-1 flex-col gap-2">
                                    <input 
                                        type="text" 
                                        name="help_links[{{ $i }}][title]" 
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-black transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-600 dark:bg-gray-700 dark:hover:border-gray-500 dark:focus:border-gray-500" 
                                        placeholder="@lang('admin::app.footer-settings.edit.link-title')" 
                                        value="{{ $helpLinks[$i]['title'] ?? '' }}" 
                                    />
                                    <input 
                                        type="text" 
                                        name="help_links[{{ $i }}][url]" 
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-black transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-600 dark:bg-gray-700 dark:hover:border-gray-500 dark:focus:border-gray-500" 
                                        placeholder="@lang('admin::app.footer-settings.edit.link-url')" 
                                        value="{{ $helpLinks[$i]['url'] ?? '' }}" 
                                    />
                                </div>
                                @if ($i > 0)
                                    <button 
                                        type="button" 
                                        class="flex h-8 w-8 items-center justify-center rounded-md bg-transparent text-red-600 hover:text-red-700 text-2xl font-bold border-none" 
                                        onclick="removeLink(this, 'help-links-wrapper')" 
                                        aria-label="Remove"
                                        style="color: red; font-size: 30px;"
                                    >
                                        &times;
                                    </button>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Important Information Links Section -->
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <div class="mb-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="flex h-6 w-6 items-center justify-center rounded-full bg-red-100 dark:bg-red-900">
                                <i class="icon-important text-red-600 dark:text-red-400"></i>
                            </div>
                            
                            <p class="text-base font-semibold text-gray-800 dark:text-white">
                                @lang('admin::app.footer-settings.edit.important-links')
                            </p>
                        </div>

                        <button 
                            type="button" 
                            class="secondary-button"
                            onclick="addImportantLink()"
                        >
                            <i class="icon-plus text-sm"></i>
                            @lang('admin::app.footer-settings.edit.add-link')
                        </button>
                    </div>

                    <div id="important-links-wrapper" class="space-y-3">
                        @php $importantLinks = old('important_links', $footer?->important_links ?? []); @endphp
                        @for ($i = 0; $i < max(1, count($importantLinks)); $i++)
                            <div class="important-link-item flex items-center gap-2 rounded-md border border-gray-200 bg-gray-50 p-3 dark:border-gray-700 dark:bg-gray-800">
                                <div class="flex flex-1 flex-col gap-2">
                                    <input 
                                        type="text" 
                                        name="important_links[{{ $i }}][title]" 
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-black transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-600 dark:bg-gray-700 dark:hover:border-gray-500 dark:focus:border-gray-500" 
                                        placeholder="@lang('admin::app.footer-settings.edit.link-title')" 
                                        value="{{ $importantLinks[$i]['title'] ?? '' }}" 
                                    />
                                    <input 
                                        type="text" 
                                        name="important_links[{{ $i }}][url]" 
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-black transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-600 dark:bg-gray-700 dark:hover:border-gray-500 dark:focus:border-gray-500" 
                                        placeholder="@lang('admin::app.footer-settings.edit.link-url')" 
                                        value="{{ $importantLinks[$i]['url'] ?? '' }}" 
                                    />
                                </div>
                                @if ($i > 0)
                                    <button 
                                        type="button" 
                                        class="flex h-8 w-8 items-center justify-center rounded-md bg-transparent text-red-600 hover:text-red-700 text-2xl font-bold border-none" 
                                        onclick="removeLink(this, 'important-links-wrapper')" 
                                        aria-label="Remove"
                                        style="color: red; font-size: 30px;"
                                    >
                                        &times;
                                    </button>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </x-admin::form>

    {!! view_render_event('bagisto.admin.footer-settings.edit.after', ['footer' => $footer]) !!}

    @pushOnce('scripts')
        <script type="text/javascript">
            window.addHelpLink = function () {
                const wrapper = document.getElementById('help-links-wrapper');
                const index = wrapper.querySelectorAll('.help-link-item').length;
                const div = document.createElement('div');
                div.className = 'help-link-item flex items-center gap-2 rounded-md border border-gray-200 bg-gray-50 p-3 dark:border-gray-700 dark:bg-gray-800';
                div.innerHTML = `
                    <div class="flex flex-1 flex-col gap-2">
                        <input 
                            type="text" 
                            name="help_links[${index}][title]" 
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-black transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-600 dark:bg-gray-700 dark:hover:border-gray-500 dark:focus:border-gray-500" 
                            placeholder="@lang('admin::app.footer-settings.edit.link-title')" 
                        />
                        <input 
                            type="text" 
                            name="help_links[${index}][url]" 
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-black transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-600 dark:bg-gray-700 dark:hover:border-gray-500 dark:focus:border-gray-500" 
                            placeholder="@lang('admin::app.footer-settings.edit.link-url')" 
                        />
                    </div>
                    <button 
                        type="button" 
                        class="flex h-8 w-8 items-center justify-center rounded-md bg-red-600 text-white hover:bg-red-700 border-none text-xl font-bold"
                        onclick="removeLink(this, 'help-links-wrapper')"
                        style="color: red; font-size: 30px;"
                        aria-label="Remove"
                    >
                        &times;
                    </button>
                `;
                wrapper.appendChild(div);
            }

            window.addImportantLink = function () {
                const wrapper = document.getElementById('important-links-wrapper');
                const index = wrapper.querySelectorAll('.important-link-item').length;
                const div = document.createElement('div');
                div.className = 'important-link-item flex items-center gap-2 rounded-md border border-gray-200 bg-gray-50 p-3 dark:border-gray-700 dark:bg-gray-800';
                div.innerHTML = `
                    <div class="flex flex-1 flex-col gap-2">
                        <input 
                            type="text" 
                            name="important_links[${index}][title]" 
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-black transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-600 dark:bg-gray-700 dark:hover:border-gray-500 dark:focus:border-gray-500" 
                            placeholder="@lang('admin::app.footer-settings.edit.link-title')" 
                        />
                        <input 
                            type="text" 
                            name="important_links[${index}][url]" 
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-black transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-600 dark:bg-gray-700 dark:hover:border-gray-500 dark:focus:border-gray-500" 
                            placeholder="@lang('admin::app.footer-settings.edit.link-url')" 
                        />
                    </div>
                    <button 
                        type="button" 
                        class="flex h-8 w-8 items-center justify-center rounded-md bg-red-600 text-white hover:bg-red-700 border-none text-xl font-bold"
                        onclick="removeLink(this, 'important-links-wrapper')"
                        aria-label="Remove"
                        style="color: red; font-size: 30px;"
                    >
                        &times;
                    </button>
                `;
                wrapper.appendChild(div);
            }

            window.removeLink = function (button, wrapperId) {
                const wrapper = document.getElementById(wrapperId);
                const item = button.closest('.help-link-item, .important-link-item');
                
                if (wrapper.querySelectorAll('.help-link-item, .important-link-item').length > 1) {
                    item.remove();
                } else {
                    // If it's the last item, just clear the inputs
                    const inputs = item.querySelectorAll('input');
                    inputs.forEach(input => input.value = '');
                }
            }
        </script>
    @endPushOnce
</x-admin::layouts>

