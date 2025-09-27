@extends('layouts.app')

@section('title', 'Edit Product')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">

@section('contents')
<h1 class="page-title">Edit Product</h1>

<div class="form-container">
    <form action="{{ route('admin/products/update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

       
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" id="title" value="{{ $product->title }}" class="form-input">
        </div>

        
        <div class="form-group">
            <label>Price</label>
            <input id="price" name="price" type="text" value="{{ $product->price }}" class="form-input">
        </div>

       
        <div class="form-group">
            <label>Product Image</label>
            <div class="image-preview">
                <img id="preview-image" src="{{ asset('storage/' . $product->image_url) }}" class="product-image">
            </div>
            <input type="file" name="image" id="image-input" class="file-input">
        </div>

        <button type="submit" class="submit-btn">Update</button>
    </form>
</div>

<script>
document.getElementById("image-input").addEventListener("change", function(event) {
    let reader = new FileReader();
    reader.onload = function() {
        document.getElementById("preview-image").src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
});
</script>
@endsection

