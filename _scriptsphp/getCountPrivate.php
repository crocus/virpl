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
	$counted_query = "SELECT COUNT(*) as count FROM tbl_flats WHERE sale = 0 AND DATEDIFF(NOW(), last_update) <= 14". $prpt_query.
	" UNION ALL SELECT COUNT(*) as count FROM tbl_flats WHERE sale = 0 AND DATEDIFF(NOW(), last_update) > 14". $prpt_query.
	" UNION ALL SELECT COUNT(*) as count FROM tbl_flats WHERE sale = 0 AND DATEDIFF(NOW(), last_update) = 14". $prpt_query.
	" UNION ALL SELECT COUNT(*) as count FROM tbl_exchange WHERE DATEDIFF(NOW(), last_update) <= 14". $prpt_query.
	" UNION ALL SELECT COUNT(*) as count FROM tbl_exchange WHERE DATEDIFF(NOW(), last_update) > 14". $prpt_query.
	" UNION ALL SELECT COUNT(*) as count FROM tbl_flats WHERE flats_claim = 1". $prpt_query;
	/*  $counted_query = "SELECT CAST('sale' AS CHAR(8)) AS category, CAST('actual' AS CHAR(8)) AS age, COUNT(*) AS COUNT FROM tbl_flats WHERE DATEDIFF(NOW(), last_update) <= 14 ".
	"UNION SELECT CAST('exchange' AS CHAR(8)),CAST('actual' AS CHAR(8)), COUNT(*) FROM tbl_exchange WHERE DATEDIFF(NOW(), last_update) <= 14 ".
	"UNION SELECT CAST('sale' AS CHAR(8)),CAST('outdated' AS CHAR(8)), COUNT(*) FROM tbl_flats WHERE DATEDIFF(NOW(), last_update) > 14 ".
	"UNION SELECT CAST('exchange' AS CHAR(8)),CAST('outdated' AS CHAR(8)), COUNT(*) FROM tbl_exchange WHERE DATEDIFF(NOW(), last_update) > 14";
	*/
	$result = mysql_query($counted_query) or die ("Couldn t execute query.".mysql_error());
	$count_array = array();
	$i=0;
	while($obj = mysql_fetch_row($result)) {
		switch($i) {
			case 0:
				$count_array["sale"]["actual"] = $obj;
				break;
			case 1:
				$count_array["sale"]["outdated"] = $obj;
				break;
			case 2:
				$count_array["sale"]["outnow"] = $obj;
				break;	
			case 3:
				$count_array["exchange"]["actual"] = $obj;
				break;
			case 4:
				$count_array["exchange"]["outdated"] = $obj;
				break;
			case 5:
				$count_array["claim"]["actual"] = $obj;
				break;
		}
		$i++;
	}
	/*while($obj = mysql_fetch_array($result, MYSQL_NUM )) {
	$count_array[] = $obj;

	}*/
	echo json_encode($count_array);
?>
