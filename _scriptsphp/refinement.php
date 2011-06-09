<?php
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	include('r_conn.php');
	include('services.php');
	include('service_tb.php');
	if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
		$action = (isset($_POST['action']) && strval($_POST['action'] && !empty($_POST['action']))) ? htmlspecialchars(trim(rtrim($_POST['action']))) : null;
		$uuid = (isset($_POST['uuid']) && strval($_POST['uuid'] && !empty($_POST['uuid']))) ? $_POST['uuid'] : null;
		if ($action == 'update') {
			$data = (array) json_decode(stripslashes($_POST['json_obj']));
			if (array_key_exists("price_sale", $data) && is_numeric($data['price_sale']) && !empty($data['price_sale'])) {
				$price_sale = $data['price_sale'];
			}
			$filepath = '../_tmp/'. $_COOKIE["_filedir"] . "/" ;
			if( is_dir($filepath) && $_COOKIE["_filedir"]!= null ) {
				$dir_list = scandir( $filepath );
				$file_list = array();
				foreach ($dir_list as $value) {
					if (!is_dir($value)) {
						$file_list[] = $value;
					}
				}
				$count = count($file_list);
			}
			$last_uuid = GetSQLValueString(isset($data['last_hot_affair']) ? $data['last_hot_affair'] : 0 , "defined");
			if(isset($data['last_hot_affair'])){
				mysql_query("UPDATE tbl_flats SET hot_affair = 0, hot_affair_type =0 WHERE UUID = '{$data['last_hot_affair']}'") or die("Couldn t execute query.".mysql_error());
			}
			if(isset($data['agent_phon'])){
				$show_phone = setParticipantsPhons($data['agent_cod'], $data['agent_phon']);
			}
			$query = sprintf("UPDATE tbl_flats SET room_cod=%s, type_cod=%s, sale_cod=%s, project_cod=%s, So=%s, Sz=%s, Sk=%s, flats_floor=%s,".
			" flats_floorest=%s, material_cod=%s, plan_cod=%s, balcon_cod=%s, cond_cod=%s, side_cod=%s, flats_comments=%s, agent_cod=%s, flats_tel=%s, ipo_ch=%s,".
			" novostroy=%s, street_cod=%s, building_id=%s, flats_price=%s, u_price=%s, show_phone=%s, foto=%s, sale=%s, date_sale=%s, price_sale=%s, hot_affair=%s, hot_affair_type=%s, last_update=Now() WHERE UUID='{$uuid}'",
			GetSQLValueString($data['room_cod'], "int"),
			GetSQLValueString($data['type_cod'], "int"),
			GetSQLValueString($data['sale_cod'], "int"),
			GetSQLValueString($data['project_cod'], "int"),
			GetSQLValueString($data['So'], "double"),
			GetSQLValueString($data['Sz'], "double"),
			GetSQLValueString($data['Sk'], "double"),
			GetSQLValueString($data['flats_floor'], "int"),
			GetSQLValueString($data['flats_floorest'], "int"),
			GetSQLValueString($data['material_cod'], "int"),
			GetSQLValueString($data['plan_cod'], "int"),
			GetSQLValueString($data['balcon_cod'], "int"),
			GetSQLValueString($data['cond_cod'], "int"),
			GetSQLValueString($data['side_cod'], "int"),
			GetSQLValueString(htmlentities($data['flats_comments'], ENT_QUOTES, "UTF-8"), "text"),
			GetSQLValueString(!empty($data['agent_cod'])? $data['agent_cod'] : exitWithError(), "text"),
			GetSQLValueString($data['flats_tel'], "int"),
			GetSQLValueString(isset($data['ipoteka']) ? $data['ipoteka'] : 0 , "int"),
			GetSQLValueString($data['novostroy'], "int"),
			GetSQLValueString($data['street_cod'], "int"),
			GetSQLValueString(!empty($data['building_id'])? htmlentities($data['building_id'], ENT_QUOTES, "UTF-8"): '', "text"),
			GetSQLValueString(!empty($data['flats_price'])? $data['flats_price']: exitWithError(), "int"),
			GetSQLValueString($data['uniform_price'], "int"),
			GetSQLValueString(isset($show_phone) ? "true" : "", "defined","1","0"),
			GetSQLValueString(empty($count)? "0" : $count, "int"),
			GetSQLValueString(isset($price_sale) ? "true" : "", "defined","1","0"),
			GetSQLValueString(isset($price_sale) ? "true" : "", "defined","Now()","NULL"),
			GetSQLValueString(isset($price_sale) ? $price_sale : 0 , "int"),
			GetSQLValueString(isset($data['hot_affair']) ? $data['hot_affair'] : 0 , "int"),
			GetSQLValueString(isset($data['hot_affair_type']) ? $data['hot_affair_type'] : 0 , "int"));
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
			mysql_query("DELETE FROM tbl_flats WHERE UUID ='{$uuid}' LIMIT 1") or die(mysql_error());
			mysql_query("DELETE FROM tbl_file WHERE UUID ='{$uuid}'") or die(mysql_error());
			$response ="Объект и прикрепленные файлы удалены с сервера.";
		}
		echo $response;
	}
	function exitWithError() {
		die('Ошибка, объект не обновлен, попробуйте еще раз!');
	}
?>