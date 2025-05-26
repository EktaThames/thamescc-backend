@php
    // Convert boolean or 0/1 to Yes/No string
    $boolToText = fn($val) => ($val === true || $val === 1 || $val === '1') ? 'Yes' : 'No';

    // Section Card Component
    function sectionCard($title, $fields, $customer, $boolToText) {
        echo '<div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">';
        echo '<p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">' . $title . '</p>';
        echo '<div class="grid grid-cols-1 md:grid-cols-2 gap-4">';

        foreach ($fields as $key => $label) {
            if (!is_null($customer->{$key})) {
                $value = $customer->{$key};

                // Convert boolean or 0/1 to Yes/No
                if (is_bool($value) || $value === 1 || $value === 0 || $value === '1' || $value === '0') {
                    $value = $boolToText($value);
                }

                echo '<div>';
                echo '<label class="text-sm text-gray-600 dark:text-gray-300">' . $label . ':</label>';
                echo '<p class="text-gray-800 dark:text-white break-words">' . e($value) . '</p>';
                echo '</div>';
            }
        }

        echo '</div>';
        echo '</div>';
    }
@endphp

{{-- Basic Information --}}
{!! sectionCard('Basic Information', [
    'first_name' => 'First Name',
    'last_name' => 'Last Name',
    'gender' => 'Gender',
    'date_of_birth' => 'Date of Birth',
    'email' => 'Email',
    'phone' => 'Phone',
    'status' => 'Status',
    'is_verified' => 'Is Verified',
    'is_suspended' => 'Is Suspended',
], $customer, $boolToText) !!}

<br>

{{-- Trading Details --}}
{!! sectionCard('Trading Details', [
    'business_trading_name' => 'Business Trading Name',
    'type_of_business' => 'Type of Business',
    'entity' => 'Entity',
    'trading_street' => 'Trading Street',
    'trading_address_line_2' => 'Trading Address Line 2',
    'trading_city' => 'Trading City',
    'trading_postal_code' => 'Trading Postal Code',
    'trading_country' => 'Trading Country',
    'trading_phone' => 'Trading Phone',
    'trading_email' => 'Trading Email',
], $customer, $boolToText) !!}

<br>

{{-- Owner Details --}}
{!! sectionCard('Owner Details', [
    'owner_first_name' => 'Owner First Name',
    'owner_last_name' => 'Owner Last Name',
    'owner_street' => 'Owner Street',
    'owner_address_line_2' => 'Owner Address Line 2',
    'owner_city' => 'Owner City',
    'owner_postal_code' => 'Owner Postal Code',
    'owner_country' => 'Owner Country',
    'owner_phone' => 'Owner Phone',
    'owner_email' => 'Owner Email',
], $customer, $boolToText) !!}

<br>

{{-- Company Registration --}}
{!! sectionCard('Company Registration', [
    'vat_number' => 'VAT Number',
    'not_vat_registered' => 'Not VAT Registered',
    'eoid' => 'EOID',
    'fid' => 'FID',
    'company_registration_number' => 'Company Registration Number',
], $customer, $boolToText) !!}

<br>

{{-- Registered Address --}}
{!! sectionCard('Registered Address', [
    'registered_street' => 'Registered Street',
    'registered_apartment' => 'Registered Apartment',
    'registered_city' => 'Registered City',
    'registered_postal' => 'Registered Postal',
    'registered_country' => 'Registered Country',
], $customer, $boolToText) !!}

<br>

{{-- Legal & Preferences --}}
{!! sectionCard('Legal & Preferences', [
    'referred_by' => 'Referred By',
    'id_address_proof' => 'ID Address Proof',
    'accept_terms' => 'Accepted Terms',
    'accept_processing' => 'Accepted Processing',
    'accept_marketing' => 'Accepted Marketing',
    'subscribed_to_news_letter' => 'Newsletter Subscription',
], $customer, $boolToText) !!}
