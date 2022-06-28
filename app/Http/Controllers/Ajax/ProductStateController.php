<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductStateController extends Controller
{
    public function getProducts(Request $request)
    {
        $search = $request->get('search', null);
        $category_id = $request->get('category', null);

        $query = Product::query();

        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if (!empty($category_id)) {
            $query->where('category_id', $category_id);
        }

        $products = $query->get(['name', 'category_id', 'id', 'code', 'price', 'quantity']);

        return response()->json($products);
        // return response()->json([
        //     'products' => $products,
        // ]);




        // $products = Product::where('name', 'like', '%' . $search . '%')
        //     ->where('id', '!=', $added)
        //     ->get();
    }
}
