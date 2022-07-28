<?php

declare(strict_types = 1);

namespace App;

abstract class Model
{
    protected DB $db;

    public function __construct()
    {
        $this->db = App::db();
    }

    protected function executeQuery(string $query, array $paramNames, array $paramValues): \PDOStatement
    {
        $stmt = $this->db->prepare($query);
        for ($i = 0; $i < count($paramNames); $i++)
        {
            $stmt->bindParam($paramNames[$i], $paramValues[$i]);
        }

        $stmt->execute();
        return $stmt;
    }
}
