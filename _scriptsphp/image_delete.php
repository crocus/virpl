<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
	$action = (isset($_GET['action']) && strval($_GET['action'] && !empty($_GET['action']))) ? htmlspecialchars(trim(rtrim($_GET['action']))) : null;
    $filename = (isset($_GET['filename']) && strval($_GET['filename'] && !empty($_GET['filename']))) ? '.' . $_GET['filename'] : null;
	if ($action == 'edit'){
		echo "{ result:1 }";
	}elseif ($action == 'del'){
 		if(is_file($filename ) && unlink ($filename )){
		echo "{ result:1 }";
		} else {
		echo "{ result:0 }";
		}
	}
}
?>