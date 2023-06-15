@extends('admin.layouts.base')

@section('title', 'Dashboard')

@section('content')
    {{-- <h1>ini dashboard</h1> --}}
    <div class="d-flex row justify-content-between">
        <div class="p-0 small-box bg-primary col">
            <div class="inner">
                <h3>{{ $goods }}</h3>
                <p>Goods</p>
            </div>
            <div class="icon">
                <i class="fas fa-laptop-house"></i>
            </div>
            <a href="{{ route('admin.good') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
        <div class="p-0 mx-3 small-box bg-success col">
            <div class="inner">
                <h3>{{ $procurements }}</h3>
                <p>Procurement</p>
            </div>
            <div class="icon">
                <i class="fas fa-file"></i>
            </div>
            <a href="{{ route('admin.procurement') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
        <div class="p-0 small-box bg-warning col">
            <div class="inner">
                <h3>{{ $loans }}</h3>
                <p>Loans</p>
            </div>
            <div class="icon">
                <i class="fas fa-people-carry"></i>
            </div>
            <a href="{{ route('admin.loan') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
@endsection
