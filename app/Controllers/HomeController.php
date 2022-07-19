<?php

namespace App\Controllers;

use App\Models\ReadDepositsModel;
use App\View;

class HomeController
{
    public function index(): View
    {
        return View::make('index');
    }
}