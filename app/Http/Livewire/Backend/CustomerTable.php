<?php

namespace App\Http\Livewire\Backend;

use App\Http\Livewire\BaseTableStyle;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Customer;

class CustomerTable extends DataTableComponent
{

    use BaseTableStyle;

    public ?int $searchFilterDebounce = 1000;
    public ?bool $searchFilterLazy = true;

    public function columns(): array
    {
        return [
            Column::make(__("Name"), "name")
                ->sortable(),
            Column::make(__("Phone"), "phone")
                ->sortable(),
            Column::make(__("E-mail"), "email")
                ->sortable(),
            Column::make(__("Actions"))
        ];
    }

    public function query(): Builder
    {
        return Customer::query();
    }

    /**
     * rowView method
     *
     * @return string
     */
    public function rowView(): string
    {
        return 'backend.customer.includes.row';
    }
}
