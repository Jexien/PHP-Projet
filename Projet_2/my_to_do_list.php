<?php
session_start();
include 'headeron.php';

// Définition de $categories pour éviter les erreurs de clé non définie
$categories = ["Défaut"];

?>

<!DOCTYPE html>
<html>
<head>
    <title>My To-Do List</title>
    <meta charset="UTF-8">
</head>
<body>
<?php if(isset($_SESSION["LOGGED_USER"]["nom"])) {
    echo "<h2>Connexion réussie, bienvenue " . $_SESSION["LOGGED_USER"]["nom"] . "</h2>"; ?>
    <div style="border: 1px solid black; padding: 10px; display: inline-block;">
        <form action="tdlprocess.php" method="post" class="input_form">
            Tâche :
            <input type="text" name="task" class="task_input"><br>
            Priorité :<br>
            <input type="radio" name="Priorite" value="Basse" checked > Basse<br>
            <input type="radio" name="Priorite" value="Moyenne"> Moyenne<br>
            <input type="radio" name="Priorite" value="Haute"> Haute <br>
            Date limite :
            <input type="date" name="date" id="date" value="<?php echo date('Y-m-d'); ?>" > <br>
            Catégorie :
            <select name="catégorie" class="catégorie_input">
                <?php
                foreach ($categories as $category) {
                    echo '<option value="' . $category . '">' . $category . '</option>';
                }
                ?>
            </select>
            <input type="text" name="new_category" class="new_category_input" placeholder="Nouvelle catégorie">
            <input type="submit" name="add_category" value="Ajouter catégorie">
            <br>
            <select name="avancement" class="avancement_input">
                <option value="En cours">En cours</option>
                <option value="Terminé">Terminé</option>
                <option value="En attente">En attente</option>
            </select>
            <br>
            <input type="submit" name="creer" value="Créer">
        </form>
    </div>

    <h2>Ma To-Do List</h2>

    <?php
    $filename = $_SESSION["LOGGED_USER"]["nom"] . "_todolist.json";
    if (file_exists($filename)) {
        $todoList = json_decode(file_get_contents($filename), true);
        foreach ($todoList as $index => $taskData) {
            echo "Tâche: " . $taskData['task'] . "   ";
            echo '<form action="tdlprocess.php" method="post">';
            echo '<input type="hidden" name="task_index" value="' . $index . '">';
            echo '<input type="submit" name="edit_task" value="Modifier">';
            echo '</form>';
            echo "<br>";
            echo "Priorité: " . (isset($taskData['priority']) ? $taskData['priority'] : '') . "<br>";
            if (isset($taskData['date'])) {
                if ($taskData['date'] < date('Y-m-d')) {
                    echo "Date butoir: <span style=\"color: red;\">" . $taskData['date'] . "</span><br>";
                } else {
                    echo "Date butoir: " . $taskData['date'] . "<br>";
                }
            }
            echo "Catégorie: " . (isset($taskData['category']) ? $taskData['category'] : '') . "<br>"; // Check if the key exists before accessing it
            echo "Avancement: <span class=\"status-dot\"></span> " . (isset($taskData['avancement']) ? $taskData['avancement'] : '') . "<br>";
            echo "<br>";
            echo "________________";
            echo "<br>";
            echo "<br>";
        }
    }
    ?>
    <input type="submit" name="sauvegarder" value="Sauvegarder">
<?php } else {
    echo "Session non initialisée";
} ?>
</body>
</html>
