<?php
        // require "users.json";
        // require_once "includes/header.php";
    ?>

    <h1>Login</h1>
    <form action="submitlogin.php" method="post">
        <div>
            <label for="email">email:</label><br>
            <input type="email" id="email" name="email" required>
        </div>

        <div>
            <label for="password">Mot de Passe:</label><br>
            <input type="password" id="password" name="password" required>
        </div>

        <div>
            <input type="submit" value="Connexion">
        <div>
    </form>
    <br><br>

    <?php
        // require_once "includes/footer.php";
    ?>
