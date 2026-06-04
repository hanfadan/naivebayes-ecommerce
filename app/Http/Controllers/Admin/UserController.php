<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user', [
            'users' => User::where('role', 'admin')->get()->toArray(),
        ]);
    }

    public function delete(Request $request)
    {
        User::where('id', $request->input('id'))->delete();
        return response()->json(['url' => route('admin.user'), 'error' => false]);
    }

    public function save(Request $request)
    {
        $email = $request->input('email');
        $phone = $request->input('phone');

        if (User::where('email', $email)->exists()) {
            return response()->json(['error' => true, 'message' => 'Email sudah terdaftar.']);
        }
        if (User::where('phone', $phone)->exists()) {
            return response()->json(['error' => true, 'message' => 'Nomor telepon sudah terdaftar.']);
        }

        $data = [
            'name'     => $request->input('name'),
            'role'     => 'admin',
            'birth'    => date('Y-m-d'),
            'email'    => $email,
            'phone'    => $phone,
            'gender'   => 'm',
            'status'   => 1,
            'address'  => '-',
            'password' => sha1(md5($request->input('password', 'admin123'))),
        ];

        if (is_numeric($request->input('id'))) {
            User::where('id', $request->input('id'))->update($data);
        } else {
            User::create($data);
        }

        return response()->json(['url' => route('admin.user'), 'error' => false]);
    }
}
