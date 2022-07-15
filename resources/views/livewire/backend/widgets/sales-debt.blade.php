<div wire:poll.10000ms>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <x-backend.card>
        <x-slot name="body">
            @if ($loading)
                <x-utils.loadings.small/>
            @else
                <h4 class="card-subtitle mb-4">@lang('Debt Sales')</h4>
                <div class="table-responsive">
                    <table class="table table-sm table-widget">
                        <tr>
                            <th>@lang('Invoice Number')</th>
                            <th>@lang('Customer')</th>
                            <th>@lang('Total')</th>
                            <th>@lang('Payment Amount')</th>
                            <th>@lang('Action')</th>
                        </tr>
                        @if (count($sales) > 0)
                            @foreach ($sales as $sale)
                                <tr>
                                    <td>{{ $sale->invoice_number }}</td>
                                    <td>{{ $sale->customer->name }}</td>
                                    <td>{{ rupiah($sale->grand_total) }}</td>
                                    <td>
                                        @if ($sale->transaction->hasPayment())
                                            {{ rupiah($sale->transaction->payment->amount) }}
                                        @else
                                            <span class="badge badge-danger">@lang('belum ada pembayaran')</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.sales.show', $sale->id) }}" target="_blank" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">@lang('Belum ada penjualan terhutang saat ini')</td>
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
