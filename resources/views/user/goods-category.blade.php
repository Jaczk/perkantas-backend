@extends('user.layouts.base')

@section('title', 'Daftar Barang Kategori')

@section('content')
    <div class="lg:pr-[70px] py-[50px] px-4 lg:pl-0 lg:ml-12">
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
                <div class="text-[32px] font-semibold text-dark">Daftar Barang</div>
                <div class="flex items-center gap-4">
                    {{-- <form class="shrink md:w-[516px] w-full flex flex-row" action="{{ route('user.goods.search') }}"
                            method="GET">
                            @csrf
                            <input type="text" name="query"
                                class="input-field !outline-none !border-none italic form-icon-search ring-indigo-200 focus:ring-2 transition-all duration-300 w-full"
                                placeholder="Cari Barang..." />
                            <button type="submit" class="w-1/3 px-2 mx-2 btn btn-buttons">Cari</button>
                        </form> --}}
                    <a class="btn btn-buttons" href="{{ route('user.good') }}">
                        Kembali
                    </a>
                </div>
            </div>
        </section>

        <section class="pt-[50px]">
            <!-- Section Header -->
            <div class="mb-[30px]">
                <div class="flex flex-col justify-between gap-6 sm:items-center sm:flex-row">
                    <div>
                        @if ($goods->isNotEmpty())
                            <h2 class="text-lg font-medium">Berdasarkan Kategori: <span
                                    class="text-3xl font-semibold text-dark">{{ $goods[0]->category->category_name }}</span></h2>
                        @else
                            <h1>Tidak ada Barang Pada Kategori ini</h1>
                        @endif
                    </div>
                </div>
            </div>

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
                                        <p class="mx-5 font-bold text-red-600 uppercase">
                                            rusak
                                        </p>
                                    @elseif ($good->condition === 'used')
                                        <p class="mx-5 font-bold text-orange-400 uppercase">
                                            normal
                                        </p>
                                    @elseif ($good->condition === 'new')
                                        <p class="mx-5 font-bold uppercase text-success">
                                            baru
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <img src="{{ filter_var($good->image, FILTER_VALIDATE_URL) ? $good->image : asset('storage/images/' . $good->image) }}" width="150" alt="" class="py-3 my-2" />
                            <p class="text-justify text-grey">{{ $good->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
