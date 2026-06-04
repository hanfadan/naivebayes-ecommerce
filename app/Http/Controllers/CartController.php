<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;

class CartController extends Controller
{
    public function index()
    {
        $userId = session('user');
        $carts  = Cart::findAllByUser($userId);

        return view('cart', [
            'home'       => false,
            'page'       => '',
            'carts'      => $carts,
            'count'      => Cart::totalByUser($userId),
            'dropdowns'  => Category::dropdownMenuHtml(),
            'categories' => Category::selectTreeHtml(),
        ]);
    }
}
