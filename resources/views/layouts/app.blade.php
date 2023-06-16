<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.partials.head')
</head>

<body>
    <div id="app">
        <main class="py-4">
            <div class="container-fluid " align="center" style="padding:50px">
                <div class="row justify-content-center">
                    <div class="col-sm-6 ">
                    <img src=" {{ asset('frontend') }}/images/logo.png" width="120">
                    </div>
                </div>
            </div>
            @yield('content')
        </main>

        <div class="col-md-12 row justify-content-center">
            <div class="copyright">
                <span class="copyright ml-auto my-auto mr-2">Copyright © {{ now()->year }}
                    <a href="#" rel="nofollow">Faculty of Computing</a>
                </span>
            </div>
        </div>
    </div>
</body>

</html>