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


include "autoload.php";
include "menu.php";

//If the URL is like /paginaweb/ then the $path will be empty, so make path "index"
if (empty($_GET['path'])) {
    $path = "index";
} else {
    $path = $_GET['path'];
}

$method = $_SERVER['REQUEST_METHOD'];
$explode = explode("/", $path);
$length = count($explode);

for ($i = 0; $i < $length - 1; $i++) {
    if ($explode[$i] === "product") {
        $productId = $explode[$i + 1];
        $productController = new \Controllers\ProductController($productId);
        $productController->get();
    }
}

$router = new Router($path);
$router->processRequest($path);
ob_end_flush();
?>

<script src="<?php echo "/paginaweb/"; ?>js/app.js"></script>

<script>
    $(document).foundation();
    path = window.location.pathname;

    //Search all the elements with the attribute href having the value of path given
    var matches = document.querySelector("[href='" + path + "']");
    $(matches).parents("[role='menuitem']:last").addClass("active");
</script>
</body>
</html>