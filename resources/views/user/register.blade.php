<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Perkantas Register</title>
</head>

<body>
    <div class="font-montserrat">
        <section class="py-[50px] flex flex-col items-center justify-center px-4">
            <!-- TODO: Ganti Logo Perkantas -->
            <img src="/assets/images/perkantas.png" style="max-width:25%" alt="" />
            <div class="text-[32px] font-semibold text-dark mt-[70px]">Sign Up</div>
            <p class="mt-4 text-base leading-7 text-center mb-[50px] text-grey">
                Sistem Informasi Inventaris <br />
                Perkantas Semarang
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
            
            <form class="w-full card" action="{{ route('user.register.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="" class="text-grey">Name</label>
                    <input type="text" class="input-field" name="name" placeholder="Nama"/>
                </div>
                <div class="form-group">
                    <label for="" class="text-grey">Email Address</label>
                    <input type="email" class="input-field" name="email" placeholder="Email"/>
                </div>
                <div class="form-group">
                    <label for="" class="text-grey">Password</label>
                    <input type="password" class="input-field" name="password" placeholder="Password"/>
                </div>
                <div class="form-group">
                    <label for="" class="text-grey">Nomor Telepon</label>
                    <p id="phone-error" class="hidden text-base font-semibold text-red-600">Tolong masukkan nomor telepon kurang dari 11 angka</p>
                    <div class="flex">
                        <input type="text" disabled="true" value="+62" name="countryCode" class="w-1/6 px-4 py-2 mr-2 rounded-full cursor-not-allowed input-field disabled:opacity-75">
                        <input type="number" class="w-4/5 input-field" id="phone-input" name="phone" placeholder="Nomor Telepon" />
                    </div>
                </div>
                <button type="submit" class="w-full btn btn-primary mt-[14px]">
                    Buat
                </button>
                <a href="{{ route('login') }}" class="w-full border btn btn-white hover:bg-slate-100">Kembali ke halaman Login</a>
            </form>
        </section>
    </div>

    <script>
        const phoneInput = document.getElementById('phone-input');
        const phoneError = document.getElementById('phone-error');
    
        phoneInput.addEventListener('input', function() {
            const phoneNumber = this.value;
            if (phoneNumber.length > 11) {
                phoneError.classList.remove('hidden');
            } else {
                phoneError.classList.add('hidden');
            }
        });
    </script>
    
</body>

</html>
