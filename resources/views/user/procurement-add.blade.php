@extends('user.layouts.forms')

@section('title', 'Tambah Pengadaan')

@section('content')
    <div>
        <section class="py-[70px] flex flex-col items-center justify-center px-4">
            <div class="text-[32px] font-semibold text-dark">
                Form Permintaan Barang
            </div>
            <p class="mt-4 text-base leading-7 text-center mb-[50px] text-grey">
                Perkantas menerima dengan senang hati <br />
                Segala bentuk komplain dan saran dari anda
            </p>
            {{-- Alert Here --}}
            @if ($errors->any())
                <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                    role="alert">
                    <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Bahaya</span>
                    <div>
                        <span class="text-lg font-semibold">Pastikan Syarat Pengisian Formulir Terpenuhi:</span>
                        <ul class="mt-1.5 ml-4 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li class="text-lg font-bold text-red-600">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>


            @endif

            <form class="w-full card" enctype="multipart/form-data" method="POST"
                action="{{ route('user.procurement.store') }}">
                @csrf
                <div class="form-group">
                    <label for="goods" class="text-lg font-medium">Pilih Barang</label>
                    <div class="select-field">
                        <select name="goods_name" id="goods" class="w-full input-field" onchange="toggleInput()">
                            <option value="" selected disabled>Pilih Barang Yang Sudah Ada</option>
                            @foreach ($goods as $good)
                                <option value="{{ $good->goods_name }}">{{ $good->goods_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="goods_name" class="text-lg font-medium">Nama Barang Baru</label>
                    <input type="text" class="input-field" placeholder="Tulis barang yang akan diajukan..."
                        name="goods_name" id="goods_name_input" oninput="toggleSelect()" />
                </div>

                <div class="form-group">
                    <label for="idRes" class="text-lg font-medium">Jumlah Barang</label>
                    <input type="number" class="input-field" placeholder="Tuliskan jumlah barang yang akan diajukan..."
                        name="goods_amount" />
                </div>
                <div class="form-group">
                    <label class="text-lg font-medium">Alasan Permintaan</label>
                    <input type="text" class="input-field" placeholder="Sebutkan alasan permintaan..."
                        name="description">
                </div>
                <button type="submit" class="w-full btn btn-primary mt-[14px]" onclick="confirmSubmitAlert(event)">
                    Ajukan Pengadaan
                </button>
            </form>
        </section>
    </div>
@endsection

@section('js')
    <script>
        function confirmSubmitAlert(event) {
            event.preventDefault(); // Prevent default form submission

            Swal.fire({
                title: 'Ajukan Formulir Pengadaan?',
                text: 'Pengajuan akan diajukan Admin',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ajukan',
                cancelButtonText: 'Kembali',
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, submit the form
                    event.target.form.submit();
                }
            });
        }

        function toggleInput() {
            var select = document.getElementById("goods");
            var input = document.getElementById("goods_name_input");

            if (select.value !== "") {
                input.disabled = true;
                input.classList.add("bg-gray-200", "cursor-not-allowed"); // Add the desired classes when input is disabled
            } else {
                input.disabled = false;
                input.classList.remove("bg-gray-200", "cursor-not-allowed"); // Remove the classes when input is enabled
            }
        }

        function toggleSelect() {
            var select = document.getElementById("goods");
            var input = document.getElementById("goods_name_input");

            if (input.value !== "") {
                select.disabled = true;
                select.value = ""; // Reset the selected value when disabled
                select.classList.add("bg-gray-200", "cursor-not-allowed"); // Add the desired classes when input is disabled
            } else {
                select.disabled = false;
                select.classList.remove("bg-gray-200", "cursor-not-allowed"); // Remove the classes when input is enabled
            }
        }
    </script>
@endsection
