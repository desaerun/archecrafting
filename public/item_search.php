<?php
require_once("includes/db_connect.php");
?>
<head>
	<title>Archeage Crafting Calculator</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/main.css" />
</head>
<body>
<?php
$stmt =  "SELECT * FROM `items` as `i` LEFT JOIN (SELECT `parent_id`,COUNT(1) as `reagent_count` FROM `items_rel` GROUP BY `parent_id`) `t` ON `t`.`parent_id`=`i`.`id` WHERE `name` LIKE '%" . $_GET['query'] . "%'";

$itemsq = $db->prepare($stmt);
$itemsq->execute();

$items = $itemsq->fetchAll();

foreach($items as $item) {
/*
	echo <<<EOD
	<div class="item_container">
		<div class="add_button">&plus;</div>
		<div class="item_label">
			<div class="item_amount"></div>
			<div class="item_icon">
				<div class="item_box">
					<img class="item_image" />
				</div>
				<div class="item_box grade">
					<img class="item_image grade" alt="{$item['name']}" />
				</div>
			</div>
		</div>
		
EOD;
*/
	echo <<<EOD
<div class="container">
	<div class="header">
		<h3>{$item['name']}</h3>
	</div>

EOD;
	if ($item['reagent_count']) {
	echo <<<EOD
	<div class="recipe_wrapper">
		<div class="recipe_label">Recipe:</div>
			
EOD;
	ingredientsTable($item['id'],1,4);
	echo <<<EOD
	</div>
EOD;
	}
	echo <<<EOD
</div>

EOD;
}
function ingredientsTable($id,$multiplier=1,$nesting=0) {
	global $db;	
	$nesting_str = str_repeat("\t",$nesting);
	echo "<!--nesting str \"{$nesting_str}\"-->\n";
	$stmt = "SELECT `items`.`name`,`items_rel`.`amount`,`parent_name`,`items`.`id` FROM (SELECT `name` as `parent_name` FROM `items` WHERE `id`='" . $id . "') k, `items_rel` LEFT JOIN `items` ON `items`.`id`=`items_rel`.`child_id` WHERE `parent_id`='" . $id . "'";
//	$stmt = "SELECT `items`.`id`,`items`.`name`,`items_rel`.`amount` FROM `items_rel` LEFT JOIN `items` ON `items`.`id`=`items_rel`.`child_id` WHERE `parent_id`='" . $id . "'";
	$ingredientsq = $db->prepare($stmt);
	$ingredientsq->execute();
	
	$ingredients = $ingredientsq->fetchAll();
	$ingredients_count = $ingredientsq->rowCount();
	if ($ingredients_count > 0) {
//		echo "<!--" . $ingredients[0]['parent_name'] . " # reagents: " . $ingredients_count . "-->\n";
		echo "{$nesting_str}<div class=\"recipe_container\">\n";
	}
	else {
//		echo "<!--item(id#$id) has no reagents (probably a crafting mat)-->\n";
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
{$nesting_str}					<img class="item_image grade" alt="{$ingredient['name']}" />
{$nesting_str}				</div>
{$nesting_str}			</div>
{$nesting_str}		</div>

EOD;
		ingredientsTable($ingredient['id'],$amount,$nesting+2);
		echo "{$nesting_str}	</div>\n";
	}
	if ($ingredients_count > 0) {
		echo "{$nesting_str}</div>\n";
	}
}
?>


</body>