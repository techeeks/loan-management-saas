<?php

namespace App\Http\Requests\SuperAdmin\User;

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
            'avatar' => 'mimes:jpeg,jpg,png,gif',
            'first_name' => 'required|string|max:190',
            'last_name' => 'required|string|max:190',
            'telephone' => 'nullable|string',
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'company_name' => ['required', 'string'],
            'email' => [
                'required',
                'string',
                'email',
                'max:190',
                Rule::unique('users')->ignore(request()->user),
            ],
        ];
    }
}