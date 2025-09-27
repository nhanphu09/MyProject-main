@extends('layouts.user')

@section('title', 'Home')

<link rel="stylesheet" href="{{ asset('css/home.css') }}">

@section('contents')

<main class="container">
    @if(isset($query))
        <h2 class="text-lg font-semibold mb-4">Kết quả tìm kiếm cho: "{{ $query }}"</h2>
    @endif

    <div class="product-grid">
        @if($products->count() > 0)
            @foreach($products as $product)
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->title }}" class="product-image">
                    </div>

                    <div class="product-content">
                        <h2 class="product-title">{{ $product->title }}</h2>
                        <p class="product-price">{{ number_format($product->price, 0, ',', '.') }} VNĐ</p>
                        <div class="product-actions">
                            <a href="{{ route('product.detail', ['id' => $product->id]) }}" class="btn-detail">
                                <i class="fas fa-eye"></i> View Details
                            </a>  
                            <button type="submit" class="btn-cart">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>        
                        
                            
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p class="no-products">Không tìm thấy sản phẩm nào.</p>
        @endif
    </div>
</main>
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
            setTimeout(() => { Alpine.store('cart').openCart = true; }, 100);
        }
    });
}

</script>

@endsection