<?php

namespace App\Models;

use App\Model;

class LoginModel extends Model
{
    public function isUserLogged(string $login, string $password): bool
    {
        $query = $this->getQuery();
        $stmt = $this->getUserFromDB($query, $login);
        return $this->isPasswordCorrect($stmt, $password);
    }

    private function getQuery(): string
    {
        return "SELECT * FROM users WHERE login = :login";
    }

    private function getUserFromDB(string $query, string $login)
    {
        $stmt = $this->db->prepare($query);
        $stmt->bindParam('login', $login);
        $stmt->execute();
        return $stmt;
    }

    private function saveUserDataToSession(array $users)
    {
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $users[0]['id'];
        $_SESSION["login"] = $users[0]['login'];
    }

    private function isPasswordCorrect(\PDOStatement $stmt, string $password): bool
    {
        if ($stmt->rowCount() == 1)
        {
            $users = $stmt->fetchAll();
            $hashed_password = $users[0]['password'];
            if (password_verify($password, $hashed_password))
            {
                $this->saveUserDataToSession($users);
                return true;
            } else
            {
                return false;
            }
        }
        return false;
    }
}