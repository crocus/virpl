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
switch ( $category ) {
    case 0:
        $SQL ="SELECT UUID FROM tbl_flats WHERE flats_cod ={$id_image}";
        break;
    case 1:
        $SQL ="SELECT UUID FROM tbl_exchange WHERE Id ={$id_image}";
        break;
    default :
        echo 'Error';
        break;
}	
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
if(!empty($image_array[$image])) {
    $im = imagecreatefromstring($image_array[$image]);
/*************************************/
    if ($im !== false) {
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        $uploaddir = './_tmp/';
        $filedir = $_COOKIE["_filedir"];
        if(empty($filedir))
            exit;
        $uploaddir .= $filedir."/";
        if(!file_exists ($uploaddir))
            mkdir($uploaddir, 0777);
        //$file = substr($UUID, 0, 8);
        $file = substr(md5(uniqid(mt_rand())),0,8);
        if(function_exists("imagejpeg")) {
            $file .= image_type_to_extension(IMAGETYPE_JPEG);
            imagejpeg($im, $uploaddir . $file, 50);
        }else if(function_exists("imagegif")) {
                $file .= image_type_to_extension(IMAGETYPE_GIF);
                imagegif($im, $uploaddir . $file);
            }else if(function_exists("imagepng")) {
                    $file .= image_type_to_extension(IMAGETYPE_PNG);
                    imagepng($im, $uploaddir . $file);
                }
        imagedestroy($im);
        echo $uploaddir.$file;
    }else {
        echo 'An error occurred.';
    }
} else {
    exit;
}
clearstatcache ();
ob_end_flush();
?>
