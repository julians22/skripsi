<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Str;

class ProductStateController extends Controller
{
    public function getProducts(Request $request)
    {
        $search = $request->get('search', null);
        $category_id = $request->get('category', null);

        $query = Product::query();

        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
            $query->where('code', 'like', '%' . $search . '%');
        }

        if (!empty($category_id)) {
            $query->where('category_id', $category_id);
        }

        $products = $query->orderBy('name', 'ASC')->orderBy('price', 'DESC')->get(['name', 'category_id', 'id', 'code', 'price', 'quantity']);

        return response()->json($products);
    }

    public function getProductCode()
    {
        $code = $this->codeGenerator();
        return response()->json(['code' => $code]);
    }

    public function checkCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $code = $request->code;
        $product = Product::where('code', $code)->first();
        if ($product) {
            $response = [
                'status' => 'error',
                'message' => 'Kode produk telah digunakan',
                'alterative_code' => $this->codeGenerator(),
            ];
            return response()->json($response, 400);
        }
        $response = [
            'status' => 'success',
        ];
    }

    private function codeGenerator()
    {
        $product = Product::orderBy('code', 'desc')->first();

        //  make product code format from AR-00001;
        $code_number = Str::afterLast($product->code, '-');
        $code_number = (int) $code_number;
        $code_number++;
        $code = str_pad($code_number, 5, '0', STR_PAD_LEFT);
        $code = 'AR-' . $code;
        return $code;
    }

}
