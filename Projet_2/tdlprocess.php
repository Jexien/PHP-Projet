<?php
session_start();

$priority = "pas de priorité";

if (!isset($_SESSION["LOGGED_USER"])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}

if (isset($_POST['creer'])) {
    $task = $_POST['task'];
    $priority = $_POST['Priorite'];
    $date = $_POST['date'];
    if (isset($_POST['catégorie'])) {
        $category = $_POST['catégorie'];
    } else {
        $category = "Test";
    }

    $todoList = [
        'task' => $task,
        'priority' => $priority,
        'date' => $date,
        'category' => $category
    ];

    // Traitement pour la sauvegarde de la tâche dans un fichier JSON
    $filename = $_SESSION["LOGGED_USER"]["nom"] . "_todolist.json";
    $existingData = [];

    if (file_exists($filename)) {
        $existingData = json_decode(file_get_contents($filename), true);
    }

    // Vérifier si la tâche existe déjà
    foreach ($existingData as $existingTask) {
        if ($existingTask['task'] === $task) {
            echo "This task already exists!";
            return;
        }
    }

    $existingData[] = $todoList;
    file_put_contents($filename, json_encode($existingData, JSON_PRETTY_PRINT));
}

if (isset($_POST['add_category'])) 
    // Traitement pour l'ajout de catégorie
    $newCategory = $_POST['new_category'];

    $filename = $_SESSION["LOGGED_USER"]["nom"] . "_categorie.json";

    if (!file_exists($filename)) 
        $categories = ["Défaut"];
header('Location: my_to_do_list.php');
exit();
    