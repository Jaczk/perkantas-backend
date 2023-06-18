<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Perkantas @yield('title')</title>
</head>

<body>
    <div class="font-montserrat bg-page">
        <div class="flex flex-row">
            <!-- Sidebar Here -->
            @include('user.layouts.sidebar')

            <!-- Main Content -->
            <section class="content">
                <div >
                    @yield('content')
                </div>
            </section>
        </div>
        @include('user.layouts.footer')
    </div>

    @yield('js')

    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.all.js') }}"></script>
</body>

</html>
