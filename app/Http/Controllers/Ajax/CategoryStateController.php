<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CategoryStateController extends Controller
{

    public function getCategories(Request $request)
    {
        $search = $request->get('search');
        $categories = ProductCategory::where('name', 'like', '%' . $search . '%')->get();
        return response()->json($categories);
    }
}
