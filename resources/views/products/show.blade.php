@extends('layouts.app')

@section('title', 'Detail Product')

@section('contents')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Detail Product</h1>
    
    <div class="bg-white shadow-md border-4 border-gray-600 rounded-lg p-6">
        <div class="mb-4">
            <label class="font-semibold">Title</label>
            <p>{{ $product->title }}</p>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Price</label>
            <p>{{ $product->price }}</p>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Image</label>
            <img src="{{ asset('storage/' . $product->image_url) }}" class="w-64 h-64 object-cover rounded-md mx-auto">


        </div>
    </div>
</div>
@endsection

