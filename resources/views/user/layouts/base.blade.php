<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Perkantas @yield('title')</title>
</head>

<body>
    <div>
        <div>
            <!-- Sidebar Here -->
            @include('user.layouts.sidebar')

            <!-- Main Content -->
            <section class="content">
                <div>
                    @yield('content')
                </div>
            </section>
        </div>
        @include('user.layouts.footer')
    </div>
</body>

</html>
