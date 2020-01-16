<?php

//header('Content-type: application/json');
require_once("../includes/db_connect.php");
if (empty($_POST)) {
    $_POST = $_GET;
}

if (!isset($_POST['search_str'])) {
    exit();
}

$search = "%" . $_POST['search_str'] . "%";
$stmt = "SELECT `id`,`full_path` FROM `icons` WHERE `filename` LIKE ? OR `path` LIKE ?";

$imgsq = $db->prepare($stmt);
$imgsq->execute([$search, $search]);

$imgs = $imgsq->fetchAll(PDO::FETCH_ASSOC);
print_r($imgs);
exit(json_encode($imgs));
?>
