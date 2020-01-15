<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="js/item_tooltip.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/items.css" type="text/css" />
<script>

</script>
<?php
require_once("includes/db_connect.php");
require_once("includes/functions.inc.php");
require_once("includes/config.inc.php");
?>
<div>
Hello there. This is a cool.
<?php
itemIcon($db,"5");
?>
Item. And here's two more:
<div>
<?php
itemIcon($db,"6");
itemIcon($db,"24");
?>
</div>
</div>
<div id="outer">
	Hello this is a test. Here's a cool item:
    <div class="inner"></div>
	<div class="item_icon inline_replace" data-item-id="6"></div>
	Or maybe not.
</div>
