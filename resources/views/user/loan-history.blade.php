@extends('user.layouts.base')

@section('title', 'Dashboard')

@section('content')

    @inject('carbon', 'Carbon\Carbon')
    <div class="lg:pr-[70px] py-[40px] px-4 lg:pl-0 lg:ml-10 w-full h-full">
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
                <div class="text-[32px] font-bold text-dark">Histori Peminjaman Barang</div>
            </div>
        </section>

        <section class="pt-[50px]">
            <!-- Section Header -->
            <div class="mb-[30px]">
                <div class="flex items-center justify-between gap-6">
                    <div>
                        <div class="text-xl font-semibold text-dark">Histori</div>
                        <p class="text-grey">Peminjaman Yang Sudah Kamu Lakukan di Perkantas</p>
                    </div>
                </div>
            </div>
        </section>
        {{-- section for flowbite --}}
        <section id="loanTableContainer">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full p-1 text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3" scope="col">
                                #
                            </th>
                            <th class="px-6 py-3" scope="col">
                                No.Pinjam
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Barang
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Tanggal Pinjam
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Tenggat
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Tanggal Kembali
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Periode
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Denda
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        <?php $counter = 1; ?>
                        @foreach ($loans as $lo)
                            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                <td class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $counter++ }}
                                </td>
                                <td class="px-6 py-3">
                                    {{ $lo->id }}
                                </td>
                                <td class="px-6 py-3">
                                    @foreach ($lo->item_loan as $item)
                                        <li>{{ $item->good->goods_name }}
                                            ({{ $item->good->condition == 'new' ? 'BARU' : ($item->good->condition == 'used' ? 'NORMAL' : 'RUSAK') }})
                                        </li>
                                    @endforeach
                                </td>
                                <td class="px-6 py-3 font-bold text-slate-600">
                                    {{ date('F j, Y h:i A', strtotime($lo->created_at)) }}
                                </td>
                                @if ($carbon::now()->greaterThan($lo->return_date) && $lo->is_returned === 0)
                                    <td class="px-6 py-3 text-red-700 font-bold">
                                        {{ date('F j, Y h:i A', strtotime($lo->return_date)) }}</td>
                                @else
                                    <td class="px-6 py-3 font-bold text-slate-600">
                                        {{ date('F j, Y h:i A', strtotime($lo->return_date)) }}</td>
                                @endif {{-- date comparison --}}

                                @if ($lo->is_returned === 1)
                                    <td class="px-6 py-3 font-bold text-slate-600">
                                        {{ date('F j, Y h:i A', strtotime($lo->updated_at)) }}</td>
                                @else
                                    <td class="px-6 py-3 text-center text-slate-600">-</td>
                                @endif
                                <td class="px-6 py-3">
                                    {{ $lo->period }}
                                </td>
                                <td class="px-6 py-3">
                                    {{ $lo->fine }}
                                </td>
                                @if ($lo->is_returned == 0)
                                    <td class="px-6 py-3 text-red-700 uppercase font-bold">{{ 'Dipinjam' }}</td>
                                @elseif($lo->is_returned == 1)
                                    <td class="px-6 py-3 text-green-600 uppercase font-bold">{{ 'Dikembalikan' }}
                                    </td>
                                @endif {{-- is_returned comparison --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection

@section('js')

    <script>
        $(document).ready(function() {
            $('#loanTableContainer table').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]], // Display dropdown with custom labels
            });
            // Adjust width of length menu dropdown
            $('.dataTables_length select').addClass('w-16');
            $('.dataTables_info').addClass('p-3 font-medium')
            $('.dataTables_paginate').addClass('m-1')
            
        });
    </script>
@endsection
