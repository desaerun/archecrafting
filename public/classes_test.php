<?php

require_once("../vendor/autoload.php");
require_once("../includes/db_connect.php");
?>
<head>
    <title>Classes Test</title>
    <link rel="stylesheet" href="css/items.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="js/item_tooltip.js" type="text/javascript"></script>
</head>

<body>
<?php
$test_item = new Core\Item\Item($db, 24);
var_dump($test_item);

//$test_item->printIcon();
?>
<?= $test_item->printIcon() ?>
</body>