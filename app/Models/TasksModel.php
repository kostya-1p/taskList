<?php

namespace App\Models;

use App\Model;

class TasksModel extends Model
{
    public function getTasks(int $user_id): array
    {
        //Get tasks from DB
        $query = "SELECT id, description, status FROM tasks WHERE user_id = :user_id
                  ORDER BY created_at";
        $stmt = $this->executeQuery($query, ['user_id'], [$user_id]);

        //Get task array if task table is not empty
        if ($stmt->rowCount() > 0)
        {
            return $stmt->fetchAll();
        }

        return [];
    }

    public function getSingleTask(int $taskId): array
    {
        $query = "SELECT * FROM tasks WHERE id = :id";
        $stmt = $this->executeQuery($query, ['id'], [$taskId]);
        return $stmt->fetch();
    }

    private function hasTask(int $taskId, int $userId): bool
    {
        $task = $this->getSingleTask($taskId);

        if (!empty($task) && $task['user_id'] == $userId)
        {
            return true;
        }
        return false;
    }

    public function addTask(int $user_id, string $description): void
    {
        //add task to database
        $query = "INSERT INTO tasks(user_id, description) VALUES (:user_id, :description)";
        $this->executeQuery($query, ['user_id', 'description'], [$user_id, $description]);
    }

    public function deleteTask(int $taskId, int $userId): void
    {
        if ($this->hasTask($taskId, $userId))
        {
            $query = "DELETE FROM tasks WHERE id = :id";
            $this->executeQuery($query, ['id'], [$taskId]);
        }
    }

    public function deleteAllTasks(int $user_id): void
    {
        $query = "DELETE FROM tasks WHERE user_id = :user_id";
        $this->executeQuery($query, ['user_id'], [$user_id]);
    }

    public function checkTask(int $taskId, int $userId): void
    {
        if ($this->hasTask($taskId, $userId))
        {
            //Change task status to opposite
            $query = "UPDATE tasks SET status = (status - 1) * -1 WHERE id = :id";
            $this->executeQuery($query, ['id'], [$taskId]);
        }
    }

    public function checkAllTasks(int $user_id): void
    {
        //Change status of all tasks to opposite
        $query = "UPDATE tasks SET status = 1 WHERE user_id = :user_id";
        $this->executeQuery($query, ['user_id'], [$user_id]);
    }
}