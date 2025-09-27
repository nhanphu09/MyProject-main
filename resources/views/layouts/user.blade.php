<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body>
    <div>
        <nav class="bg-gradient-to-r from-blue-900 to-purple-900 shadow-lg fixed w-full z-50">
            <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
                <div class="flex items-center justify-between h-16">
                    
                    <div class="flex items-center space-x-4">
                        <div class="text-white text-3xl font-extrabold tracking-wide">SportX</div>
                        <form action="{{ route('search') }}" method="GET" class="flex items-center bg-white rounded-lg px-2 mt-2">
                            <input type="text" name="q" placeholder="Tìm kiếm sản phẩm..."
                                class="px-3 py-2 outline-none focus:outline-none rounded-lg border-none w-64">
                            <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-lg ml-2 hover:bg-blue-700">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>

                    <div class="hidden md:flex space-x-8 text-lg font-medium">
                        <a href="{{ url('/home') }}" class="text-white hover:text-gray-300 transition duration-300">Home</a>
                        <a href="{{ url('/contacts') }}" class="text-white hover:text-gray-300 transition duration-300">Contacts</a>
                        <a href="{{ url('/about') }}" class="text-white hover:text-gray-300 transition duration-300">About</a>
                        <a href="{{ url('/services') }}" class="text-white hover:text-gray-300 transition duration-300">Services</a>
                    </div>

                    <div x-data="{ openCart: false }" class="flex md:flex items-center space-x-6">
                        <!-- Giỏ hàng -->
                        <a @click="openCart = true" class="text-white text-2xl relative cursor-pointer">
                            <i class="bi bi-cart-fill"></i>
                            <span class="absolute top-0 right-0 bg-red-500 text-white text-xs px-1 rounded-full">
                                {{ count(session('cart', [])) }}
                            </span>
                        </a>

                        @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-5 rounded-lg shadow-md transition-transform transform hover:scale-105 mt-2">
                                Sign Out
                            </button>
                        </form>
                        @else
                        <a href="{{ route('login') }}" class="bg-green-500 hover:bg-green-600 text-white py-2 px-5 rounded-lg shadow-md transition-transform transform hover:scale-105">Log in</a>
                        <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-5 rounded-lg shadow-md transition-transform transform hover:scale-105">Register</a>
                        @endauth

                        <!-- Popup Giỏ hàng -->
                        <div x-show="openCart" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                            <div class="bg-white p-5 rounded-lg shadow-lg w-96">
                                <div class="flex justify-between items-center mb-3">
                                    <h2 class="text-lg font-bold">Giỏ hàng</h2>
                                    <button @click="openCart = false" class="text-red-500 text-xl">&times;</button>
                                </div>

                                <div>
                                    @if(session('cart'))
                                        @foreach(session('cart') as $id => $details)
                                            <div class="flex justify-between items-center border-b py-2">
                                                <div class="flex items-center space-x-2">
                                                    <img src="{{ asset('storage/' . $details['image']) }}" class="w-12 h-12 object-cover">
                                                    <div>
                                                        <p class="font-semibold">{{ $details['title'] }}</p>
                                                        <p class="text-sm text-gray-500">{{ number_format($details['price'], 0, ',', '.') }} VNĐ</p>
                                                    </div>
                                                </div>
                                                <div>
                                                
                                                    <form action="{{ route('cart.update', $id) }}" method="POST" @submit.prevent="updateCart($el)">
                                                        @csrf
                                                        <select name="size" class="border rounded p-1 text-sm" onchange="this.form.submit()">
                                                            <option value="S" {{ $details['size'] == 'S' ? 'selected' : '' }}>S</option>
                                                            <option value="M" {{ $details['size'] == 'M' ? 'selected' : '' }}>M</option>
                                                            <option value="L" {{ $details['size'] == 'L' ? 'selected' : '' }}>L</option>
                                                            <option value="XL" {{ $details['size'] == 'XL' ? 'selected' : '' }}>XL</option>
                                                        </select>
                                                    </form>
                                                </div>
                                                <div>
                                                    
                                                    <form action="{{ route('cart.update', $id) }}" method="POST" @submit.prevent="updateCart($el)">
                                                        @csrf
                                                        <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1"
                                                            class="w-12 text-center border rounded" onchange="this.form.submit()">
                                                    </form>
                                                </div>
                                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-red-500"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-center text-gray-500">Giỏ hàng trống</p>
                                    @endif
                                </div>

                                <div class="mt-4 flex justify-between items-center">
                                    <strong>Tổng: {{ number_format(session('cart_total', 0), 0, ',', '.') }} VNĐ</strong>
                                    <a href="{{ route('checkout') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Thanh toán</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            @yield('contents')
        </main>

        <footer class="bg-gray-900 text-white py-8">
            <div class="containerr mx-auto grid grid-cols-1 md:grid-cols-4 gap-6 px-6 mt-10">
                <div>
                    <h2 class="text-xl font-bold">SportX</h2>
                    <p class="text-sm mt-2">CAM KẾT CHÍNH HÃNG – UY TÍN HÀNG ĐẦU</p>
                    <p class="text-sm mt-2"><i class="bi bi-check2"></i>Sản phẩm 100% chính hãng, chất lượng cao.</p>
                    <p class="text-sm mt-2"><i class="bi bi-check2"></i>Đa dạng mẫu mã, cập nhật xu hướng thể thao mới nhất.</p>
                    <p class="text-sm mt-2"><i class="bi bi-check2"></i>Hỗ trợ đổi trả linh hoạt trong vòng 7 ngày.</p>
                    <p class="text-sm mt-2"><i class="bi bi-check2"></i>Giao hàng nhanh chóng – Thanh toán an toàn.</p>


                </div>

                <div>
                    <h3 class="text-lg font-semibold">Liên kết nhanh</h3>
                    <ul class="mt-2 space-y-1">
                        <li><a href="/" class="hover:text-gray-400">Trang chủ</a></li>
                        <li><a href="/about" class="hover:text-gray-400">Giới thiệu</a></li>
                        <li><a href="/services" class="hover:text-gray-400">Dịch vụ</a></li>
                        <li><a href="/contact" class="hover:text-gray-400">Liên hệ</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold">Liên hệ</h3>
                    <p class="mt-2"><i class="bi bi-geo-alt-fill"></i>Địa chỉ: Thành phố hà nội</p>
                    <p><a href="#" class="hover:text-gray-400"><i class="bi bi-telephone"></i> 0123456789</a></p>
                    <p><i class="bi bi-envelope"></i>Email: contact@abc.com</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold">Theo dõi chúng tôi</h3>
                    <div class="mt-2 flex space-x-3">
                        <a href="#" class="hover:text-gray-400"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="hover:text-gray-400"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="hover:text-gray-400"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="hover:text-gray-400"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>

            <div class="mt-8 text-center text-sm text-gray-500">
                © 2025 Cửa hàng Sports.
            </div>
        </footer>
    </div>
</body>
<script>
    function addToCart(productId) {
        fetch(`/cart/add/${productId}`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartUI();
                alert('Sản phẩm đã được thêm vào giỏ hàng!');
            }
        });
    }

    function updateCart(formElement) {
        let formData = new FormData(formElement);
        let actionUrl = formElement.action;

        fetch(actionUrl, {
            method: "POST",
            body: formData,
            headers: { "X-CSRF-TOKEN": '{{ csrf_token() }}' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartUI();
            }
        });
    }

    function updateCartUI() {
        fetch('/cart/data')
        .then(response => response.json())
        .then(data => {
            document.querySelector('.cart-count').innerText = data.cart_count;
        });
    }
</script>
</html>
