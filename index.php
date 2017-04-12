<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Web shop</title>
    <link rel="stylesheet" type="text/css" href="/paginaweb/css/foundation.css">
    <link rel="stylesheet" type="text/css" href="/paginaweb/css/app.css">
</head>

<body>
<?php


include "menu.php";
include "autoload.php";

//If the URL is like /paginaweb/ then the $path will be empty, so make path "index"
if (empty($_GET['path'])) {
    $path = "index";
} else {
    $path = $_GET['path'];
}

$router = new Router($path);
$router->processRequest($path);

if ($path === "account"):
    //If not logged in, show login form
    ?>
    <form method="post" action="login.php" style="margin-top: 20px;">
        <div class="row">
            <div class="large-10 columns">
                <label>
                    Username
                    <input type="text" name="username">
                </label>

                <label>
                    Password
                    <input type="password" name="password">
                </label>
                <input type="submit" class="button" value="Log in">
            </div>

        </div>
    </form>
    <?php
    //else show register form
//        else:
    ?>
    <div class="row">
        <div class="large-10 columns">
            <h2> Register </h2>
            <form method="post" action="register.php">
                <label>
                    Full name
                    <input type="text" name="name">
                </label>
                <label>
                    Address
                    <input type="text" name="address">
                </label>
                <label>
                    Username
                    <input type="text" name="username">
                </label>
                <label>
                    Password
                    <input type="password" name="password">
                </label>
                <label>
                    Repeat password
                    <input type="password" name="repeat_password">
                </label>
                <input type="submit" class="button" value="Register">
            </form>
        </div>
    </div>
<?php endif; ?>

<script>
    path = window.location.pathname;

    //Search all the elements with the attribute href having the value of path given
    var matches = document.querySelector("[href='" + path + "']");

    $(matches).parents("[role='menuitem']:last").addClass("active");
</script>
</body>
</html>