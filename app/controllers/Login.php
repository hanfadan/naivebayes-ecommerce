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
            echo '<pre>';
echo 'Password Plain: [' . $pw . ']' . PHP_EOL;
echo 'Password Hashed: ' . $hash . PHP_EOL;
if (!empty($user)) {
    echo 'Password di DB     : ' . $user['password'] . PHP_EOL;
}
echo '</pre>';

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

