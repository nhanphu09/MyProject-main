@extends('layouts.app')
    
@section('title', 'Home Product List')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


@section('contents')
    <div class="container">
        <h1 class="title">Our Products</h1>
        
        <a href="{{ route('admin/products/create') }}" class="btn-add">+ Add Product</a>

        @if(Session::has('success'))
        <div id="alert-success"class="alert-success">
            {{ Session::get('success') }}
        </div>
        @endif

    
        <div class="product-grid">
            @if($product->count() > 0)
                @foreach($product as $rs)
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="{{ asset('storage/' . $rs->image_url) }}" alt="{{ $rs->title }}" class="product-image">
                    </div>
        
                    <div class="product-content">
                        <h2 class="product-title">{{ $rs->title }}</h2>
                        <p class="product-code"><strong></strong> {{ $rs->product_code }}</p>
                        <p class="product-description">{{ $rs->description }}</p>
                        <p class="product-price">{{ number_format($rs->price, 0, ',', '.') }} VNĐ</p>

                        <div class="product-actions">
                            <div class="btn-detail">
                                <i class="bi bi-eye-fill"></i> View Details
                            </div>
                            <button class="btn-cart">
                                <i class="bi bi-cart4"></i> Add to Cart
                            </button>
                        </div>
        
                        <div class="admin-actions">
                            <a href="{{ route('admin/products/show', $rs->id) }}" class="btn-details">
                                <i class="fas fa-eye"></i> Details
                            <a href="{{ route('admin/products/edit', $rs->id) }}" class="btn-edit">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('admin/products/destroy', $rs->id) }}" method="POST" onsubmit="return confirm('Delete?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn-delete">
                                    <i class="bi bi-trash3"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <p class="no-products">No products found</p>
            @endif
        </div>       
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let alertBox = document.getElementById('alert-success');
            if (alertBox) {
                setTimeout(function() {
                    alertBox.style.transition = "opacity 0.1s ease-in-out";
                    alertBox.style.opacity = "0";
                    setTimeout(() => {
                        alertBox.style.display = "none";
                    }, 500);
                }, 5000);
            }
        });
    </script>
@endsection


