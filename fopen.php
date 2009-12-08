<?php
require_once('_scriptsphp/r_conn.php');
 $agency = $_GET['agency']; 
 mysql_select_db($database_realtorplus, $realtorplus);
	$query_del=("DELETE LOW_PRIORITY tbl_flats FROM tbl_flats, tbl_agent  WHERE tbl_flats.agent_cod = tbl_agent.agent_cod AND tbl_agent.agency_cod={$agency};");
	$del = mysql_query($query_del) or die(mysql_error());
$lines = file("/home/public_html/admin.sql");
// Осуществим проход массива и выведем номера строк и их содержимое в виде HTML-кода.
$query_Recordset1= ("INSERT INTO `tbl_flats` (sale_cod, type_cod, So, Sz, Sk, plan_cod, wc_cod, balcon_cod, side_cod, cond_cod,  flats_comments, agent_cod, flats_date, flats_tel, street_cod, flats_price, room_cod, flats_floor, flats_floorest, material_cod, sale, date_sale, price_sale) VALUES ");
 foreach ($lines as $line_num => $line) {
   $r = sprintf("(" . $line . ");\r\n"); 
   $update_agency =$query_Recordset1 . $r;
   $Recordset1 = mysql_query($update_agency) or die(mysql_error());
}
unlink("/home/public_html/admin.sql");
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>ООО"Фолиант"- недвижимость Владивостока</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
</head>

<body bgcolor="#F1DABC">
<font color="#993333">Обновление сервера благополучно завершено!!! </font>
</body>
</html>

