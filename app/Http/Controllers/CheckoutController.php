<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;

class CheckoutController extends Controller
{
    public function index()
    {
        $userId = session('user');
        $carts  = Cart::findAllByUser($userId);

        if (empty($carts)) {
            return redirect()->route('product');
        }

        return view('checkout', [
            'home'       => false,
            'page'       => '',
            'user'       => User::find($userId)?->toArray() ?? [],
            'carts'      => $carts,
            'count'      => Cart::totalByUser($userId),
            'dropdowns'  => Category::dropdownMenuHtml(),
            'categories' => Category::selectTreeHtml(),
        ]);
    }

    public function process()
    {
        $userId = session('user');
        $carts  = Cart::findAllByUser($userId);

        if (empty($carts)) {
            return redirect()->route('product');
        }

        $total = 0;
        foreach ($carts as $val) {
            $total += (int) $val['qty'] * (int) $val['price'];
        }

        $transaction = Transaction::create([
            'total'    => $total,
            'invoice'  => Transaction::generateCode(),
            'user_id'  => $userId,
            'created'  => date('Y-m-d'),
            'modified' => date('Y-m-d'),
        ]);

        $details = [];
        foreach ($carts as $val) {
            $details[] = [
                'qty'        => $val['qty'],
                'price'      => $val['price'],
                'tran_id'    => $transaction->id,
                'product_id' => $val['product'],
                'user_id'    => $userId,
            ];
            Cart::where('id', $val['id'])->delete();
        }

        TransactionDetail::insert($details);

        return redirect()->route('checkout.finish');
    }

    public function finish()
    {
        $userId = session('user');
        $carts  = Cart::findAllByUser($userId);
        $trans  = Transaction::latest('id')->first()?->toArray() ?? [];

        return view('finish', [
            'home'   => false,
            'page'   => '',
            'carts'  => $carts,
            'count'  => Cart::totalByUser($userId),
            'trans'  => $trans,
        ]);
    }
}
