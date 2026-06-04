<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register', [
            'home'       => false,
            'page'       => 'home',
            'count'      => 0,
            'dropdowns'  => Category::dropdownMenuHtml(),
            'categories' => Category::selectTreeHtml(),
        ]);
    }

    public function store(Request $request)
    {
        $data = [
            'name'     => $request->input('name'),
            'role'     => 'user',
            'email'    => $request->input('email'),
            'phone'    => $request->input('phone'),
            'birth'    => dateToSql(str_replace('/', '-', $request->input('birth'))),
            'gender'   => $request->input('gender'),
            'status'   => 1,
            'address'  => $request->input('address'),
            'password' => sha1(md5($request->input('password'))),
        ];

        if (User::create($data)) {
            return redirect()->route('register')->with('flash', [
                'title'   => 'Sukses',
                'status'  => 'success',
                'message' => 'Pendaftaran Berhasil',
            ]);
        }

        return redirect()->route('register')->with('flash', [
            'title'   => 'Gagal',
            'status'  => 'danger',
            'message' => 'Pendaftaran gagal ditambahkan',
        ]);
    }
}
