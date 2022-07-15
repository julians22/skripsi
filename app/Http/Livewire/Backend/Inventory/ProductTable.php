<?php

namespace App\Http\Livewire\Backend\Inventory;

use App\Http\Livewire\BaseTableStyle;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Product;
use App\Models\ProductCategory;
use Arr;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class ProductTable extends DataTableComponent
{
    use BaseTableStyle;

    /**
     * perPageAccepted property
     */
    public array $perPageAccepted = [10, 25, 50];


    public array $bulkActions = [
        'categoryChange' => 'Ubah Kategori',
    ];

    public ?int $searchFilterDebounce = 1000;
    public ?bool $searchFilterLazy = true;


    /**
     * Columns property
     */
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
            Column::make(__('Category'))
                ->sortable(function(Builder $query, $direction) {
                    return $query->orderBy(ProductCategory::select('name')->whereColumn('product_categories.id', 'products.category_id'), $direction);
                }),
            Column::make(__('Actions'))
        ];
    }

    public function filters(): array
    {
        return [
            'category_id' => Filter::make(__('Category Product'))
                ->select(
                    $this->getFilterProductCategories()
                )
        ];

    }

    public function query(): Builder
    {
        $query = Product::with('category');
        return $query->when(
            $this->getFilter('category_id'), fn ($query) => $query->where('category_id', $this->getFilter('category_id'))
        );
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

    /**
     * get Product Categories
     *
     * @return array
     */
    private function getFilterProductCategories(): array
    {
        $productCateories = ProductCategory::all()->pluck('name', 'id')->toArray();
        // add [null => 'All'] to the beginning of the array
        $productCateories = Arr::prepend($productCateories, __('All'), null);
        return $productCateories;
    }

    public function categoryChange()
    {
        dd($this->selectedKeys());
    }
}
