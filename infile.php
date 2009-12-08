<?php 
require_once('_scriptsphp/r_conn.php');
 $agency = $_GET['agency']; 
 mysql_select_db($database_realtorplus, $realtorplus);
	$query_del=("DELETE LOW_PRIORITY tbl_flats FROM tbl_flats, tbl_agent  WHERE tbl_flats.agent_cod =  tbl_agent.agent_cod AND  tbl_agent.agency_cod={$agency}");
	$del = mysql_query($query_del) or die(mysql_error());
	$query_update= ("LOAD DATA LOCAL INFILE ".
	 "'/home/public_html/admin.sql' INTO TABLE tbl_flats ".
	 "FIELDS TERMINATED BY ';' LINES TERMINATED BY '\r\n' (sale_cod, type_cod, So, Sz, Sk, plan_cod, wc_cod, balcon_cod, side_cod, cond_cod, flats_comments, agent_cod, flats_date, flats_tel, street_cod, flats_price, room_cod, flats_floor, flats_floorest, material_cod, flats_adress, flats_confid, foto, sale, date_sale, price_sale)");
  	$update = mysql_query($query_update) or die(mysql_error());
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>ООО"Фолиант"- недвижимость Владивостока</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
</head>

<body bgcolor="#F1DABC">
<font color="#993333">Обновление сервера благополучно завершено!!! </font>
</body>
</html>







