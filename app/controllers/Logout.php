<?php

class Logout extends Controller {
    public function index()
    {
        session_unset();
        redirect(url());
    }
}
