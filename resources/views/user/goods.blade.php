@extends('user.layouts.base')

@section('title', 'Daftar Barang')

@section('content')
    <div>
        <div class="lg:pr-[70px] py-[50px] px-4 lg:pl-0 lg:ml-12">
            <!-- Top Section -->
            <section class="flex flex-col flex-wrap justify-between gap-6 md:items-center md:flex-row">
                <div class="flex items-center justify-between gap-4">
                    <a href="#" id="toggleOpenSidebar" class="lg:hidden">
                        <svg class="w-6 h-6 text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                    </a>
                    <div class="text-[32px] font-semibold text-dark">Katalog Barang</div>
                </div>

                <div class="flex items-center gap-4">
                    <form class="shrink md:w-[516px] w-full flex flex-row" action="{{ route('user.goods.search') }}"
                        method="GET">
                        @csrf
                        <input type="text" name="query"
                            class="input-field !outline-none !border-none italic form-icon-search ring-indigo-200 focus:ring-2 transition-all duration-300 w-full"
                            placeholder="Cari Barang..." />
                        <button type="submit" class="w-1/3 px-2 mx-2 btn btn-buttons">Search</button>
                    </form>
                </div>
            </section>

            <section class="pt-[50px]">
                <!-- Section Header -->
                <div class="mb-[30px]">
                    <div class="flex flex-col justify-between gap-6 sm:items-center sm:flex-row">
                        <div>
                            <div class="text-xl font-medium text-dark">Kategori</div>
                            <p class="text-grey">Kategori Barang Perkantas Semarang</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-6 lg:gap-5">
                    @foreach ($categories as $category)
                        <a href="{{ route('user.good.category', $category->id) }}">
                            <div class="card !gap-y-3 hover:bg-slate-100 hover:cursor-pointer">
                                <div class="flex flex-row items-center justify-between flex-nowrap">
                                    <div class="text-[20px] font-bold text-grey">
                                        {{ $category->category_name }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>

            <section class="pt-[50px]">
                <div class="mb-[30px]">
                    <div class="flex items-center justify-between gap-6">
                        <div>
                            <div class="text-xl font-medium text-dark">Daftar Barang</div>
                            <p class="text-grey">Daftar Barang Perkantas Semarang</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:gap-10 lg:gap-3">
                    @foreach ($goods as $good)
                        <div
                            class="items-center card py-6 md:!py-10 md:!px-[38px] !gap-y-0 hover:bg-slate-200 hover:cursor-pointer">

                            <div class="mx-2 font-semibold text-center text-dark ">
                                {{ $good->goods_name }}
                            </div>
                            <img src={{ $good->image }} width="150" class="mt-5" alt="" />
                            @if ($good->condition === 'broken')
                                <p class="mt-5 font-bold text-center text-red-600 uppercase">
                                    {{ $good->condition }}
                                </p>
                            @elseif ($good->condition === 'used')
                                <p class="mt-5 font-bold text-center text-orange-400 uppercase">
                                    {{ $good->condition }}
                                </p>
                            @elseif ($good->condition === 'new')
                                <p class="mt-5 font-bold text-center uppercase text-success">
                                    {{ $good->condition }}
                                </p>
                            @endif

                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
@endsection


@section('js')
    <script>
        $(document).ready(function() {
            $('#good').DataTable({
                dom: 'lBfrtipl',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            });
        });
    </script>
@endsection
