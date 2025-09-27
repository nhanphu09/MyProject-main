@extends('layouts.user');

@section('title', $product->title)

<link rel="stylesheet" href="{{ asset('css/detail.css') }}">

@section('contents')

<main class="container">
    <div class="product-detail">
        <div class="product-image-container">
            <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->title }}" class="product-image">
        </div>

        <div class="product-info">
            <h2 class="product-title">{{ $product->title }}</h2>
            <p class="product-price">
              
                {{-- <span class="new-price">${{ number_format($product->price, 2) }}</span> --}}
                <span class="new-price">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>

            </p>
            <p class="product-description">{{ $product->description }}</p>

            <div class="product-info-extra">
                <p>• Full size từ 10kg – 120kg</p>
                <p>• Full 6 chất liệu tương ứng 6 mức giá</p>
                <p>• Thoải mái thay đổi logo, nhà tài trợ</p>
                <p>• Miễn phí in ấn 100%</p>
                <p>• Miễn phí ship toàn quốc 100%</p>
                <p>• Nhiều ưu đãi về giá và quà tặng đi kèm.</p>
            </div>

            <div class="size-quantity-container">
                <div>
                    <label for="size">Choose Size:</label>
                    <select id="size" name="size" class="size-select">
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                    </select>
                </div>

                <div>
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" class="quantity-input" value="1" min="1">
                </div>
            </div>

            <div class="product-actions">
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="size" id="selected-size" value="S">
                    <input type="hidden" name="quantity" id="selected-quantity" value="1">
                    <button type="submit" class="btn-buy"><i class="bi bi-cart4"></i>Buy Now</button>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    document.getElementById('size').addEventListener('change', function() {
        document.getElementById('selected-size').value = this.value;
    });

    document.getElementById('quantity').addEventListener('change', function() {
        document.getElementById('selected-quantity').value = this.value;
    });
</script>
@endsection
