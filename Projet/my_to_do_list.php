<?php 
session_start();

include 'headeron.php';

$priority = "pas de priorité";

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}

if (isset($_POST['creer'])) {
    $task = $_POST['task'];
    $priority = $_POST['Priorite'];
    $date = $_POST['date'];
    $category = $_POST['catégorie'];

    $todoList = [
        'task' => $task,
        'priority' => $priority,
        'date' => $date,
        'category' => $category
    ];
}
?>
<?php
$filename = $_SESSION["LOGGED_USER"]["nom"] . "_categorie.json";
if (!file_exists($filename)) {
    $categories = ["Défaut"];
    file_put_contents($filename, json_encode($categories, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE | JSON_FORCE_OBJECT));
} else {
    $categories = json_decode(file_get_contents($filename), true);
}
?>

<?php //créer une nouvelle catégorie
if (isset($_POST['add_category'])) {
    $newCategory = $_POST['new_category'];
    
    // Vérifier si la catégorie existe déjà
    if (!in_array($newCategory, $categories)) {
        $categories[] = $newCategory;
        file_put_contents($_SESSION["LOGGED_USER"]["nom"] . "_categorie.json", json_encode($categories, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE | JSON_FORCE_OBJECT));
    }
}
?>

<?php


if (isset($_POST['creer'])) {
    $taskData = [
        'task' => $_POST['task'],
        'Priorite' => isset($_POST['Priorite']) ? $_POST['Priorite'] : 'Pas de priorité',
        'date' => $_POST['date'],
        'catégorie' => isset($_POST['catégorie']) ? $_POST['catégorie'] : null,
        'avancement' => $_POST['avancement'] ? $_POST['avancement'] : null
    ];

    $filename = $_SESSION["LOGGED_USER"]["nom"] . "_todolist.json";
    $existingData = [];

    if (file_exists($filename)) {
        $existingData = json_decode(file_get_contents($filename), true);
    }

    // Check si la tâche existe déjà
    foreach ($existingData as $existingTask) {
        if ($existingTask['task'] === $taskData['task']) {
            echo "This task already exists!";
            return;
        }
    }

    $existingData[] = $taskData;
    file_put_contents($filename, json_encode($existingData, JSON_PRETTY_PRINT));
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>My To-Do List</title>
    <meta charset="UTF-8">
</head>
<body>
    <div style="border: 1px solid black; padding: 10px; display: inline-block;">
        <form method="post" action="" class="input_form">
            Tâche :   
            <input type="text" name="task" class="task_input"><br>
            Priorité :<br>
            <input type="radio" name="Priorite" value="Basse" checked > Basse<br>
            <input type="radio" name="Priorite" value="Moyenne"> Moyenne<br>
            <input type="radio" name="Priorite" value="Haute"> Haute <br>
            Date limite :
            <input type="date" name="date" id="date" value="<?php echo date('Y-m-d'); ?>" ?> <br>
            Catégorie : 
            <select name="catégorie" class="catégorie_input">
                <?php
                    foreach ($categories as $category) {
                        echo '<option value="' . $category . '">' . $category . '</option>';
                    }
                ?>
            </select>


<input type="text" name="new_category" class="new_category_input" placeholder="Nouvelle catégorie">
<input type="submit" name="add_category" value="Ajouter catégorie" onclick="window.location.href = window.location.href">

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


    <?php echo "<h2>Bravo tu es connecté " . $_SESSION["LOGGED_USER"]["nom"] . "</h2>"; ?>
    <?php echo "<h2>Ma To-Do List</h2>"; ?>



    <?php
$filename = $_SESSION["LOGGED_USER"]["nom"] . "_todolist.json";
if (file_exists($filename)) {
    $todoList = json_decode(file_get_contents($filename), true);
    foreach ($todoList as $taskData) {
        echo "Tâche: " . $taskData['task'] . "<br>";
        echo "Priorité: " . $taskData['Priorite'] . "<br>";
        echo "Date butoir: " . $taskData['date'] . "<br>";
        echo "Catégorie: " . $taskData['catégorie'] . "<br>";
        echo "Avancement: <span class=\"status-dot\"></span> " . $taskData['avancement'] . "<br>";
        echo "<br>";
        echo "________________";
        echo "<br>";
        echo "<br>";
    }
}

foreach ($todoList as $index => $taskData) {
    echo "Tâche: " . $taskData['task'] . "<br>";
    // Afficher les autres détails de la tâche

    // Bouton de modification
    echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
    echo '<input type="hidden" name="task_index" value="' . $index . '">';
    echo '<input type="submit" name="edit_task" value="Modifier">';
    echo '</form>';
}
if (isset($_POST['edit_task'])) {
    $index = $_POST['task_index'];
    $taskToEdit = $todoList[$index];
    ?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="task_index" value="<?php echo $index; ?>">
        Nouveau nom de la tâche : <input type="text" name="new_task_name" value="<?php echo $taskToEdit['task']; ?>"><br>
        <!-- Ajoutez d'autres champs de formulaire pour les autres détails de la tâche -->
        <input type="submit" name="save_changes" value="Enregistrer les modifications">
    </form>
    <?php
}
if (isset($_POST['save_changes'])) {
    $index = $_POST['task_index'];
    $newTaskName = $_POST['new_task_name'];
    // Mettez à jour les autres champs de formulaire nécessaires

    // Mettez à jour la tâche correspondante dans $todoList
    $todoList[$index]['task'] = $newTaskName;
    // Mettez à jour les autres champs de formulaire nécessaires

    // Écrivez le contenu mis à jour dans le fichier JSON
    file_put_contents($filename, json_encode($todoList, JSON_PRETTY_PRINT));
}

?>

<input type="submit" name="sauvegarder" value="Sauvegarder">


    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="submit" name="logout" value="Déconnexion">
    </form>
</body>
</html>