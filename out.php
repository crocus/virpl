<?php 
/*$database_realtorplus = "foliant_realtorplus";
$realtorplus = mysql_connect("localhost", "foliant_crocus", "negacxit") or die ('I cannot connect to the database because: ' . mysql_error());*/
include('_scriptsphp/r_conn.php');
$agency = $_GET['agency']; 
 
	$query_Recordset1= ("SELECT sale_cod, type_cod, So, Sz, Sk, plan_cod, wc_cod, balcon_cod, side_cod, cond_cod, flats_comments, tbl_flats.agent_cod, flats_date, flats_tel, street_cod, flats_price, room_cod, flats_floor, flats_floorest, material_cod, flats_adress, flats_confid, foto, sale, date_sale, price_sale".
	 " FROM tbl_flats, tbl_agent, tbl_agency WHERE tbl_flats.agent_cod = tbl_agent.agent_cod AND tbl_agency.agency_cod = tbl_agent.agency_cod AND tbl_agency.agency_cod != ".$agency. ";");
  	$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
	 $sp = fopen("/home/foliant/inlocal.sql",'w+'); 
	 do {  
$r= sprintf($row_Recordset1['sale_cod'] . ";".$row_Recordset1['type_cod'] . ";".$row_Recordset1['So'] . ";".$row_Recordset1['Sz']  . ";".$row_Recordset1['Sk'] .  ";".$row_Recordset1['plan_cod'] . ";".$row_Recordset1['wc_cod'] . ";".$row_Recordset1['balcon_cod'] . ";".$row_Recordset1['side_cod'] . ";".
$row_Recordset1['cond_cod'] . ";".$row_Recordset1['flats_comments'] . ";".$row_Recordset1['agent_cod'] . ";".$row_Recordset1['flats_date'] . ";".$row_Recordset1['flats_tel'] . ";".$row_Recordset1['street_cod'] .";".$row_Recordset1['flats_price'] .";".$row_Recordset1['room_cod'] .";".$row_Recordset1['flats_floor'] .";".$row_Recordset1['flats_floorest'] .
";".$row_Recordset1['material_cod'] .";".$row_Recordset1['flats_adress'] .";".$row_Recordset1['flats_confid'] .";".$row_Recordset1['foto'] .";".$row_Recordset1['sale'] .";".$row_Recordset1['date_sale'] .";".$row_Recordset1['price_sale'] ."\r\n");
fputs($sp, $r);
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
$file="/home/foliant/inlocal.sql";
fclose($sp);
$data = implode("", file("/home/foliant/inlocal.sql"));
$gzdata = gzencode($data,9);
$fp = fopen("update.gz","w+");
fwrite($fp, $gzdata);
    fclose($fp); 
?>








