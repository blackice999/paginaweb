<?php
$menu = [
    "computer_parts" => [
        ["motherboards", "video_cards", "processors", "ssds", "hdds", "power_supplies", "chassis"],
    ],
    "peripherials" => [
        ["monitors", "mice", "keyboards", "external_hdds"]
    ],
    "software" => [
        ["operating_systems", "office_apps", "security_solutions"]
    ],
    "telephones" => [
        ["smartphones", "smartwatches", "external_batteries",
            "gsm_accessories" => [
                ["selfie_sticks", "memory_cards", "chargers", "wireless_chargers"]
            ]
        ]
    ],
    "audio_photo" => [
        ["speakers" => [
            ["portable_speakers"]
        ], "microphones",
            "cameras" => [
                ["d_slrs", "compacts", "bridges"]
            ]
        ]
    ],
    "contact" => [[]],
    "account" => [[]],
    "log_in" => [[]],
    "log_out" => [[]],
    "register" => [[]],
    "cart" => [[]]
];

$rootPath = "/paginaweb/";

$test = [
    "informations" => [[]]
];

echo " <div class=\"large-10 medium-10 small-10 small-centered medium-centered large-centered columns\">";
echo \Utils\HTMLGenerator::link($rootPath . "index",
    \Utils\HTMLGenerator::image($rootPath . "img/workstation-147953_960_720.png", "", "float-center", "width: 30%; height: 30%;"));
echo " <ul class=\"dropdown menu\" data-dropdown-menu id=\"example-menu\">";
foreach ($menu as $menuItem => $item) {

    echo "<li>";
    if ($menuItem === "account" || $menuItem === "log_out") {
        if (isset($_SESSION['userId'])) {
            echo \Utils\HTMLGenerator::link($rootPath . $menuItem, ucfirst(\Utils\StringUtils::removeUnderscore($menuItem)));
        }
    } else if ($menuItem === "log_in" || $menuItem === "register") {
        if (!isset($_SESSION['userId'])) {
            echo \Utils\HTMLGenerator::link($rootPath . $menuItem, ucfirst(\Utils\StringUtils::removeUnderscore($menuItem)));
        }
    } else {
        echo \Utils\HTMLGenerator::link($rootPath . $menuItem, ucfirst(\Utils\StringUtils::removeUnderscore($menuItem)));
    }
    foreach ($item as $key => $value) {
        if (!empty($value)) {
            echo "<ul class='menu vertical'>";
            foreach ($value as $subcategory => $subsub) {
                if (is_array($subsub)) {
                    //Displays the key for the subsubcategories, like GSm accssories
                    echo "<li>" . \Utils\HTMLGenerator::link($rootPath . $subcategory, ucfirst(\Utils\StringUtils::removeUnderscore($subcategory)));
                    foreach ($subsub as $subsubsub => $keys) {
                        echo "<ul class='menu vertical'>";
                        foreach ($keys as $item) {
                            echo "<li>" . \Utils\HTMLGenerator::link($rootPath . $item, ucfirst(\Utils\StringUtils::removeUnderscore($item))) . "</li>";
                        }
                        echo "</ul>";
                    }
                    echo "</li>";
                } else {
                    echo "<li> " . \Utils\HTMLGenerator::link($rootPath . $subsub, ucfirst(\Utils\StringUtils::removeUnderscore($subsub))) . "</li>";
                }
            }
            echo "</ul>";
        }
    }
    echo "</li>";
}
echo "</ul>";
echo "</div>";

?>

<script src="<?php echo $rootPath; ?>js/vendor/jquery.js"></script>
<script src="<?php echo $rootPath; ?>js/vendor/foundation.js"></script>
