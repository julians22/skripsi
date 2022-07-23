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
use PDF;

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
        return view('backend.inventory.product.index');
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
            'product_price' => 'required',
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
        return view('backend.inventory.product.show', compact('product'));
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
            // remove dot, comma and space from price
            $request->merge(['product_price' => clear_number($request->product_price)]);
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
        // event(new ProductUpdated($product));

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

    /**
     *  Show the form for import product.
     *
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        return view('backend.inventory.product.import');
    }

    /**
     * Generate Price List
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generatePriceList(Request $request)
    {
        $request->validate([
            'paper_size' => 'required',
        ]);

        $paper_size = $request->paper_size;
        $products = ProductCategory::with('products')->get();
        $data = [];
        foreach ($products as $product) {
            // sort by product name
            $product->products = $product->products->sortBy('name');
            $data[] = [
                'category' => $product->name,
                'show' => $product->products->count() > 0,
                'products' => $product->products->map(function ($product) use ($paper_size) {
                    return [
                        'name' => $product->name,
                        'price' => $product->price,
                        'code' => $product->code,
                    ];
                }),
            ];
        }

        $pdf = PDF::loadView('backend.utils.print.products.price-list', compact('data', 'paper_size'))->setPaper($paper_size)->setOptions(['dpi' => 90, 'defaultFont' => 'Source Sans Pro', 'isHtml5ParserEnabled' => true,
        'isRemoteEnabled' => true]);
        return $pdf->stream('price-list.pdf');




    }
}
