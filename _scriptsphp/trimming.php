<?php
$filepath = '../_tmp/'. $_COOKIE["_filedir"].'/'; 
 if( is_dir($filepath) && $_COOKIE["_filedir"]!= null ){
    $dir_list = scandir( $filepath );
    $file_list = array();
    foreach ($dir_list as $value) {
        if (!is_dir($value)) {
            $file_list[] = $value;
        }
    }
    if(!empty($file_list)) {
        foreach ($file_list as $file) {
            if (file_exists($filepath . $file)) 
            unlink ( $filepath . $file );
        }
    }
   if( is_dir($filepath) && $_COOKIE["_filedir"]!= null )
        rmdir ($filepath);
}
unset($filepath);
setcookie("_filedir", null, 0, "/");
clearstatcache();
?>