<?php
//include ('services.php');
header('Content-Type: text/html; charset=utf-8');
echo $_SERVER['REMOTE_ADDR'];
//$prpt_name="ASASSA ASS  ASAS ";
$prpt_name="Фолиант2";

$prpt_name = trim($prpt_name);
//$prpt_name_array = explode(" ", $prpt_name);
//$i=0;
//foreach ($prpt_name_array as $field) {
//    $field = trim($field);
//    $prpt_name_array[$i] = str_replace($field, ucwords_utf8($field) ,$field);
//    $i++;
//}
//$valid_name = implode(" ", $prpt_name_array);
$valid_name = ucwords_utf8($prpt_name);
echo mb_strlen($valid_name, "UTF-8")."<br/>";
echo "<br />". $valid_name;

function ucwords_utf8($string) {
	$string = mb_convert_case(mb_convert_case($string, MB_CASE_LOWER, "UTF-8"), MB_CASE_TITLE, "UTF-8");
	return $string;
}
?>
