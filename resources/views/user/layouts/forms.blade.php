<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Forms @yield('title')</title>
</head>

<body>
    <div>
        <div class="pt-[50px] md:px-[50px] flex justify-between items-center px-4">
            <a href="{{ route('user.dashboard') }}">
                <img src="/assets/images/perkantas.png" alt="" class="w-1/4 hover:cursor-pointer hover:opacity-50" />
            </a>
            <a href="#" onclick="history.back()" class="hover:cursor-pointer hover:opacity-50">
                <img src="/assets/svgs/ric-close-white.svg" alt="" />
            </a>
        </div>
        <section class="content">
            <div>
                @yield('content')
            </div>
        </section>
    </div>
    @yield('js')
</body>

</html>
