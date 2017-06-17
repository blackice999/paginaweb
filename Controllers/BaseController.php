<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 03.06.2017
 * Time: 17:46
 */

namespace Controllers;


use Models\ProductModel;
use Models\ProductResourcesModel;
use Models\ProductSpecDescriptionModel;
use Models\ProductSpecModel;
use Utils\HTMLGenerator;
use Utils\StringUtils;

abstract class BaseController implements Controller
{

    public function get()
    {
        // TODO: Implement get() method.
    }

    public function post()
    {
        // TODO: Implement post() method.
    }

    public function displayAllProductsByCategory(string $mainCategoryPath, array $categories)
    {
        if (isset($_GET['path']) && $_GET['path'] !== $mainCategoryPath) {
            $this->{$_GET['path']}($_GET['path']);
        } else {
            foreach ($categories as $category) {
                $titleFromLink = StringUtils::removeUnderscore($category);
                echo HTMLGenerator::tag("h3", ucfirst($titleFromLink));
                echo HTMLGenerator::link($category, "Check all " . $titleFromLink);
            }
        }
    }

    public function displayProducts(int $categoryId, string $categoryName)
    {
        if (empty(ProductModel::loadByCategoryId($categoryId))) {
            echo HTMLGenerator::tag("h2", "No " . StringUtils::removeUnderscore($categoryName) . " found");
        } else {

            foreach (ProductModel::loadByCategoryId($categoryId) as $product) {
                echo "<div class=\"column\" style='border: 1px solid black; padding: 10px; height: 400px;'>";

                //Display only the first image when viewing all products

                $productResourcesModel = ProductResourcesModel::loadByProductId($product->id);

                if (!empty($productResourcesModel)) {
                    echo HTMLGenerator::image($productResourcesModel[0]->location, "",
                        "float-center",
                        "margin-bottom:30px; width:40%; height:40%");
                } else {
                    echo HTMLGenerator::image("https://placehold.it/150x150", "",
                        "float-center",
                        "margin-bottom:30px; width:40%; height:40%");
                }
                echo HTMLGenerator::link("product/" . $product->id, $product->name,
                    "float-center text-center", "margin-bottom:30px");

                echo " <ul>";
                $productSpecModel = $product->getProductSpecModel();

                foreach ($productSpecModel as $productSpec) {
                    echo "<li>" . $productSpec->name . ": ";

                    $productSpecDescriptionName = [];
                    foreach ($productSpec->getProductSpecDescriptionModel() as $productSpecDescriptionModel) {
                        $productSpecDescriptionName[] = $productSpecDescriptionModel->name;
                    }
                    echo implode(", ", $productSpecDescriptionName);
                    echo "</li>";

                }
                echo "</ul>";
                $productSpecModelLength = sizeof($productSpecModel);

                if ($productSpecModelLength < 3) {
                    for ($i = 0; $i < (3 - $productSpecModelLength); $i++) {
                        echo "<br/>";
                    }
                }

                $this->productActionsForm($product);
                echo "</div>";
            }

            echo "</div>";
        }
    }

    public function insertNewProductForm($name)
    {

        if (isset($_SESSION['userId'])) {
            HTMLGenerator::row(5, 5, 5);
            echo HTMLGenerator::tag("h2", "Add a new " . StringUtils::removeUnderscore(StringUtils::toSingular($name)));
            HTMLGenerator::form("post", $_GET['path'], [
                ["label" => "Name", "type" => "text", "name" => "name", "value" => ""],
                ["label" => "Description", "type" => "text", "name" => "description", "value" => ""],
                ["label" => "price", "type" => "text", "name" => "price", "value" => ""],
                ["label" => "Specification name", "type" => "text", "name" => "spec_name", "value" => ""],
                ["label" => "Specification description", "type" => "text", "name" => "spec_description", "value" => ""],
                ["label" => "Stock", "type" => "number", "name" => "stock", "value" => ""],
                ["label" => "", "type" => "submit", "name" => "submit", "value" => "Insert"]
            ]);
        }
    }

    public function insertNewProduct(int $categoryId)
    {
        $name = StringUtils::sanitizeString($_POST['name']);
        $description = StringUtils::sanitizeString($_POST['description']);
        $price = StringUtils::sanitizeString($_POST['price']);
        $specName = StringUtils::sanitizeString($_POST['spec_name']);
        $specDescription = StringUtils::sanitizeString($_POST['spec_description']);
        $stock = StringUtils::sanitizeString($_POST['stock']);

        $result = ProductModel::create($categoryId, $name, $description, $price, $stock);
        echo HTMLGenerator::tag("p", "Inserted new " .
            StringUtils::removeUnderscore(StringUtils::toSingular($_GET['path'])) .
            " with the id " . $result->id);
        $specId = ProductSpecModel::create($result->id, $specName);
        ProductSpecDescriptionModel::create($specId->id, $specDescription);
    }

    /**
     * @param $product
     */
    public function productActionsForm($product)
    {
        echo HTMLGenerator::tag("h3", "$" . $product->price, "", "float:left;");


        //Delete a product if the user is logged in
        if (isset($_SESSION['userId'])) {
            HTMLGenerator::form("post", $_GET['path'], [
                ['label' => "", "type" => "hidden", "name" => "product_id", "value" => $product->id],
                ['label' => "", "type" => "submit", "name" => "delete_product", "value" => "Delete"]
            ], "float-left");
        }


        //Purchase a given product
        HTMLGenerator::form("get", "cart", [
            ['label' => "", "type" => "hidden", "name" => "product_id", "value" => $product->id],
            ['label' => "", "type" => "submit", "name" => "purchase", "value" => "Purchase"]
        ], "float-right");
    }

    public function deleteProduct(int $productId)
    {

        //Delete images
        ProductResourcesModel::delete($productId);

        $productSpecIds = [];
        foreach (ProductSpecModel::loadByProductId($productId) as $productSpec) {
            $productSpecIds[] = $productSpec->id;
        }

        //The spec id's are not identical, so delete each specification description based on product id
        foreach ($productSpecIds as $productSpecId) {
            ProductSpecDescriptionModel::delete($productSpecId);
        }

        //Delete specifications
        ProductSpecModel::delete($productId);

        //Delete the given product
        ProductModel::delete($productId);

        echo HTMLGenerator::tag("p", "Successfully deleted the product, going back");
        header("Refresh:1; URL=" . $_GET['path']);

    }
}