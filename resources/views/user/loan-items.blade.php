@extends('user.layouts.forms-loan')

@section('title', 'Pilih Barang')

@section('content')
    <div>
        @if (session('refresh'))
            <script>
                window.location.reload();
            </script>
        @endif
        <section class="py-[70px] flex flex-col items-center justify-center px-4">
            <div class="text-[32px] font-semibold text-dark">Pilih Barang</div>
            <p class="mt-4 text-base leading-7 text-center mb-[50px] text-grey">
                Pilih Barang Yang akan Anda Pinjam! <br />
                Batas Pengembalian Barang adalah
                <span class="text-lg font-bold text-red-600">1 Hari</span> dihitung dari tanggal
                peminjaman.
            </p>
            <form class="w-full max-w-3xl card ">
                <div class="flex flex-col items-center mb-[14px]">
                    <div class="mt-6 mb-1 text-2xl font-semibold">
                        Daftar Barang yang Tersedia
                    </div>
                </div>
                <div class="form-group ">
                    <div class="grid grid-cols-2 grid-rows-none ">
                        @foreach ($goods as $index => $good)
                            <form action="{{ route('user.loan.create', ['id' => $good->id]) }}" method="POST"
                                class="p-3">
                                @csrf
                                <button type="button" onclick="confirmAddItems({{ $good->id }}, {{ $index }})"
                                    class="card !gap-y-0 bg-white lg:w-[350px] lg:h-[320px] hover:bg-slate-100 border-solid border-2 border-indigo-100 hover:cursor-pointer">
                                    <div class="p-2 mx-auto space-x-0">
                                        <div class="font-semibold text-center text-dark justice-between">
                                            <div>{{ $good->goods_name }} ({{ $good->id }})</div>
                                            <div>
                                                @if ($good->condition === 'broken')
                                                    <p class="my-2 font-bold text-center text-red-600 uppercase">
                                                        Rusak
                                                    </p>
                                                @elseif ($good->condition === 'used')
                                                    <p class="my-2 font-bold text-center text-orange-400 uppercase">
                                                        Normal
                                                    </p>
                                                @elseif ($good->condition === 'new')
                                                    <p class="my-2 font-bold text-center uppercase text-success">
                                                        Baru
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <img src="{{ filter_var($good->image, FILTER_VALIDATE_URL) ? $good->image : asset('storage/images/' . $good->image) }}"
                                            alt="Image" class="inline-block w-[120px] h-[120px] align-middle my-2">
                                        @if (Str::length($good->description) < 60)
                                            <p class="my-2 text-grey">
                                                {{ $good->description }}
                                            </p>
                                        @elseif (Str::length($good->description) >= 60)
                                            <p class="my-2 text-grey">
                                                {{ Str::limit($good->description, 60) . '...' }}
                                            </p>
                                        @endif
                                    </div>
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('user.user-summary', ['loanId' => Crypt::encrypt(session()->get('loanId'))]) }}"
                    class="w-1/2 btn btn-primary mt-[14px]">
                    Lihat Ringkasan Peminjaman
                </a>
            </form>
        </section>
    </div>
@endsection

@section('js')
    <script>
        function confirmAddItems(goodId, index) {
            Swal.fire({
                title: 'Konfirmasi Tambah Barang Peminjaman',
                text: 'Apakah Anda Yakin ingin Meminjam Barang ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Tambahkan Barang',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    addItems(goodId, index);
                }
            });
        }

        function addItems(goodId, index) {
            var card = document.getElementById('card' + index);
            var url = '{{ route('user.loan.create', ':id') }}';
            url = url.replace(':id', goodId);
            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        _token: '{{ csrf_token() }}',
                    }),
                })
                .then(response => {
                    // Handle the response here
                    
                    // Reload the page
                    window.location.reload();
                    // Hide the card
                    card.style.display = 'none';


                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
@endsection
