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
</body>
</html>