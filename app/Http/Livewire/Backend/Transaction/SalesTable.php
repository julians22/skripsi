<?php

namespace App\Http\Livewire\Backend\Transaction;

use App\Http\Livewire\BaseTableStyle;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Sales;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class SalesTable extends DataTableComponent
{
    use BaseTableStyle;

    public string $defaultSortColumn = 'created_at';
    public string $defaultSortDirection = 'desc';

    public function columns(): array
    {
        return [
            Column::make(__("Invoice Number"), "invoice_number")
                ->searchable(),
            Column::make(__("Customer"), "customer.name")
                ->searchable(),
            Column::make(__("Status")),
            Column::make(__("Total"), "total")
                ->sortable(),
            Column::make(__("Created at"), "created_at")
                ->sortable(),
            Column::make(__("Actions"))
        ];
    }

    public function filters(): array
    {
        return [
            'status' => Filter::make(__("Status"))
                ->select(
                    [
                        'pending' => __('Pending'),
                        'paid' => __('Paid'),
                        'canceled' => __('Canceled'),
                    ]
                )
        ];

    }

    public function query(): Builder
    {
        $query = Sales::with('customer', 'transaction');
        return $query
            ->when($this->getFilter('search'), fn ($query) => $query->customerName($this->getFilter('search')))
            ->when($this->getFilter('status'), fn ($query) => $query->transactionStatus($this->getFilter('status')));
    }

    /**
     * Row view for the table.
     *
     * @return string
     */
    public function rowView() :string
    {
        return 'backend.sales.includes.row';
    }

}
