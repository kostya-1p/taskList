<?php

namespace App\Models;

use App\Model;

class TasksModel extends Model
{
    public function getTasks(): array
    {
        //Get tasks from DB
        $query = "SELECT id, description, status FROM tasks WHERE user_id = :user_id
                  ORDER BY created_at";
        $stmt = $this->executeQuery($query, ['user_id'], [$_SESSION['id']]);

        //Get task array if task table is not empty
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
            //handle user input and add task to database
            $description = htmlspecialchars($_POST['description']);
            $query = "INSERT INTO tasks(user_id, description) VALUES (:user_id, :description)";
            $this->executeQuery($query, ['user_id', 'description'], [$_SESSION['id'], $description]);
        }
    }

    public function deleteTask(): void
    {
        $taskId = $_POST['id'];
        if (!empty($id))
        {
            $query = "DELETE FROM tasks WHERE id = :id";
            $this->executeQuery($query, ['id'], [$taskId]);
        }
    }

    public function deleteAllTasks(): void
    {
        $query = "DELETE FROM tasks WHERE user_id = :user_id";
        $this->executeQuery($query, ['user_id'], [$_SESSION['id']]);
    }

    public function checkTask(): void
    {
        $taskId = $_POST['id'];
        if (!empty($id))
        {
            //Change task status to opposite
            $query = "UPDATE tasks SET status = (status - 1) * -1 WHERE id = :id";
            $this->executeQuery($query, ['id'], [$taskId]);
        }
    }

    public function checkAllTasks(): void
    {
        //Change status of all tasks to opposite
        $query = "UPDATE tasks SET status = 1 WHERE user_id = :user_id";
        $this->executeQuery($query, ['user_id'], [$_SESSION['id']]);
    }
}