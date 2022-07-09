<?php

namespace App\Http\Livewire\Backend\Transaction;

use App\Http\Livewire\BaseTableStyle;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Purchase;

class PurchaseTable extends DataTableComponent
{
    use BaseTableStyle;

    public string $defaultSortColumn = 'created_at';
    public string $defaultSortDirection = 'desc';

    public function columns(): array
    {
        return [
            Column::make(__("Invoice Number"), 'invoice_number')
                ->searchable(),
            Column::make(__("Supplier"), 'supplier.name')
                ->searchable(),
            Column::make(__("Status")),
            Column::make(__("Total"), "total")
                ->sortable(),
            Column::make(__("Created at"), "created_at")
                ->sortable(),
            Column::make(__("Actions"))
        ];
    }

    public function query(): Builder
    {
        $query = Purchase::with('supplier', 'transaction');
        return $query
            ->when($this->getFilter('search'), fn ($query) => $query->supplierName($this->getFilter('search')));
    }

    /**
     * Row view for the table.
     *
     * @return string
     */
    public function rowView() :string
    {
        return 'backend.purchase.includes.row';
    }
}
