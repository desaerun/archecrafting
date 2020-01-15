<?php

class CraftsList {
	private $db;
	private $fields = [
		"id",
		"name",
		"description"
	];
	public $parent_item_id;
	public $crafts;


	public function __construct($db, $parent_item_id) {
		$this->db = $db;
		$this->parent_item_id = $parent_item_id;

		$this->setInfo();
	}

	private function setInfo() {
		$stmt = "SELECT `crafts`.`id`,`crafts`.`name`,`crafts`.`labor_cost` FROM `crafts` LEFT JOIN `items` ON `crafts`.`crafted_item_id`=`items`.`id` WHERE `crafts`.`crafted_item_id`=?";
		$query = $this->db->prepare($stmt);
		$query->execute([ $this->parent_item_id ]);
		$crafts_db = $query->fetchAll(PDO::FETCH_ASSOC);

		foreach ($crafts_db as $craft_db) {
			$crafts[] = new Craft($this->db, $craft_db['id']);
		}
		$this->crafts = $crafts;
	}

	public function getArray() {
		$i = 0;
		foreach ($this->crafts as $craft) {
			foreach ($fields as $key) {
				$crafts_arr[$i][$key] = $craft[$key];
			}
		}
		return $crafts_arr;
	}

	public function getCrafts() {
		return $this->crafts;
	}
}
