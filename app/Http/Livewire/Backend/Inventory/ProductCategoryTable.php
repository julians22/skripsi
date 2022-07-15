<?php

namespace App\Http\Livewire\Backend\Inventory;

use App\Http\Livewire\BaseTableStyle;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ProductCategoryTable extends DataTableComponent
{

    use BaseTableStyle;

    public function columns(): array
    {
        return [
            Column::make(__('Name'), 'name'),
            Column::make(__('Description'), 'description'),
            Column::make(__('Actions'), 'id')
        ];
    }

    public ?int $searchFilterDebounce = 1000;
    public ?bool $searchFilterLazy = true;

    public function query(): Builder
    {
        return ProductCategory::query();
    }

    /**
     * rowView method
     *
     * @return string
     */
    public function rowView(): string
    {
        return 'backend.inventory.category.includes.row';
    }
}
