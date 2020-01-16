<?php

ini_set('display_errors', 1);
$host = "localhost";
$user = "archeagedb";
$pw = "UTHERzsZzF9uvZQP";

$db_name = "archeage";

$db = new \PDO("mysql:host={$host};dbname={$db_name}", $user, $pw);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>