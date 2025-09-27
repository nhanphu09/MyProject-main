<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Import model Product


class HomeController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        // return view('home');

         // Lấy tất cả sản phẩm từ database, sắp xếp theo ngày tạo mới nhất
         $products = Product::orderBy('created_at', 'DESC')->get();

         // Trả về view 'home' với danh sách sản phẩm
         return view('home', compact('products'));
    }

    public function adminHome(){
        return view('dashboard');
    }
}
