<?php

require_once("../includes/db_connect.php");
require_once("../includes/functions.inc.php");
require_once("../includes/config.inc.php");

$item_id = (!isset($_GET['item_id'])) ? DEFAULT_ITEM_ID : $_GET['item_id'];

$stmt = "SELECT `items`.*,`icons`.`full_path` AS `icon_full_path` FROM `items` LEFT JOIN `icons` ON `items`.`icon_id`=`icons`.`id` WHERE `items`.`id`=? LIMIT 1";

$query = $db->prepare($stmt);
$query->execute([$item_id]);

$item = $query->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    die("No such item.");
}
if (!iconExists($db, $item['icon_id'])) {
    $item_icon_image = ICON_NOT_FOUND_ICON;
    $item_grade_image = "images/item_grades/item_grade_0.png";
} else {
    $item_icon_image = $item['icon_full_path'];
    $item_grade_image = "images/item_grades/item_grade_{$item['grade']}.png";
}
?>
<div class="item_tooltip_title_box_wrapper">
    <div>
        <div class="item_icon">
            <div class="item_image_wrapper">
                <img src="<?= $item_icon_image ?>"/>
            </div>
            <div class="item_grade_wrapper">
                <img src="<?= $item_grade_image ?>"/>
            </div>
        </div>
    </div>
    <div class="item_tooltip_title_box">
        <p><?= $item['item_type'] ?></p>
        <?php
        //item grade
        if (!$item['hide_grade']) {
            ?>
            <p class="grade_color_<?= $item['grade'] ?>"><?= $grades_text[$item['grade']] ?></p>
            <?php
        }
        $temper_text = ($item['temper']) ? "+" . $item['temper'] . " " : "";
        ?>
        <p class="item_tooltip_item_name grade_color_<?= $item['grade'] ?>"><?= $temper_text ?><?= $item['name'] ?></p>
    </div>
</div>
<?php
//item equipment points
if ($item['equipment_points']) {
    ?>
    <div class="item_tooltip_separator"></div>
    <div>
        <p>Equipment Points</p>
        <p class="item_tooltip_equipment_points_text"><?= $item['equipment_points'] ?></p>
    </div>
    <?php
}
//item required level and tradeability
if ($item['req_level'] || $item['tradeable'] != 1) {
    ?>
    <div class="item_tooltip_separator"></div>
    <div>
        <?php
        if ($item['req_level']) {
            ?>
            <p>Req. Level:<?= $item['req_level'] ?>~<span class="item_tooltip_req_level_text ancestral">55</span></p>
            <?php
        }
        if ($item['tradeable'] != 1) {
            $tradeable_text = Array(
                "Untradeable",
                "",
                "Binds on Pickup",
                "Binds on Equip"
            );
            ?>
            <p><?= $tradeable_text[$item['tradeable']] ?></p>
            <?php
        }
        ?>
    </div>
    <?php
}
///////////////////////////////////////
///////////////////////////////////////
/////          ITEM XP             ////
///////////////////////////////////////
if ($item['total_xp']) {
    ?>
    <div class="item_tooltip_separator"></div>
    <div>
        <p class="item_tooltip_xp_text">XP 0/<?= $item['total_xp'] ?> (0%)</p>
    </div>
    <?php
}
///////////////////////////////////////
///////////////////////////////////////
/////WEAPON STATS, TYPE, DURABILITY////
///////////////////////////////////////
///////////////////////////////////////
if ($item['total_durability']) {
    $equipment_slot_text = Array(
        "Head",            //slot 0
        "Chest",            //slot 1
        "Waist",            //slot 2
        "Wrists",            //slot 3
        "Hands",            //slot 4
        "Cloak",            //slot 5
        "Legs",                //slot 6
        "Feet",                //slot 7
        "Neck",                //slot 8
        "Ear",                //slot 9
        "Ring",                //slot 10
        "2H Weapon",        //slot 11
        "1H Weapon",        //slot 12
        "Right Hand",        //slot 13
        "Left Hand",        //slot 14
        "Ranged Weapon",    //slot 15
        "Instrument",        //slot 16
        "Glider",            //slot 17
        "Underwear",        //slot 18
        "Costume",            //slot 19
        "Trade Pack"        //slot 20
    );
    ?>
    <div class="item_tooltip_separator"></div>
    <div>
        <p><?= $equipment_slot_text[$item['equipment_slot']] ?></p>
        <?php
        //attack speed
        if ($item['weapon_attack_speed']) {
            ?>
            <p><span class="item_tooltip_label_text">Attack Speed</span> <?= $item['weapon_attack_speed'] ?></p>
            <?php
        }
        //durability
        ?>
        <p><span class="item_tooltip_label_text">Dura</span> <?= $item['total_durability'] ?>
            /<?= $item['total_durability'] ?></p>
        <?php
        if ($item['weapon_type']) {
            ?>
            <p><span class="item_tooltip_label_text">Weapon Type</span> <?= $item['weapon_type'] ?></p>
            <?php
        }
        ?>
    </div>
    <?php
}
///////////////////////////////////////
///////////////////////////////////////
/////DPS,PHYS/MAGIC DEF, LUNAFROSTS////
///////////////////////////////////////
if ($item['weapon_dps'] || $item['armor_phys_def'] || $item['armor_magic_def'] || $item['lunafrost_id']) {
    ?>
    <div class="item_tooltip_separator"></div>
    <div>
        <?php
        //weapon dps
        if ($item['weapon_dps']) {
            ?>
            <p><span class="item_tooltip_label_text">DPS</span><?= $item['weapon_dps'] ?></p>
            <?php
        }
        //physical defense
        if ($item['armor_phys_def']) {
            ?>
            <p><span class="item_tooltip_label_text">Physical Defense</span> <?= $item['armor_phys_def'] ?></p>
            <?php
        }
        //magic defense
        if ($item['armor_magic_def']) {
            ?>
            <p><span class="item_tooltip_label_text">Magic Defense</span> <?= $item['armor_magic_def'] ?></p>
            <?php
        }
        //lunafrost
        if ($item['lunafrost_id']) {
            $stmt = "SELECT `lf`.`effect_text`,`icons`.`full_path` AS `icon_full_path` FROM `item_lunafrosts` AS `lf` LEFT JOIN `icons` ON `lf`.`icon_id`=`icons`.`id` WHERE `lf`.`id`=? LIMIT 1";
            $query = $db->prepare($stmt);
            $query->execute([$item['lunafrost_id']]);

            $lunafrost = $query->fetch(PDO::FETCH_ASSOC);
            ?>
            <p class="item_lunafrost_text">
                <img src="<?= $lunafrost['icon_full_path'] ?>"/><?= $lunafrost['effect_text'] ?>
            </p>
            <?php
        }
        ?>
    </div>
    <?php
}
///////////////////////////////////////
///////////////////////////////////////
/////        LUNAGEMS              ////
///////////////////////////////////////
if ($item['gem_slots']) {
    ?>
    <div class="item_tooltip_separator"></div>
    <div class="item_tooltip_lunagems_wrapper">
        <?php
        //each gem slot
        for ($i = 1; $i <= $item['gem_slots']; $i++) {
            $current_lunagem_id = $item['lunagem_' . $i . '_id'];
            //if no gem is specified for the current slot
            if (!$current_lunagem_id) {
                //empty lunagem icon / text
                $lunagem['icon_full_path'] = "images/icon/emotion/icon_emotion_010.png";
                $lunagem['effect_text'] = "";
            } else {
                $stmt = "SELECT `lg`.`effect_text`,`icons`.`full_path` AS `icon_full_path` FROM `item_lunagems` AS `lg` LEFT JOIN `icons` ON `lg`.`icon_id`=`icons`.`id` WHERE `lg`.`id`=? LIMIT 1";
                $query = $db->prepare($stmt);
                $query->execute([$current_lunagem_id]);

                $lunagem = $query->fetch(PDO::FETCH_ASSOC);
            }
            ?>
            <p>
                <img src="<?= $lunagem['icon_full_path'] ?>"/> <?= $lunagem['effect_text'] ?>
            </p>
            <?php
        }
        ?>
    </div>
    <?php
}
///////////////////////////////////////
///////////////////////////////////////
/////        SYNTHESIS             ////
///////////////////////////////////////
if ($item['synth_avail'] || $item['tempering_avail']) {
    ?>
    <div class="item_tooltip_separator"></div>
    <div>
        <?php
        if ($item['synth_avail']) {
            if ($item['grade'] == $item['max_grade']) {
                ?>
                <p class="item_tooltip_synth_avail_text">Max Grade</p>
                <?php
            } else {
                ?>
                <p class="item_tooltip_synth_avail_text">Synthesis
                    Available<br/>(~<?= $grades_text[$item['max_grade']] ?>)</p>
                <?php
            }
        }
        if ($item['tempering_avail']) {
            ?>
            <p>Tempering Available</p>
            <?php
        }
        ?>
    </div>
    <?php
}
///////////////////////////////////////
///////////////////////////////////////
/////  ITEM DESCRIPTION, SYNTH/    ////
/////  EQUIP/USE EFFECTS           ////
///////////////////////////////////////
?>
<div class="item_tooltip_separator"></div>
<div class="item_tooltip_item_desc_wrapper">
    <p><?= nl2br($item['description']) ?></p>
    <?php
    if ($item['equip_effect_1_id']) {
        ?>
        <?php
        //each equip effect
        $stmt = "SELECT `effect_text` FROM `item_equip_effects` WHERE `id`=? LIMIT 1";
        $query = $db->prepare($stmt);
        $query->execute([$item['equip_effect_1_id']]);

        $equip_effect_text = $query->fetchColumn();
        ?>
        <br/>
        <p class="item_tooltip_equip_effects_text">
            <span class="item_tooltip_equip_effects_text">Equip Effect</span><br/><?= $equip_effect_text ?> <span
                    class="item_tooltip_equip_effect_amount"><?= $item['equip_effect_1_amount'] ?></span>
        </p>
        <?php
    }
    if ($item['synth_effect_1_id']) {
        ?>
        <br/>
        <?php
        //each synth effect
        $stmt = "SELECT `effect_text` FROM `item_synth_effects` WHERE `id`=? LIMIT 1";
        $query = $db->prepare($stmt);
        $query->execute([$item['synth_effect_1_id']]);

        $synth_effect_text = $query->fetchColumn();
        ?>
        <p class="item_tooltip_synth_effects_text"><span
                    class="item_tooltip_synth_effects_label">Synthesis Effect</span><br/><?= $synth_effect_text ?> <?= $item['synth_effect_1_amount'] ?>
        </p>
        <?php
    }
    if ($item['use_effect_id']) {
        ?>
        <?php
        //each use effect
        $stmt = "SELECT `effect_text` FROM `item_use_effects` WHERE `id`=? LIMIT 1";
        $query = $db->prepare($stmt);
        $query->execute([$item['use_effect_id']]);

        $use_effect_text = $query->fetchColumn();
        ?>
        <p class="item_tooltip_use_effects_text"><span
                    class="item_tooltip_use_effects_label">Use:</span><br/><?= nl2br($use_effect_text) ?></p>
        <?php
    }

    ////////////////////////////////////
    ///MOVE THIS TO ANOTHER FILE      //
    ////////////////////////////////////
    function currencyHtmlFormat($amount)
    {
        $parts = explode(".", $amount);

        $gold = $parts[0];
        list($silver, $copper) = str_split($parts[1], 2);

        $gold = (int)$gold;
        $silver = (int)$silver;
        $copper = (int)$copper;

        $output = "";
        if ($gold) {
            $output .= "<span class=\"currency gold\">{$gold}</span>\n";
        }
        if ($silver || $gold) {
            $output .= "<span class=\"currency silver\">{$silver}</span>\n";
        }
        $output .= "<span class=\"currency copper\">{$copper}</span>\n";

        return $output;
    }

    ?>
</div>
<div class="item_tooltip_separator"></div>
<div class="item_tooltip_prices">
    <div>
        <p>Shop Price</p>
    </div>
    <div>
        <p class="currency_wrapper"><?= currencyHtmlFormat($item['vendor_price']) ?></p>
    </div>
</div>
