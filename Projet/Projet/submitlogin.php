<?php
// include_once 'users.php';
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
        <?php
            header("Location: my_to_do_list.php");
            exit;
        ?>
    <?php else : ?>
        <h2>Echec</h2>
    <?php endif; ?>
</main>

<!-- <?php
    include_once 'includes/footer.php';
?> -->