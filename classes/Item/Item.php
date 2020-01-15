<?php

class Item {
	protected $db;

	public $id;
	public $name;
	public $description;
	public $crafts;
	public $info;


	public function __construct(PDO $db, $id) {
		$this->db = $db;
		$this->id = $id;
		$this->setInfo();
	}

	public $cool_line = "HELLO THIS IS A TEST OF A VERY LONG LING WITH LOTS OF PHP TEXT AND COOL STUFF AND GREAT THINGS AND LONG LINES OF TEXT HERE EXTENDING BEYOND THE 120 CHARACTER LIMIT ON LINES";

	protected function setInfo() {
		$stmt = "SELECT * FROM `items` WHERE `id`=? LIMIT 1";
		$query = $this->db->prepare($stmt);
		$query->execute([ $this->id ]);

		$item_info = $query->fetch();

		$this->info = $item_info;

	}

	public function getId() {
		return $this->id;
	}

	public function getInfo() {
		return $this->info;
	}

	public function getCraftsList() {
		$crafts_list = new CraftsList($this->db, $this->id);
		return $crafts_list;
	}
}
