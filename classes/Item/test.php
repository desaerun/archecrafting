<?php
require_once("../../includes/db_connect.php");

require_once("Craft.php");
require_once("CraftsList.php");
require_once("Item.php");
require_once("Reagent.php");

$test_item = new Item($db, 16);
print_r($test_item);
print_r($test_item->getCraftsList());