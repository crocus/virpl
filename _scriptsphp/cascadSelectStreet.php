<?php
include('r_conn.php');
include('services.php');
$city = $_GET['city'];
$query_street= "SELECT street_cod as Id, street_name as Name 
FROM tbl_street  WHERE city_cod = {$city} ORDER BY Name ASC";
//{$city}";
  	$street = mysql_query($query_street) or die(mysql_error());
	$arr = array();
while($obj = mysql_fetch_assoc($street)){
$arr[] = $obj;
}
$first_json_str = json_encode($arr);
$last_json_str = utf8_JSON_russian_cyr($first_json_str);
echo $last_json_str;
?> 