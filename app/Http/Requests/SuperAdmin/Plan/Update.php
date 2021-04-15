<?php

namespace App\Http\Requests\SuperAdmin\Plan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Update extends FormRequest
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
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:32768',
            'is_active' => 'sometimes|boolean',
            'price' => 'required',
            'trial_period' => 'sometimes|integer|max:100000',
            'invoice_period' => 'sometimes|integer|max:100000',
            'grace_period' => 'sometimes|integer|max:100000',
            'order' => 'integer'
        ];
    }
}