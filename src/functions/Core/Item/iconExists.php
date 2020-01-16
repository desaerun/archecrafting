<?php

namespace Core\Item;

function iconExists($db, $icon_id = false, $icon_path = "", $icon_filename = false)
{
    $stmt = "SELECT 1 FROM `icons` WHERE `id`=? OR (`path`=? AND `filename`=?) LIMIT 1";
    $query = $db->prepare($stmt);
    $query->execute([$icon_id, $icon_path, $icon_filename]);

    if ($query->fetchColumn()) {
        return true;
    }
    return false;
}