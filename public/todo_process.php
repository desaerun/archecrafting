<?php

header('Content-type: application/json');
require_once("../includes/db_connect.php");


////////production -- delete this on live/////////////
if (empty($_POST)) {
    $_POST = $_GET;
}
/////////////////////end debug/////////////////////////

///////debug--this should only use the user's ID instead of allowing anything through/////////
if (!isset($_POST['user_id'])) {
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
    case "new":
        $stmt = "SELECT `sort` FROM `todo` WHERE `user_id`=1 ORDER BY `sort` DESC LIMIT 1";
        $query = $db->prepare($stmt);
        $query->execute();
        if (!$sort = $query->fetchColumn()) {
            $sort = 0;
        }

        $values = Array(
            'text'    => $_POST['new_todo_text'],
            'user_id' => $_POST['user_id'],
            'sort'    => $sort
        );
        $stmt = "INSERT INTO `todo` (`text`,`user_id`,`sort`) VALUES (:text,:user_id,:sort)";
        $db->prepare($stmt)->execute($values);
        exit(
        json_encode(
            Array(
                "success"       => 1,
                "success_msg"   => "Inserted new row successfully.",
                "new_row_id"    => $db->lastInsertId(),
                "new_todo_text" => $_POST['new_todo_text']
            )
        )
        );
        break;
    case "update":
        $values = Array(
            'text' => $_POST['todo_edit_text'],
            'id'   => $_POST['row_id']
        );

        $stmt = "UPDATE `todo` SET `text` = :text WHERE `id`=:id LIMIT 1";
        $db->prepare($stmt)->execute($values);
        exit(
        json_encode(
            Array(
                "success"     => 1,
                "success_msg" => "Updated row successfully.",
                "updated_row" => $_POST['row_id']
            )
        )
        );
        break;
    case "update_sort":
        $i = 0;
        $stmt = "";
        foreach ($_POST['tr'] as $tr) {
            $i++;
            $updated_ids[] = $tr;
            $values = Array(
                'id' => $tr
            );
            $stmt .= "UPDATE `todo` SET `sort`='{$i}' WHERE `id`=:id LIMIT 1;";
            $db->prepare($stmt)->execute($values);
        }
        exit(
        json_encode(
            Array(
                "success"      => 1,
                "success_msg"  => "Updated sort order successfully.",
                "updated_rows" => json_encode($updated_ids)
            )
        )
        );
        break;
    case "delete":
        $values = Array(
            'id' => $_POST['post_id']
        );
        $stmt = "DELETE FROM `todo` WHERE `id`=:id LIMIT 1";
        $db->prepare($stmt)->execute($values);
        break;
    default:
        $values = Array(
            'error'     => 1,
            'error_msg' => "No valid mode specified."
        );
        break;
}
exit(json_encode($values));
