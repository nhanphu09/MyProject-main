<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');
        $products = Product::where('title', 'like', "%{$query}%")->get();

        return view('home', compact('products', 'query'));
    }
}
