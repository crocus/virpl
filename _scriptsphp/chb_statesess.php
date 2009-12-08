<?php
include('services.php');
require_once('session.inc');
session_start();
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
	$data = (array) json_decode(stripslashes($_REQUEST['checkstates']));
	$marga = (isset($_REQUEST['marga']) && intval($_REQUEST['marga'] && !empty($_REQUEST['marga']))) ? $_REQUEST['marga'] : null;
	$action = (isset($_REQUEST['action']) && strval($_REQUEST['action'] && !empty($_REQUEST['action']))) ? htmlspecialchars(trim(rtrim($_REQUEST['action']))) : null;
	$hidden_count = 0;
	switch($action) {
		case "a_update":
			if (isset( $_SESSION['thisChecked']) && !empty($_SESSION['thisChecked'])) {
				$sess_array = array_unique(explode(",",(!empty($data['selected']))? $_SESSION['thisChecked'] . "," . $data['selected']: $_SESSION['thisChecked']));
				$uncheck_array = explode(",", $data['unselected']);
				$a_intersect = array_intersect ($sess_array, $uncheck_array);
				foreach ($a_intersect as $value) {
					$sess_array = str_replace($value, "", $sess_array);
				}
				$sess_array = clear_array_empty($sess_array);
				$current_checked = implode(",", $sess_array);
				$_SESSION['thisChecked'] = $current_checked;
			} else {
				$_SESSION['thisChecked'] = $data['selected'];
			}
			/*if (isset( $_SESSION['margin']) && !empty($_SESSION['margin'])) {
				if(!is_null($marga))
					$_SESSION['margin'] = $_SESSION['margin'] + $marga;
			} else {
				$_SESSION['margin'] = $marga;
			}*/
			if(!is_null($marga))
			$_SESSION['margin'] = $marga;
			break;
		case "a_print":
			if (isset( $_SESSION['forprint']) && !empty($_SESSION['forprint'])) {
				$sess_array = array_unique(explode(",",(!empty($data['selected']))? $_SESSION['forprint'] . "," . $data['selected']: $_SESSION['forprint']));
				$uncheck_array = explode(",", $data['unselected']);
				$a_intersect = array_intersect ($sess_array, $uncheck_array);
				foreach ($a_intersect as $value) {
					$sess_array = str_replace($value, "", $sess_array);
				}
				$sess_array = clear_array_empty($sess_array);
				$current_checked = implode(",", $sess_array);
				$_SESSION['forprint'] = $current_checked;
			} else {
				$_SESSION['forprint'] = $data['selected'];
			}
			/*if (isset( $_SESSION['thisChecked']) && !empty($_SESSION['thisChecked'])) {
				$sess_array = array_unique(explode(",",  $_SESSION['forprint'] . "," . $_SESSION['thisChecked']));
				$_SESSION['forprint'] = implode(",", $sess_array);
			}*/
			break;	
		case "a_delete":
			if (isset( $_SESSION['hiddenRow']) && !empty($_SESSION['hiddenRow'])) {
				$_SESSION['hiddenRow'] = $_SESSION['hiddenRow'] . "," . $data['selected'];
				$hidden_count = count(explode(",", $data['selected']));
			} else {
				$_SESSION['hiddenRow'] = $data['selected'];
				$hidden_count = count(explode(",", $_SESSION['hiddenRow']));
			}
			break;
	}
	echo $hidden_count;
}
?>
