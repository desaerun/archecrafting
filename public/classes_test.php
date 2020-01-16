<?php

require_once("../vendor/autoload.php");
require_once("../includes/db_connect.php");

$test_item = new Core\Item\Item($db, 24);
var_dump($test_item);

