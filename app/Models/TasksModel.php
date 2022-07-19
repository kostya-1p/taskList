<?php

namespace App\Models;

class TasksModel
{
    private $tasks = [];

    public function getTasks(): array
    {
        if (isset($_COOKIE['tasks'])) {
            $this->tasks = json_decode($_COOKIE['tasks'], true);
            return $this->tasks;
        }

        return [];
    }

    public function addTask()
    {
        if (!empty($_POST['description'])) {
            $task = array("id" => uniqid(), "description" => $_POST['description'], "checked" => false);
            $currentTasks = $this->getTasks();
            $currentTasks[] = $task;
            setcookie('tasks', json_encode($currentTasks), time() + (10 * 365 * 24 * 60 * 60));
        }
    }
}