<?php
class Craft {
	private $_db;

    public $id;
    public $name;
    public $reagents;

    public function __construct ($db,$craft_id) {
        $this->db = $db;
        $this->id = $craft_id;

        $this->setInfo();
    }
    private function setInfo(){
	    $stmt = "SELECT `craft_links`.*,`items`.`name`,`items`.`id` FROM `craft_links` LEFT JOIN `items` ON `craft_links`.`child_item_id`=`items`.`id` WHERE `craft_links`.`craft_id`=?";
	    $query = $this->db->prepare($stmt);
	    $query->execute([ $craft['id'] ]);
	    $reagents_db = $query->fetchAll();

	    foreach ($reagents_db as $reagent_db) {
		    $this->reagents[] = new Reagent($this->_db,$reagent_db['id']);
	    }
    }
    public function getInfo() {

    }
    public function getReagents() {
    	return $this->reagents;
    }

}
?>