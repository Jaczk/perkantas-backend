@extends('user.layouts.base')

@section('title', 'Dashboard')

@section('content')

    @inject('carbon', 'Carbon\Carbon')
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

        <section class="pt-[10px]">
            <div class="container flex justify-center mx-auto">
                <div class="flex flex-col">
                    <div class="w-full">

                        <table class="divide-y divide-gray-300" id="dataTable">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-2 text-base text-gray-500">
                                        #
                                    </th>
                                    <th class="px-6 py-2 text-base text-gray-500">
                                        No.Peminjaman
                                    </th>
                                    <th class="px-6 py-2 text-base text-gray-500">
                                        Barang
                                    </th>
                                    <th class="px-6 py-2 text-base text-gray-500">
                                        Tanggal Pinjam
                                    </th>
                                    <th class="px-6 py-2 text-base text-gray-500">
                                        Tenggat
                                    </th>
                                    <th class="px-6 py-2 text-base text-gray-500">
                                        Tanggal Dikembalikan
                                    </th>
                                    <th class="px-6 py-2 text-base text-gray-500">
                                        Periode
                                    </th>
                                    <th class="px-6 py-2 text-base text-gray-500">
                                        Denda
                                    </th>
                                    <th class="px-6 py-2 text-base text-gray-500">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-500">
                                <?php $counter = 1; ?>
                                
                                @foreach ($loans as $lo)
                                    <tr>
                                        <td class="text-center text-sm text-gray-900">{{ $counter++ }}</td>
                                        <td class="text-center text-sm text-gray-900">{{ $lo->id }}</td>
                                        <td class="text-sm text-gray-900">
                                            @foreach ($lo['item_loan'] as $item)
                                                <li>{{ $item->good->goods_name }}
                                                    ({{ $item->good->condition == 'new' ? 'BARU' : ($item->good->condition == 'used' ? 'NORMAL' : 'RUSAK') }})
                                                </li>
                                            @endforeach
                                        </td>
                                        <td class="text-center text-sm text-gray-900">{{ date('F j, Y h:i A', strtotime($lo->created_at)) }}

                                        </td>
                                        @if ($carbon::now()->greaterThan($lo->return_date) && $lo->is_returned === 0)
                                            <td class="text-red-700 font-bold">
                                                {{ date('F j, Y h:i A', strtotime($lo->return_date)) }}</td>
                                        @else
                                            <td class="font-bold">
                                                {{ date('F j, Y h:i A', strtotime($lo->return_date)) }}</td>
                                        @endif {{-- date comparison --}}

                                        @if ($lo->is_returned === 1)
                                            <td class="font-bold">
                                                {{ date('F j, Y h:i A', strtotime($lo->updated_at)) }}</td>
                                        @else
                                            <td class="text-center">-</td>
                                        @endif

                                        <td class="text-center text-sm text-gray-900">{{ $lo->period }}</td>
                                        <td class="text-center text-sm text-gray-900">{{ $lo->fine }}</td>

                                        @if ($lo->is_returned == 0)
                                            <td class="text-red-700 font-weight-bold">{{ 'Dipinjam' }}</td>
                                        @elseif($lo->is_returned == 1)
                                            <td class="text-green-600 font-weight-bold">{{ 'Dikembalikan' }}</td>
                                        @endif {{-- is_returned comparison --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();

        });
    </script>
@endsection
