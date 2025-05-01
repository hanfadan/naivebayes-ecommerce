<?php

class Checkout extends Controller {
    public function index()
    {
        if (empty(session('isUser'))) {
            redirect(url('login'));
        } else {
            $model = $this->model('cart');

            $carts = $model->findAll(session('user'));
            $count = $model->total();
            $categories = $this->model('category');

            if (empty($carts)) {
                redirect(url('product'));
            } else {
                $this->page('checkout', [
                    'home' => false,
                    'page' => '',
                    'user' => $this->model('user')->findWhere('id', session('user')),
                    'carts' => $carts,
                    'count' => $count,
                    'dropdowns' => $categories->dropdownMenu(),
                    'categories' => $categories->selectTree()
                ]);
            }
        }
    }

    public function process()
    {
        if (empty(session('isUser'))) {
            redirect(url('login'));
        } else {
            $carts = $this->model('cart')->findAll(session('user'));

            if (empty($carts)) {
                redirect(url('product'));
            } else {
                $total = 0;
                $products = [];
                $transactions = $this->model('transaction');

                foreach($carts as $val) {
                    $total += ($val['qty'] * $val['price']);
                }

                $tranId = $transactions->store([
                    'total' => $total,
                    'invoice' => $transactions->code(),
                    'user_id' => session('user'),
                    'created' => date('Y-m-d'),
                    'modified' => date('Y-m-d')
                ]);

                foreach($carts as $val) {
                    $products[] = [
                        'qty' => $val['qty'],
                        'price' => $val['price'],
                        'tran_id' => $tranId,
                        'product_id' => $val['product']
                    ];

                    $transactions->deleteCart($val['id']);
                }

                $transactions->storeProduct($products);

                redirect(url('checkout/finish'));
            }
        }
    }

    public function finish()
    {
        if (empty(session('isUser'))) {
            redirect(url('login'));
        } else {
            $model = $this->model('cart');
            $trans = $this->model('transaction');

            $carts = $model->findAll(session('user'));
            $count = $model->total();
            $categories = $this->model('category')->findAll();

            $this->page('finish', [
                'home' => false,
                'page' => '',
                'carts' => $carts,
                'count' => $count,
                'trans' => $trans->findLast(),
                'categories' => $categories
            ]);
        }
    }
}
