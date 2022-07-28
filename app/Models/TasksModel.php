<?php

namespace App\Models;

use App\Model;

class TasksModel extends Model
{
    private function executeQuery(string $query, array $paramNames, array $paramValues): \PDOStatement
    {
        $stmt = $this->db->prepare($query);
        for ($i = 0; $i < count($paramNames); $i++)
        {
            $stmt->bindParam($paramNames[$i], $paramValues[$i]);
        }

        $stmt->execute();
        return $stmt;
    }

    public function getTasks(): array
    {
        $query = "SELECT id, description, status FROM tasks WHERE user_id = :user_id
                  ORDER BY created_at";
        $stmt = $this->executeQuery($query, ['user_id'], [$_SESSION['id']]);

        if ($stmt->rowCount() > 0)
        {
            return $stmt->fetchAll();
        }

        return [];
    }

    public function addTask(): void
    {
        if (!empty($_POST['description']))
        {
            $description = htmlspecialchars($_POST['description']);
            $query = "INSERT INTO tasks(user_id, description) VALUES (:user_id, :description)";
            $this->executeQuery($query, ['user_id', 'description'], [$_SESSION['id'], $description]);
        }
    }

    public function deleteTask(): void
    {
        $id = $_POST['id'];
        if (!empty($id))
        {
            $query = "DELETE FROM tasks WHERE id = :id";
            $this->executeQuery($query, ['id'], [$id]);
        }
    }

    public function deleteAllTasks(): void
    {
        $query = "DELETE FROM tasks WHERE user_id = :user_id";
        $this->executeQuery($query, ['user_id'], [$_SESSION['id']]);
    }

    private function getTaskStatus(int $id): int
    {
        $query = "SELECT status FROM tasks WHERE id = :id";
        $stmt = $this->executeQuery($query, ['id'], [$id]);
        $task = $stmt->fetch();
        return $task['id'];
    }

    public function checkTask(): void
    {
        $id = $_POST['id'];
        if (!empty($id))
        {
            $query = "UPDATE tasks SET status = (status - 1) * -1 WHERE id = :id";
            $this->executeQuery($query, ['id'], [$id]);
        }
    }

    public function checkAllTasks(): void
    {
        $query = "UPDATE tasks SET status = 1 WHERE user_id = :user_id";
        $this->executeQuery($query, ['user_id'], [$_SESSION['id']]);
    }
}