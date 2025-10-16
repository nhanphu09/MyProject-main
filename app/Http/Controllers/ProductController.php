<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Product;


class ProductController extends Controller
{

    public function index()
    {
        $product = Product::orderBy('created_at', 'DESC')->get();

        return view('products.index', compact('product'));
    }
    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'price' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        } else {
            $imagePath = null;
        }


        Product::create([
            'title' => $request->title,
            'price' => $request->price,
            'image_url' => $imagePath,
        ]);

        return redirect()->route('admin.products')->with('success', 'Product added successfully');
    }

    public function show(string $id)
    {

        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }


    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product'));
    }
    public function update(Request $request, string $id)
    {


        $request->validate([
            'title' => 'required',
            'price' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }


            $imagePath = $request->file('image')->store('products', 'public');
        } else {
            $imagePath = $product->image_url;
        }

        $product->update([
            'title' => $request->title,
            'price' => $request->price,
            'image_url' => $imagePath,
        ]);

        return redirect()->route('admin.products')->with('success', 'Product updated successfully');
    }


    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return redirect()->route('admin.products')->with('success', 'product deleted successfully');
    }


    public function detail($id)
    {
        $product = Product::findOrFail($id);
        return view('products.detail', compact('product'));
    }

    // ============================================================
    // ============== RESTful API (cho SportX app) ================
    // ============================================================

    public function apiIndex()
    {
        return response()->json(Product::orderBy('created_at', 'desc')->get(), 200);
    }

    public function apiShow($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product, 200);
    }

    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image_url' => 'nullable|string', // Nếu bạn upload qua API thì dùng URL
        ]);

        $product = Product::create($validated);
        return response()->json($product, 201);
    }

    public function apiUpdate(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update($request->only(['title', 'price', 'image_url']));
        return response()->json($product, 200);
    }

    public function apiDestroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }


}
