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
        //Check if user is logged in
        session_start();
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
        {
            header("location: /");
            exit;
        }

        //Get tasks and send them to View
        $tasks = $this->tasksModel->getTasks();
        return View::make('index', ['tasks' => $tasks]);
    }

    public function create()
    {
        $this->callTaskModelFunction('addTask');
    }

    public function delete()
    {
        $this->callTaskModelFunction('deleteTask');
    }

    public function deleteAllTasks()
    {
        $this->callTaskModelFunction('deleteAllTasks');
    }

    public function checkTask()
    {
        $this->callTaskModelFunction('checkTask');
    }

    public function checkAllTasks()
    {
        $this->callTaskModelFunction('checkAllTasks');
    }

    private function callTaskModelFunction(string $methodName)
    {
        //Call method from task model and go to /tasks page
        session_start();
        $this->tasksModel->{$methodName}();
        $this->setHeader();
    }

    private function setHeader()
    {
        header("Location: /tasks");
    }
}