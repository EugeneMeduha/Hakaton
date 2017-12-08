<?php
set_time_limit(7600);
require_once("../nc.php");

function thumb($pict){
$filename = "/home/baby4by/public_html/images/catalog_m/".$pict; 
$percent = 0.5 ; 

    // Get new sizes
$mime = getimagesize ( $filename ); 

$percent = round(220/$mime[1],5) ; 

$newwidth = $mime[0] * $percent ; 
$newheight = $mime[1] * $percent ; 

$im = new imagick( $filename );
/* create the thumbnail */
$im->cropThumbnailImage( $newwidth, $newheight );
/* Write to a file */
$im->writeImage( "/home/baby4by/public_html/images/catalog_m/th_".$pict );

} 

if (!empty($_FILES)) {
$randdo = rand(1,750); 
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
	$targetFile =  str_replace('//','/',$targetPath) . $randdo.$_FILES['Filedata']['name'];
	while(file_exists($targetFile)){
	    $randdo++; 
	    $targetFile =  str_replace('//','/',$targetPath) . $randdo.$_FILES['Filedata']['name'];
	}
		move_uploaded_file($tempFile,$targetFile);
		$path_=$randdo.$_FILES['Filedata']['name'];
		thumb($path_);		
			
		$sql="INSERT INTO `dr_subitems` ( `id_item` , `path` ) VALUES ('".$_REQUEST['itemID']."','".$path_."')";
		$result = mysql_query($sql);
		echo "1";

}
?>