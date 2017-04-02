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

        $path = $_GET['path'];
        echo $path;

        if($path === "software") {
            echo "in software";
        }

    ?>

<script>
    path = window.location.pathname;

    //Search all the elements with the attribute href having the value of path given
    var matches = document.querySelector("[href='" + path + "']");

    $(matches).parents("[role='menuitem']:last").addClass("active");
</script>
</body>
</html>