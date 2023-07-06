@extends('user.layouts.forms-loan')

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
                <span class="text-lg font-bold text-red-600">1 Hari</span> dihitung
                dari tanggal peminjaman.
            </p>
            <form class="w-full max-w-3xl card">
                <div class="flex flex-col items-center mb-[14px]">
                    <div class="flex flex-row mt-6 mb-1 text-lg font-semibold">
                        <div class="mb-3">
                            Daftar Barang Pinjaman
                        </div>
                    </div>
                    @if ($items->count() > 0)
                        <div class="form-group">
                            <div class="grid w-full grid-cols-2 grid-rows-none gap-4 p-3">
                                @foreach ($items as $index => $item)
                                    <div class="p-5 text-center border-2 border-indigo-100 border-solid card"
                                        id="card{{ $index }}">
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
                                        <img src="{{ filter_var($item->good->image, FILTER_VALIDATE_URL) ? $item->good->image : asset('storage/images/' . $item->good->image) }}"
                                            alt="Image" class="w-[150px] h-[150px] mx-auto my-2">
                                        @if (Str::length($item->good->description) < 30)
                                            <p class="mt-2 text-grey">
                                                {{ $item->good->description }}
                                            </p>
                                        @elseif (Str::length($item->good->description) >= 30)
                                            <p class="mt-2 text-grey">
                                                {{ Str::limit($item->good->description, 30) . '...' }}
                                            </p>
                                        @endif
                                        <div class="text-center">
                                            <form action="{{ route('user.loan.delete-item', ['id' => $item->good->id]) }}"
                                                method="POST" id="deleteForm{{ $index }}">
                                                @csrf
                                                <button type="button"
                                                    class="hover:cursor-pointer hover:opacity-75 btn btn-buttons-warn"
                                                    onclick="confirmDeleteItems(event, {{ $item->id }}, {{ $index }})">
                                                    Batalkan Pinjaman
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="flex flex-row">
                            <div class="p-4 mt-4">
                                <a href="#" onclick="history.back()"
                                    class="w-1/4 btn btn-primary bg-primary_hover hover:opacity-80">Kembali</a>
                            </div>
                            
                            <a href="{{ route('user.loan') }}" class="w-3/4 btn btn-primary mt-6 hover:opacity-80">
                                Selesaikan Peminjaman
                            </a>
                        </div>
                    @elseif ($items->isEmpty())
                        <div class="flex justify-center my-10 text-2xl font-bold text-red-600">
                            Anda Tidak Meminjam Apapun!
                        </div>
                        <div class="flex flex-row">
                          <div class="mt-6 px-5 ">
                            <a href="#" onclick="history.back()"
                                class="w-1/4 btn btn-primary_hover hover:opacity-80">Kembali</a>
                        </div>
                        <a href="{{ route('user.loan') }}" class="w-3/4 btn btn-primary mt-[14px]">
                            Selesaikan Peminjaman
                        </a>  
                        </div>
                        
                    @endif
                </div>

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
                    // Reload the page
                    window.location.reload();
                    // Hide the card
                    card.style.display = 'none';
                    // Reload the page if necessary
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
@endsection
