<?php
require_once("../../includes/db_connect.php");

require_once("Craft.php");
require_once("CraftsList.php");
require_once("Item.php");
require_once("Reagent.php");

$test_item = new Item($db, 16);
echo "<pre>";
echo "ITEM: " . print_r($test_item, TRUE) . "\n";
echo "ITEM->getCraftsList: " . print_r($test_item->getCraftsList(), TRUE) . "\n";
echo "</pre>";
