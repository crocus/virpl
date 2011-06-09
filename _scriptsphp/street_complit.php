<?php
	header('Content-Type: text/html; charset=utf-8');
	include('r_conn.php');
	require_once('services.php');
	if (isset( $_GET['id']) && !empty($_GET['id'])) {
		$id = implode(",", $_GET['id']);
	} else {
		$id=1;
	}
	$query_param= "SELECT f.street_cod AS Id, s.street_name AS Name 
	FROM tbl_street s
	INNER JOIN tbl_flats f ON f.street_cod = s.street_cod AND f.sale=0
	WHERE s.region_cod IN ({$id}) GROUP BY f.street_cod ORDER BY Name ASC";
	$Recordset = mysql_query($query_param, $realtorplus) or die(mysql_error());
	$arr = array();
	while($obj = mysql_fetch_assoc($Recordset)) {
		$arr[] = $obj;
	}
	$first_json_str = json_encode($arr);
	$last_json_str = utf8_JSON_russian_cyr($first_json_str);
	echo $last_json_str;
	unset($id);
?>