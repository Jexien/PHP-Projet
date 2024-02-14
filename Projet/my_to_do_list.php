<?php 
session_start();

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');
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
    <div style="border: 1px solid black; padding: 10px; display: inline-block;">
        <form method="post" action="" class="input_form">
            Tâche :   
            <input type="text" name="task" class="task_input"><br>
            Priorité :<br>
            <input type="radio" name="Priorité" value="Basse"> Basse<br>
            <input type="radio" name="Priorité" value="Moyenne"> Moyenne<br>
            <input type="radio" name="Priorité" value="Haute"> Haute <br>
            Date limite :
            <input type="date" name="date" id="date" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>"> <br>
            Catégorie : 
            <input type="text" name="catégorie" class="catégorie_input"> <br>
            <input type="submit" name="creer" value="Créer">
            
        </form>
    </div>


    <?php echo "<h2>Bravo tu es connecté " . $_SESSION["LOGGED_USER"]["nom"] . "</h2>"; ?>
    <?php echo "<h2>Ma To-Do List</h2>";
    ?>



    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="submit" name="logout" value="Déconnexion">
    </form>
</body>
</html>