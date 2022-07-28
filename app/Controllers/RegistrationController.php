<?php

namespace App\Controllers;

use App\Models\RegistrationModel;
use App\View;

class RegistrationController
{
    public function index(): View
    {
        return View::make('register');
    }

    //Send registration error to View
    private function sendErrorMessage(string $message): View
    {
        return View::make('register', ['registerErr' => $message]);
    }

    public function register(): View
    {
        //Check user input for empty fields
        if (empty($_POST['login']) || empty($_POST['password']) || empty($_POST['confirm_password']))
        {
            return $this->sendErrorMessage('Fields must not be empty');
        }

        $registrationModel = new RegistrationModel();

        //Handle user input
        $login = htmlspecialchars($_POST['login']);
        $password = htmlspecialchars($_POST['password']);
        $confirmPassword = htmlspecialchars($_POST['confirm_password']);

        if ($password != $confirmPassword)
        {
            return $this->sendErrorMessage('Passwords are not equal');
        }

        //Register user
        session_start();
        $result = $registrationModel->registerUser($login, $password);

        if ($result)
        {
            header('Location: /tasks');
        }

        return $this->sendErrorMessage('User with the same username already exists');
    }
}