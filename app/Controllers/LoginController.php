<?php

namespace App\Controllers;

use App\View;

class LoginController
{
    public function index(): View
    {
        return View::make('login');
    }

    public function login()
    {

    }
}