<?php

namespace Webkul\Shop\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Webkul\Customer\Facades\Captcha;

class RegistrationRequest extends FormRequest
{
    /**
     * Define your rules.
     *
     * @var array
     */
    private $rules = [
        'first_name' => 'string|required',
        'last_name'  => 'string|required',
        'email'      => 'email|required|unique:customers,email',
        'password'   => 'confirmed|min:6|required',
        'company_registration_number' => 'nullable|string|max:255',
'business_trading_name'      => 'nullable|string|max:255',
'vat_number'                 => 'nullable|string|max:255',

    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Captcha::getValidations($this->rules);
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return Captcha::getValidationMessages();
    }
}
