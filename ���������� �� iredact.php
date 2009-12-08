<?php 
require_once('_scriptsphp/r_conn.php');
$font_path ='./_style/fonts/';

$image = $_GET['image'];
$min = $_GET['min'];
$percent = $_GET['percent'];
if(!$percent) $percent = 0.2;
$SQL ="SELECT UUID FROM tbl_flats WHERE flats_cod = 4576";						
$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
$row = mysql_fetch_assoc($result);
$UUID = $row['UUID'];
$SQL ="SELECT content FROM tbl_file WHERE UUID ='{$UUID}'";
$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());	

$image_array = array();
$i=0;
while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
$image_array[$i] = $row[content];
    $i++;
}

$im = imagecreatefromstring($image_array[$image]);
$width = imagesx($im);
$height = imagesy($im);
/***********************************/
$t_stamp = imagecreate($width, $height );
/************************************/
$stamp = imagecreatetruecolor(150, 150);
$white = imagecolorallocate($stamp, 255, 255, 255);
$grey = imagecolorallocate($stamp, 128, 128, 128);
$black = imagecolorallocate($stamp, 0, 0, 0);
imagefilledrectangle($stamp, 0, 0, 150, 150, IMG_COLOR_TILED);

// The text to draw
$text = $UUID;
//$text = date("d.m.y");
// Replace path by your own font path
$font = $font_path.'tahoma.ttf';
$angle = rand(25, 50);
// Add some shadow to the text
imagettftext($stamp, 20, $angle, 17, 145, $white, $font, $text);

// Add the text
imagettftext($stamp, 20, $angle, 20, 148, IMG_COLOR_TILED, $font, $text);
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
$sx = imagesx($t_stamp);
$sy = imagesy($t_stamp);
imagefilter($im, IMG_FILTER_BRIGHTNESS,25);
imagecopymerge($im, $t_stamp, imagesx($im) - $sx, imagesy($im) - $sy, 0, 0, imagesx($t_stamp), imagesy($t_stamp), 15);
//imagefilter($im, IMG_FILTER_COLORIZE,255,255,255,127);
imagefilter($im, IMG_FILTER_CONTRAST,-10);
//imagefilter($im, IMG_FILTER_PIXELATE, 100, true);
}
/*************************************/
if ($im !== false) {
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
header('Cache-Control: no-store, no-cache, must-revalidate'); 
header('Cache-Control: post-check=0, pre-check=0', FALSE); 
header('Pragma: no-cache');
if(function_exists("imagejpeg")){
			header("Content-Type: image/jpeg");
			 imagejpeg($im, null, 50);
		}else if(function_exists("imagegif")){
			header("Content-Type: image/gif");
			 imagegif($im);
		}else if(function_exists("imagepng")){
			header("Content-Type: image/png");
			 imagepng($im);
		}
imagedestroy($r_img);
} else {
    echo 'An error occurred.';
}
?>
