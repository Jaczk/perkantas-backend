@extends('admin.layouts.base')

@section('title', 'Dashboard')

@section('content')
    {{-- <h1>ini dashboard</h1> --}}
    <div class="d-flex row justify-content-between"> {{-- row 1 --}}
        <div class="p-0 small-box bg-primary col">
            <div class="inner">
                <h3>{{ $goods }}</h3>
                <p>Barang</p>
            </div>
            <div class="icon">
                <i class="fas fa-laptop-house"></i>
            </div>
            <a href="{{ route('admin.good') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
        <div class="p-0 small-box bg-success col mx-3">
            <div class="inner">
                <h3>{{ $procurements }}</h3>
                <p>Pengadaan</p>
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
                <p>Peminjaman</p>
            </div>
            <div class="icon">
                <i class="fas fa-people-carry"></i>
            </div>
            <a href="{{ route('admin.loan') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="d-flex row justify-content-between"> {{-- row 2 --}}
        <div class="p-0 small-box bg-dark col">
            <div class="inner">
                <h3>{{ $brokenItem }}</h3>
                <p>Barang Rusak</p>
            </div>
            <div class="icon">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <a href="{{ route('admin.good') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
        <div class="p-0 small-box bg-danger col mx-3">
            <div class="inner">
                <h3>{{ $returnLate }}</h3>
                <p>Terlambat Dikembalikan</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <a href="{{ route('admin.loan') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
        <div class="p-0 small-box bg-info col">
            <div class="inner">
                <h3>{{ $userActive }}</h3>
                <p>Pengguna dengan Akses Pengembalian </p>
            </div>
            <div class="icon">
                <i class="fas fa-universal-access"></i>
            </div>
            <a href="{{ route('admin.user') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

@endsection
