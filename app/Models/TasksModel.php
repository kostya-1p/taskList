<?php

namespace App\Models;

class TasksModel
{

    public function getTasks(): array
    {
        if (isset($_COOKIE['tasks'])) {
            return json_decode($_COOKIE['tasks'], true);
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

    private function findTaskByID(array $tasks, string $id): int
    {
        $ids = array_column($tasks, 'id');
        $foundKey = array_search($id, $ids);
        return $foundKey;
    }

    public function deleteTask(): void
    {
        $id = $_POST['id'];
        if (!empty($id)) {
            $currentTasks = $this->getTasks();
            $foundKey = $this->findTaskByID($currentTasks, $id);
            array_splice($currentTasks, $foundKey, 1);
            $this->setTasksToCookie($currentTasks);
        }
    }

    private function setTasksToCookie(array $tasks): void
    {
        setcookie('tasks', json_encode($tasks), time() + (10 * 365 * 24 * 60 * 60));
    }

    public function deleteAllTasks(): bool
    {
        if (isset($_COOKIE['tasks'])) {
            unset($_COOKIE['tasks']);
            setcookie('tasks', null, -1);
            return true;
        } else {
            return false;
        }
    }

    public function checkTask(): void
    {
        $id = $_POST['id'];
        if (!empty($id)) {
            $currentTasks = $this->getTasks();
            $foundKey = $this->findTaskByID($currentTasks, $id);
            $currentTasks[$foundKey]['checked'] = !$currentTasks[$foundKey]['checked'];
            $this->setTasksToCookie($currentTasks);
        }
    }

    public function checkAllTasks(): void
    {
        $currentTasks = $this->getTasks();
        for ($i = 0; $i < count($currentTasks); $i++){
            $currentTasks[$i]['checked'] = true;
        }
        $this->setTasksToCookie($currentTasks);
    }
}