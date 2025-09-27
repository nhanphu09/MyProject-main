<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;




class AuthController extends Controller
{
    public function __construct(){
        $this->middleware('guest')->except('logout');
    }
    public function register()
    {
        return view('auth/register');
    }

    public function registerSave(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ])->validate();
 
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => "0"
        ]);
 
        return redirect()->route('login');
    }

    public function login()
    {
        return view('auth/login');
    }

    public function loginAction(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();
        
        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->with('error', 'Sai mật khẩu hoặc email không tồn tại.');
        }
        $request->session()->regenerate();
        if (auth()->user()->type == 'admin') {
            return redirect()->route('admin/products');
        } else {
            return redirect()->route('home');
        }
        return redirect()->route('dashboard');
    
    }
    public function logout(Request $request)
    {
        // Auth::guard('web')->logout();
 
        // $request->session()->invalidate();
 
        // return redirect('/login');
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/login'); // Quay về trang login sau khi logout
    }
}
