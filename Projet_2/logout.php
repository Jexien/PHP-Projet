<?php
session_start();
session_reset();
session_regenerate_id();
session_destroy();
header('Location: login.php');
exit();
?>