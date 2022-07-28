<?php

namespace App\Controllers;

use App\Models\LoginModel;
use App\View;

class LoginController
{
    public function index(): View
    {
        return View::make('login');
    }

    public function login()
    {
        session_start();
        $login = htmlspecialchars($_POST['login']);
        $password = htmlspecialchars($_POST['password']);

        $loginModel = new LoginModel();
        $isFound = $loginModel->isUserLogged($login, $password);

        if ($isFound)
        {
            header('Location: /tasks');
        }
        return View::make('login', ['loginErr' => 'Invalid Login or Password']);
    }
}