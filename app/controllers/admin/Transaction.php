<?php

class Transaction extends Controller {
    public function index() {
        if (empty(session('isAdmin'))) {
            redirect(url('login'));
        } else {
            $trans = $this->model('transaction');

            $this->admin('transaction', [
                'transactions' => $trans->findAll()
            ]);
        }
    }

    public function detail() {
        if (empty(session('isAdmin'))) {
            redirect(url('login'));
        } else {
            $trans = $this->model('transaction');

            $this->admin('transaction_detail', [
                'invoice' => get('invoice'),
                'transactions' => $trans->findDetails(get('invoice'))
            ]);
        }
    }
}