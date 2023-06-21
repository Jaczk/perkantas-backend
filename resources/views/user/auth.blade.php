<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>SIIP Login</title>
</head>

<body class="font-montserrat">
    <section class="py-[50px] flex flex-col items-center justify-center px-4">
        <!--TODO: Ganti Logo Perkantas -->
        <img src="/assets/images/perkantas.png" style="max-width:25%" alt="" />
        <div class="text-[32px] font-semibold text-dark mt-[70px]">Sign In</div>
        <p class="mt-4 text-base leading-7 text-center mb-[50px] text-grey">
            Sistem Informasi Inventaris Perkantas Semarang
        </p>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="w-full card" action="{{ route('admin.login.auth') }}" method="post">
            @csrf
            <div class="form-group">
                <label class="text-grey">Email Address</label>
                <input type="email" class="input-field" name="email" placeholder="Email" value="{{ old('email') }}"/>
            </div>
            <div class="form-group">
                <label for="" class="text-grey">Password</label>
                <input type="password" class="input-field" name="password" placeholder="Password" value="{{ old('password') }}"/>
            </div>
            <button type="submit" class="w-full btn btn-primary mt-[14px] hover:bg-primary_hover">
                Masuk
            </button>
            <div class="text-center">Tidak Mempunyai Akun?</div>
            <a href="{{ route('user.register') }}" class="w-full border btn btn-white hover:bg-slate-100">Registrasi</a>
        </form>
    </section>
</body>

</html>
