<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use App\Services\NaiveBayesService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $userId = session('user');
        $carts  = $userId ? Cart::findAllByUser($userId) : [];
        $count  = $userId ? Cart::totalByUser($userId) : 0;

        $products  = Product::findLast(8);
        $dropdowns = Category::dropdownMenuHtml();
        $treeOpts  = Category::selectTreeHtml();

        $allCats     = Category::orderBy('parent_id')->get(['id', 'name', 'slug', 'parent_id'])->toArray();
        $categoryShortcuts = Category::where('parent_id', '!=', 0)
            ->orderBy('name')
            ->limit(12)
            ->get(['name', 'slug'])
            ->toArray();
        $kategoriList = [];
        foreach ($allCats as $c) {
            if ((int) $c['parent_id'] !== 0) {
                $kategoriList[$c['slug']] = $c['name'];
            }
        }

        $buyFreqList    = ['Setiap minggu', 'Setiap bulan', 'Beberapa bulan', 'Jarang'];
        $budgetBandList = ['<100k', '100-300k', '300-600k', '>600k'];

        $naivebayes = [];
        $formInput  = [];

        if (
            $request->isMethod('POST') &&
            $request->filled(['umur', 'kategori', 'gender', 'buy_freq', 'budget_band'])
        ) {
            $formInput = $request->only(['umur', 'kategori', 'gender', 'buy_freq', 'budget_band']);
            $service   = new NaiveBayesService();
            $naivebayes = $service->recommendProducts($formInput, 8);
        }

        return view('home', compact(
            'carts', 'count', 'products', 'dropdowns', 'treeOpts',
            'kategoriList', 'categoryShortcuts', 'buyFreqList', 'budgetBandList', 'formInput', 'naivebayes'
        ));
    }

    public function addCart(Request $request)
    {
        if (empty(session('isUser'))) {
            return response()->json(['error' => true, 'redirect' => route('login')]);
        }

        $userId    = session('user');
        $productId = $request->input('product');
        $priceInput = $request->input('price');
        $price     = $priceInput !== null
            ? str_replace('.', '', (string) $priceInput)
            : Product::whereKey($productId)->value('price');
        $qty       = (int) $request->input('qty', 1);

        $cart = Cart::where('user_id', $userId)->where('product_id', $productId)->first();

        if (!$cart) {
            Cart::create(['qty' => $qty, 'price' => $price, 'user_id' => $userId, 'product_id' => $productId]);
        } else {
            $newQty = $request->filled('qty') ? $qty : ($cart->qty + 1);
            $cart->update(['qty' => $newQty]);
        }

        return response()->json(['error' => false]);
    }

    public function addWishlist(Request $request)
    {
        if (empty(session('isUser'))) {
            return response()->json(['error' => true]);
        }

        $userId    = session('user');
        $productId = $request->input('product');

        $exists = Wishlist::where('user_id', $userId)->where('product_id', $productId)->exists();
        if (!$exists) {
            Wishlist::create(['user_id' => $userId, 'product_id' => $productId]);
        }

        return response()->json(['error' => false]);
    }

    public function delCart(Request $request)
    {
        if (empty(session('isUser'))) {
            return response()->json(['error' => true]);
        }

        Cart::where('id', $request->input('id'))->delete();
        return response()->json(['error' => false]);
    }

    public function delWishlist(Request $request)
    {
        if (empty(session('isUser'))) {
            return response()->json(['error' => true]);
        }

        Wishlist::where('id', $request->input('id'))->delete();
        return response()->json(['error' => false]);
    }
}
