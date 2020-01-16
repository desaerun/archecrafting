<?php

namespace Core\Item;

function itemIcon($db, $item_id)
{
    $item_id_embed = $item_id;
    include("item_icon.php");
    return true;
}
