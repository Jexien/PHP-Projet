<?php 
session_start();

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php'); // Redirect to login page after logout
    exit();
}
$user = json_decode(file_get_contents('users.json'), true);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My To-Do List</title>
</head>
<body>

<form method="post" action="" class="input_form">   
    <input type="text" name="task" class="task_input">
    <button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
</form>

<?php echo "<h2>Bravo tu es connecté " . $_SESSION["LOGGED_USER"]["nom"] . "</h2>"; ?>
<?php echo "<h2>Ma To-Do List</h2>";
if (isset($_POST['submit'])) {
    $task = $_POST['task'];
    if (empty($task)) {
        echo "Ajoutez une nouvelle tâche !";
    } else {
        $_SESSION['tasks'][] = $task; 
        $username = "Username";
        $filename = $_SESSION["LOGGED_USER"]["nom"] . "_Todolist.json";
        
        $existingTasks = [];
        if (file_exists($filename)) {
            $content = file_get_contents($_SESSION["LOGGED_USER"]["nom"] . "_Todolist.json");
            $existingTasks = json_decode($content);
        }
        
        $existingTasks[] = [
            "task" => $task,
            "status" => "Not Started"
        ];

        $data = json_encode($existingTasks);
        file_put_contents($filename, $data);
    }
}

$filename = $_SESSION["LOGGED_USER"]["nom"];
if (file_exists($filename)) {
    $content = file_get_contents($filename);
    $tasks = json_decode($content);
    if ($tasks) {
        foreach ($tasks as $task) {
            echo $task->task .  $task->status;
            echo '<select name="status">';
            echo '<option value="Not Started" ' . ($task->status == "Not Started" ? 'selected' : '') . '>Not Started</option>';
            echo '<option value="In Progress" ' . ($task->status == "In Progress" ? 'selected' : '') . '>In Progress</option>';
            echo '<option value="Completed" ' . ($task->status == "Completed" ? 'selected' : '') . '>Completed</option>';
            echo '</select>';
            echo '<br/>';
        }
    }
}
?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="submit" name="save" value="Sauvegarder">
</form>

<?php
if (isset($_POST['save'])) {
    if ($tasks) {
        foreach ($tasks as &$task) {
            if (isset($_POST['status'])) {
                $task->status = $_POST['status'];
            }
        }
        $data = json_encode($tasks);
        file_put_contents($filename, $data);
    }
}
?>

</body>
</html>


    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="submit" name="logout" value="Déconnexion">
    </form>
</body>
</html>
