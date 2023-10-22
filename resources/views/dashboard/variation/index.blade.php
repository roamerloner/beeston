@extends('layouts.dashboardmaster')

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Product Add</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-6 col-lg-6">
            @livewire('variation.addsize')
        </div>
        <div class="col-xl-6 col-lg-6">
            @livewire('variation.addcolor')
        </div>
    </div>
@endsection




