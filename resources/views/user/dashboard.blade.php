@extends('user.layouts.base')

@section('title', 'Dashboard')

@section('content')
    <div class="lg:pr-[70px] py-[50px] px-4 lg:pl-0 lg:ml-12 w-full h-full">
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
                <div class="text-[32px] font-bold text-dark">Dashboard</div>
            </div>
        </section>

        <section class="pt-[50px]">
            <!-- Section Header -->
            <div class="mb-[30px]">
                <div class="flex items-center justify-between gap-6">
                    <div>
                        <div class="text-xl font-semibold text-dark">Statistik</div>
                        <p class="text-grey">Yang Sudah Kamu Lakukan di Perkantas</p>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:gap-11">
                <!-- First Card -->
                <div class="card !gap-y-0 min-h-[100px] bg-white p-5 rounded-3xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-grey text-[23px] font-bold">Barang yang Dapat Dipinjam</p>
                            <div class="text-[56px] font-bold text-dark mt-[6px]">
                                {{ $goods }}
                            </div>
                        </div>
                    </div>
                    <button href="#" class="self-end w-2/5 p-2 btn btn-primary hover:text-lg hover:bg-primary_hover">
                        Pinjam
                    </button>
                </div>
                <!-- Second Card -->
                <div class="card !gap-y-0 min-h-[100px] bg-white p-5 rounded-3xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-grey text-[26px] font-bold">Total Pengajuan Barang</p>
                            <div class="text-[56px] font-bold text-dark mt-[6px]">
                                {{ $procurements }}
                            </div>
                        </div>
                    </div>
                    <button href="#" class="self-end w-1/2 p-2 btn btn-primary hover:text-lg hover:bg-primary_hover">
                        Ajukan Lagi
                    </button>
                </div>
                <!-- Third Card -->
                <div class="card !gap-y-0 min-h-[100px] bg-white p-5 rounded-3xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-grey text-[23px] font-bold">Barang Yang Masih Dipinjam</p>
                            <div class="text-[56px] font-bold text-dark mt-[6px]">
                               {{ $items }}
                            </div>
                        </div>
                    </div>
                    <button href="#" class="self-end w-3/6 p-2 btn btn-primary hover:text-lg hover:bg-primary_hover">
                        Kembalikan
                    </button>
                    {{-- <button href="#" v-else-if="can_return === 1"
                        class="self-end w-2/3 btn btn-primary hover:text-lg">
                        Kembalikan
                    </button> --}}
                </div>
            </div>
        </section>

        <section class="pt-[50px]">
            <div class="grid md:grid-cols-2 gap-11">
                <!-- Documents -->
                <div>
                    <!-- Section Header -->
                    <!-- <div class="mb-[30px]">
            <div class="flex items-center justify-between gap-6">
              <div>
                <div class="text-xl font-medium text-dark">Documents</div>
                <p class="text-grey">Standard procedure</p>
              </div>
            </div>
          </div>
          <div class="card md:min-h-[468px]">
            <div class="m-auto text-center">
              <div class="text-xl font-bold text-dark">No Documents</div>
              <p class="text-grey mt-5 mb-[30px]">
                Add guidance or design style for <br />
                your employees in company
              </p>
              <button type="button" class="btn btn-primary">
                Upload File
              </button>
            </div>
          </div> -->
                </div>

                <!-- History -->
                <div>
                    <!-- Section Header -->
                    <!-- <div class="mb-[30px]">
            <div class="flex items-center justify-between gap-6">
              <div>
                <div class="text-xl font-medium text-dark">History</div>
                <p class="text-grey">Track the flow</p>
              </div>
            </div>
          </div>
          <div class="card min-h-[468px]">
            <div class="m-auto text-center">
              <div class="text-xl font-bold text-dark">No History</div>
              <p class="text-grey mt-5 mb-[30px]">
                Information of employees added <br />
                and promoting shown here
              </p>
              <button type="button" class="btn btn-primary">
                Upload File
              </button>
            </div>
          </div> -->
                </div>
            </div>
        </section>
    </div>
@endsection
