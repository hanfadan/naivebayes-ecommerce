<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $userId = session('user');
        $carts  = Cart::findAllByUser($userId);

        return view('profile', [
            'home'       => false,
            'page'       => '',
            'user'       => User::find($userId)?->toArray() ?? [],
            'carts'      => $carts,
            'count'      => Cart::totalByUser($userId),
            'dropdowns'  => Category::dropdownMenuHtml(),
            'categories' => Category::selectTreeHtml(),
        ]);
    }
}
