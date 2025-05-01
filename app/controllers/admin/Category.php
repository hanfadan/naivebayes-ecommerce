<?php

class Category extends Controller {
    public function index()
    {
        if (empty(session('isAdmin'))) {
            redirect(url('login'));
        } else {
            $id = 0;
            $view = 'category';
            $submenu = get('submenu');

            if (!empty($submenu)) {
                $id = $submenu;
                $view = 'submenu';
            }

            $this->admin($view, [
                'submenu' => $submenu,
                'categories' => $this->model('category')->findWhere('parent_id', $id)
            ]);
        }
    }

    public function delete() {
        $this->model('category')->delete(post('id'));
        $this->toJson([
            'url' => url('admin/category'),
            'error' => false
        ]);
    }

    public function save() {
        $data['name'] = post('name');
        $data['slug'] = friendlyUrl(post('name'));

        if (empty(post('name')))
        {
            $output['error'] = true;
            $output['message'] = 'Nama masih kosong.';
        }

        $model = $this->model('category');

        if ( ! empty($model->findWhere('slug', friendlyUrl(post('name')))))
        {
            $output['error'] = true;
            $output['message'] = 'Nama masih tidak boleh sama.';
        }
        else
        {
            if (is_numeric(post('id')))
            {
                if ($model->update(post('id'), $data))
                {
                    $output['url'] = url('admin/category');
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
                $url = url('admin/category');
                if (!empty(post('parent'))) {
                    $url = url('admin/category?submenu='.post('parent'));
                    $data['parent_id'] = post('parent');
                }

                if ($model->insert($data))
                {
                    $output['url'] = $url;
                    $output['error'] = false;
                }
                else
                {
                    $output['error'] = true;
                    $output['message'] = 'Terjadi masalah saat menyimpan data!';
                }
            }
        }

        $this->toJson($output);
    }
}
