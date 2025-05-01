<?php

class Wishlist extends Controller {
    public function index()
    {
        if (empty(session('isUser'))) {
            redirect(url('login'));
        } else {
            $model = $this->model('cart');

            $carts = $model->findAll(session('user'));
            $count = $model->total();
            $wishlists = $this->model('wishlist')->findAll(session('user'));
            $categories = $this->model('category');

            $this->page('wishlist', [
                'home' => false,
                'page' => '',
                'carts' => $carts,
                'count' => $count,
                'dropdowns' => $categories->dropdownMenu(),
                'wishlists' => $wishlists,
                'categories' => $categories->selectTree()
            ]);
        }
    }
}
