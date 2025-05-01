<?php

class Dashboard extends Controller {
    public function index()
    {
        if (empty(session('isAdmin'))) {
            redirect(url('login'));
        } else {
            $trans = $this->model('transaction');

            $this->admin('dashboard', [
                'searchs' => $this->model('search')->findAll(),
                'totalAll' => $trans->totalAll(),
                'totalNow' => $trans->totalNow(),
                'totalUser' => $trans->totalUser(),
                'totalMonth' => $trans->totalMonth()
            ]);
        }
    }
}
