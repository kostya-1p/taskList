<?php

namespace App\Controllers;

use App\View;

class RegistrationController
{
    public function index(): View
    {
        return View::make('register');
    }
}