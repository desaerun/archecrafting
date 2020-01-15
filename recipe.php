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

    $i = 0;
    $j = 0;

    $stmt = "SELECT `id`,`name`,`vendor_price`,`auction_price` FROM `items` WHERE `id`=? LIMIT 1";

    $query = $db->prepare($stmt);
    $query->execute([ $item_id ]);
    $parent_item = $query->fetch();

    $ingrs['name'] = $parent_item['name'];
    $ingrs['amount'] = $craft['amount'];

    $stmt = "SELECT `crafts`.`id`,`crafts`.`name` FROM `crafts` LEFT JOIN `items` ON `crafts`.`crafted_item_id`=`items`.`id` WHERE `crafts`.`crafted_item_id`=?";
    $query = $db->prepare($stmt);
    $query->execute([ $item_id ]);

    $crafts = $query->fetchAll();
    foreach ($crafts as $craft) {
        print_r($craft);
        $stmt = "SELECT `craft_links`.*,`items`.`name`,`items`.`id` FROM `craft_links` LEFT JOIN `items` ON `craft_links`.`child_item_id`=`items`.`id` WHERE `craft_links`.`craft_id`=?";

        $query = $db->prepare($stmt);
        $query->execute([ $craft['id'] ]);

        $reagents = $query->fetchAll();

        //debug
        echo "Stmt: {$stmt}  ::  {$craft['id']}<br />";
        print_r($reagents);

        foreach ($reagents as $reagent) {
            print_r($reagent);
            $ingrs[$i]['crafts'][$j]['amount'] = $reagent['amount'];
            $ingrs[$i]['crafts'][$j] = ingredientsArray($db, $reagent['child_item_id']);

            $j++;
        }
        $i++;
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
