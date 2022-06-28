@extends('backend.layouts.app')

@section('title', 'Report')

@section('content')
<div class="row">
    <div class="col-md-6">
        <x-backend.card>
            <x-slot name="header">
                @lang('Sales Report')
            </x-slot>

            <x-slot name="body">
                <select-date></select-date>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <form action="{{ route('admin.report.sales') }}" method="post">
                            @csrf
                            <report-out></report-out>
                        </form>
                    </div>
                </div>
            </x-slot>
        </x-backend.card>
    </div>

    <div class="col-md-6">
        <x-backend.card>
            <x-slot name="header">
                @lang('Purchase Report')
            </x-slot>

            <x-slot name="body">
                <select-date align="right"></select-date>
            </x-slot>
        </x-backend.card>
    </div>
</div>
@endsection

