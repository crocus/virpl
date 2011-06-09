<?php
include('r_conn.php');
require_once('services.php');
require_once('session.inc');
session_start();
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;
	switch ($theType) {
		case "text":
			$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
			break;
		case "long":
		case "int":
			$theValue = ($theValue != "") ? intval($theValue) : "NULL";
			// $theValue = ($theValue != "") ? str_replace ("-", "", $theValue) : "NULL";
			break;
		case "double":
			$theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
			break;
		case "date":
			$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
			break;
		case "defined":
			$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
			break;
	}
	return $theValue;
}
if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
	$time = date("H:i:s", time());
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "linsert")) {
	// //////////////////////////
	// $uuid = substr(md5(uniqid(mt_rand())),0,5);
		$tmp_array = createParticipants();
		$uuid = $tmp_array[0];
		// ///////////////////////////
		// $filepath = '.'. $_POST['filepath_a'];
		$filepath = (isset($_POST['filepath_a']) && strval($_POST['filepath_a'] && !empty($_POST['filepath_a']))) ? '.' . $_POST['filepath_a'] : null;
		// chmod($filepath, 0777);
		if (is_dir($filepath)) {
			$dir_list = scandir($filepath);
			$file_list = array();
			foreach ($dir_list as $value) {
				if (!is_dir($value)) {
					$file_list[] = $value;
				}
			}
			$count = count($file_list);
		}
		// ///////////////////////////
		$fio = (isset($_POST['fio']) && strval($_POST['fio'] && !empty($_POST['fio']))) ? htmlspecialchars(trim(rtrim($_POST['fio']))) : null;
		$phon = (isset($_POST['phon']) && strval($_POST['phon'] && !empty($_POST['phon']))) ? htmlspecialchars(trim(rtrim($_POST['phon']))) : null;
		$email = (isset($_POST['e_mail']) && strval($_POST['e_mail'] && !empty($_POST['e_mail']))) ? htmlspecialchars(trim(rtrim($_POST['e_mail']))) : null;
		$contact = createContact($fio, $phon, $email);
		if ($contact != null) {
			$source = "0";
			$treated = "0";
		} else {
			$agent_cod = (isset($_POST['agent_cod']) && intval($_POST['agent_cod'] && !empty($_POST['agent_cod']))) ? $_POST['agent_cod'] : null;
			if(isset($_POST['agent_phon']) && !empty($_POST['agent_phon'])) {
				$show_phone = setParticipantsPhons($agent_cod, $_POST['agent_phon']);
			}
			$source = "1";
			$treated = "1";
		}
		$price = (isset($_POST['flats_price']) && strval($_POST['flats_price'] && !empty($_POST['flats_price']))) ? preg_replace('/([^\d])/', "", $_POST['flats_price']) : null;
		$currency = (isset($_POST['currency']) && strval($_POST['currency'] && !empty($_POST['currency']))) ? $_POST['currency'] : null;
		if(!is_null($currency)){
			switch ($currency) {
		case "0":
		default;
			break;
		case "1":
			$price = $price * $_SESSION['usd'];
			break;
		case "2":
		   $price = $price * $_SESSION['eu'];
			break;

	}
		}
		$insertSQL = sprintf("INSERT INTO tbl_flats (UUID, sale_cod, type_cod, project_cod, So, Sz, Sk, plan_cod, wc_cod, balcon_cod, side_cod, cond_cod, flats_comments, agent_cod, flats_date, flats_tel, ipo_ch, street_cod, building_id, flats_price, kind_calc, room_cod, flats_floor, flats_floorest, material_cod, show_phone, Contact, Source, Treated, foto, last_update) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,  %s, Now(), %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, Now())", 
			GetSQLValueString($uuid, "text"),
			GetSQLValueString(empty($_POST['sale_cod'])? "1": $_POST['sale_cod'], "int"),
			GetSQLValueString(empty($_POST['type_cod'])?"1":$_POST['type_cod'], "int"),
			GetSQLValueString(empty($_POST['project_cod'])?"1":$_POST['project_cod'], "int"),
			GetSQLValueString($_POST['so'], "double"),
			GetSQLValueString(empty($_POST['sz'])?"0": $_POST['sz'], "double"),
			GetSQLValueString(empty($_POST['sk'])?"0": $_POST['sk'], "double"),
			GetSQLValueString(empty($_POST['plan_cod'])?"1": $_POST['plan_cod'], "int"),
			GetSQLValueString(empty($_POST['wc_cod'])?"1":$_POST['wc_cod'], "int"),
			GetSQLValueString(empty($_POST['balcon_cod'])?"1":$_POST['balcon_cod'], "int"),
			GetSQLValueString(empty($_POST['side_cod'])?"1":$_POST['side_cod'], "int"),
			GetSQLValueString(empty($_POST['cond_cod'])?"1":$_POST['cond_cod'], "int"),
			GetSQLValueString(empty($_POST['flats_comments'])? "" : htmlentities($_POST['flats_comments'], ENT_QUOTES, "UTF-8"), "text"),
			GetSQLValueString($agent_cod, "text"),
			GetSQLValueString(isset($_POST['flats_tel']) ? "true" : "", "defined", "1", "0"),
			GetSQLValueString(isset($_POST['mortgage-chance']) ? "true" : "", "defined", "1", "0"),
			GetSQLValueString(empty($_POST['street_cod'])?"1":$_POST['street_cod'], "int"),
			GetSQLValueString(empty($_POST['building_id'])? "" : htmlentities($_POST['building_id'], ENT_QUOTES, "UTF-8"), "text"),
			GetSQLValueString($price, "int"),
			GetSQLValueString(is_null($currency) ? "0" : $currency, "int"),
			GetSQLValueString(empty($_POST['room_cod'])?"0":$_POST['room_cod'], "int"),
			GetSQLValueString(empty($_POST['flats_floor'])?"0":$_POST['flats_floor'], "int"),
			GetSQLValueString(empty($_POST['flats_floorest'])?"0":$_POST['flats_floorest'], "int"),
			GetSQLValueString(empty($_POST['material_cod'])?"1":$_POST['material_cod'], "int"),
			GetSQLValueString(isset($show_phone) ? "true" : "", "defined","1","0"),
			GetSQLValueString($contact, "text"),
			GetSQLValueString($source, "int"),
			GetSQLValueString($treated, "int"),
			GetSQLValueString(empty($count)? "0" : $count, "int"));
		if (isset($_POST['action_a']) && $_POST['action_a'] == 'submitted') {
			$Result1 = mysql_query($insertSQL, $realtorplus) or die(mysql_error());
			if (!empty($file_list)) {
				foreach ($file_list as $file) {
					$image = file_get_contents($filepath . $file);
					$image = mysql_real_escape_string($image);
					$insert_file = ("INSERT INTO tbl_file (UUID, content) VALUES('{$uuid}', '{$image}')");
					$Result1 = mysql_query($insert_file, $realtorplus) or die(mysql_error());
					unlink ($filepath . $file);
				}
			}
			if (is_dir($filepath))
				rmdir ($filepath);
			echo '<span>Ваше объявление добавлено! Вы можете продолжить размещение объектов или <a href="#" class="tabs-back-button" title="К вариантам продажи">Вернутся к вариантам продажи</a>.</span>';
			if ($contact != null) {
				echo "<p><span class='red redline'>Примечание: Объявления, размещенные в разделе \"Продажа квартир\", проходят постмодерацию. В ближайшее время с Вами свяжется специалист для дальнейшего сотрудничества и размещения объявления в общем разделе.</span></p>";
			}
		}
	}
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form-proposal-buy")) {
		if (isset($_POST['room_cod'])) {
			$room = implode(",", $_POST['room_cod']);
		}
		if (isset($_POST['region_cod'])) {
			$region = implode(",", $_POST['region_cod']);
		}
		if (isset($_POST['pfb_fio']) && $_POST['pfb_fio'] != null) {
			$contact = $contact . $_POST['pfb_fio'] . '<br/>';
		}
		if (isset($_POST['pfb_phon']) && $_POST['pfb_phon'] != null) {
			$contact = $contact . 'Тел:&nbsp;' . $_POST['pfb_phon'] . '<br/>';
		}
		if (isset($_POST['pfb_e_mail']) && $_POST['pfb_e_mail'] != null) {
			$contact = $contact . 'Эл. почта:&nbsp;' . $_POST['pfb_e_mail'];
		}
		$result = mysql_query("SELECT UUID()") or die("Couldn t execute query." . mysql_error());
		$UUID = mysql_result($result, 0);
		$insertSQL = sprintf("INSERT INTO tbl_fbuy (UUID, Contact, Header, type_cod, room_cod, region_cod, price_fb, comm_fb) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
			GetSQLValueString($UUID, "text"),
			GetSQLValueString($contact, "text"),
			GetSQLValueString($_POST['header_fb'], "text"),
			GetSQLValueString($_POST['type_cod'], "int"),
			GetSQLValueString($room, "text"),
			GetSQLValueString($region, "text"),
			GetSQLValueString(preg_replace('/([^\d])/', "", $_POST['price_fb']), "int"),
			GetSQLValueString($_POST['comm_fb'], "text"));
		if (isset($_POST['action_pb']) && $_POST['action_pb'] == 'submitted') {
			if (mysql_query($insertSQL) == 'true') {
				echo '<span class="mark-field">Вы добавили объявление в раздел: КУПЛЮ</span><br/>';
				echo '<span class="mark-field">Заголовок объявления:&nbsp;&nbsp;</span><br/>' . $_POST['header_fb'] . '<br/>';
				echo '<span class="mark-field">Текст объявления:</span><br/>' . $_POST['comm_fb'];
				echo "<br/><span class='mark-field'>Ваша контактная информация:</span><br/>$contact";
				echo '<p><span class="red redline">Примечание: Объявления, размещенные в разделе "Куплю", проходят постмодерацию и доступны  авторизованным пользователям. При наличии подходящих для Вас вариантов продажи, с Вами свяжется специалист-риэлтор для дальнейшего сотрудничества.</span></p>';
				echo '<a href="#" class="tabs-back-button" title="Вернуться к вариантам продажи">Вернуться к вариантам продажи</a>';
			} else {
				die("Ошибка при размещении Вашего объявления: " . mysql_error());
			}
		}
	}
	if ((isset ($_POST["MM_insert"])) && ($_POST["MM_insert"] == "add_advert_form")) {
		if (isset ($_POST['fio']) && $_POST['fio'] != null) {
			$contact = $contact . $_POST['fio'] . '<br/>';
		}
		if (isset ($_POST['phon']) && $_POST['phon'] != null) {
			$contact = $contact . 'Тел:&nbsp;' . $_POST['phon'] . '<br/>';
		}
		if (isset ($_POST['e_mail']) && $_POST['e_mail'] != null) {
			$contact = $contact . 'Эл. почта:&nbsp;' . $_POST['e_mail'];
		}
		// парсинг формулы /////////////////////
		$formula = $_POST['formula'];
$formula = (isset($_POST['formula']) && strval($_POST['formula'] && !empty($_POST['formula']))) ? htmlspecialchars(trim(rtrim($_POST['formula']))) : null;
//парсинг формулы /////////////////////
if (!is_null($formula)) {
	$formula_array = formulaParser($formula, $type);
	$formula = $formula_array[0];
	$result = $formula_array[1];
	$type = $formula_array[2];
}
		if ($contact != null) {
			$source = "0";
			$treated = "0";
		} else {
			$agent_cod = (isset ($_POST['agent_cod']) && intval($_POST['agent_cod'] && !empty ($_POST
				['agent_cod']))) ? $_POST['agent_cod'] : null;
			$source = "1";
			$treated = "1";
		}
		// //////////////////////////
		// $uuid = substr(md5(uniqid(mt_rand())),0,5);
		$tmp_array = createParticipants();
		$uuid = $tmp_array[0];
		// ///////////////////////////
		// $filepath = $_POST['filepath_u'];
		$filepath = (isset($_POST['filepath_u']) && strval($_POST['filepath_u'] && !empty($_POST['filepath_u']))) ? '.' . $_POST['filepath_u'] : null;
		// chmod($filepath, 0777);
		if (is_dir($filepath)) {
			$dir_list = scandir($filepath);
			$file_list = array();
			foreach ($dir_list as $value) {
				if (!is_dir($value)) {
					$file_list[] = $value;
				}
			}
			$count = count($file_list);
		}
		// ///////////////////////////
		$insertSQL = sprintf("INSERT INTO tbl_exchange (UUID, Date, Type_Exchange, Formula, Result, Description, Source, Treated, agent_cod, Contact, foto, last_update) VALUES (%s, Now(), %s, %s, %s, %s, %s, %s, %s, %s, %s, Now())",
			GetSQLValueString($uuid, "text"),
			GetSQLValueString($type, "int"),
			GetSQLValueString($formula, "text"),
			GetSQLValueString($result, "text"),
			GetSQLValueString($_POST['description'], "text"),
			GetSQLValueString($source, "int"),
			GetSQLValueString($treated, "int"),
			GetSQLValueString($agent_cod, "text"),
			GetSQLValueString($contact, "text"),
			GetSQLValueString($count, "int"));
		if (isset ($_POST['action']) && $_POST['action'] == 'submitted') {
			$Result1 = mysql_query($insertSQL, $realtorplus) or die(mysql_error());
			if (!empty($file_list)) {
				foreach ($file_list as $file) {
					$image = file_get_contents($filepath . $file);
					$image = mysql_real_escape_string($image);
					$insert_file = ("INSERT INTO tbl_file (UUID, content) VALUES('{$uuid}', '{$image}')"
					);
					$Result1 = mysql_query($insert_file, $realtorplus) or die(mysql_error());
					unlink($filepath . $file);
				}
			}
			if (is_dir($filepath))
				rmdir($filepath);
			echo '<span>Ваш вариант обмена добавлен! Вы можете продолжить размещение объявлений или <a id="back_exchanges_all" href="#">Вернуться к вариантам обмена.</a></span>';
			if ($contact != null) {
			echo '<br/><span class="mark-field">Объявление в разделе:&nbsp;&nbsp;</span>';
			($type == "0") ? print "съезд." : print "разъезд.";
			echo '<br/><span class="mark-field">Вариант обмена:&nbsp;&nbsp;</span>';
			($type == "0") ? print '&nbsp;' . $formula . "=" . $result : print '&nbsp;' . $result . "=" . $formula;
			echo '<br/><span class="mark-field">Текст объявления:</span><br/>';
			echo $_POST['description'];
				echo "<br/><span class='mark-field'>Ваша контактная информация:</span><br/>$contact<p><span class='red redline'>Примечание: Объявления, размещенные в разделе \"Обмен квартир\", проходят постмодерацию. В ближайшее время с Вами свяжется специалист для дальнейшего сотрудничества и размещения объявления в общем разделе.</span></p>";
			}
			unset ($_SESSION['captcha_keystring']);
		}
	}
}
?>
