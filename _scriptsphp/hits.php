<?php
	ob_start("ob_gzhandler");
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
	header('Cache-Control: no-store, no-cache, must-revalidate'); 
	header('Cache-Control: post-check=0, pre-check=0', FALSE); 
	header('Pragma: no-cache');
	require_once('r_conn.php');
	if(isset($_REQUEST["UUID"])&& !empty($_REQUEST["UUID"])) {
		$UUID = $_REQUEST["UUID"];
		$ip = $_SERVER['REMOTE_ADDR'];
		/*$result = mysql_query("SELECT UUID, Ip FROM tbl_hits WHERE UUID = '{$UUID}' AND Ip = '{$ip}'") or die ("Couldn t execute query.".mysql_error());
		if (mysql_num_rows($result) > 0) {
			$result = mysql_query( "UPDATE tbl_hits SET Hits = Hits+1 WHERE UUID ='{$UUID}' AND Ip = '{$ip}'" ) or die("Couldn t execute query.".mysql_error());
		} else {
			$result = mysql_query( "INSERT INTO tbl_hits (UUID, Ip, Hits) VALUES ('{$UUID}', '{$ip}', 1)" ) or die("Couldn t execute query.".mysql_error());
		}*/
		$result = mysql_query( "INSERT INTO tbl_hits (UUID, Ip, Hits) VALUES ('{$UUID}', '{$ip}', 1)" ) or die("Couldn t execute query.".mysql_error());
	}
	$union_hits = "SELECT SUM(Hits) as hit FROM tbl_hits WHERE UUID = '{$UUID}' AND DATEDIFF(Now(), Timestamp) = 0".
	" UNION ALL SELECT SUM(Hits) as hit FROM tbl_hits WHERE UUID = '{$UUID}'". 
	" UNION ALL SELECT COUNT(*) FROM (SELECT Ip FROM tbl_hits WHERE UUID = '{$UUID}' GROUP BY Ip) AS unque";
	$result = mysql_query($union_hits) or die ("Couldn t execute query.".mysql_error());
	$hit_array = array();
	$i=0;
	while($obj = mysql_fetch_row($result)) {
		switch($i) {
			case 0:
				$hit_array["day"] = $obj;
				break;
			case 1:
				$hit_array["all"] = $obj;
				break;
			case 2:
				$hit_array["unique"] = $obj;
				break;
		}
		$i++;
	}
	echo json_encode($hit_array);
	ob_end_flush();
?>
