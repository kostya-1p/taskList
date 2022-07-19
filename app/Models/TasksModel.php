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
        $task = array("id" => uniqid(), "description" => $_POST['description'], "checked" => false);
        $this->tasks[] = $task;
        setcookie('tasks', json_encode($this->tasks), time() + (10 * 365 * 24 * 60 * 60));
    }
}