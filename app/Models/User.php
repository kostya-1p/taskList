<?php

namespace App\Models;

use App\Model;

class User extends Model
{
    public function isUserLogged(string $login, string $password): bool
    {
        $query = "SELECT * FROM users WHERE login = :login";
        $stmt = $this->getUserFromDB($query, $login);
        return $this->isPasswordCorrect($stmt, $password);
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

    public function registerUser(string $login, string $password): bool
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertQuery = "INSERT INTO users (login, password) VALUES (:login, :password)";

        if ($this->isLoginUnique($login))
        {
            $this->insertUser($insertQuery, $login, $hashedPassword);
            $this->saveLastInsertedUserToSession($login);
            return true;
        }
        return false;
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