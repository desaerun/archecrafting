<?php
$sso = Array(
	"item_id" => 2,
	"amount"  => 1,
	"crafts"  => [
		[
			"item_id" => 17,
			"amount"  => 3,
			"crafts"  => [
				[
					"item_id" => 12,
					"amount"  => 3
				]
			]
		],
		[
			"item_id" => 17,
			"amount"  => 3,
			"crafts"  => [
				[
					"item_id" => 12,
					"amount"  => 3,
					"crafts"  => []
				]
			]
		],
		[
			"item_id" => 17,
			"amount"  => 3,
			"crafts"  => [
				"craft_id" => 2,
				"reagents" => [
					[
						"item_id" => 12,
						"amount"  => 3,
						"crafts"  => []
					]
				]
			]
		]
	]
);

$dept = 0;
foreach ($sso as $craft_item) {
	echo "Parent item: {$craft_item['item_id']}<br />";
	echo "Crafting Mats: <br />";
	$depth += 1;
	foreach ($craft_item[$crafts] as $sub_item) {
		$depth_str = "|" . str_repeat("----", $depth)
        echo "{$depth_str}Item ID: {$sub_item['item_id']} x{$sub_item['amount']}<br />";
    }
	$depth -= 1;
}
}
?>