<?php

namespace App\Http\Controllers\Backend;

use App\Events\Products\ProductCreated;
use App\Events\Products\ProductUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Products\UpdateProductRequest;
use App\Models\Product as Product;
use App\Models\ProductCategory;
use App\Services\ProductServices;
use DB;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productServices;

    public function __construct(ProductServices $productServices)
    {
        $this->productServices = $productServices;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productServices->getAllPaginated(5);
        return view('backend.inventory.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProductCategory::all(['name', 'id']);
        return view('backend.inventory.product.create', compact('categories'));
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
            'product_name' => 'required',
            'selected_category' => 'sometimes',
            'product_price' => 'integer',
            'product_stock' => 'integer',
            'product_description' => 'sometimes',
        ]);

        DB::beginTransaction();
        try {
            $product = Product::create([
                'name' => $request->product_name,
                'category_id' => $request->selected_category,
                'price' => $request->product_price,
                'quantity' => $request->product_stock,
                'description' => $request->product_description,
                'code' => $request->product_code,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withFlashError($e->getMessage());
        }
        event(new ProductCreated($product));

        DB::commit();

        return redirect()->route('admin.product.index')->withFlashSuccess('Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = ProductCategory::all(['name', 'id']);
        return view('backend.inventory.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        DB::beginTransaction();

        try {
            $product->update([
                'name' => $request->product_name,
                'category_id' => $request->selected_category,
                'price' => $request->product_price,
                'quantity' => $request->product_stock,
                'description' => $request->product_description,
                'code' => $request->product_code,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withFlashError($th->getMessage());
        }

        DB::commit();
        event(new ProductUpdated($product));

        return redirect()->route('admin.product.index')->withFlashSuccess('Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.product.index')->withFlashSuccess('Product deleted successfully.');
    }
}
