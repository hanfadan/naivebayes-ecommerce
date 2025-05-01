<?php

class Product extends Controller {
    public function index()
    {
        if (empty(session('isAdmin'))) {
            redirect(url('login'));
        } else {
            $this->admin('product', [
                'products' => $this->model('product')->findAll(),
                'categories' => $this->model('category')->findAll()
            ]);
        }
    }

    public function delete() {
        $model = $this->model('product');
        $product = $model->findOne(post('id'));
        $model->delete(post('id'));

        @unlink('images/01_'.$product['image']);
        @unlink('images/02_'.$product['image']);
        @unlink('images/03_'.$product['image']);
        @unlink('images/04_'.$product['image']);
        @unlink('images/05_'.$product['image']);

        $this->toJson([
            'url' => url('admin/product'),
            'error' => false
        ]);
    }

    public function save() {
        $data['name'] = post('name');
        $data['slug'] = friendlyUrl(post('name'));
        $data['stok'] = post('stok');
        $data['price'] = post('price');
        $data['status'] = 1;
        $data['created'] = date('Y-m-d');
        $data['modified'] = date('Y-m-d');
        $data['category_id'] = post('category');
        $data['description'] = post('description');
        $model = $this->model('product');

        if (isUploaded('image'))
        {
            $rand = time();
            $exts = ['png','jpg','jpeg','gif'];
            $path = 'images/';
            $extd = strtolower(substr(strrchr($_FILES['image']['name'], '.') ,1));

            if ( ! file_exists(FCPATH.$path))
            {
                @mkdir(FCPATH.$path, 0777, true);
            }

            if (in_array($extd, $exts))
            {
                $data['image'] = $rand.'.'.$extd;
                $filename = $path.$rand.'.'.$extd;
                move_uploaded_file($_FILES['image']['tmp_name'], $filename);

                imageResize($filename, $path.'01_'.$rand.'.'.$extd, 70, 70);
                imageResize($filename, $path.'02_'.$rand.'.'.$extd, 100, 100);
                imageResize($filename, $path.'03_'.$rand.'.'.$extd, 115, 140);
                imageResize($filename, $path.'04_'.$rand.'.'.$extd, 550, 750);
                imageResize($filename, $path.'05_'.$rand.'.'.$extd, 569, 528);
                @unlink($filename);

                if (is_numeric(post('id')))
                {
                    if ($model->update(post('id'), $data))
                    {
                        @unlink('images/01_'.post('old'));
                        @unlink('images/02_'.post('old'));
                        @unlink('images/03_'.post('old'));
                        @unlink('images/04_'.post('old'));
                        @unlink('images/05_'.post('old'));

                        $output['url'] = url('admin/product');
                        $output['error'] = false;
                    }
                    else
                    {
                        $output['error'] = true;
                        $output['message'] = 'Terjadi masalah saat memperbaharui data!';
                    }
                }
                else
                {
                    if ($model->insert($data))
                    {
                        $output['url'] = url('admin/product');
                        $output['error'] = false;
                    }
                    else
                    {
                        $output['error'] = true;
                        $output['message'] = 'Terjadi masalah saat menyimpan data!';
                    }
                }
            }
            else
            {
                $output['error'] = true;
                $output['message'] = 'Berkas tidak valid. Silakan coba lagi';
            }
        }
        else
        {
            $output['error'] = true;
            $output['message'] = 'Gambar belum dipilih!';
        }

        $this->toJson($output);
    }
}
