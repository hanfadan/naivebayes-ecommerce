<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function index()
    {
        $userId    = session('user');
        $carts     = Cart::findAllByUser($userId);
        $wishlists = Wishlist::findAllByUser($userId);

        return view('wishlist', [
            'home'       => false,
            'page'       => '',
            'carts'      => $carts,
            'count'      => Cart::totalByUser($userId),
            'wishlists'  => $wishlists,
            'dropdowns'  => Category::dropdownMenuHtml(),
            'categories' => Category::selectTreeHtml(),
        ]);
    }
}
