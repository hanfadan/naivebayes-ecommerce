<?php

class Login extends Controller {
    public function index()
    {
        $categories = $this->model('category');

        if (!empty(post('submit'))) {
            $cred = trim(post('identity'));
            $pw   = post('password');

            // hash sesuai yang Anda pakai; contoh memakai sha1(md5())
            $hash = sha1(md5($pw));

            // dapatkan user by email OR phone
            $user = $this->model('user')->login($cred, $hash);

            if (!empty($user)) {
                // sukses login
                if ($user === 'admin') {
                    redirect(url('admin/dashboard'));
                } else {
                    redirect(url());
                }
            }

            // gagal
            Flasher::danger('Gagal', 'Email/Telepon atau kata sandi salah!');
        }

        $this->page('login', [
            'home'       => false,
            'page'       => 'home',
            'count'      => 0,
            'dropdowns'  => $categories->dropdownMenu(),
            'categories' => $categories->selectTree()
        ]);
    }
}

