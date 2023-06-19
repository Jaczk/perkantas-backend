@extends('user.layouts.forms')

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
                <span class="text-lg font-bold">2 Minggu</span> dihitung dari tanggal
                peminjaman.
            </p>
            <form class="w-full max-w-2xl card">
                <div class="flex flex-col items-center mb-[14px]">
                    <div class="mt-6 mb-1 text-lg font-semibold">
                        Daftar Barang yang Tersedia
                    </div>
                </div>
                <div class="form-group">
                    <div class="grid grid-cols-2 grid-rows-none">
                        @foreach ($goods as $index => $good)
                            <form action="{{ route('user.loan.create', ['id' => $good->id]) }}" method="POST">
                                @csrf
                                <button type="button" onclick="addItems({{ $good->id }}, {{ $index }})"
                                    class="card !gap-y-0 bg-white hover:bg-slate-100 border-solid border-2 border-indigo-100 hover:cursor-pointer">
                                    <div class="p-3">
                                        <div class="font-semibold text-center text-dark justice-between">
                                            <div>{{ $good->goods_name }} ({{ $good->id }})</div>
                                            <div>
                                                @if ($good->condition === 'broken')
                                                    <p class="mt-1 font-bold text-center text-red-600 uppercase">
                                                        Rusak
                                                    </p>
                                                @elseif ($good->condition === 'used')
                                                    <p class="mt-1 font-bold text-center text-orange-400 uppercase">
                                                        Normal
                                                    </p>
                                                @elseif ($good->condition === 'new')
                                                    <p class="mt-1 font-bold text-center uppercase text-success">
                                                        Baru
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <img src="{{ $good->image }}" alt=""
                                            class="max-w-[10px] max-h-[10px] place-items-center">
                                        @if (Str::length($good->description) < 25)
                                            <p class="mt-2 text-grey">
                                                {{ $good->description }}
                                            </p>
                                        @elseif (Str::length($good->description) >= 25)
                                            <p class="mt-2 text-grey">
                                                {{ Str::limit($good->description, 25) . '...' }}
                                            </p>
                                        @endif
                                    </div>
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
                <a href="#" class="w-full btn btn-primary mt-[14px]">
                    Lihat Ringkasan Peminjaman
                </a>
            </form>
        </section>
    </div>
@endsection

@section('js')
    <script>
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
                    window.location.reload();
                    // Hide the card
                    card.style.display = 'none';

                    // Reload the page
                    
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
@endsection
