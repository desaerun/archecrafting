<?php

class Craft {
	private $_db;

	public $id;
	public $name;
	public $labor_cost;
	public $reagents;

	public function __construct ($db, $craft_id) {
		$this->_db = $db;
		$this->id = $craft_id;

		$this->setInfo();
	}

	private function setInfo () {
		$stmt = "SELECT `craft_links`.*,`items`.`name` FROM `craft_links` LEFT JOIN `items` ON `craft_links`.`child_item_id`=`items`.`id` WHERE `craft_links`.`craft_id`=?";
		$query = $this->_db->prepare($stmt);
		$query->execute([ $this->id ]);
		$reagents_db = $query->fetchAll(PDO::FETCH_ASSOC);

		foreach ($reagents_db as $reagent_db) {
			$this->reagents[] = new Reagent($this->_db, $reagent_db['id']);
		}
	}

	public function getArray () {
		$craft = [];
		$craft['id'] = $this->id;
		$craft['name'] = $this->name;
		$craft['labor'] = $this->labor_cost;
	}

	public function getReagents () {
		return $this->reagents;
	}

}
