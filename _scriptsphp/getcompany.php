<?php
include('r_conn.php');
include('services.php');
mysql_select_db($database_realtorplus, $realtorplus);
$query_Recordset1= "SELECT pc.participants_id as Id, pn.value_property as Name 
FROM tbl_participants_catalog pc 
LEFT JOIN tbl_participants_catalog pn on (pn.participants_id = pc.participants_id AND pn.participants_property_id = 1)
WHERE pc.participants_property_id = 7 And pc.value_property = 7";
$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
$arr = array();
while($obj = mysql_fetch_assoc($Recordset1)) {
    $arr[] = $obj;
}
$first_json_str = json_encode($arr);
$last_json_str = utf8_JSON_russian_cyr($first_json_str);
echo $last_json_str;
?> 