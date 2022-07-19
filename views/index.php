<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task List</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial;
        }

        h3 {
            text-align: center
        }

        .new-task {
            width: 300px;
            margin: 0 auto;
            border-bottom: thin solid grey;
            margin-bottom: 20px;
        }

        .new-task-form input,
        .new-task-form button {
            font-family: Arial;
            padding: 5px 10px;
            display: inline-block;
            margin-bottom: 15px;
        }

        .check_all, .delete_all {
            display: inline-block;
            margin-bottom: 10px;
        }

        .tasks {
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            align-items: center;
        }

        .task {
            color: black;
            width: 300px;
            display: block;
            margin: 10px;
            position: relative;
            min-height: 100px;
            border-bottom: thin solid grey;
        }

        .task .description {
            margin-bottom: 10px;
            font-weight: bold;
            display: inline-block;
            width: 200px;
            clear: right;
            word-break: break-all;
        }

        .check,
        .delete {
            display: inline-block;
        }

        .check button,
        .delete button {
            font-family: Arial;
            padding: 5px 10px;
            margin-bottom: 15px;
        }

        .task img {
            display: inline-block;
            width: 80px;
            height: 80px;
            float: right;
        }
    </style>
</head>
<body>
<div>
    <h3> Task list </h3>

    <div class="new-task">
        <form class="new-task-form" action="/create" method="post">
            <input type="text" name="description" placeholder="Enter text..." autocomplete="off">
            <button>
                ADD TASK
            </button>
        </form>

        <form class="delete_all" action="/delete_all" method="post">
            <button>
                REMOVE ALL
            </button>
        </form>

        <form class="check_all" action="/check_all" method="post">
            <button>
                READY ALL
            </button>
        </form>
    </div>

    <div class="tasks">
        <?php foreach ($tasks as $task): ?>
            <div class="task">
                <div class="description">
                    <?php echo $task['description'] ?>
                </div>

                <img src=
                    <?php
                    if ($task['checked'])
                        echo 'Green_circle.svg';
                    else
                        echo 'Red_circle.svg';
                    ?>>

                <form action="/check" class="check" method="post">
                    <input type="hidden" name="id" value="<?php echo $task['id'] ?>">
                    <button>
                        <?php
                        if ($task['checked'])
                            echo 'UNREADY';
                        else
                            echo 'READY';
                        ?>
                    </button>
                </form>

                <form action="/delete" class="delete" method="post">
                    <input type="hidden" name="id" value="<?php echo $task['id'] ?>">
                    <button> DELETE</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>