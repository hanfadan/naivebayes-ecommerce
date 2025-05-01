<?php

class Profile extends Controller {
    public function index()
    {
        if (empty(session('isUser'))) {
            redirect(url('login'));
        } else {
            $model = $this->model('cart');

            $carts = $model->findAll(session('user'));
            $count = $model->total();
            $categories = $this->model('category');

            $this->page('profile', [
                'home' => false,
                'page' => '',
                'carts' => $carts,
                'count' => $count,
                'dropdowns' => $categories->dropdownMenu(),
                'categories' => $categories->selectTree()
            ]);
        }
    }
}
