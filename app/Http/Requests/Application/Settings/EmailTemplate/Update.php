<?php

namespace App\Http\Requests\Application\Settings\EmailTemplate;

use Illuminate\Foundation\Http\FormRequest;

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
            'payment_mail_subject' => 'required|string',
            'payment_mail_content' => 'required|string',
        ];
    }
}