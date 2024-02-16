<?php 
session_start();

include 'headeron.php';

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
        'Priorite' => isset($_POST['Priorite']) ? $_POST['Priorite'] : null,
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
            <input type="radio" name="Priorite" value="Basse"> Basse<br>
            <input type="radio" name="Priorite" value="Moyenne"> Moyenne<br>
            <input type="radio" name="Priorite" value="Haute"> Haute <br>
            Date limite :
            <input type="date" name="date" id="date" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>"> <br>
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
        echo "Avancement: <span class=\"status-dot\"></span> " . $taskData['avancement'] . "<select name=\"avancement\" class=\"avancement_input\">
            <option value=\"En cours\" " . ($taskData['avancement'] == 'En cours' ? 'selected' : '') . ">En cours</option>
            <option value=\"Terminé\" " . ($taskData['avancement'] == 'Terminé' ? 'selected' : '') . ">Terminé</option>
            <option value=\"En attente\" " . ($taskData['avancement'] == 'En attente' ? 'selected' : '') . ">En attente</option>
        </select>";
        echo "<br>";
        echo "________________";
        echo "<br>";
        echo "<br>";
    }
}

if(isset($_POST['sauvegarder'])) {
    // Récupérer les tâches existantes depuis le fichier JSON
    $json = file_get_contents('Claire_todolist.json');
    $todoList = json_decode($json, true);

    // Mettre à jour les données des tâches
    foreach($_POST as $key => $value) {
        if(strpos($key, 'tache') === 0) {
            $taskId = substr($key, 5);
            // Rechercher la tâche correspondante dans la liste des tâches
            foreach ($todoList as &$taskData) {
                if ($taskData['taskID'] == $taskId) {
                    // Mettre à jour l'avancement de la tâche
                    $taskData['avancement'] = $value;
                    break;
                }
            }
        }
    }

    // Réécrire le fichier JSON avec les données mises à jour
    $jsonUpdated = json_encode($todoList);
    file_put_contents('Claire_todolist.json', $jsonUpdated);
}


?>

<input type="submit" name="sauvegarder" value="Sauvegarder">


    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="submit" name="logout" value="Déconnexion">
    </form>
</body>
</html>