<?php


namespace Core\Item;


use PDO;

class ItemIconList
{
    private $db;
    private $icons = [];

    public function __construct(PDO $db, $search_str = "")
    {
        $this->db = $db;

        $padded_search_str = "%" . $search_str . "%";
        $stmt = "SELECT * FROM `icons` WHERE `filename` LIKE ? OR `path` LIKE ?";
        $query = $this->db->prepare($stmt);
        $query->execute([$padded_search_str, $padded_search_str]);

        $icons = $query->fetchAll();
        if (!$icons) {
            //there is no data matching the search string
        } else {
            $i = 0;
            foreach ($icons as $icon) {
                $this->icons[$i] = $icon;
                $i++;
            }
        }
    }

    public function getIcons()
    {
        return $this->icons;
    }
}