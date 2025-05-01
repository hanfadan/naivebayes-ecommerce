<?php

class Home extends Controller {
    public function index()
    {
        $model = $this->model('cart');
        $carts = $model->findAll(session('user'));
        $count = $model->total();
        $products = $this->model('product')->findLast(8);
        $categories = $this->model('category');
        $catModel   = $this->model('category');

        

        $trxModel   = $this->model('transaction');
        $formInput  = [];                 // untuk sticky value di view
        $naivebayes = $trxModel->naiveBayes();   // default lama

        if (
            $_SERVER['REQUEST_METHOD'] === 'POST' &&
            post('umur') && post('kategori') && post('gender')
        ) {
            $formInput = [
                'umur'     => post('umur'),
                'kategori' => post('kategori'),
                'gender'   => post('gender')
            ];

            /* gunakan rekomendasi baru jika method tersedia */
            if (method_exists($trxModel, 'recommendProducts')) {
                $naivebayes = $trxModel->recommendProducts($formInput, 8);
            }
        }

        $kategoriOptions = $catModel->selectTree();   // sudah berupa string opsi
        if (!empty($formInput['kategori'])) {
            // sisipkan selected supaya tetap terpilih setelah POST
            $kategoriOptions = str_replace(
                'value="'.$formInput['kategori'].'"',
                'value="'.$formInput['kategori'].'" selected',
                $kategoriOptions
            );
        }

        $this->page('home', [
            'home' => true,
            'page' => 'home',
            'carts' => $carts,
            'count' => $count,
            'products' => $products,
            'dropdowns'   => $categories->dropdownMenu(),
            'categories'  => $categories->selectTree(),
            'naivebayes' => $naivebayes,
            'formInput'   => $formInput,              // supaya <select> tetap terisi
            'kategoriOptions' => $kategoriOptions   
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
