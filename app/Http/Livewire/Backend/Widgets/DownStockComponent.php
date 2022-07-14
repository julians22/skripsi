<?php

namespace App\Http\Livewire\Backend\Widgets;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class DownStockComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public bool $loading = true;

    public function mount()
    {
        $this->loading = false;
    }

    public function render()
    {
        $products = Product::where('quantity', '<', 1)->orderBy('quantity', 'asc')->paginate(5, '*', 'runoutstock');
        return view('livewire.backend.widgets.down-stock-component', [
            'products' => $products,
        ]);
    }
}
