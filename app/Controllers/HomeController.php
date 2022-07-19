<?php

namespace App\Controllers;

use App\Models\ReadDepositsModel;
use App\Models\TasksModel;
use App\View;

class HomeController
{
    private $tasksModel;

    public function __construct()
    {
        $this->tasksModel = new TasksModel();
    }

    public function index(): View
    {
        $tasks = $this->tasksModel->getTasks();
        return View::make('index', ['tasks' => $tasks]);
    }

    public function create()
    {
        $this->tasksModel->addTask();
        header("Location: /");
    }

    public function delete()
    {
        $this->tasksModel->deleteTask();
        header("Location: /");
    }

    public function deleteAllTasks()
    {
        $this->tasksModel->deleteAllTasks();
        header("Location: /");
    }

    public function checkTask()
    {
        $this->tasksModel->checkTask();
        header("Location: /");
    }

    public function checkAllTasks()
    {
        $this->tasksModel->checkAllTasks();
        header("Location: /");
    }
}