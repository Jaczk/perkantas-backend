@extends('admin.layouts.base')

@section('title', 'Dashboard')

@section('content')
    {{-- <h1>ini dashboard</h1> --}}
    <div class="d-flex row justify-content-between">
        <div class="small-box bg-info col">
            <div class="inner">
                <h3>{{ $goods }}</h3>
                <p>Goods</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="#" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
        <div class="small-box bg-info col mx-3">
            <div class="inner">
                <h3>{{ $procurements }}</h3>
                <p>Procurement</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="#" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
        <div class="small-box bg-info col">
            <div class="inner">
                <h3>{{ $loans }}</h3>
                <p>Loans</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="#" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
@endsection
