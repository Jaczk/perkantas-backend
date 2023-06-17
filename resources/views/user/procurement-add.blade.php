@extends('user.layouts.forms')

@section('title', 'Tambah Pengadaan')

@section('content')
    <div>
        <section class="py-[70px] flex flex-col items-center justify-center px-4">
            <div class="text-[32px] font-semibold text-dark">
                Form Permintaan Barang Baru
            </div>
            <p class="mt-4 text-base leading-7 text-center mb-[50px] text-grey">
                Perkantas menerima dengan senang hati <br />
                Segala bentuk komplain dan saran dari anda
            </p>
            <form class="w-full card" enctype="multipart/form-data" method="POST" action="{{ route('user.procurement.store') }}">
                @csrf
                <div class="form-group">
                    <label for="" class="text-grey">Nama Barang</label>
                    <input type="text" class="input-field" placeholder="Tulis barang yang akan diajukan..." name="goods_name"/>
                </div>
                <div class="form-group">
                    <label for="idRes" class="text-grey">Jumlah Barang</label>
                    <input type="number" class="input-field" placeholder="Tuliskan jumlah barang yang akan diajukan..." name="goods_amount"/>
                </div>
                <div class="form-group">
                    <label class="text-grey">Alasan Permintaan</label>
                    <input type="text" class="input-field" placeholder="Sebutkan alasan permintaan..." name="description">
                </div>
                <button type="submit" class="w-full btn btn-primary mt-[14px]">
                    Ajukan Pengadaan
                </button>
            </form>
        </section>
    </div>
@endsection