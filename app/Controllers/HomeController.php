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
        return View::make('index', ['tasks'=>$tasks]);
    }

    public function create()
    {
        $this->tasksModel->addTask();
        header("Location: /");
    }
}