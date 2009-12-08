<?php
require_once('r_conn.php');
include ('services.php');
include('./rdate/rdate.php');
$counted_query = "SELECT COUNT(*) as result FROM tbl_flats WHERE sale = 0 And DATEDIFF(NOW(), last_update) < 14". 
	" UNION ALL SELECT MIN(flats_price) as result FROM tbl_flats WHERE sale = 0 And DATEDIFF(NOW(), last_update) < 14". 
	" UNION ALL SELECT MAX(flats_price) as result FROM tbl_flats WHERE sale = 0 And DATEDIFF(NOW(), last_update) < 14".
	" UNION ALL SELECT UNIX_TIMESTAMP(MAX(last_update)) as result FROM tbl_flats WHERE sale = 0";
$result = mysql_query($counted_query) or die ("Couldn t execute query.".mysql_error());
$count_array = array();
$i=0;
while($obj = mysql_fetch_assoc($result)) {	
	switch($i) {
		case 0:
			$count_array["sale"]["actual"] = $obj['result'];
			break;
		case 1:
			$count_array["price"]["min"] = number_format($obj['result'], 0, '.', ' ');
			break;
		case 2:
			$count_array["price"]["max"] = number_format($obj['result'], 0, '.', ' ');
			break;
		case 3:
			$count_array["last"]["dated"] = timeLeftOnFact($obj['result']);
			break;
	}
	$i++;
}
$first_json_str = json_encode($count_array);
$last_json_str = utf8_JSON_russian_cyr($first_json_str);
echo $last_json_str;
//echo json_encode($count_array);
?>