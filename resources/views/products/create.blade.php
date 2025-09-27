@extends('layouts.app')
 
@section('title', 'Create Product')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">

@section('contents')
<h1 class="font-bold text-2xl ml-3">Add Product</h1>
<hr />

<div class="container">
    <div class="form-wrapper">
        <form action="{{ route('admin/products/store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-input">
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" id="price" name="price" class="form-input">
            </div>
            <div class="form-group">
                <label for="image">Product Image</label>
                <input type="file" name="image" id="image" class="form-file">
            </div>

            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </div>
</div>

@endsection

