<?php

class Register extends Controller {
    public function index()
    {
        $categories = $this->model('category');

        if ( ! empty(post('submit'))) {
            $data['name'] = post('name');
            $data['role'] = 'user';
            $data['email'] = post('email');
            $data['phone'] = post('phone');
            $data['birth'] = dateToSql(str_replace('/', '-', post('birth')));
            $data['gender'] = post('gender');
            $data['status'] = 1;
            $data['address'] = post('address');
            $data['password'] = sha1(md5(post('password')));
            
            if ($this->model('user')->store($data)) {
                Flasher::success('Sukses', 'Pedaftaran Berhasil');
            } else {
                Flasher::danger('Gagal', 'Pedaftaran gagal ditambahkan');
            }
        }

        $this->page('register', [
            'home' => false,
            'page' => 'home',
            'count' => 0,
            'dropdowns' => $categories->dropdownMenu(),
            'categories' => $categories->selectTree()
        ]);
    }
}
