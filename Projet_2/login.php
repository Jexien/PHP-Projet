<?php
include 'headeroff.php';
session_start();
session_regenerate_id();

if(isset($_SESSION['utilisateur_actif'])) {
    // Si une session est active, affiche un message pour l'utilisateur actif
    echo "Bienvenue, ".$_SESSION['utilisateur_actif']."!";
} else {
    // Si aucune session n'est active, affiche un formulaire de connexion
    echo "<h1>Login</h1>
    <form action=\"submitlogin.php\" method=\"post\">
        <div>
            <label for=\"email\">email:</label><br>
            <input type=\"email\" id=\"email\" name=\"email\" required>
        </div>

        <div>
            <label for=\"password\">Mot de Passe:</label><br>
            <input type=\"password\" id=\"password\" name=\"password\" required>
        </div>

        <div>
            <input type=\"submit\" value=\"Connexion\">
        </div>
    </form>
    <br><br>";
}
?>
