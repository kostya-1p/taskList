<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task List</title>
    <link rel="stylesheet" href="css/app.css">
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
                        echo "img/Green_circle.svg";
                    else
                        echo "img/Red_circle.svg";
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