<?php 
ob_start("ob_gzhandler"); 
require_once('_scriptsphp/r_conn.php');
$font_path ='./_style/fonts/';
$id_image = $_GET['id_image'];
$category = $_GET['category'];
//if(!$category) $category = 1;
$image = $_GET['image'];
$min = $_GET['min'];
$percent = $_GET['percent'];
if(!$percent) $percent = 0.2;
$destination = (isset($_GET['dest']) && strval($_GET['dest'] && !empty($_GET['dest']))) ? htmlspecialchars(trim(rtrim($_GET['dest']))) : "browser";
switch ( $category ) {
	case 0:
//      $SQL ="SELECT UUID FROM tbl_flats WHERE flats_cod ={$id_image}";	
$SQL ="SELECT f.UUID, na.Name_Node AS agency_name FROM tbl_flats f 
LEFT JOIN node n ON f.agent_cod = n.UUID 
LEFT JOIN node na ON na.participants_id = n.parents_id 
WHERE flats_cod ={$id_image}";    
		break;
	case 1:
	  $SQL ="SELECT e.UUID, na.Name_Node as agency_name FROM tbl_exchange e 
	  LEFT JOIN node n ON e.agent_cod = n.UUID 
LEFT JOIN node na ON na.participants_id = n.parents_id  
WHERE Id ={$id_image}";
		 break;
	default : 
	echo 'Error';
		break;
}	
$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
$row = mysql_fetch_assoc($result);
$UUID = $row['UUID'];
//////////////////////////
$agency_name = $row['agency_name'];
///////////////////////////////
$SQL ="SELECT content FROM tbl_file WHERE UUID ='{$UUID}'";
$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());	

$image_array = array();
$i=0;
while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
$image_array[$i] = $row[content];
	$i++;
}
//print_r($image_array);
if(!empty($image_array[$image])){
$im = imagecreatefromstring($image_array[$image]);
$width = imagesx($im);
$height = imagesy($im);
/***********************************/
$t_stamp = imagecreate($width, $height );
/************************************/
$stamp = imagecreatetruecolor(210, 160);
$white = imagecolorallocate($stamp, 255, 255, 255);
$grey = imagecolorallocate($stamp, 128, 128, 128);
$black = imagecolorallocate($stamp, 0, 0, 0);
imagefilledrectangle($stamp, 0, 0, 210, 160, IMG_COLOR_TILED);

// The text to draw
/////////////////////
//$text = ($UUID, 0, 8);
if(mb_strlen($agency_name, "UTF-8") <= 10 ){
   $text = $agency_name; 
} else {
   $text = substr($UUID, 0, 8); 
}
//$text = substr($agency_name, 0, strrchr($agency_name, '\s'));

////////////////////
//$text = date("d.m.y");
// Replace path by your own font path
$font = $font_path.'tahoma.ttf';
$angle = rand(25, 50);
// Add some shadow to the text
imagettftext($stamp, 20, $angle, 32, 155, $white, $font, $text);
// Add the text
imagettftext($stamp, 20, $angle, 35, 158, IMG_COLOR_TILED, $font, $text);
/*******************/
imagesettile($t_stamp, $stamp) ;
// Make the image repeat
imagefilledrectangle($t_stamp, 0, 0, imagesx($im), imagesy($im), IMG_COLOR_TILED);
// Set the margins for the stamp and get the height/width of the stamp image
if($min==1){
$newwidth = $width * $percent;
$newheight = $height * $percent;
// Load
$thumb = imagecreatetruecolor($newwidth, $newheight);
imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
$im = $thumb;
} else {
/*$sx = imagesx($t_stamp);
$sy = imagesy($t_stamp);
imagefilter($im, IMG_FILTER_BRIGHTNESS,23);
imagecopymerge($im, $t_stamp, imagesx($im) - $sx, imagesy($im) - $sy, 0, 0, imagesx($t_stamp), imagesy($t_stamp), 15);
imagefilter($im, IMG_FILTER_CONTRAST,-8);*/
}
/*************************************/
if ($im !== false) {
/*header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
header('Cache-Control: no-store, no-cache, must-revalidate'); 
header('Cache-Control: post-check=0, pre-check=0', FALSE); 
header('Pragma: no-cache');*/
	if(function_exists("imagejpeg")){
			header("Content-Type: image/jpeg");
			 imagejpeg($im);
		}else if(function_exists("imagegif")){
			header("Content-Type: image/gif");
			 imagegif($im);
		}else if(function_exists("imagepng")){
			header("Content-Type: image/png");
			 imagepng($im);
		}
imagedestroy($im);
}else {
	echo 'An error occurred.';
}
} else {
	exit;
}
ob_end_flush();
?>
