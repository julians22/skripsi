<x-livewire-tables::bs4.table.cell>
    {{ $row->name }}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    {{ $row->description_short }}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    <a data-toggle="tooltip" data-placement="top" title="@lang('Edit')" class="btn btn-sm m-0 btn-primary p-px" href="{{ route('admin.category.edit', [ 'productCategory' => $row]) }}"><i class="fas fa-pen"></i></a>
    <form method="POST" action="{{ route('admin.category.destroy', ['productCategory' => $row]) }}" name="delete-item" class="d-inline">
        @csrf
        @method('delete')

        <button type="submit" class="btn btn-sm m-0 btn-danger p-px">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</x-livewire-tables::bs4.table.cell>
