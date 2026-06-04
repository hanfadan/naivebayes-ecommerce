<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\Search;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $userId  = session('user');
        $carts   = $userId ? Cart::findAllByUser($userId) : [];
        $count   = $userId ? Cart::totalByUser($userId) : 0;
        $search  = $request->query('search');
        $category = $request->query('category');

        $products    = Product::findHome($search, $category);
        $bestSellers = Product::bestSellers($category ?: null, 5);
        $categories  = Category::class;

        if (!empty($search)) {
            $entry = Search::where('name', $search)->first();
            if (!$entry) {
                Search::create(['name' => $search, 'view' => 1]);
            } else {
                $entry->increment('view');
            }
        }

        return view('product', [
            'home'        => false,
            'page'        => 'product',
            'carts'       => $carts,
            'count'       => $count,
            'sidebars'    => Category::sidebarHtml(),
            'products'    => $products,
            'bestSellers' => $bestSellers,
            'dropdowns'   => Category::dropdownMenuHtml(),
            'categories'  => Category::selectTreeHtml(),
        ]);
    }
}
