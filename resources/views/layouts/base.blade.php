<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Columbus')</title>
    @vite('resources/css/app.css')
</head>
<body>
    {{-- Main Content --}}
    <main class="bg-body-primary p-0 d-flex min-vh-100">
        @yield('content')
    </main>


    @vite('resources/js/app.js')
</body>
</html>
