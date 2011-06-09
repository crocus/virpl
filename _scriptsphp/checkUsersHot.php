<?php
	require_once('r_conn.php');
	include ('services.php');
	require_once('session.inc');
	session_start();
	if(isset($_COOKIE["inquery"])&& !empty($_COOKIE["inquery"])) {
		$prptinquery = searchFromParticipants($_COOKIE["inquery"]);
	} else {
		$prptinquery = null;
	}
	$prpt_query = (isset($prptinquery) && !empty($prptinquery)) ? " And agent_cod in ($prptinquery)" : null;
	$counted_query = "SELECT UUID FROM tbl_flats WHERE hot_affair = 1". $prpt_query;
	$result = mysql_query($counted_query) or die ("Couldn t execute query.".mysql_error());
	if(mysql_num_rows($result) >0){
		$count_array = array();
		while($obj = mysql_fetch_row($result)) {
			$count_array["UUID"] = $obj;
		}
		echo json_encode($count_array);
	} else {
		echo '{ UUID: "false" }';
	}
?>
