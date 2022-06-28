<x-livewire-tables::bs4.table.cell>
    {{ $row->name }}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    {{ $row->phone }}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    {{ $row->email }}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    <a data-toggle="tooltip" data-placement="top" title="@lang('Edit Customer')" class="btn btn-sm m-0 btn-primary p-px" href="{{ route('admin.customer.edit', [ 'customer' => $row]) }}"><i class="fas fa-pen"></i></a>
    <a data-toggle="tooltip" data-placement="top" title="@lang('Show Customer')" class="btn btn-sm m-0 btn-success p-px" href="{{ route('admin.customer.show', [ 'customer' => $row]) }}"><i class="fas fa-eye"></i></a>
    <form method="POST" action="{{ route('admin.customer.destroy', ['customer' => $row]) }}" name="delete-item" class="d-inline">
        @csrf
        @method('delete')

        <button type="submit" class="btn btn-sm m-0 btn-danger p-px">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</x-livewire-tables::bs4.table.cell>
