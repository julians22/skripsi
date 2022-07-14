<div wire:poll.10000ms>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <x-backend.card>
        <x-slot name="body">
            @if ($loading)
                <x-utils.loadings.small/>
            @else
                <h4 class="card-subtitle mb-4">@lang('Debt Sales')</h4>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tr>
                            <th>@lang('Invoice Number')</th>
                            <th>@lang('Customer')</th>
                            <th>@lang('Total')</th>
                        </tr>
                        @if (count($sales) > 0)
                            @foreach ($sales as $sale)
                                <tr>
                                    <td>{{ $sale->invoice_number }}</td>
                                    <td>{{ $sale->customer->name }}</td>
                                    <td>Rp. {{ rupiah($sale->grand_total) }}</td>
                                </tr>
                            @endforeach
                            <tr class="bg-dark">
                                <td colspan="2" align="right">@lang('Sub Total')</td>
                                <td>Rp. {{ rupiah($totalDebt) }}</td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="3">@lang('Belum ada penjualan terhutang saat ini')</td>
                            </tr>
                        @endif
                    </table>
                    <div class="w-100" style="overflow-x: auto">
                        {{ $sales->links() }}
                    </div>
                </div>
            @endif
        </x-slot>
    </x-backend.card>
</div>
