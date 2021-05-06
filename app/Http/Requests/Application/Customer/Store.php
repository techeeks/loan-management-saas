<?php

namespace App\Http\Requests\Application\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Store extends FormRequest
{
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
        return [
            'display_name' => 'required|string|max:190',
            'email' => [
                'required',
                'string',
                'email',
                'max:190',
                Rule::unique('customers')->where(function ($query) {
                    return $query->where('company_id', request()->user()->currentCompany()->id);
                }),
            ],
            'phone' => 'nullable|string|max:190',
            'guarantor_phone'=>'nullable|string|max:190',
            'guarantor_name'=>'required|string|max:190',

            'billing.country_id' => 'required|integer',
            'billing.state' => 'nullable|string|max:190',
            'billing.city' => 'nullable|string|max:190',
            'billing.zip' => 'nullable|string|max:190',
            'billing.address_1' => 'required|string|max:500',

            'gurantor.country_id' => 'required|integer',
            'gurantor.state' => 'nullable|string|max:190',
            'gurantor.city' => 'nullable|string|max:190',
            'gurantor.zip' => 'nullable|string|max:190',
            'gurantor.address_1' => 'required|string|max:500',

            'shipping.name' => 'nullable|string|max:190',
            'shipping.phone' => 'nullable|string|max:190',
            'shipping.country_id' => 'nullable|integer',
            'shipping.state' => 'nullable|string|max:190',
            'shipping.city' => 'nullable|string|max:190',
            'shipping.zip' => 'nullable|string|max:190',
            'shipping.address_1' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.unique' => __('messages.customer_exists'),
        ];
    }
}