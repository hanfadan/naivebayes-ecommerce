<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        return view('login', [
            'home'       => false,
            'page'       => 'home',
            'count'      => 0,
            'dropdowns'  => Category::dropdownMenuHtml(),
            'categories' => Category::selectTreeHtml(),
        ]);
    }

    public function store(Request $request)
    {
        $identity = trim($request->input('identity'));
        $password = $request->input('password');
        $hash     = sha1(md5($password));

        $user = User::where('phone', $identity)
            ->orWhere('email', $identity)
            ->first();

        if ($user && $user->password === $hash) {
            $request->session()->put('user', $user->id);
            $request->session()->put('name', $user->name);
            $request->session()->put('phone', $user->phone);

            if ($user->role === 'admin') {
                $request->session()->put('isAdmin', true);
                return redirect()->route('admin.dashboard');
            } else {
                $request->session()->put('isUser', true);
                return redirect()->route('home');
            }
        }

        return redirect()->route('login')->with('flash', [
            'title'   => 'Gagal',
            'status'  => 'danger',
            'message' => 'Email/Telepon atau kata sandi salah!',
        ]);
    }
}
