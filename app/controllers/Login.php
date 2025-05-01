<?php

class Login extends Controller {
    public function index()
    {
        $categories = $this->model('category');

        if ( ! empty(post('submit'))) {
            $password = sha1(md5(post('password')));
            $user = $this->model('user')->login(post('identity'), $password);

            if ( ! empty($user)) {
                if ($user === 'admin') {
                    redirect(url('admin/dashboard'));
                } else {
                    redirect(url());
                }
            } else {
                Flasher::danger('Gagal', 'Nomor telepon atau kata sandi salah!');
            }
        }

        $this->page('login', [
            'home' => false,
            'page' => 'home',
            'count' => 0,
            'dropdowns' => $categories->dropdownMenu(),
            'categories' => $categories->selectTree()
        ]);
    }
}
