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

		$this->init();
	}

	private function init() {
		$this->setCrafts();
	}

	private function setCrafts() {
		$stmt = "SELECT `crafts`.`id`,`crafts`.`name`,`crafts`.`labor_cost` FROM `crafts` LEFT JOIN `items` ON `crafts`.`crafted_item_id`=`items`.`id` WHERE `crafts`.`crafted_item_id`=?";
		$query = $this->db->prepare($stmt);
		$query->execute([ $this->parent_item_id ]);
		$crafts_db = $query->fetchAll(PDO::FETCH_ASSOC);
		foreach ($crafts_db as $craft_db) {
			$crafts[] = new Craft($this->db, $craft_db['id']);
		}
		$this->crafts = $crafts;
	}

	public function getCrafts() {
		return $this->crafts;
	}

	public function getCraftsArray() {
		$i = 0;
		$crafts_arr = [];

		foreach ($this->crafts as $craft) {
			foreach ($fields as $key) {
				$crafts_arr[$i][$key] = $craft[$key];
			}
			$i++;
		}
		return $crafts_arr;
	}

	public function getCrafts() {
		return $this->crafts;
	}
}
