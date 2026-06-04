<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        return view('admin.transaction', [
            'transactions' => Transaction::findAll(),
        ]);
    }

    public function detail(Request $request)
    {
        $invoice = $request->query('invoice');
        return view('admin.transaction_detail', [
            'invoice'      => $invoice,
            'transactions' => Transaction::findDetails($invoice),
        ]);
    }
}
