@extends('user.layouts.base')

@section('title', 'Dashboard')

@section('content')
    <div class="container lg:pr-[70px] py-[50px] px-4 lg:pl-0 lg:ml-12 lg:w-screen md:w-screen sm:w-screen">
        <section class="flex flex-col flex-wrap gap-6 md:items-center md:flex-row">
            <div class="flex items-center justify-between gap-3">
                <a href="#" id="toggleOpenSidebar" class="lg:hidden">
                    <svg class="w-6 h-6 text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7">
                        </path>
                    </svg>
                </a>
                <div class="text-[32px] font-semibold text-dark">Daftar Pencarian Barang</div>
            </div>
            <div class="flex items-center gap-4">
                <form class="shrink md:w-[516px] w-full flex flex-row" action="{{ route('user.goods.search') }}"
                        method="GET">
                        @csrf
                        <input type="text" name="query"
                            class="input-field !outline-none !border-none italic form-icon-search ring-indigo-200 focus:ring-2 transition-all duration-300 w-full"
                            placeholder="Cari Barang..." />
                        <button type="submit" class="w-1/4 px-2 mx-2 btn btn-buttons">Cari</button>
                    </form>
                <a class="btn btn-buttons" href="{{ route('user.good') }}">
                    Kembali
                </a>
            </div>
        </section>
        <section>
            <div class="pt-[50px]">
                <div class="mb-[30px]">
                    <p class="text-xl font-medium">Menampilkan Hasil Pencarian Barang: <strong
                            class="text-3xl font-semibold uppercase text-dark">{{ $searchQuery }}</strong></p>
                </div>

                @if ($goods->isEmpty())
                    <p class="pt-8 text-4xl font-bold text-dark">Tidak Ada Barang dengan Kata Pencarian di atas!</p>
                @else
                    <div class="grid gap-6 md:grid-cols-8 lg:grid-cols-2">
                        @foreach ($goods as $good)
                        <div class="items-center card gap-4 lg:w-[450px]">
                            <div>
                                <div class="flex justify-between">
                                    <div class="text-lg font-bold text-dark">
                                        {{ $good->goods_name }}
                                    </div>
                                    <div>
                                        @if ($good->condition === 'broken')
                                            <p class="font-bold text-red-600 uppercase">
                                                rusak
                                            </p>
                                        @elseif ($good->condition === 'used')
                                            <p class="font-bold text-orange-400 uppercase">
                                                normal
                                            </p>
                                        @elseif ($good->condition === 'new')
                                            <p class="font-bold uppercase text-success">
                                                baru
                                            </p>
                                        @endif
                                    </div>
                                </div>
    
                                <img src={{ $good->image }} width="150" alt="" class="py-3 my-2" />
                                <p class="text-justify text-grey">{{ $good->description }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
