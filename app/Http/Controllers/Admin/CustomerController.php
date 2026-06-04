<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class CustomerController extends Controller
{
    public function index()
    {
        return view('admin.customer', [
            'customers' => User::where('role', 'user')->get()->toArray(),
        ]);
    }
}
