<?php

namespace App\Http\Livewire\Backend\Inventory;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Product;

class ProductTable extends DataTableComponent
{

    /**
     * perPageAccepted property
     */
    public array $perPageAccepted = [10, 25, 50];

    public function columns(): array
    {
        return [
            Column::make(__('Code'), 'code')
                ->searchable()
                ->sortable(),
            Column::make(__('Name'), 'name')
                ->searchable()
                ->sortable(),
            Column::make(__('Price'), 'price')
                ->sortable(),
            Column::make(__('Stock'), 'quantity')
                ->sortable(),
            Column::make(__('Category')),
            Column::make(__('Actions'))
        ];
    }

    public function query(): Builder
    {
        return Product::query();
    }

    /**
     * settableclass
     *
     */
    public function setTableClass(){
        return 'table table-striped table-bordered table-hover table-sm';
    }

    /**
     * rowView method
     *
     * @return string
     */
    public function rowView(): string
    {
        return 'backend.inventory.product.includes.row';
    }
}
