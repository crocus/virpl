<?php
ob_start("ob_gzhandler");
require_once('r_conn.php');
require_once('session.inc');
session_start();
$counted_query = "SELECT type_cod, room_cod,  COUNT(*) as count FROM `tbl_flats`";
if(isset($_SESSION['user'])&& !empty($_SESSION['user'])){
		$counted_query.= " WHERE sale = 0 And DATEDIFF(NOW(), last_update) <= 14";
	} else {
		$counted_query.= " WHERE sale = 0 And Treated = 1 And DATEDIFF(NOW(), last_update) <= 14";
	}
$counted_query.= " GROUP BY type_cod, room_cod;";	
$result = mysql_query($counted_query) or die ("Couldn t execute query.".mysql_error());
$count_array = array();
while ($obj = mysql_fetch_assoc($result))
{
	$count_array[] = $obj;
}
echo json_encode($count_array);
ob_end_flush();
?>
