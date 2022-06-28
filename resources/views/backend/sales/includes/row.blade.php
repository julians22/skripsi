<x-livewire-tables::bs4.table.cell>
    <span class="badge badge-indigo">
        {{ $row->invoice_number }}
    </span>
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    {{ $row->customer->name }}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    @if ($row->transaction->hasPayment())
        @if ($row->status_label == 'paid')
            <span class="badge badge-success">
                {{ __($row->status_label) }}
            </span>
        @elseif ($row->status_label == 'canceled')
            <span class="badge badge-danger">
                {{ __($row->status_label) }}
            </span>
        @else
            <span class="badge badge-warning">
                {{__( $row->status_label) }}
            </span>
        @endif
    @else
        <span class="badge badge-danger">
            @lang('payment not found')
        </span>
    @endif
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    {{ rupiah($row->total) }}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    <span class="badge badge-orange">@displayDate($row->created_at, 'Y-M-d')</span>
</x-livewire-tables::bs4.table.cell>


<x-livewire-tables::bs4.table.cell>
    <a target="_blank" data-toggle="tooltip" data-placement="top" title="@lang('Print Invoice')" class="btn btn-sm m-0 btn-primary p-px" href="{{ route('admin.sales.print', ['sales' => $row]) }}"><i class="fas fa-print"></i></a>
    <a data-toggle="tooltip" data-placement="top" title="@lang('Show Sales')" class="btn btn-sm m-0 btn-success p-px" href="{{ route('admin.sales.show', ['sales' => $row]) }}"><i class="fas fa-eye"></i></a>
</x-livewire-tables::bs4.table.cell>
