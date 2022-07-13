<?php

namespace App\Http\Livewire\Products;

use App\Imports\ProductImport as ImportsProductImport;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ProductImport extends Component
{
    use WithFileUploads;

    public $file;

    public array $products;
    public int $procesCounter = 0;
    public bool $isInserting = false;

    public function render()
    {
        return view('livewire.products.product-import');
    }

    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $import = new ImportsProductImport;

        Excel::import($import, $this->file->path());

        $this->products = $import->products;
    }

    public function save()
    {
        $this->isInserting = true;
        foreach ($this->products as $product) {
            // save product
            $query = Product::where([['code', $product['code']], ['name', $product['name']]])->first();
            if ($query) {
                $query->update([
                    'price' => $product['price'],
                    'quantity' => $query->quantity + $product['quantity'],
                ]);
            } else {
                Product::create([
                    'code' => $product['code'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $product['quantity'],
                    'category_id' => 1,
                ]);
            }

        }
        session()->flash('success', 'Produk berhasil diimport.');
        return redirect()->route('admin.product.index');
    }
}
