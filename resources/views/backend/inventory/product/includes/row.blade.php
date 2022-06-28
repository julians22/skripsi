<x-livewire-tables::bs4.table.cell>
    {{ $row->code }}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    {{ $row->name }}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    {{ rupiah($row->price) }}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    {{ $row->quantity }}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    {{ $row->category->name ?? 'Not Categoried' }}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    <a data-toggle="tooltip" data-placement="top" title="@lang('Edit Product')" class="btn btn-sm m-0 btn-primary p-px" href="{{ route('admin.product.edit', [ 'product' => $row]) }}"><i class="fas fa-pen"></i></a>
    <a data-toggle="tooltip" data-placement="top" title="@lang('Show Product')" class="btn btn-sm m-0 btn-success p-px" href="{{ route('admin.product.show', [ 'product' => $row]) }}"><i class="fas fa-eye"></i></a>
    <form method="POST" action="{{ route('admin.product.destroy', ['product' => $row]) }}" name="delete-item" class="d-inline">
        @csrf
        @method('delete')

        <button type="submit" class="btn btn-sm m-0 btn-danger p-px">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</x-livewire-tables::bs4.table.cell>
