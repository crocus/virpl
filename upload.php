<?php
require_once('_scriptsphp/r_conn.php');
$uploaddir = '/home/public_html/';
move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir . $_FILES['userfile']['name']);
 $agency = $_POST['agency']; 
 mysql_select_db($database_realtorplus, $realtorplus);
	$query_del=("DELETE LOW_PRIORITY tbl_flats FROM tbl_flats, tbl_agent  WHERE tbl_flats.agent_cod =  tbl_agent.agent_cod AND  tbl_agent.agency_cod={$agency}");
	$del = mysql_query($query_del) or die(mysql_error());
	/*$query_update= ("LOAD DATA LOCAL INFILE  '/home/public_html/admin.sql' INTO TABLE tbl_flats FIELDS TERMINATED BY ', ' OPTIONALLY  ENCLOSED BY '\'' LINES TERMINATED BY '\r\n' (sale_cod, type_cod, So, Sz, Sk, plan_cod, wc_cod, balcon_cod, side_cod, cond_cod,  flats_comments, agent_cod, flats_date, flats_tel, street_cod, flats_price, room_cod, flats_floor, flats_floorest, material_cod, sale, date_sale, price_sale)");
  	$update = mysql_query($query_update) or die(mysql_error());*/
	$lines = file("/home/public_html/update");
// Осуществим проход массива и выведем номера строк и их содержимое в виде HTML-кода.
/////$query_Recordset1= ("INSERT INTO `tbl_flats` (sale_cod, type_cod, So, Sz, Sk, plan_cod, wc_cod, balcon_cod, side_cod, cond_cod,  /////flats_comments, agent_cod, flats_date, flats_tel, street_cod, flats_price, room_cod, flats_floor, flats_floorest, material_cod, sale,///// date_sale, price_sale) VALUES ");
$query_Recordset1= ("INSERT INTO `tbl_flats` (sale_cod, type_cod, So, Sz, Sk, plan_cod, wc_cod, balcon_cod, side_cod, cond_cod, flats_comments, agent_cod, flats_date, flats_tel, street_cod, flats_price, room_cod, flats_floor, flats_floorest, material_cod, flats_adress, flats_confid, foto, sale, date_sale, price_sale) VALUES ");
 foreach ($lines as $line_num => $line) {
   $r = sprintf("(" . $line . ");\r\n"); 
   $update_agency =$query_Recordset1 . $r;
   $Recordset1 = mysql_query($update_agency) or die(mysql_error());
}
unlink("/home/public_html/update");
?>