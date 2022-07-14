<?php

namespace App\Http\Livewire\Backend\Widgets;

use App\Models\Sales;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class SalesDebt extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public bool $loading = true;
    public int $totalDebt = 0;

    public function mount()
    {
        $this->loading = false;
    }

    public function render()
    {
        $sales = Sales::whereHas('transaction', function (EloquentBuilder $query) {
            $query->doesntHave('payment')
                ->orWhere('status', 'debt');
        })
        ->orderBy('id', 'desc')->paginate(5, '*', 'salesdebt');

        $this->totalDebt = $sales->sum('total');

        return view('livewire.backend.widgets.sales-debt', [
            'sales' => $sales,
        ]);
    }
}
