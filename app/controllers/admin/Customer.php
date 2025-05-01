<?php

class Customer extends Controller {
    public function index()
    {
        if (empty(session('isAdmin'))) {
            redirect(url('login'));
        } else {
            $this->admin('customer', [
                'customers' => $this->model('user')->findAll('role', 'user')
            ]);
        }
    }
}
