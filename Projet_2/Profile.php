
<?php
session_start();
include 'headeron.php';
if (isset($_SESSION["LOGGED_USER"])) {
    $user = $_SESSION["LOGGED_USER"];
    echo "Nom d'utilisateur: " . $_SESSION["LOGGED_USER"]["nom"] . "<br>";
    echo "Email: " . $user["email"] . "<br>";
} else {
    header('Location: login.php');
    exit();
}
?>


