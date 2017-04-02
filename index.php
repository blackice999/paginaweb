<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Web shop</title>
    <link rel="stylesheet" type="text/css" href="/paginaweb/css/foundation.css">
    <link rel="stylesheet" type="text/css" href="/paginaweb/css/app.css">

    <style>

    </style>

    <script>

        var jsonPath = window.location.pathname;

        components = jsonPath.split("/");

        rootPath = components[1];

        //Remove root and /paginaweb from the path
        components.shift();
        components.shift();

//        document.write(components);
        var path = components.join("/");
        document.write(path);
    </script>
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
    var arr = [], links = document.links;

    for(var i = 0; i< links.length; i++){
        arr.push(links[i].pathname);
    }

    console.log(arr);

    element = arr[10];
//    element.shift();
    console.log(element);

    var matches = document.querySelectorAll("[href='/paginaweb/monitors']");
    console.log(matches);
    </script>
</body>
</html>