<?php

namespace App\Http\Requests\Backend\Transactions\Purchases;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchasesRequest extends FormRequest
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
            'name' => 'required|string|max:191',
            'email' => 'nullable|string|email|max:191',
            'phone' => 'required|string|max:191',
            'address' => 'required|string|max:191',
            'products.*.product_id' => 'required|integer',
            'products.*.price' => 'required|numeric',
            'products.*.quantity' => 'required|integer',
        ];
    }
}
