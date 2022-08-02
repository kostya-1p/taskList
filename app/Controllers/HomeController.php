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
        $tasks = $this->tasksModel->getTasks($_SESSION['id']);
        return View::make('index', ['tasks' => $tasks]);
    }

    public function create()
    {
        if (!empty($_POST['description']))
        {
            //handle user input and add task to database
            $description = htmlspecialchars($_POST['description']);
            session_start();
            $this->callTaskModelFunction('addTask', [$_SESSION['id'], $description]);
        }
    }

    public function delete()
    {
        session_start();
        $taskId = $_POST['id'];
        if (!empty($taskId))
        {
            $this->callTaskModelFunction('deleteTask', [$taskId, $_SESSION['id']]);
        }
    }

    public function deleteAllTasks()
    {
        session_start();
        $this->callTaskModelFunction('deleteAllTasks', [$_SESSION['id']]);
    }

    public function checkTask()
    {
        session_start();
        $taskId = $_POST['id'];
        if (!empty($taskId))
        {
            $this->callTaskModelFunction('checkTask', [$taskId, $_SESSION['id']]);
        }
    }

    public function checkAllTasks()
    {
        session_start();
        $this->callTaskModelFunction('checkAllTasks', [$_SESSION['id']]);
    }

    private function callTaskModelFunction(string $methodName, array $args)
    {
        //Call method from task model and go to /tasks page
        call_user_func_array([$this->tasksModel, $methodName], $args);
        $this->setHeader();
    }

    private function setHeader()
    {
        header("Location: /tasks");
    }
}