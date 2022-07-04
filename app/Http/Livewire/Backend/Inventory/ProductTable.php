<?php

namespace App\Http\Livewire\Backend\Inventory;

use App\Http\Livewire\BaseTableStyle;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Product;

class ProductTable extends DataTableComponent
{
    use BaseTableStyle;

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
     * rowView method
     *
     * @return string
     */
    public function rowView(): string
    {
        return 'backend.inventory.product.includes.row';
    }
}
