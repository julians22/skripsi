<?php

namespace App\Http\Requests\Backend\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            "product_name" => "required",
            "product_code" => "unique:products,code,".$this->product_id ,
            "selected_category" => "required|numeric",
            "product_description" => "sometimes|string",
            "product_price" => "required",
            "product_stock" => "numeric"
        ];
    }
}
