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
            </div>
            <div class="flex items-center gap-4">
                <form class="shrink md:w-[516px] w-full">
                    <input type="text" v-model="search"
                        class="input-field !outline-none !border-none italic form-icon-search ring-indigo-200 focus:ring-2 transition-all duration-300 w-full"
                        placeholder="Cari Barang..." />
                </form>
                <a href="#"
                    class="flex-none w-[46px] h-[46px] bg-white rounded-full p-[11px] relative notification-dot">
                    <img src="/assets/svgs/ic-bell.svg" alt="" />
                </a>
            </div>
        </section>

        <section class="pt-[50px]">
            <!-- Section Header -->
            <div class="mb-[30px]">
                <div class="flex flex-col justify-between gap-6 sm:items-center sm:flex-row">
                    <div>
                        @if ($goods->isNotEmpty())
                            <span class="text-2xl text-dark">{{ $goods[0]->category->category_name }}</span>
                        @else
                            <h1>Tidak ada Barang Pada Kategori ini</h1>
                        @endif
                    </div>
                    <div>
                        <a onclick="history.back()" style="cursor:pointer">
                            <img src="/assets/svgs/ric-close-white.svg" alt="" />
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 gap-10 md:grid-cols-8 lg:grid-cols-2">

                @foreach ($goods as $good)
                    <div class="items-center card !flex-row gap-4">
                        <div>
                            <div class="flex justify-between">
                                <div class="text-lg font-bold text-dark">
                                    {{ $good->good_name }}
                                </div>
                                <div>
                                    @if ($good->condition === 'broken')
                                        <p class="mt-5 font-bold text-center text-red-600 uppercase">
                                            rusak
                                        </p>
                                    @elseif ($good->condition === 'used')
                                        <p class="mt-5 font-bold text-center text-orange-400 uppercase">
                                            normal
                                        </p>
                                    @elseif ($good->condition === 'new')
                                        <p class="mt-5 font-bold text-center uppercase text-success">
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
        </section>
    </div>
@endsection
