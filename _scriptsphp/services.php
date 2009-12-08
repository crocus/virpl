<?php
include('r_conn.php');
function createParticipants() {
	$result = mysql_query( "SELECT UUID()" ) or die("Couldn t execute query.".mysql_error());
	$row = mysql_fetch_assoc($result);
	$UUID = mysql_result($result,0);
	$result = mysql_query( "INSERT INTO tbl_participants SET UUID ='{$UUID}'" ) or die("Couldn t execute query.".mysql_error());
	$result = mysql_query( "SELECT participants_id FROM  tbl_participants WHERE UUID ='{$UUID}'" ) or die("Couldn t execute query.".mysql_error());
	$pid= mysql_result($result,0);
	return array($UUID, $pid);
}
//function rightNameParticipant($prpt_name) {
//    $prpt_name = trim($prpt_name);
//    $prpt_name_array = explode(" ", $prpt_name);
//    $i=0;
//    foreach ($prpt_name_array as $field) {
//        $field = trim($field);
//        $prpt_name_array[$i] = str_replace($field, ucwords_utf8($field) ,$field);
//        $i++;
//    }
//    $valid_name = implode(" ", $prpt_name_array);
//    return $valid_name;
//
//};
function createParticipant($prpt_fld_array, $tmp_p_array) {
	$cur_uuid = $tmp_p_array[0];
	$cur_id =  $tmp_p_array[1];
	$new_prpt_query = ("INSERT INTO `tbl_participants_catalog` (`participants_id`, `participants_property_id`, `value_property`) VALUES ");
	if (array_key_exists("name", $prpt_fld_array))
		$new_prpt_query.= "(" . $cur_id . ", 1, '" . ucwords_utf8($prpt_fld_array['name']) . "')," ;
	if (array_key_exists("email", $prpt_fld_array))
		$new_prpt_query.= "(" . $cur_id . ", 2, '" . $prpt_fld_array['email'] . "')," ;
	if (array_key_exists("role", $prpt_fld_array))
		$new_prpt_query.= "(" . $cur_id . ", 3, '" . $prpt_fld_array['role'] . "')," ;
	if (array_key_exists("access", $prpt_fld_array))
		$new_prpt_query.= "(" . $cur_id . ", 4, '" . $prpt_fld_array['access'] . "')," ;
	if (array_key_exists("login", $prpt_fld_array))
		$new_prpt_query.= "(" . $cur_id . ", 5, '" . $prpt_fld_array['login'] . "')," ;
	if (array_key_exists("password", $prpt_fld_array))
		$new_prpt_query.= "(" . $cur_id . ", 6, '" . $prpt_fld_array['password'] . "')," ;
	if (array_key_exists("type_group", $prpt_fld_array))
		$new_prpt_query.= "(" . $cur_id . ", 7, '" . $prpt_fld_array['type_group'] . "')," ;
	if (array_key_exists("inn", $prpt_fld_array))
		$new_prpt_query.= "(" . $cur_id . ", 9, '" . $prpt_fld_array['inn'] . "')," ;
	if (array_key_exists("parent_group", $prpt_fld_array))
		$new_prpt_query.= "(" . $cur_id . ", 14, '" . $prpt_fld_array['parent_group'] . "')," ;
	if (array_key_exists("show_phon", $prpt_fld_array))
		$new_prpt_query.= "(" . $cur_id . ", 11, '" . $prpt_fld_array['show_phon'] . "')," ;
	if (array_key_exists("moderated", $prpt_fld_array))
		$new_prpt_query.= "(" . $cur_id . ", 12, '" . $prpt_fld_array['moderated'] . "')," ;
	$new_prpt_query.= "(" . $cur_id . ", 15, '" . $cur_uuid . "')," ;
	$new_prpt_query.= "(" . $cur_id . ", 16, 'N');" ;
	return $new_prpt_query;
}
function updateParticipant($prpt_fld_array, $tmp_p_array) {
	$cur_uuid = $tmp_p_array[0];
	$cur_id =  $tmp_p_array[1];
	$new_prpt_query = ("INSERT INTO `tbl_participants_catalog` (`participants_id`, `participants_property_id`, `value_property`) VALUES ");
	if (array_key_exists("name", $prpt_fld_array))
		$new_prpt_query.= "(" . $cur_id . ", 1, '" . ucwords_utf8($prpt_fld_array['name']) . "')," ;
	if (array_key_exists("email", $prpt_fld_array))
		$new_prpt_query.= "(" . $cur_id . ", 2, '" . $prpt_fld_array['email'] . "')," ;
	if (array_key_exists("role", $prpt_fld_array))
		$new_prpt_query.= "(" . $cur_id . ", 3, '" . $prpt_fld_array['role'] . "')," ;
	if (array_key_exists("access", $prpt_fld_array))
		$new_prpt_query.= "(" . $cur_id . ", 4, '" . $prpt_fld_array['access'] . "')," ;
	if (array_key_exists("login", $prpt_fld_array))
		$new_prpt_query.= "(" . $cur_id . ", 5, '" . $prpt_fld_array['login'] . "')," ;
	if (array_key_exists("password", $prpt_fld_array))
		$new_prpt_query.= "(" . $cur_id . ", 6, '" . $prpt_fld_array['password'] . "')," ;
	if (array_key_exists("type_group", $prpt_fld_array))
		$new_prpt_query.= "(" . $cur_id . ", 7, '" . $prpt_fld_array['type_group'] . "')," ;
	if (array_key_exists("inn", $prpt_fld_array))
		$new_prpt_query.= "(" . $cur_id . ", 9, '" . $prpt_fld_array['inn'] . "')," ;
	if (array_key_exists("parent_group", $prpt_fld_array))
		$new_prpt_query.= "(" . $cur_id . ", 14, '" . $prpt_fld_array['parent_group'] . "')," ;
	if (array_key_exists("show_phon", $prpt_fld_array))
		$new_prpt_query.= "(" . $cur_id . ", 11, '" . $prpt_fld_array['show_phon'] . "')," ;
	if (array_key_exists("moderated", $prpt_fld_array))
		$new_prpt_query.= "(" . $cur_id . ", 12, '" . $prpt_fld_array['moderated'] . "')," ;
	$new_prpt_query.= "(" . $cur_id . ", 15, '" . $cur_uuid . "')," ;
	$new_prpt_query.= "(" . $cur_id . ", 16, 'N');" ;
	return $new_prpt_query;
}
function getParentGroup($parent_prpt) {
	$result = mysql_query( "SELECT Participants_id FROM `tbl_participants_catalog` WHERE Participants_property_id = 1 And value_property ='{$parent_prpt}'" ) or die("Couldn t execute query.".mysql_error());
	return mysql_result($result,0);
};
function ucwords_utf8($string) {
	$string = mb_convert_case(mb_convert_case($string, MB_CASE_LOWER, "UTF-8"), MB_CASE_TITLE, "UTF-8");
	return $string;
};
function strtolower_utf8($string) {
	$string = mb_convert_case($string, MB_CASE_LOWER, "UTF-8");
	return $string;
};
function utf8_JSON_russian_cyr($str) {
	$arr_replace_symbols = array
		(
		'\u0410' => 'А', '\u0430' => 'а',
		'\u0411' => 'Б', '\u0431' => 'б',
		'\u0412' => 'В', '\u0432' => 'в',
		'\u0413' => 'Г', '\u0433' => 'г',
		'\u0414' => 'Д', '\u0434' => 'д',
		'\u0415' => 'Е', '\u0435' => 'е',
		'\u0401' => 'Ё', '\u0451' => 'ё',
		'\u0416' => 'Ж', '\u0436' => 'ж',
		'\u0417' => 'З', '\u0437' => 'з',
		'\u0418' => 'И', '\u0438' => 'и',
		'\u0419' => 'Й', '\u0439' => 'й',
		'\u041a' => 'К', '\u043a' => 'к',
		'\u041b' => 'Л', '\u043b' => 'л',
		'\u041c' => 'М', '\u043c' => 'м',
		'\u041d' => 'Н', '\u043d' => 'н',
		'\u041e' => 'О', '\u043e' => 'о',
		'\u041f' => 'П', '\u043f' => 'п',
		'\u0420' => 'Р', '\u0440' => 'р',
		'\u0421' => 'С', '\u0441' => 'с',
		'\u0422' => 'Т', '\u0442' => 'т',
		'\u0423' => 'У', '\u0443' => 'у',
		'\u0424' => 'Ф', '\u0444' => 'ф',
		'\u0425' => 'Х', '\u0445' => 'х',
		'\u0426' => 'Ц', '\u0446' => 'ц',
		'\u0427' => 'Ч', '\u0447' => 'ч',
		'\u0428' => 'Ш', '\u0448' => 'ш',
		'\u0429' => 'Щ', '\u0449' => 'щ',
		'\u042a' => 'Ъ', '\u044a' => 'ъ',
		'\u042d' => 'Ы', '\u044b' => 'ы',
		'\u042c' => 'Ь', '\u044c' => 'ь',
		'\u042d' => 'Э', '\u044d' => 'э',
		'\u042e' => 'Ю', '\u044e' => 'ю',
		'\u042f' => 'Я', '\u044f' => 'я',
		'\/' => '/', '\"' => '\''
	);
	foreach($arr_replace_symbols as $from_gluk => $to_normal) {
		$str = str_replace ($from_gluk,$to_normal,$str);
	}
	return $str;
};
function createContact($fio, $phon, $email) {
	if(isset($fio) && !empty($fio)) {
		$client_contact = 'Разместил:&nbsp;' . $fio . '<br/>';
	}
	if(isset($phon) && !empty($phon)) {
		$client_contact = $client_contact . 'Тел:&nbsp;' . $phon. '<br/>';
	}
	if(isset($email)&& !empty($email)) {
		$client_contact = $client_contact . 'Эл. почта:&nbsp;' . $email;
	}
	return $client_contact;
};
function formulaParser($formula, $type) {
	while ( strpos($formula,' ')!==false ) {
		$formula = str_replace(' ','',$formula);
	}
	while ( strpos($formula,'.')!==false ) {
		$formula = str_replace('.','',$formula);
	}
	$findme  = '=';
	$pos = strpos($formula, $findme);

	if ($pos === false) {
	//   echo "Не корректно задана формула.";
	} else {
	//  echo "Строка '$findme' найдена в строке '$mystring1'";
	//  echo " в позиции $pos";
	}
	$rest = substr(strpbrk($formula, '='), 1);
	$before_eqv = substr($formula, 0, $pos);

	if($pos == NULL) {
	} elseif($pos <= "2" ) {
		$formula = $rest;
		$result = $before_eqv;
		if($type==NULL && $pos!= NULL)
			$type='1';
	} else {
		$formula = $before_eqv;
		$result = $rest;
		if($type==NULL && $pos!= NULL)
			$type='0';
	}
	return array($formula, $result, $type);
//попытка обработки равноценных
/*if(strlen($formula)== strlen($result)){
$type = NULL;
($formula>=$result && $type==NULL && $pos!= NULL)? $type='0':$type='1';
} */
////////////////////
};
function searchFromParticipants($prpt_array) {
	$pieces = explode(",", $prpt_array);
	$result_array = array();
	$is_end_prpt = false;
	foreach($pieces as $value) {
		$tmp_array = getParticipantsForSearch($value);
		echo $is_end_prpt;
		$new = array();
		foreach ($tmp_array as $v1) {
			foreach ((array)$v1 as $key=>$v2) {
				if($key == 'id') {
					$new[]= $v2;
				}
			}
		}
		$c_intersect = count(array_intersect($pieces, $new));
		if (($c_intersect == 0) || (array_key_exists("flag", $tmp_array)== "true")) {
			$result_array = array_merge($result_array, $tmp_array);
		}
		unset($new);
		unset($tmp_array);
	}
	foreach ($result_array as $result_e) {
		foreach ((array)$result_e as $keyuuid=>$valuuid) {
			if($keyuuid == 'uuid')
				$returned_array[]= "'".$valuuid."'";
		}
	}
	unset($pieces);
	return implode(",", $returned_array);
};
function getParticipantsForSearch($prpt_id) {
	$result = mysql_query( "SELECT participants_id as Id, UUID FROM vw_participants WHERE parents_id = {$prpt_id}" ) or die("Couldn t execute query.".mysql_error());
	if (mysql_num_rows($result) === 0) {
		$_array['flag']="elevel";
		$result = mysql_query( "SELECT participants_id as Id, UUID FROM vw_participants WHERE participants_id = {$prpt_id}" ) or die("Couldn t execute query.".mysql_error());
	}
	$i=0;
	while ($object = mysql_fetch_array($result)) {
		$_array[$i]['id']= $object[Id];
		//$tmp_array[$i]['name'] = $object[Name];
		$_array[$i]['uuid'] = $object[UUID];
		$i++;
	}
	return $_array;
};
function parsePhon($phons) {
	$pattern = '/([^\d,])/';
	$replacement = "";
	$phons = preg_replace($pattern, $replacement, $phons);
	$phons_array = explode(",", $phons);
	$i=0;
	foreach ($phons_array as $phon) {
		if(strlen($phon)===11) {
			$phons_array[$i] = str_replace($phon, substr_replace($phon,'', 0, 1),$phon);
		}
		$i++;
	}
	return $phons_array;
};
function clear_array_empty($array)
{
$ret_arr = array();
foreach($array as $val)
{
	if (!empty($val))
	{
		$ret_arr[] = trim($val);
	}
}
return $ret_arr;
};
?>