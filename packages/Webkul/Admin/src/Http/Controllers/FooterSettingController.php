<?php

namespace Webkul\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Webkul\Shop\Models\FooterSetting;
use Illuminate\Routing\Controller;

class FooterSettingController extends Controller
{
    public function edit()
    {
        $footer = FooterSetting::first();
        return view('admin::footer-settings.edit', compact('footer'));
    }

    public function update(Request $request)
    {
        $footer = FooterSetting::first();
        if (!$footer) {
            $footer = new FooterSetting();
        }
        $footer->fill($request->only([
            'about_text',
            'twitter',
            'instagram',
            'facebook',
            'contact_address',
            'contact_phone',
            'contact_email',
            'copyright_text',
        ]));
        $footer->help_links = $request->input('help_links', []);
        $footer->important_links = $request->input('important_links', []);
        $footer->save();

        return redirect()->back()->with('success', 'Footer settings updated successfully.');
    }
} 