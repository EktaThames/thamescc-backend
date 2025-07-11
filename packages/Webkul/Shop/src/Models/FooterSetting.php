<?php

namespace Webkul\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    protected $table = 'footer_settings';

    protected $fillable = [
        'about_text',
        'twitter',
        'instagram',
        'facebook',
        'contact_address',
        'contact_phone',
        'contact_email',
        'copyright_text',
        'help_links',
        'important_links',
    ];

    protected $casts = [
        'help_links' => 'array',
        'important_links' => 'array',
    ];
} 