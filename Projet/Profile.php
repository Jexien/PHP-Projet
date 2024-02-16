<?php 
session_start();
session_regenerate_id();

// Verif connexion
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];

    // Infos utilisateur
    echo "Username: " . $user['username'] . "<br>";
    echo "Email: " . $user['email'] . "<br>";
} else {
    // Rediriger vers la page de connexion
    header("Location: login.php");
    exit();
}
?>