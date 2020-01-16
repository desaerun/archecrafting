<?php

class Item {
	protected $db;

	public $id;
	public $name;
	public $description;
	public $icon_id;
	private $hide_grade;
	private $icon_path;

	public function __construct(PDO $db, $id) {
		$this->db = $db;
		$this->id = $id;

		$this->init();
	}

	public $cool_line = "HELLO THIS IS A TEST OF A VERY LONG LING WITH LOTS OF PHP TEXT AND COOL STUFF AND GREAT THINGS AND LONG LINES OF TEXT HERE EXTENDING BEYOND THE 120 CHARACTER LIMIT ON LINES";

	protected function init() {
		$this->setItemInfo();
	}

	protected function setItemInfo() {
		$stmt = "SELECT `items`.*,`icons`.`full_path` AS `icon_full_path`,`icons`.`filename` AS `icon_filename` FROM `items`LEFT JOIN `icons` ON `items`.`icon_id` = `icons`.`id` WHERE `items`.`id`=? LIMIT 1";
		$query = $this->db->prepare($stmt);
		$query->execute([ $this->id ]);

		$item_info = $query->fetch();

		$icon_path = $item_info['full_path'] . $item_info['filename']


		$stats = [];
		$this->name = $item_info['name'];
		$this->description = $item_info['description'];
		$this->hide_grade = $item_info['hide_grade'];

		$this->icon_path = $item_info['icon_'];
		$this->vendor_price = $item_info['vendor_price'];
		$this->auction_price = $item_info['auction_price'];

		$this-> = $item_info['grade'];

		$this-> = $item_info['item_type'];
		$this-> = $item_info['temper'];
		$this-> = $item_info[''];
	}

	public function hasIcon() {
		$stmt = "SELECT * FROM `icons` WHERE `id`=?";
		$query = $this->db->prepare($stmt);
		$query->execute([ $this->icon_id ]);
		$icon = $query->fetch();
		if ($icon) {
			return TRUE;
		}
		return FALSE;
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
