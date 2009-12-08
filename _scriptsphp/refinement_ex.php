<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include('r_conn.php');
include('service_tb.php');
require_once('services.php');
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
	$action = (isset($_POST['action']) && strval($_POST['action'] && !empty($_POST['action']))) ? htmlspecialchars(trim(rtrim($_POST['action']))) : null;
	$uuid = (isset($_POST['uuid']) && strval($_POST['uuid'] && !empty($_POST['uuid']))) ? $_POST['uuid'] : null;
	if ($action == 'update') {
		$data = (array) json_decode(stripslashes($_POST['json_obj']));
		if (array_key_exists("formula", $data) && strval($data['formula'] && !empty($data['formula']))) {
			$formula = $data['formula'];
		}
		//парсинг формулы /////////////////////
		if (!is_null($formula)) {
			$formula_array = formulaParser($formula, $type);
			$formula = $formula_array[0];
			$result = $formula_array[1];
			$type = $formula_array[2];
		}
		$filepath = '../_tmp/'. $_COOKIE["_filedir"]. '/' ;
		if(is_dir($filepath) && $_COOKIE["_filedir"]!= null) {
			$dir_list = scandir( $filepath );
			$file_list = array();
			foreach ($dir_list as $value) {
				if (!is_dir($value)) {
					$file_list[] = $value;
				}
			}
			$count = count($file_list);
		}
		$query = sprintf("UPDATE tbl_exchange SET Type_Exchange=%s, Formula=%s, Result=%s, Description=%s, agent_cod=%s, foto=%s, last_update=Now() WHERE UUID='{$uuid}'",
			GetSQLValueString($type, "int"),
			GetSQLValueString($formula, "text"),
			GetSQLValueString($result, "text"),
			GetSQLValueString(htmlentities($data['Description'], ENT_QUOTES, "UTF-8"), "text"),
			GetSQLValueString(!empty($data['agent_cod'])? $data['agent_cod'] : exitWithError(), "text"),
			GetSQLValueString(empty($count)? "0" : $count, "int"));
		if(mysql_query($query) == 'true') {
			if(!empty($file_list)) {
				$delete = mysql_query("DELETE FROM tbl_file WHERE UUID = '{$uuid}'") or die("Couldn t execute query.".mysql_error());
				foreach ($file_list as $file) {
					if (file_exists($filepath . $file)) {
					$image = file_get_contents( $filepath . $file );
					$image = mysql_real_escape_string( $image );
					$insert_file = ("INSERT INTO tbl_file (UUID, content) VALUES('{$uuid}', '{$image}')");
					$Result1 = mysql_query($insert_file, $realtorplus) or die(mysql_error());
			   if(is_dir($filepath) && $_COOKIE["_filedir"]!= null)
					unlink ( $filepath . $file );
					}
				}
			}
			if(is_dir($filepath) && $_COOKIE["_filedir"]!= null)
				rmdir ($filepath);
			$response ="Объект успешно обновлен.";
		} else {
			die("Ошибка при выполнении обновления объекта: " . mysql_error());
		}
		setcookie("_filedir", null, 0, "/");
		clearstatcache();
	} elseif ($action == 'delete') {
		mysql_query("DELETE FROM tbl_exchange WHERE UUID ='{$uuid}' LIMIT 1") or die(mysql_error());
		mysql_query("DELETE FROM tbl_file WHERE UUID ='{$uuid}'") or die(mysql_error());
		$response ="Объект и прикрепленные файлы удалены с сервера.";
	}
	//$Recordset = mysql_query($query) or die(mysql_error());
	echo $response;
}
function exitWithError() {
	die('Ошибка, объект не обновлен, попробуйте еще раз!');
}
?>
