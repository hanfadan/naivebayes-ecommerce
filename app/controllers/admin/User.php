<?php

class User extends Controller {
    public function index()
    {
        if (empty(session('isAdmin'))) {
            redirect(url('login'));
        } else {
            $this->admin('user', [
                'users' => $this->model('user')->findAll('role', 'admin')
            ]);
        }
    }

    public function delete() {
        $this->model('user')->delete(post('id'));
        $this->toJson([
            'url' => url('admin/user'),
            'error' => false
        ]);
    }

    public function save() {
        $data['name'] = post('name');
        $data['role'] = 'admin';
        $data['birth'] = date('Y-m-d');
        $data['email'] = post('name');
        $data['phone'] = post('name');
        $data['gender'] = 'm';
        $data['status'] = 1;
        $data['address'] = 'Cirebon';

        $model = $this->model('user');
        $email = $model->findWhere('email', post('email'));
        $phone = $model->findWhere('phone', post('phone'));

        if ( ! empty($email))
        {
            $output['error'] = true;
            $output['message'] = 'Email sudah terdaftar.';
        }
        elseif ( ! empty($phone))
        {
            $output['error'] = true;
            $output['message'] = 'Nomor telepon sudah terdaftar.';
        }
        else
        {
            if (is_numeric(post('id')))
            {
                if ($model->update(post('id'), $data))
                {
                    $output['url'] = url('admin/user');
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
                if ($model->store($data))
                {
                    $output['url'] = url('admin/user');
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
