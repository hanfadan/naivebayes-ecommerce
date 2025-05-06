<?php

class Home extends Controller {
    public function index()
    {
        // 1) Keranjang & count
        $cartModel = $this->model('cart');
        $carts     = $cartModel->findAll(session('user'));
        $count     = $cartModel->total();

        // 2) Produk terbaru & kategori untuk header/nav
        $products  = $this->model('product')->findLast(8);
        $catModel  = $this->model('category');
        $dropdowns = $catModel->dropdownMenu();
        $treeOpts  = $catModel->selectTree();

        // 3) Siapkan list kategori leaf (slug=>name) untuk form radio
        $allCats     = $catModel->getAllForForm();
        $kategoriList = [];
        foreach ($allCats as $c) {
            if ((int)$c['parent_id'] !== 0) {
                $kategoriList[$c['slug']] = $c['name'];
            }
        }

        // 4) List opsi kuisioner lain
        $buyFreqList    = ['Setiap minggu','Setiap bulan','Beberapa bulan','Jarang'];
        $budgetBandList = ['<100k','100-300k','300-600k','>600k'];

        // 5) Default rekomendasi = best-seller (lama)
        $trxModel   = $this->model('transaction');
        $naivebayes = [];
        $formInput  = [];

        // 6) Kalau form POST lengkap → pakai Bayes
        if (
            $_SERVER['REQUEST_METHOD']==='POST' &&
            post('umur')        &&
            post('kategori')    &&
            post('gender')      &&
            post('buy_freq')    &&
            post('budget_band')
        ) {
            $formInput = [
                'umur'        => post('umur'),
                'kategori'    => post('kategori'),
                'gender'      => post('gender'),
                'buy_freq'    => post('buy_freq'),
                'budget_band' => post('budget_band'),
            ];
            if (method_exists($trxModel,'recommendProducts')) {
                $naivebayes = $trxModel->recommendProducts($formInput, 8);
            }
        }

        // 7) Render view
        $this->page('home', [
            'home'           => true,
            'page'           => 'home',
            'carts'          => $carts,
            'count'          => $count,
            'products'       => $products,
            'dropdowns'      => $dropdowns,
            'categories'     => $treeOpts,
            'kategoriList'   => $kategoriList,
            'buyFreqList'    => $buyFreqList,
            'budgetBandList' => $budgetBandList,
            'formInput'      => $formInput,
            'naivebayes'     => $naivebayes,
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
