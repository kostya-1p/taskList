<?php

namespace App\Models;

use App\Model;

class RegistrationModel extends Model
{
    public function registerUser(string $login, string $password): bool
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = $this->getQuery();

        if ($this->isLoginUnique($login))
        {
            $this->insertUser($query, $login, $hashedPassword);
            return true;
        }
        return false;
    }

    private function getQuery(): string
    {
        return "INSERT INTO users (login, password) VALUES (:login, :password)";
    }

    private function isLoginUnique(string $login)
    {
        $query = "SELECT id FROM users WHERE login = :login";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam('login', $login);
        $stmt->execute();

        if ($stmt->rowCount() > 0)
            return false;
        return true;
    }

    private function insertUser(string $query, string $login, string $hashedPassword): void
    {
        $stmt = $this->db->prepare($query);
        $stmt->bindParam('login', $login);
        $stmt->bindParam('password', $hashedPassword);
        $stmt->execute();
    }
}