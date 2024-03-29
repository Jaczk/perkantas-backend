@extends('user.layouts.base')

@section('title', 'Dashboard')

@section('content')
    <div class="lg:pr-[70px] py-[50px] px-8 lg:px-4 lg:pl-0 lg:ml-12 w-full h-full overflow-x-visible">
        <!-- Top Section -->
        <section class="flex flex-col flex-wrap justify-between gap-6 md:items-center md:flex-row">
            <div class="flex items-center gap-4">
                <a href="#" id="toggleOpenSidebar" class="lg:hidden">
                    <svg class="w-6 h-6 text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7">
                        </path>
                    </svg>
                </a>
                <div class="text-[32px] font-bold text-dark">Dasbor</div>
            </div>
        </section>

        <section class="pt-[50px]">
            <!-- Section Header -->
            <div class="mb-[30px]">
                <div class="flex items-center justify-between gap-6">
                    <div>
                        <div class="text-2xl font-semibold md:text-xl text-dark">Statistik</div>
                        <p class="text-grey">Yang Sudah Kamu Lakukan di Perkantas</p>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:gap-11">
                <!-- First Card -->
                <div class="card !gap-y-0 min-h-[100px] bg-white p-5 rounded-3xl text-center md:text-left">
                    <div class="flex self-center">
                        <div>
                            <p class="text-grey text-[20px] md:text-[23px] font-bold">Barang yang Dapat Dipinjam</p>
                            <div class="text-[56px] font-bold text-dark mt-[6px] ">
                                {{ $goods }}
                            </div>
                        </div>
                    </div>
                    @if ($user->total_fine > 0)
                        <button
                            class="flex self-center w-2/3 md:self-end md:w-2/5 md:p-2 btn btn-primary md:hover:text-lg hover:bg-primary_hover"
                            onclick="alertLoan(event)">
                            <span class="mx-auto text-lg md:text-base">Pinjam</span>
                        </button>
                    @elseif ($user->total_fine === 0)
                        <form action="{{ route('user.loan.store') }}" enctype="multipart/form-data" method="POST"
                            class="flex self-center w-2/3 md:self-end md:w-2/5 md:p-2 btn btn-primary md:hover:text-lg hover:bg-primary_hover">
                            @csrf
                            <button type="submit" class="mx-auto text-lg md:text-base">Pinjam</button>
                        </form>
                    @endif

                </div>
                <!-- Second Card -->
                <div class="card !gap-y-0 min-h-[100px] bg-white p-5 rounded-3xl">
                    <div class="flex self-center">
                        <div>
                            <p class="text-grey text-xl text-center md:text-left md:text-[26px] font-bold">Total Pengajuan Barang</p>
                            <div class="text-[56px] font-bold text-dark mt-[6px] text-center md:text-left">
                                {{ $procurements }}
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('user.procurement.add') }}"
                        class="flex self-center w-2/3 md:self-end md:w-2/5 md:p-2 btn btn-primary md:hover:text-lg hover:bg-primary_hover">
                        <span class="w-full text-center text-lg md:text-base max-[240px]:text-[12px]">Ajukan Lagi</span>
                    </a>
                </div>
                <!-- Third Card -->
                <div class="card !gap-y-0 min-h-[100px] bg-white p-5 rounded-3xl">
                    <div class="flex self-center">
                        <div>
                            <p class="text-grey text-xl text-center md:text-left md:text-[23px] font-bold">Barang Yang Masih Dipinjam</p>
                            <div class="text-[56px] font-bold text-dark mt-[6px] text-center md:text-left">
                                {{ $items }}
                            </div>
                        </div>
                    </div>
                    @if ($user->can_return === 0)
                        <button
                            class="flex self-center w-2/3 md:self-end md:w-2/5 md:p-2 btn btn-primary md:hover:text-lg hover:bg-primary_hover"
                            onclick="alertReturn(event)">
                            <span class="w-full text-center text-lg md:text-base xsm:text-[20px]">Kembalikan</span>
                        </button>
                    @elseif ($user->can_return === 1)
                        <a href="{{ route('user.return') }}"
                            class="flex self-center w-2/3 md:self-end md:w-2/5 md:p-2 btn btn-primary md:hover:text-lg hover:bg-primary_hover">
                            <span class="w-full text-center text-lg md:text-base xsm:text-[20px]">Kembalikan</span>
                        </a>
                    @endif
                </div>
            </div>
        </section>

        <section class="pt-[30px] md:pt-[50px]">
            <div class="grid md:grid-cols-2 gap-11 lg:grid-cols-2">
                <div>
                    <div class="card !gap-y-0 min-h-[100px] bg-white p-5 rounded-3xl">
                        <div class="flex self-center justify-between">
                            <div>
                                <p class="text-grey text-xl md:text-[23px] font-bold">Total Denda Anda</p>
                                @if ($totalFine === 0)
                                    <p class="text-dark text-[23px] font-bold">Anda Tidak Memiliki Denda</p>
                                @else
                                    <div class="text-[40px] md:text-[56px] font-bold text-dark mt-[6px]">
                                        Rp {{ $totalFine }}000
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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

        function alertLoan(event) {
            event.preventDefault(); // Prevent form submission

            Swal.fire({
                toast: true,
                icon: 'warning',
                title: 'Harap Selesaikan Pembayaran Denda Anda Terlebih Dahulu!',
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
        }
    </script>
@endsection
