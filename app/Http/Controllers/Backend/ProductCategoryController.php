<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.inventory.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.inventory.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:product_categories,name',
            'description' => 'sometimes|nullable',
        ]);

        $category = ProductCategory::create($request->only(['name', 'description']));

        return redirect()->route('admin.category.index')->with('success', 'Product category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCategory $productCategory)
    {
        $category = $productCategory;
        return view('backend.inventory.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $request->validate([
            'name' => 'required|unique:product_categories,name,'.$productCategory->id,
            'description' => 'sometimes|nullable',
        ]);

        $productCategory->update($request->only(['name', 'description']));

        return redirect()->route('admin.category.index')->withFlashSuccess(__('Product category updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $productCategory)
    {
        $products = $productCategory->products()->get();
        if ($products->count() > 0) {
            $products->each(function ($product) {
                $product->update(['category_id' => 1]);
            });
        }
        $productCategory->delete();

        return redirect()->route('admin.category.index')->withFlashSuccess(__('Product category deleted successfully.'));
    }
}
