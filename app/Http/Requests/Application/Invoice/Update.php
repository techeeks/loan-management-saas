<?php

namespace App\Http\Requests\Application\Invoice;

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
        if (is_array($this->product)) {
            // Make sure the lenght of product array is the same with other attributes of arrays
            $max_lenght = count($this->product);
            return [
                'invoice_number' => 'required|unique:invoices,invoice_number,' . $this->route('invoice'),
                'invoice_date' => 'required|date',
                'due_date' => 'required|date',
                'reference_number' => 'nullable|string',
                'customer_id' => 'required|exists:customers,id',
                'sub_total' => 'required',
                'grand_total' => 'required',
                'notes' => 'nullable|string',
                'private_notes' => 'nullable|string',

                'total_discount' => 'sometimes|integer|min:0',
                'total_taxes' => 'sometimes|array|min:0',

                'product' => 'required|array|max:'.$max_lenght,
                'product.*' => 'required|integer|exists:products,id',

                'quantity' => 'required|array|max:'.$max_lenght,
                'quantity.*' => 'required|integer|min:0',

                'price' => 'required|array|max:'.$max_lenght,
                'price.*' => 'required',

                'total' => 'required|array|max:'.$max_lenght,
                'total.*' => 'required',

                'taxes' => 'sometimes|required|array|max:'.$max_lenght,
                'taxes.*' => 'sometimes|required|array',

                'discount' => 'sometimes|required|array|max:'.$max_lenght,
                'discount.*' => 'sometimes|required',
            ];
        }

        return [
            'product' => 'required|array',
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
            'invoice_number.unique' => __('messages.invoice_exists'),
            'product.required' => __('messages.please_select_a_product'),
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'invoice_number' => $this->invoice_prefix.'-'.sprintf('%06d', intval($this->invoice_number)),
        ]);
    }
}