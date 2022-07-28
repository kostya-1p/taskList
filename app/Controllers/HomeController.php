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
        session_start();
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
        {
            header("location: /");
            exit;
        }

        $tasks = $this->tasksModel->getTasks();
        return View::make('index', ['tasks' => $tasks]);
    }

    public function create()
    {
        session_start();
        $this->tasksModel->addTask();
        header("Location: /tasks");
    }

    public function delete()
    {
        $this->tasksModel->deleteTask();
        header("Location: /tasks");
    }

    public function deleteAllTasks()
    {
        session_start();
        $this->tasksModel->deleteAllTasks();
        header("Location: /tasks");
    }

    public function checkTask()
    {
        $this->tasksModel->checkTask();
        header("Location: /tasks");
    }

    public function checkAllTasks()
    {
        session_start();
        $this->tasksModel->checkAllTasks();
        header("Location: /tasks");
    }
}