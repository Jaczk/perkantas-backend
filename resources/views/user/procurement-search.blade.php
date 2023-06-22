@extends('user.layouts.base')

@section('title', 'Pengadaan')

@section('content')

    <div class="lg:pr-[70px] py-[50px] px-4 lg:pl-0 lg:ml-12 w-full">
        <!-- Top Section -->
        <section class="flex flex-col flex-wrap justify-between gap-6 md:items-center md:flex-row">
            <div class="flex items-center justify-between gap-4">
                <a href="#" id="toggleOpenSidebar" class="lg:hidden">
                    <svg class="w-6 h-6 text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7">
                        </path>
                    </svg>
                </a>
                <div class="text-[32px] font-semibold text-dark">
                    Daftar Pencarian Form Pengadaan Barang
                </div>
            </div>
            <div class="flex items-center gap-4">
                <form class="shrink md:w-[516px] w-full flex flex-row" action="{{ route('user.procurement.search') }}"
                    method="GET">
                    @csrf
                    <input type="text" name="query"
                        class="input-field !outline-none !border-none italic form-icon-search ring-indigo-200 focus:ring-2 transition-all duration-300 w-full"
                        placeholder="Cari Data Pengajuan..." />
                    <button type="submit" class="w-1/3 px-2 mx-2 btn btn-buttons">Cari</button>
                    <a class="btn btn-buttons" href="{{ route('user.procurement') }}">
                        Kembali
                    </a>
                </form>
            </div>
        </section>

        <section class="pt-[50px]">
            <!-- Section Header -->
            <div class="mb-[30px]">
                <div class="mb-[30px]">
                    <p class="text-xl font-medium">Menampilkan Hasil Pencarian Formulir Pengajuan Barang: <strong
                            class="text-3xl font-semibold uppercase text-dark">{{ $searchQuery }}</strong></p>
                </div>
            </div>

            @if ($procurements->isEmpty())
                <p class="pt-8 text-4xl font-bold text-dark">Tidak Ada Form Pengajuan Barang dengan Kata Pencarian di atas!</p>
            @else
                <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-[30px]">
                    @foreach ($procurements as $procurement)
                        <div
                            class="items-center card !flex-row gap-4 hover:bg-slate-200 hover:cursor-pointer bg-white rounded-2xl p-4">
                            <div class="flex flex-row">
                                <img src="/assets/svgs/ric-globe.svg" alt="" class="pl-2 pr-6" />
                                <div>
                                    <div class="place-items-end">
                                        @if ($procurement->status === 'pending')
                                            <div class="text-lg font-bold text-yellow-600 uppercase">
                                                Menunggu
                                            </div>
                                        @elseif ($procurement->status === 'approved')
                                            <div class="text-lg font-bold text-green-600 uppercase">
                                                Diterima
                                            </div>
                                        @elseif ($procurement->status === 'rejected')
                                            <div class="text-lg font-bold text-red-600 uppercase">
                                                Ditolak
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-1 font-semibold text-dark">
                                        {{ $procurement->goods_name }} ( {{ $procurement->goods_amount }} barang)
                                    </div>
                                    <div>
                                        @if ($procurement->status === 'pending')
                                            <p class="font-light">
                                                Menunggu Persetujuan Admin...
                                            </p>
                                        @elseif ($procurement->status === 'approved')
                                            <p class="font-light">
                                                Pengajuan Telah Disetujui
                                            </p>
                                        @elseif ($procurement->status === 'rejected')
                                            <p class="font-light">
                                                Pengajuan Anda Ditolak
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
        <script src="{{ asset('js/sweet-alert.js') }}"></script>
    </div>
@endsection
