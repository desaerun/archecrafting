<?php

namespace Core\Item;

use PDO;

class Item
{
    public $id;
    public $name;
    public $description;
    public $icon_id;
    public $hide_grade;
    public $icon_path;
    public $grade;
    public $vendor_price;
    public $auction_price;
    public $item_type;
    public $temper;
    public $amount;
    protected $db;
    /**
     * @var CraftsList
     */
    private $crafts_list;

    public function __construct(PDO $db, $id, $amount = 1)
    {
        $this->db = $db;
        $this->id = $id;
        $this->amount = $amount;

        $this->init();
    }

    protected function init()
    {
        $this->setItemInfo();
    }

    protected function setItemInfo()
    {
        $stmt = "SELECT `items`.*,`icons`.`full_path` AS `icon_full_path` FROM `items` LEFT JOIN `icons` ON `items`.`icon_id` = `icons`.`id` WHERE `items`.`id`=? LIMIT 1";
        $query = $this->db->prepare($stmt);
        $query->execute([$this->id]);

        $item_info = $query->fetch();


        $this->name = $item_info['name'];
        $this->description = $item_info['description'];
        $this->icon_path = $item_info['icon_full_path'];

        $this->hide_grade = $item_info['hide_grade'];

        $this->vendor_price = $item_info['vendor_price'];
        $this->auction_price = $item_info['auction_price'];

        $this->grade = $item_info['grade'];

        $this->item_type = $item_info['item_type'];
        $this->temper = $item_info['temper'];
    }

    public function hasIcon()
    {
        $stmt = "SELECT * FROM `icons` WHERE `id`=?";
        $query = $this->db->prepare($stmt);
        $query->execute([$this->icon_id]);
        $icon = $query->fetch();
        if ($icon) {
            return true;
        }
        return false;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getInfo()
    {
//        return $this->info;
    }

    public function getCraftsList()
    {
        $this->crafts_list = new CraftsList($this->db, $this->id);
        return $this->crafts_list;
    }

    public function printIcon()
    {
        echo <<<HTML
<div class="item_icon grade_{$this->grade} has_item_tooltip" data-item-id="{$this->id}">
    <div class="item_grade grade_{$this->grade}">
        <div class="item_image_wrapper">
            <img src="{$this->icon_path}" alt="{$this->name}"/>
            <div class="count">{$this->amount}</div>
        </div>
    </div>
</div>
HTML;
    }
}
