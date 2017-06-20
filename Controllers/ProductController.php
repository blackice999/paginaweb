<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 03.06.2017
 * Time: 18:05
 */

namespace Controllers;


use Models\CategoriesModel;
use Models\ProductModel;
use Models\ProductResourcesModel;
use Models\ProductSpecDescriptionModel;
use Models\ProductSpecModel;
use Utils\HTMLGenerator;
use Utils\StringUtils;

class ProductController implements Controller
{

    private $productId;
    private $product;
    const IMAGES_ROOT_DIRECTORY = "uploads/";

    /**
     * ProductController constructor.
     * @param int $productId
     */
    public function __construct(int $productId)
    {
        $this->productId = $productId;
        $this->product = ProductModel::loadById($this->productId);
    }

    public function get()
    {

        HTMLGenerator::row(12, 12, 12);
        echo HTMLGenerator::tag("h2", $this->product->name);
        HTMLGenerator::closeRow();
        HtmlGenerator::row(5, 5, 5);

        echo "<div class=\"orbit\" role=\"region\" aria-label=\"Favorite Space Pictures\" data-orbit>
         <ul class=\"orbit-container\">
        <button class=\"orbit-previous\"><span class=\"show-for-sr\">Previous Slide</span>&#9664;&#xFE0E;</button>
        <button class=\"orbit-next\"><span class=\"show-for-sr\">Next Slide</span>&#9654;&#xFE0E;</button>";

        $productResourcesModel = ProductResourcesModel::loadByProductId($this->productId);
        foreach ($productResourcesModel as $productResources) {

            //If the image is stored on the server, display from there
            if (StringUtils::contains($productResources->location, self::IMAGES_ROOT_DIRECTORY)) {
                echo HTMLGenerator::tag("li",
                    HTMLGenerator::image("../" . $productResources->location, "", "orbit-image"),
                    "orbit-slide");
            } else {
                echo HTMLGenerator::tag("li",
                    HTMLGenerator::image($productResources->location, "", "orbit-image"),
                    "orbit-slide");
            }
        }
        echo "</ul>
        <nav class=\"orbit-bullets\">";

        $productResourcesLength = sizeof($productResourcesModel);

        //First button needs to be active, so set it here
        echo "<button class=\"is-active\" data-slide=\"1\">";
        echo HTMLGenerator::tag("span", "First slide details", "show-for-sr");
        echo HTMLGenerator::tag("span", "Current slide", "show-for-sr");
        echo "</button>";
        for ($i = 2; $i <= $productResourcesLength; $i++) {
            echo "<button data-slide=\"$i\">";
            echo HTMLGenerator::tag("span", "First slide details", "show-for-sr");
            echo HTMLGenerator::tag("span", "Current slide", "show-for-sr");
            echo "</button>";
        }
        echo "</nav>
</div>";

        echo "<div class='large-5  medium-5 small-5 columns>";
        echo "<div  style='border:1px solid black; width: 200px; height: 100px;'>";
        HtmlGenerator::row(1, 1, 1);
        echo "</div>";
        echo "</div>";
        HTMLGenerator::closeRow();
        echo "<div class='float-right'>";
        echo HTMLGenerator::tag("div", "$" . $this->product->price);
        echo "<br />";
        HTMLGenerator::form("get", "../cart", [
            ['label' => "", "type" => "hidden", "name" => "product_id", "value" => $this->product->id],
            ['label' => "", "type" => "submit", "name" => "purchase", "value" => "Purchase"]
        ], "float-right");

        echo "</div>";

        //Content for the middle of the page
        if ($this->product->stock > 50) {
            echo HTMLGenerator::tag("b", "Stock plenty", "", "color:green;");
        } else if ($this->product->stock < 50 && $this->product->stock > 0) {
            echo HTMLGenerator::tag("b", "Stock shortage", "", "color: orange");
        } else {
            echo HTMLGenerator::tag("b", "Out of stock", "", "color:red");
        }

        if ($this->product->price > 100) {
            echo HTMLGenerator::tag("p", "Free shipping");
        }

        echo "</div>";

        HTMLGenerator::row(11, 11, 11);
        echo "<div class='callout'>";
        echo $this->product->description;
        echo "</div>";
        HTMLGenerator::closeRow();
        HTMLGenerator::row(5, 5, 5);
        echo HTMLGenerator::tag("h2", "Technical specifications");

        echo "<table>";
        foreach ($this->product->getProductSpecModel() as $productSpecModel) {
            echo "<tr>";
            echo "<td> " . $productSpecModel->name . "</td>";
            echo "<td>";
            foreach ($productSpecModel->getProductSpecDescriptionModel() as $productSpecDescriptionModel) {
                echo $productSpecDescriptionModel->name . "<br />";
            }
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";

        HTMLGenerator::closeRow();
        $this->addNewSpecificationForm();
        $this->addImageForm();
        $this->modifyProductForm();
    }

    public function modifyProductForm()
    {
        if (isset($_SESSION['userId']) && ($_SESSION['userId'] == 1 || $_SESSION['userId']) == 3) {
            HTMLGenerator::row(5, 5, 5);
            echo HTMLGenerator::tag("h2", "Modify this product");
            HTMLGenerator::form("post", "../" . $_GET['path'], [
                ["label" => "Name", "type" => "text", "name" => "name", "value" => ""],
                ["label" => "Description", "type" => "text", "name" => "description", "value" => ""],
                ["label" => "price", "type" => "text", "name" => "price", "value" => ""],
                ["label" => "Stock", "type" => "number", "name" => "stock", "value" => ""],
                ["label" => "", "type" => "submit", "name" => "modify_product", "value" => "Modify"]
            ]);

            HTMLGenerator::closeRow();
        }
    }

    public function addNewSpecificationForm()
    {
        if (isset($_SESSION['userId']) && ($_SESSION['userId'] == 1 || $_SESSION['userId']) == 3) {
            HTMLGenerator::row(5, 5, 5);
            echo HTMLGenerator::tag("h2", "Add new specification, separate description by comma");
            HTMLGenerator::form("post", "../" . $_GET['path'], [
                ["label" => "Name", "type" => "text", "name" => "name", "value" => ""],
                ["label" => "Description", "type" => "text", "name" => "description", "value" => ""],
                ["label" => "", "type" => "submit", "name" => "new_spec", "value" => "Insert"]
            ]);

            HTMLGenerator::closeRow();
        }
    }

    public function addImageForm()
    {
        if (isset($_SESSION['userId']) && ($_SESSION['userId'] == 1 || $_SESSION['userId']) == 3) {
            HTMLGenerator::row(5, 5, 5);
            echo HTMLGenerator::tag("h2", "Upload image");
            HTMLGenerator::form("post", "../" . $_GET['path'], [
                ["label" => "Select image", "type" => "file", "name" => "product_image", "value" => ""],
                ["label" => "", "type" => "submit", "name" => "add_image", "value" => "Add"]
            ], "", "", "multipart/form-data");

            HTMLGenerator::closeRow();
        }
    }

    public function post()
    {
        if (isset($_POST['new_spec'])) {
            $name = StringUtils::sanitizeString($_POST['name']);
            $description = StringUtils::sanitizeString($_POST['description']);
            $descriptionPieces = explode(", ", $description);
            $spec = ProductSpecModel::create($this->productId, $name);

            foreach ($descriptionPieces as $descriptionPiece) {
                ProductSpecDescriptionModel::create($spec->id, $descriptionPiece);
            }
        }

        if (isset($_POST['add_image'])) {
            $category = CategoriesModel::loadById($this->product->category_id);
            $categoryName = str_replace(" ", "_", strtolower($category->name));
            $targetDirectory = self::IMAGES_ROOT_DIRECTORY . $categoryName . "/";
            $targetFile = $targetDirectory . basename($_FILES['product_image']['name']);
            $fileType = pathinfo($targetFile, PATHINFO_EXTENSION);
            $uploadOk = 1;
            $check = getimagesize($_FILES['product_image']['tmp_name']);

            if (!$check) {
                echo HTMLGenerator::tag("p", "File is not an image");
                $uploadOk = 0;
            }

            if (!file_exists($targetDirectory)) {
                mkdir($targetDirectory);
            }

            if (file_exists($targetFile)) {
                echo HTMLGenerator::tag("p", "Sorry, file already exists");
                $uploadOk = 0;
            }

            //If the file is bigger than 5MB, don't upload it
            if ($_FILES['product_image']['size'] > 5000000) {
                echo HTMLGenerator::tag("p", "File is too large");
                $uploadOk = 0;
            }

            if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif") {
                echo HTMLGenerator::tag("p", "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                echo HTMLGenerator::tag("p", "Sorry, your file was not uploaded");
            } else {
                if (move_uploaded_file($_FILES['product_image']['tmp_name'], $targetFile)) {
                    echo HTMLGenerator::tag("p",
                        "The file " . basename($_FILES['product_image']['name']) . " has been uploaded, going back");
                    header("Refresh:1; URL=../" . $_GET['path']);
                    ProductResourcesModel::create($this->productId, $targetFile, $check['mime']);
                } else {
                    echo HTMLGenerator::tag("p", "Sorry, there was an error uploading your file");
                }
            }
        }

        if (isset($_POST['modify_product'])) {
            $categoryId = CategoriesModel::loadById($this->product->category_id)->id;

            $name = StringUtils::sanitizeString($_POST['name']);
            $description = StringUtils::sanitizeString($_POST['description']);
            $price = StringUtils::sanitizeString($_POST['price']);
            $stock = StringUtils::sanitizeString($_POST['stock']);

            ProductModel::update($this->productId, $categoryId, $name, $description, $price, $stock);


        }
    }
}