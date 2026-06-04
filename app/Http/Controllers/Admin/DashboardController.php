<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Search;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'searchs'    => Search::orderByDesc('view')->get()->toArray(),
            'totalAll'   => Transaction::totalAll(),
            'totalNow'   => Transaction::totalNow(),
            'totalUser'  => Transaction::totalUser(),
            'totalMonth' => Transaction::totalMonth(),
        ]);
    }
}
