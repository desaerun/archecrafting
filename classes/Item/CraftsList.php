<?php
class CraftsList {
    private $_db;

    public $parent_item_id;
    public $_crafts;

    public function __construct ($db,$parent_item_id) {
        $this->_db = $db;
	    $this->parent_item_id = $parent_item_id;

        $this->setInfo();
    }
    private function setInfo() {
        $stmt = "SELECT `crafts`.`id`,`crafts`.`name` FROM `crafts` LEFT JOIN `items` ON `crafts`.`crafted_item_id`=`items`.`id` WHERE `crafts`.`crafted_item_id`=?";
        $query = $this->db->prepare($stmt);
        $query->execute([ $this->parent_item_id ]);
        $crafts_db = $query->fetchAll();

        foreach ($crafts_db as $craft_db) {
        	$crafts[] = new Craft($this->_db,$craft_db['id']);
        }
        $this->_crafts = $crafts;
    }
    public function getCrafts() {
    	return $this->_crafts;
    }
}