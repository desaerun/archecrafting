<?php
require_once("includes/db_connect.php");

if (!isset($_GET['id'])){
	exit("no id provided");
}
if (!isset($_GET['amount'])) {
	$_GET['amount'] = 1;
}

function ingredientsTable($id,$multiplier=1,$nesting=0) {
	global $db;	
	$nesting_str = str_repeat("\t",$nesting);
	
	$stmt = "SELECT `items`.`name` AS `parent_name`,`craft_links`.`amount`,`items`.`id` FROM `craft_links` LEFT JOIN `items` ON `items`.`id`=`craft_links`.`child_item_id` WHERE `craft_id`=?";
//	$stmt = "SELECT `items`.`id`,`items`.`name`,`items_rel`.`amount` FROM `items_rel` LEFT JOIN `items` ON `items`.`id`=`items_rel`.`child_id` WHERE `parent_id`='" . $id . "'";
	$ingredientsq = $db->prepare($stmt);
	$ingredientsq->execute([$id]);
	
	$ingredients = $ingredientsq->fetchAll();

	if ($ingredients) {
		echo "{$nesting_str}<div class=\"recipe_container\">\n";
	}
	
	foreach ($ingredients as $ingredient) {
		$amount = $ingredient['amount'] * $multiplier;
		echo <<<EOD
{$nesting_str}	<div class="item_container">
{$nesting_str}		<div class="add_button">&plus;</div>
{$nesting_str}		<div class="item_label">
{$nesting_str}			<div class="item_amount">{$amount}x</div>
{$nesting_str}			<div class="item_icon">
{$nesting_str}				<div class="item_box">
{$nesting_str}					<img class="item_image" />
{$nesting_str}				</div>
{$nesting_str}				<div class="item_box grade">
{$nesting_str}					<img class="item_image grade" alt="{$ingredient['parent_name']}" />
{$nesting_str}				</div>
{$nesting_str}			</div>
{$nesting_str}		</div>
EOD;
		ingredientsTable($ingredient['id'],$amount,$nesting+2);
		echo "{$nesting_str}	</div>\n";

	}
	if ($ingredients) {
		echo "{$nesting_str}</div>\n";
	}
}

function ingredientsArray($db,$item_id,$multiplier = 0)
{
    $ingrs = [];

    $stmt = "SELECT `id`,`name` FROM `items` WHERE `id`=? LIMIT 1";
    $query = $db->prepare($stmt);
    $query->execute([ $item_id ]);

    $parent_item = $query->fetchAll();

    echo "Parent item: " . print_r($parent_item,true);

    $ingrs['name'] = $parent_item['name'];
    $ingrs['amount'] = 1;

    $stmt = "SELECT `craft_links`.*,`crafts`.*,`craft_links`.`id`,`craft_links`.`child_item_id` AS `item_id`,`craft_links`.`amount`,`items`.`name`,`items`.`vendor_price`,`items`.`auction_price` FROM `craft_links` LEFT JOIN `crafts` ON `craft_links`.`craft_id`=`crafts`.`id` LEFT JOIN `items` ON `craft_links`.`child_item_id`=`items`.`id` WHERE `craft_links`.`craft_id`=?";
    $query = $db->prepare($stmt);
    $query->execute([ $item_id ]);

    $ingrs_db = $query->fetchAll();

    if ($ingrs_db) {
        foreach ($ingrs_db as $ingr_db) {
            print_r($ingr_db);
  //          $ingrs['crafts'][] = ingredientsArray($db, $ingr_db['id']);
       }
    }
    return $ingrs;
}

?>
<link rel="stylesheet" type="text/css" href="css/main.css" />
<?php
//ingredientsTable($_GET['id'],$_GET['amount']);
?>
<pre>
<?php
print_r(ingredientsArray($db,$_GET['id'],$_GET['amount']))
?>
</pre>
