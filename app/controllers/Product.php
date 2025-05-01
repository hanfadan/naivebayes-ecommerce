<?php

class Product extends Controller {
    public function index()
    {
        $mCart = $this->model('cart');
        $carts = $mCart->findAll(session('user'));
        $count = $mCart->total();
        $products = $this->model('product')->findHome(get('search'), get('category'));
        $categories = $this->model('category');

        $search = $this->model('search');

        if ( ! empty(get('search')))
        {
            $data = $search->findByName(get('search'));

            if (empty($data))
            {
                $search->insert([
                    'name' => get('search'),
                    'view' => 1
                ]);
            } else {
                $view = intval($data['view']) + 1;

                $search->update($data['id'], [
                    'view' => $view
                ]);
            }
        }

        $this->page('product', [
            'home' => false,
            'page' => 'product',
            'carts' => $carts,
            'count' => $count,
            'sidebars' => $categories->sidebars(),
            'products' => $products,
            'dropdowns' => $categories->dropdownMenu(),
            'categories' => $categories->selectTree()
        ]);
    }
}
