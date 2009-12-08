<?php
$f_description = $_POST['f_description'];
$filedir = (isset($_POST['filedir']) && strval($_POST['filedir'] && !empty($_POST['filedir']))) ? $_POST['filedir'] : null;
 $uploaddir = '../_tmp/';
 $font_path ='../_style/fonts/';
 $font = $font_path.'tahoma.ttf';
if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
 //  echo "File ". $_FILES['userfile']['name'] ." uploaded successfully.\n";
   $uploaddir .= $filedir."/";
   if(!file_exists ($uploaddir))
	mkdir($uploaddir, 0777);
   //readfile($_FILES['userfile']['tmp_name']);
} else {
   echo "Possible file upload attack: ";
   echo "filename '". $_FILES['userfile']['tmp_name'] . "'.";
   exit;
}
 $imgname = $_FILES['userfile']['name'];
  $tmp_imgname = $_FILES['userfile']['tmp_name'];
  $imageinfo = getimagesize($_FILES['userfile']['tmp_name']);
  $mimetype = $imageinfo['mime']; 
 // echo $mimetype;
 if($mimetype != 'image/gif' && $mimetype != 'image/jpeg' && $mimetype != 'image/png') {
  echo "Sorry, we only accept GIF, JPEG and PNG images\n";
  exit;
 }

/*if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir . $imgname)) {
    print "Файл существует и благополучно переправлен на сервер!!!";
	echo $name;
} else {
    print "Какие-то ошибки при отправке файла!";
}*/
  switch ( $mimetype ) {
    case 'image/jpeg':
      $im = @imagecreatefromjpeg($tmp_imgname);
        break;
    case 'image/gif':
       $im = @imagecreatefromgif($tmp_imgname);
         break;
	case 'image/png':
        $im = @imagecreatefrompng($tmp_imgname);
         break;	 
    default : 
        break;
}

$width = imagesx($im);
$height = imagesy($im);
$ratio = $width/$height;
if( $ratio <= 1){
	$percent = 480/$height;
} elseif ($ratio > 1 ) {
	$percent = 640/$width;
}
	$new_width = $width  * $percent;
	$new_height = $height * $percent;
	$resized_im = imagecreatetruecolor($new_width, $new_height);
imagecopyresized($resized_im, $im, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
$im = $resized_im;
if(!empty($f_description))
{
// First we create our stamp image manually from GD
$stamp = imagecreatetruecolor(105, 20);
$black = imagecolorallocate($stamp, 0, 0, 0);
$grey = imagecolorallocate($stamp, 128, 128, 128);
imagefilledrectangle($stamp, 0, 0, 103, 19, $grey);
imagefilledrectangle($stamp, 2,2, 101,17, 0xFFFFFF);
//imagestring($stamp, 3, 10, 5, 'Дом снаружи', 0x0000FF);
imagettftext($stamp, 10, 0, 5, 14, $black, $font, $f_description);
// Set the margins for the stamp and get the height/width of the stamp image
$marge_right = 2;
$marge_bottom = 2;
$sx = imagesx($stamp);
$sy = imagesy($stamp);
// Merge the stamp onto our photo with an opacity (transparency) of 50%
imagecopymerge($im, $stamp, $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 70);
}
$file = substr(md5(uniqid(mt_rand())),0,8);
if ($im !== false) {
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
header('Cache-Control: no-store, no-cache, must-revalidate'); 
header('Cache-Control: post-check=0, pre-check=0', FALSE); 
header('Pragma: no-cache');
if(function_exists("imagejpeg")){
			$file .= image_type_to_extension(IMAGETYPE_JPEG);
			imagejpeg($im, $uploaddir . $file, 50);
		}else if(function_exists("imagegif")){
			$file .= image_type_to_extension(IMAGETYPE_GIF);
			imagegif($im, $uploaddir . $file);
		}else if(function_exists("imagepng")){
			$file .= image_type_to_extension(IMAGETYPE_PNG);
			imagepng($im, $uploaddir . $file);
		}
echo $file;
imagedestroy($im);
} else {
    echo 'An error occurred.';
}
/*  $whitelist = array(".jpeg", ".jpg", ".png", ".gif");
 foreach ($whitelist as $item) {
  if(!preg_match("/$item\$/i", $imgname)) {
   echo "We do not allow uploading execute files\n";
   exit;
   }
  }*/

//print_r($_FILES);
?>