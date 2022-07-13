@extends('backend.layouts.app')

@section('title', 'Report')

@section('content')
<div class="row">
    <div class="col-md-12">
        <x-backend.card>
            <x-slot name="header">
                @lang('Report Sales')
            </x-slot>

            <x-slot name="body">
                <report-sales :products='@json($sales_products)'/>
            </x-slot>
        </x-backend.card>

        <x-backend.card>
            <x-slot name="header">
                @lang('Report Purchase')
            </x-slot>

            <x-slot name="body">
                <report-purchase :products='@json($purchase_products)'/>
            </x-slot>
        </x-backend.card>
    </div>
</div>
@endsection

