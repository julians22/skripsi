@extends('backend.layouts.app')

@section('title', 'Report')

@section('content')
<div class="row">
    <div class="col-md-12">
        <x-backend.card>
            <x-slot name="header">
                @lang('Report')
            </x-slot>

            <x-slot name="body">
                <report :products='@json($products)'/>
            </x-slot>
        </x-backend.card>
    </div>
</div>
@endsection

