<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductStateController extends Controller
{
    public function getProducts(Request $request)
    {
        $search = $request->get('search');
        $added = $request->get('added');
        $products = Product::where('name', 'like', '%' . $search . '%')
            ->where('id', '!=', $added)
            ->get();
        return response()->json($products);
    }
}
