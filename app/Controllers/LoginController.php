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

    public function login(): View
    {
        session_start();

        //handle user input
        $login = htmlspecialchars($_POST['login']);
        $password = htmlspecialchars($_POST['password']);

        //Find user with entered login and password in database
        $loginModel = new LoginModel();
        $isUserFound = $loginModel->isUserLogged($login, $password);

        if ($isUserFound)
        {
            header('Location: /tasks');
        }

        //Send login error to View
        return View::make('login', ['loginErr' => 'Invalid Login or Password']);
    }
}