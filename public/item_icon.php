<?php

require_once("../includes/db_connect.php");
require_once("../includes/config.inc.php");

if (isset($item_id_embed)) {
    $item_id = $item_id_embed;
} else {
    $item_id = (!isset($_GET['item_id'])) ? DEFAULT_ITEM_ID : $_GET['item_id'];
}

$stmt = "SELECT `items`.`id`,`items`.`icon_id`,`items`.`grade`,`icons`.`full_path` AS `icon_full_path` FROM `items` LEFT JOIN `icons` ON `items`.`icon_id`=`icons`.`id` WHERE `items`.`id`=? LIMIT 1";

$query = $db->prepare($stmt);
$query->execute([$item_id]);

$item = $query->fetch(PDO::FETCH_ASSOC);

if ($item) {
    if (!iconExists($db, $item['icon_id'])) {
        $item_icon_image = ICON_NOT_FOUND_ICON;
        $item_grade_image = "images/item_grades/item_grade_0.png";
    } else {
        $item_icon_image = $item['icon_full_path'];
        $item_grade_image = "images/item_grades/item_grade_{$item['grade']}.png";
    }
} else {
    $item_icon_image = ICON_NOT_FOUND_ICON;
    $item_grade_image = "images/item_grades/item_grade_0.png";
}
?>
<!--<a href="item.php?id=<?= $item['id'] ?>" class="item_link">-->


<!--</a>-->