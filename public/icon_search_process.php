<?php

//header('Content-type: application/json');
require_once("../includes/db_connect.php");
require_once("../vendor/autoload.php");

if (empty($_POST)) {
    $_POST = $_GET;
}

if (!isset($_POST['search_str'])) {
    exit();
}

$item_icons = new Core\Item\ItemIconList($db, $_POST['search_str']);

exit(json_encode($item_icons->getIcons()));
