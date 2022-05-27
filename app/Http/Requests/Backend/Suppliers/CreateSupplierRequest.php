<?php

namespace App\Http\Requests\Backend\Suppliers;

use Illuminate\Foundation\Http\FormRequest;

class CreateSupplierRequest extends FormRequest
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
            'name' => 'required|max:225',
            'email' => 'required|email|max:225|unique:suppliers',
            'phone' => 'required|max:20',
            'address' => 'nullable|max:225',
        ];
    }
}
