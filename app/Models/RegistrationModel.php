<?php

namespace App\Models;

use App\Model;

class RegistrationModel extends Model
{
    public function registerUser(string $login, string $password): bool
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertQuery = $this->getQuery();

        if ($this->isLoginUnique($login))
        {
            $this->insertUser($insertQuery, $login, $hashedPassword);
            $this->saveLastInsertedUserToSession($login);
            return true;
        }
        return false;
    }

    private function getQuery(): string
    {
        return "INSERT INTO users (login, password) VALUES (:login, :password)";
    }

    private function isLoginUnique(string $login): bool
    {
        $stmt = $this->getUserByLogin($login);

        if ($stmt->rowCount() > 0)
            return false;
        return true;
    }

    private function getUserByLogin(string $login): \PDOStatement
    {
        $query = "SELECT id FROM users WHERE login = :login";
        return $this->executeQuery($query, ['login'], [$login]);
    }

    private function insertUser(string $query, string $login, string $hashedPassword): void
    {
        $this->executeQuery($query, ['login', 'password'], [$login, $hashedPassword]);
    }

    private function saveLastInsertedUserToSession(string $login): void
    {
        $stmt = $this->getUserByLogin($login);
        $user = $stmt->fetch();

        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $user['id'];
        $_SESSION["login"] = $login;
    }
}