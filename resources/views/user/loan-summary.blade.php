@extends('user.layouts.forms')

@section('title', 'Ringkasan Peminjaman')

@section('content')
    <div>
        <section class="py-[70px] flex flex-col items-center justify-center px-4">
            <div class="text-[32px] font-semibold text-dark">
                Ringkasan Peminjaman
            </div>
            <p class="mt-4 text-base leading-7 text-center mb-[50px] text-grey">
                Daftar Barang yang kamu pinjam kali ini! <br />
                Batas Pengembalian Barang adalah
                <span class="text-lg font-bold text-red-600">1 Minggu</span> dihitung
                dari tanggal peminjaman.
            </p>
            <form class="w-full max-w-2xl card">
                <div class="flex flex-col items-center mb-[14px]">
                    <div class="mt-6 mb-1 text-lg font-semibold">
                        Daftar Barang Pinjaman
                    </div>
                </div>
                <div class="form-group">
                    <div class="grid w-full grid-cols-1 grid-rows-none">
                        @foreach ($items as $index => $item)
                            <div class="p-3 card" id="card{{ $index }}">
                                <div class="items-end">
                                    <form action="{{ route('user.loan.delete-item', ['id' => $item->good->id]) }}" method="POST" id="deleteForm{{ $index }}">
                                        @csrf
                                        <button type="button" class="hover:cursor-pointer hover:opacity-50"
                                            onclick="confirmDeleteItems(event, {{ $item->id }}, {{ $index }})">
                                            <img src="/assets/svgs/ric-close-white.svg" alt="" />
                                        </button>
                                    </form>
                                </div>
                                <div class="font-semibold text-center text-dark justice-evenly">
                                    <div>{{ $item->good->goods_name }} ({{ $item->good->id }}) </div>
                                    <div>
                                        @if ($item->good->condition === 'broken')
                                            <p class="mt-5 font-bold text-center text-red-600 uppercase">
                                                rusak
                                            </p>
                                        @elseif ($item->good->condition === 'used')
                                            <p class="mt-5 font-bold text-center text-orange-400 uppercase">
                                                normal
                                            </p>
                                        @elseif ($item->good->condition === 'new')
                                            <p class="mt-5 font-bold text-center uppercase text-success">
                                                baru
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <img src={{ $item->good->image }} width="150" class="mt-5" alt="" />
                                @if (Str::length($item->good->description) < 75)
                                    <p class="mt-2 text-grey">
                                        {{ $item->good->description }}
                                    </p>
                                @elseif (Str::length($item->good->description) >= 75)
                                    <p class="mt-2 text-grey">
                                        {{ Str::limit($item->good->description, 75) . '...' }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('user.loan') }}" class="w-2/5 btn btn-primary mt-[14px]">
                    Selesaikan Peminjaman
                </a>
            </form>
        </section>
    </div>
@endsection

@section('js')
    <script>
        function confirmDeleteItems(event, itemId, index) {
            event.preventDefault(); // Prevent default form submission

            Swal.fire({
                title: 'Konfirmasi Hapus Barang',
                text: 'Apakah anda yakin ingin menghapus barang ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus Barang',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteItems(itemId, index);
                }
            });
        }

        function deleteItems(itemId, index) {
            var card = document.getElementById('card' + index);
            var url = '{{ route('user.loan.delete-item', ':id') }}';
            url = url.replace(':id', itemId);
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
                card.style.display = 'none'; // Hide the card
                // Reload the page if necessary
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
@endsection
