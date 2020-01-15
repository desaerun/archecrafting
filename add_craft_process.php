<?php
header('Content-type: application/json');
require_once("includes/db_connect.php");

////////production -- delete this on live/////////////
if(empty($_POST)) {
	$_POST = $_GET;
}
/////////////////////end debug/////////////////////////

///////debug--this should only use the user's ID instead of allowing anything through/////////
if(!isset($_POST['user_id'])) {
	$_POST['user_id'] = "1";
}
/////////////// end debug //////////////////

//////////////debug--uncomment this in live///////////
/*
if (!isset($_POST['mode'])) {
	exit();
}
*/
//////////////////end debug///////////////////////////

switch ($_POST['mode']) {
	case "get_reagents":
		$stmt = "SELECT `i`.`id` as `child_item_id`,`cl`.`amount`,`i`.`name`    FROM `craft_links` `cl` LEFT JOIN `items` `i` ON `cl`.`child_item_id`=`i`.`id` WHERE `craft_id`=?";

		$reagentsq = $db->prepare($stmt);
		$reagentsq->execute(array($_POST['craft_id']));
	
		$reagents = $reagentsq->fetchAll(PDO::FETCH_ASSOC);

		exit(json_encode($reagents));
	break;
	case "add_craft_link":
		$values = Array(
			"craft_id" => $_POST['craft_id'],
			"child_item_id" => $_POST['child_item_id'],
			"amount" => $_POST['amount']
		);

		$stmt = "SELECT `name` FROM `items` WHERE `id`=?";
		$query = $db->prepare($stmt);
		$query->execute(Array($_POST['child_item_id']));

		$item_name = $query->fetch(PDO::FETCH_COLUMN);


		$stmt = "INSERT INTO `craft_links` (`craft_id`,`child_item_id`,`amount`) VALUES(:craft_id,:child_item_id,:amount)";
		$db->prepare($stmt)->execute($values);
		exit(json_encode(Array(
			"success" => 1,
			"message" => "Inserted new row successfully.",
			"new_row_id" => $db->lastInsertId(),
			"new_item_amount" => $_POST['amount'],
			"new_item_name" => $item_name
		)));
	break;
	case "update_craft_link":
		$values = Array(
			"craft_link_id" => $_POST['craft_link_id'],
			"child_item_id" => $_POST['child_item_id'],
			"amount" => $_POST['amount']
		);
		$stmt = "UPDATE `craft_links` SET `child_item_id`=:child_item_id,`amount`=:amount WHERE `id`=:craft_link_id";
		$db->prepare($stmt)->execute($values);
		exit(json_encode(Array(
			"success" => 1,
			"message" => "Updated row {$_POST['craft_link_id']} successfully."
		)));
	break;
	case "delete_craft_link":
		$values = Array(
			"craft_link_id" => $_POST['craft_link_id']
		);
		$stmt = "DELETE FROM `craft_links` WHERE `id`=:craft_link_id";
		$db->prepare($stmt)->execute($values);
		exit(json_encode(Array(
			"success" => 1,
			"message" => "Deleted row {$_POST['craft_link_id']} successfully."
		)));
	break;
	default:
		$values = Array(
			'error' => 1,
			'message' => "No valid mode specified."
		);
		break;
	break;
}
exit(json_encode($values));
?>
