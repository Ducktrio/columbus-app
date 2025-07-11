<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Columbus')</title>
    @vite('resources/css/app.css')
</head>
<body>
    {{-- Main Content --}}
    @yield('content')

    @include('components.toast')


    @vite('resources/js/app.js')
    @stack('scripts')
</body>
</html>
