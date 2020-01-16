<?php
require_once("includes/db_connect.php");

?>
<a href="icon_import.php?confirm=true">Import Icons to DB</a>&nbsp;&nbsp;<a href="icon_import.php?confirm=true&truncate=true">Truncate DB and then Import</a><br />

<?php
if(!isset($_GET['confirm'])) {
	die();
}
$start_time = microtime(true);
echo "Execution started at {$start_time}..<br />";
$start_truncate_time = microtime(true);
if(isset($_GET['truncate'])) {
	echo "Truncating database...";
	$stmt = "DELETE FROM `icons` WHERE 1";
	$db->prepare($stmt)->execute();
	$truncate_exec_time = (microtime(true) - $start_truncate_time);
	echo "done! This operation took {$truncate_exec_time} seconds.<br />";
}

function getDirImages($dir, &$results = array()){
    $files = scandir($dir);

    foreach($files as $key => $value){
		$path = $dir."/".$value;
        if(!is_dir($path)) {
            $results[] = $path;
        } else if($value != "." && $value != "..") {
            getDirImages($path, $results);
        }
    }

    return $results;
}

define("ICON_LIVE_DIRECTORY","images/icon");
define("ICON_TEST_DIRECTORY","images/icons_test");


$images_dir = (!isset($_GET['live'])) ? ICON_TEST_DIRECTORY : ICON_LIVE_DIRECTORY;

$files = getDirImages($images_dir);

$i = 0;
foreach ($files as $image) {
	$image_start_time = microtime(true);
	
	$path_parts = pathinfo($image);
	
	$path = $path_parts['dirname'];
	$image_path = substr($path,strlen($images_dir)) . "/"; //path within the images folder

	$filename = $path_parts['filename'];
	$ext = strtolower($path_parts['extension']);
	$fullfilename = $path_parts['basename'];
	
	$full_path = $images_dir . $image_path . $fullfilename;
	
	$filesize = filesize($image);
	
	list($width,$height) = getimagesize($image);
		
	$stmt = "SELECT 1 FROM `icons` WHERE `full_path`=?";
	$query = $db->prepare($stmt);
	$query->execute([$full_path]);
	
	if ($query->fetchColumn()) {
		//icon already exists
		
		$stmt = "UPDATE `icons` SET `full_path`=?,`width`=?,`height`=?,`filesize`=? WHERE `filename`=?";
		$db->prepare($stmt)->execute([$full_path,$width,$height,$filesize,$filename]);
		echo "Successfully Updated ";
	}
	else {
		$stmt = "INSERT INTO `icons` (`path`,`filename`,`ext`,`full_path`,`width`,`height`,`filesize`) VALUES (?,?,?,?,?,?,?)";
		$db->prepare($stmt)->execute([$image_path,$filename,$ext,$full_path,$width,$height,$filesize]);
		echo "Successfully Added ";
	}
	echo "Icon: <img src=\"{$full_path}\" /><br />\n";
	echo "{$full_path}<br />\n";
	$image_exec_time = (microtime(true) - $image_start_time);
	$total_exec_time = (microtime(true) - $start_time);
	echo "This operation took {$image_exec_time} seconds. Total execution time: {$total_exec_time} seconds.<br /><br />\n";
	
	if ($i%5==0) {
		flush();
	}
	$i++;
}
$total_exec_time = (microtime(true) - $start_time);
echo "Folder and subdirectories imported to database successfully. This operation took {$total_exec_time} seconds.<br /><br />\n";
?>