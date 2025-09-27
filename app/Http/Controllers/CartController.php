<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class CartController extends Controller
{
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        $size = $request->input('size', 'M'); 

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            $cart[$id]['size'] = $size; 
        } else {
            $cart[$id] = [
                "title" => $product->title,
                "price" => $product->price,
                "image" => $product->image_url,
                "quantity" => 1,
                "size" => $size
            ];
        }

        session()->put('cart', $cart);
        session()->put('cart_total', collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']));
        return back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');

    }


     public function getCart()
    {
        $cart = session()->get('cart', []);
        $cartTotal = session()->get('cart_total', 0);
        
        return response()->json([
            'cart' => $cart,
            'cart_total' => $cartTotal,
            'cart_count' => count($cart)
        ]);
    }


    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = max(1, $request->quantity); // Đảm bảo số lượng >= 1
            $cart[$id]['size'] = in_array($request->size, ['S', 'M', 'L', 'XL']) ? $request->size : 'S'; 

            session()->put('cart', $cart);
            session()->put('cart_total', collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']));
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'cart' => $cart, 'cart_total' => session('cart_total')]);
        }

        return back()->with('success', 'Cập nhật giỏ hàng thành công!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            session()->put('cart_total', collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']));
        }

        return back()->with('success', 'Xóa sản phẩm khỏi giỏ hàng!');
    }
    public function clear()
    {
        session()->forget('cart');
        session()->forget('cart_total');

        return back()->with('success', 'Giỏ hàng đã được làm trống!');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        $total = session()->get('cart_total', 0);

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        return view('checkout', compact('cart', 'total'));
    }

}
