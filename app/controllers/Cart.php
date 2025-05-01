<?php

class Cart extends Controller {
    public function index()
    {
        if (empty(session('isUser'))) {
            redirect(url('login'));
        } else {
            $model = $this->model('cart');
            $carts = $model->findAll(session('user'));
            $categories = $this->model('category');

            $this->page('cart', [
                'home' => false,
                'page' => '',
                'carts' => $carts,
                'count' => $model->total(),
                'dropdowns' => $categories->dropdownMenu(),
                'categories' => $categories->selectTree()
            ]);
        }
    }
}
