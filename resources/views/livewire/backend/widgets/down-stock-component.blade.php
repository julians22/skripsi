<div wire:poll.10000ms>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <x-backend.card>
        <x-slot name="body">
            @if ($loading)
                <x-utils.loadings.small/>
            @else
                <h4 class="card-subtitle mb-4">@lang('Run out stock')</h4>
                <div class="table-responsive">
                    <table class="table table-sm table-widget">
                        <tr>
                            <th>@lang('Name')</th>
                            <th>@lang('Quantity')</th>
                            <th>@lang('Action')</th>
                        </tr>
                        @foreach ($products as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>
                                    <a href="{{ route('admin.product.edit', $item->id) }}" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="w-100" style="overflow-x: auto">
                        {{ $products->links() }}
                    </div>
                </div>
            @endif
        </x-slot>
    </x-backend.card>
</div>
