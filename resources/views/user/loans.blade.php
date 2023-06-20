@extends('user.layouts.base')

@section('title', 'Peminjaman Barang')

@section('content')
    <div>
        <!-- Main Content -->
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
                    <div class="text-[32px] font-semibold text-dark">
                        Peminjaman Barang
                    </div>
                </div>
            </section>

            <section class="pt-[50px]">
                <!-- Section Header -->
                <div class="mb-[30px]">
                    <div class="flex flex-col justify-between gap-6 sm:items-center sm:flex-row">
                        <div>
                            <div class="text-xl font-medium text-dark">Statistik</div>
                            <p class="text-grey">Daftar Peminjaman Barang</p>
                        </div>
                        <div class="flex flex-row">
                            @if ($user->can_return === 0)
                                <button class="cursor-not-allowed btn btn-primary" onclick="alertReturn(event)">
                                    Kembalikan Barang
                                </button>
                            @elseif ($user->can_return === 1)
                                <a href="{{ route('user.return') }}" class="btn btn-primary">
                                    Kembalikan Barang
                                </a>
                            @endif
                            <form action="{{ route('user.loan.store') }}" enctype="multipart/form-data" method="POST"
                                class="px-5">
                                @csrf
                                <button type="submit" class="btn btn-primary ">
                                    Buat Peminjaman
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:gap-11">
                    <div class="card !gap-y-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-grey">Total Peminjaman Barang</p>
                                <div class="text-[32px] font-bold text-dark mt-[6px]">
                                    {{ count($items) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card !gap-y-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-grey">Yang Masih Dipinjam</p>
                                <div class="text-[32px] font-bold text-dark mt-[6px]">
                                    {{ count($filteredItems) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card !gap-y-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-grey">Yang Sudah Dikembalikan</p>
                                <div class="text-[32px] font-bold text-dark mt-[6px]">
                                    {{ count($items) - count($filteredItems) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="pt-[50px]">
                <!-- Section Header -->
                <div class="mb-[30px]">
                    <div class="flex items-center justify-between gap-6">
                        <div>
                            <div class="text-xl font-medium text-dark">Daftar Barang</div>
                            <p class="text-grey">Harap Dikembalikan sebelum waktunya ya!</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:gap-10 lg:gap-3">
                    <!-- Card -->
                    @foreach ($filteredItems as $item)
                        <div class="items-center card py-6 md:!py-10 md:!px-[38px] !gap-y-0">
                            <div class="mb-2 font-semibold text-center text-dark">
                                Nomor Peminjaman {{ $item->loan->id }}
                            </div>
                            <img src={{ $item->good->image }} width="150" alt="" />
                            <p class="text-center text-grey mt-[8px]">
                                {{ $item->good->goods_name }}
                            </p>
                            <div class="mt-[10px] px-5 text-dark font-semibold text-lg flex text-center">
                                {{ \Carbon\Carbon::parse($item->loan->return_date)->format('d-m-Y') }}
                            </div>
                            @if (\Carbon\Carbon::now()->greaterThan($item->loan->return_date))
                                <div class="mt-[10px] px-5 text-red-600 font-bold text-lg flex text-center">
                                    {{ abs(intval(\Carbon\Carbon::parse($item->loan->return_date)->diffInDays(\Carbon\Carbon::now()))) }}
                                    Hari Terlambat
                                </div>
                            @else
                                <div class="mt-[10px] px-5 text-green-600 font-bold text-lg flex text-center">
                                    {{ \Carbon\Carbon::parse($item->loan->return_date)->diffInDays(\Carbon\Carbon::now()) }}
                                    Hari Lagi
                                </div>
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
        function alertReturn(event) {
            event.preventDefault(); // Prevent form submission

            Swal.fire({
                toast: true,
                icon: 'warning',
                title: 'Harap Menghubungi Admin Terlebih Dahulu',
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
        }
    </script>
@endsection
