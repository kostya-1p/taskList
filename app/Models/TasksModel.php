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

    public function addTask(): void
    {
        if (!empty($_POST['description'])) {
            $task = array("id" => uniqid(), "description" => $_POST['description'], "checked" => false);
            $currentTasks = $this->getTasks();
            $currentTasks[] = $task;
            $this->setTasksToCookie($currentTasks);
        }
    }

    public function deleteTask(): void
    {
        $id = $_POST['id'];
        if (!empty($id)) {
            $currentTasks = $this->getTasks();
            $ids = array_column($currentTasks, 'id');
            $foundKey = array_search($id, $ids);
            array_splice($currentTasks, $foundKey, 1);
            $this->setTasksToCookie($currentTasks);
        }
    }

    private function setTasksToCookie(array $tasks): void
    {
        setcookie('tasks', json_encode($tasks), time() + (10 * 365 * 24 * 60 * 60));
    }
}