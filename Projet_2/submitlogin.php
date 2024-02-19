<?php
session_start();
session_regenerate_id();
include 'headeron.php';
$users = json_decode(file_get_contents('users.json'), true);
// include_once 'includes/header.php';

$Data = $_POST;
if(!isset($Data["email"]) || empty($Data["email"]) ||
    !isset($Data["password"]) || empty($Data["password"]) ||
    !filter_var($Data["email"], FILTER_VALIDATE_EMAIL)
) {
    echo "Il y a une erreur dans le formulaire";
    return;
}
else{
    foreach ($users as $user) {
        if($user["email"] === $Data["email"] 
        && $user["password"] === $Data["password"])
        {
            $_SESSION["LOGGED_USER"] = [
                "email" => $user["email"],
                "nom" => $user["nom"]
            ];
        }
    }
}

?>
<main>
    <?php if(isset($_SESSION["LOGGED_USER"])) : ?>

        <h2>Bravo tu es connecté <?php echo $_SESSION["LOGGED_USER"]["nom"];?></h2>

        <button onclick="window.location.href='my_to_do_list.php'";>My to do</button>
        <button onclick="window.location.href='logout.php'">Déconnexion</button>
    <?php else : ?>
        <h2>Echec</h2>
    <?php endif; ?>
</main>

<!-- <?php
    include_once 'footer.php';
?> -->