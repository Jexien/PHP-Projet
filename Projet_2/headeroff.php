<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <?php
    $pageName = basename($_SERVER['PHP_SELF']);
    echo "<title>$pageName</title>";
    ?>
    <title></title>
    <link rel="stylesheet" href="styles.css">
    <style>
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
        }

        nav li {
            float: left;
        }

        nav li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        nav li a:hover {
            background-color: #111;
        }
    </style>
    <script src="script.js"></script>
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Index</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
