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

    private function getUserFromDB(string $query, string $login): \PDOStatement
    {
        //Get User from DB by login
        $stmt = $this->db->prepare($query);
        $stmt->bindParam('login', $login);
        $stmt->execute();
        return $stmt;
    }

    private function isPasswordCorrect(\PDOStatement $stmt, string $password): bool
    {
        //Check if found only one user
        if ($stmt->rowCount() == 1)
        {
            //Get password from DB and compare with user input password
            $usersArray = $stmt->fetchAll();
            $hashedPassword = $usersArray[0]['password'];
            if (password_verify($password, $hashedPassword))
            {
                $this->saveUserDataToSession($usersArray);
                return true;
            } else
            {
                return false;
            }
        }
        return false;
    }

    private function saveUserDataToSession(array $users)
    {
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $users[0]['id'];
        $_SESSION["login"] = $users[0]['login'];
    }
}