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
    <div>
        <section class="py-[50px] flex flex-col items-center justify-center px-4">
            <!-- TODO: Ganti Logo Perkantas -->
            <img src="/assets/images/perkantas.png" style="max-width:25%" alt="" />
            <div class="text-[32px] font-semibold text-dark mt-[70px]">Sign Up</div>
            <p class="mt-4 text-base leading-7 text-center mb-[50px] text-grey">
                Sistem Informasi Inventaris <br />
                Perkantas Semarang
            </p>
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
                    <label for="" class="text-grey">Phone Number</label>
                    <input type="text" class="input-field" name="phone" placeholder="Nomor Telepon" />
                </div>
                {{-- <div class="font-semibold text-red-600" v-if="register.phone.length > 12">Tolong Masukkan no Telepon
                    kurang dari 12 angka</div> --}}
                <button type="submit" class="w-full btn btn-primary mt-[14px]">
                    Continue
                </button>
                <a href="{{ route('admin.login') }}" class="w-full border btn btn-white hover:bg-slate-100">Back to Login</a>
            </form>
        </section>
    </div>
</body>

</html>
