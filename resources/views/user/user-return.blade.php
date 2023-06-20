@extends('user.layouts.forms')

@section('title', 'Pengembalian Barang')

@section('content')
    <div>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <section class="py-[70px] flex flex-col items-center justify-center px-4">
            <div class="text-[32px] font-semibold text-dark">Kembalikan Barang</div>
            <p class="mt-4 mb-3 text-base leading-7 text-center text-grey">
                Pilih Nomor Peminjaman Barang yang akan dikembalikan
            </p>
            <div class="w-full max-w-2xl card">
                <div class="flex flex-col items-center mb-[14px]">
                    <div class="mt-6 mb-1 text-lg font-semibold">
                        Daftar peminjaman barang yang telah anda dilakukan
                    </div>
                </div>
                <div class="form-group">
                    <div class="grid grid-cols-2 grid-rows-none col-span-full">
                        @foreach ($loans as $loan)
                            <div class="p-2 font-bold text-center">
                                <form action="{{ route('user.return-items', ['id' => $loan->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="gap-2 bg-white border-2 border-indigo-100 border-solid card hover:bg-slate-100 hover:cursor-pointer confirm-return-alert">
                                        <div class="p-3">
                                            <div class="items-center font-semibold">
                                                Nomor Peminjaman: {{ $loan->id }}
                                            </div>
                                            @foreach ($loan['item_loan'] as $item_loan)
                                                <div class="font-medium text-center text-dark justice-between">
                                                    <div>&#x2022; {{ $item_loan->good->goods_name }}
                                                        ({{ $item_loan->good->id }})
                                                    </div>
                                                    <div>
                                                        @if ($item_loan->good->condition === 'broken')
                                                            <p
                                                                class="mt-1 font-semibold text-center text-red-600 uppercase">
                                                                Rusak
                                                            </p>
                                                        @elseif ($item_loan->good->condition === 'used')
                                                            <p
                                                                class="mt-1 font-semibold text-center text-orange-400 uppercase ">
                                                                Normal
                                                            </p>
                                                        @elseif ($item_loan->good->condition === 'new')
                                                            <p
                                                                class="mt-1 font-semibold text-center uppercase text-success">
                                                                Baru
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="font-bold">
                                            Harap dikembalikan sebelum:
                                            <span>{{ Carbon\Carbon::parse($loan->return_date)->format('d F Y') }}</span>
                                        </div>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <a href="{{ route('user.loan') }}" class="w-2/5 btn btn-primary mt-[14px]">
                Kembali Ke Daftar Peminjaman
            </a>
        </section>
    </div>
@endsection

@section('js')
    <script>
        document.querySelectorAll('.confirm-return-alert').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent default form submission

                Swal.fire({
                    title: 'Ajukan Pengembalian Barang',
                    text: 'Barang yang telah dikembalikan tidak dapat dikembalikan lagi. Apakah anda yakin ingin mengajukan pengembalian barang?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Kembalikan Barang',
                    cancelButtonText: 'Kembali',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // User confirmed, submit the form
                        event.target.closest('form').submit();
                    }
                });
            });
        });
    </script>
@endsection
