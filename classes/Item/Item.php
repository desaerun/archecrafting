<?php
class Item {

    public $id;
    public $name;
    public $description;
    public crafts;

    protected $_db;

    public function __construct (PDO $db,$id) {
        $this->_db = $db;
        $this->setInfo();
    }
    protected function setInfo() {
        $stmt = "SELECT * FROM `items` WHERE `id`=? LIMIT 1";
        $query = $this->db->prepare($stmt);
        $query->execute();

        $item_info = $query->fetch();
        $this->
    }
    public function getId() {
        return $this->id;
    }
    public function getCraftsArray () {
        $crafts_array = new CraftsList($this->_db,$this->id);
        return $crafts_array;
    }
}
?>