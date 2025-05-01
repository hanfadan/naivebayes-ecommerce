<?php

class Home extends Controller {
    public function index()
    {
        $model = $this->model('cart');

        $carts = $model->findAll(session('user'));
        $count = $model->total();
        $products = $this->model('product')->findLast(8);
        $categories = $this->model('category');
        $naivebayes = $this->model('transaction')->naiveBayes();
        $trxModel   = $this->model('transaction');   // sudah kita refactor

        if (request()->isPost()) {
            /* tangkap jawaban user */
            $input = [
                'umur'     => post('umur'),       // ex: 18-24
                'kategori' => post('kategori'),   // ex: Kasual
                'gender'   => post('gender')      // m / f
            ];
            /* rekomendasi via Naive Bayes */
            $naivebayes = $trxModel->recommendProducts($input, 8);
        } else {
            $input      = [];        // supaya view bisa tahu “belum ada jawaban”
            $naivebayes = [];        // blok rekomendasi tidak muncul
        }

        $this->page('home', [
            'home' => true,
            'page' => 'home',
            'carts' => $carts,
            'count' => $count,
            'products' => $products,
            'dropdowns' => $categories->dropdownMenu(),
            'categories' => $categories->selectTree(),
            'naivebayes' => $naivebayes,
            'formInput'   => $input,                       // untuk sticky value
            'kategoriOpt' => $catModel->selectTree()       // list kategori utk <select>
        ]);
    }

    public function addCart() {
        if (empty(session('isUser'))) {
            redirect(url('login'));
        } else {
            $model = $this->model('cart');
            $cart = $model->findWhere(session('user'), post('product'));

            if (empty($cart)) {
                $qty = post('qty');

                if (empty(post('qty')))
                {
                    $qty = 1;
                }

                $model->insert([
                    'qty' => $qty,
                    'price' => str_replace('.', '', post('price')),
                    'user_id' => session('user'),
                    'product_id' => post('product')
                ]);
            }
            else
            {
                $qty = post('qty');

                if (empty(post('qty')))
                {
                    $qty = intval($cart['qty'])+1;
                }

                $model->update($cart['id'], [
                    'qty' => post('qty')
                ]);
            }
        }

        $this->toJson([
            'error' => false
        ]);
    }

    public function addWishlist() {
        if (empty(session('isUser'))) {
            redirect(url('login'));
        } else {
            $model = $this->model('wishlist');

            if (empty($model->findWhere(session('user'), post('product')))) {
                $this->model('wishlist')->insert([
                    'user_id' => session('user'),
                    'product_id' => post('product')
                ]);
            }
        }

        $this->toJson([
            'error' => false
        ]);
    }

    public function delCart() {
        if (empty(session('isUser'))) {
            redirect(url('login'));
        } else {
            $this->model('cart')->delete(post('id'));
        }
        
        $this->toJson([
            'error' => false
        ]);
    }

    public function delWishlist() {
        if (empty(session('isUser'))) {
            redirect(url('login'));
        } else {
            $this->model('wishlist')->delete(post('id'));
        }
        
        $this->toJson([
            'error' => false
        ]);
    }
}
