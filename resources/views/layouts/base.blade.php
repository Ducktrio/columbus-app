<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Columbus')</title>
    @vite('resources/css/app.css')
</head>
<body>
    {{-- Main Content --}}
    <main class="container-fluid d-flex min-vh-100">
        @yield('content')
    </main>


    @vite('resources/js/app.js')
</body>
</html>
