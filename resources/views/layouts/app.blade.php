<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
    <div class="flex flex-row">
        <div class="w-64 h-screen bg-blue-800 sticky top-0 text-white">
            <div class="p-4 text-center text-xl font-bold">Admin</div>
            <a href="{{ route('admin/products') }}" class="block p-4 hover:bg-blue-600">
                <i class="bi bi-house-door-fill"></i> Home
            </a>
            <div class="my-4 "></div>
            <a href="{{ route('logout') }}" class="block p-4 hover:bg-blue-600">
                <i class="bi bi-box-arrow-in-right"></i> Logout
            </a>
        </div>
        <div class="flex-1 p-8">
            @yield('contents')
        </div>
    </div>
</body>
</html>
