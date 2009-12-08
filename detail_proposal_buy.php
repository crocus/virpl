<?php 
require_once('_scriptsphp/r_conn.php');
include('_scriptsphp/services.php');
$query_Recordset2 = "SELECT fb.Id, fb.UUID, fb.Header, DATE_FORMAT( fb.Date, '%a %b %d %Y %H:%i:%s' ) AS Date, fb.Contact, t.type_name, fb.room_cod, fb.region_cod AS r_cod, GROUP_CONCAT( r.region_name
SEPARATOR ', ' ) AS regions, fb.price_fb, fb.comm_fb
FROM tbl_fbuy fb
LEFT OUTER JOIN tbl_type t ON t.type_cod = fb.type_cod
LEFT OUTER JOIN tbl_region r ON FIND_IN_SET( r.region_cod, fb.region_cod ) 
WHERE fb.Id =".intval($_GET['id'])."
GROUP BY fb.Id";
$Recordset2 = mysql_query($query_Recordset2, $realtorplus) or die(mysql_error());
$first_json_str = json_encode(mysql_fetch_assoc($Recordset2));
$last_json_str = utf8_JSON_russian_cyr($first_json_str);
echo $last_json_str;
mysql_free_result($Recordset2);  
?>