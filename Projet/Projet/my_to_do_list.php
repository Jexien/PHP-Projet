<?php 
session_start();

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php'); // Redirect to login page after logout
    exit();
}
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

<?php
if (isset($_POST['submit'])) {
    $task = $_POST['task'];
    if (empty($task)) {
        echo "Please enter a task!";
    } else {
        echo $task;
    }
}
$task = isset($_GET["task"]) && is_array($_GET["task"]) ? $_GET["task"] : [];
foreach($task as $valeur){
    echo $valeur.'<br/>';
}
?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="submit" name="logout" value="Déconnexion">
    </form>
</body>
</html>
