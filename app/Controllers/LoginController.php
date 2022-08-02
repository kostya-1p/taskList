<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\RegistrationModel;
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
        $userModel = new User();
        $isUserFound = $userModel->isUserLogged($login, $password);

        if ($isUserFound)
        {
            header('Location: /tasks');
        }

        return $this->register();
    }

    public function register(): View
    {
        //Check user input for empty fields
        if (empty($_POST['login']) || empty($_POST['password']))
        {
            return $this->sendErrorMessage('Fields must not be empty');
        }

        $userModel = new User();

        //Handle user input
        $login = htmlspecialchars($_POST['login']);
        $password = htmlspecialchars($_POST['password']);

        //Register user
        $result = $userModel->registerUser($login, $password);

        if ($result)
        {
            header('Location: /tasks');
        }

        return $this->sendErrorMessage('User with the same username already exists');
    }

    private function sendErrorMessage(string $message): View
    {
        return View::make('login', ['loginErr' => $message]);
    }
}