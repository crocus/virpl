<?php
require_once('_scriptsphp/r_conn.php');
require_once('pclzip.lib.php');    
$agency = $_POST['agency']; 
$table = $_POST['table']; 
 mysql_select_db($database_realtorplus, $realtorplus);
  switch ( $table ) {
    case "tbl_agent.sql":
       $query_Recordset1= ("SELECT agent_cod, agency_cod, agent_mail, agent_pass, agent_name FROM tbl_agent WHERE tbl_agent.agency_cod!={$agency}");
  	$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
	 $sp = fopen("/home/public_html/{$table}",'w+'); 
	 do {  
$r= sprintf($row_Recordset1['agent_cod'] . ", ".$row_Recordset1['agency_cod'] . ", " . "'" .$row_Recordset1['agent_mail'] . "'" . ", " . "'" . $row_Recordset1['agent_pass'] . "'"  . ", " . "'" . $row_Recordset1['agent_name'] . "'" ."\r\n");
fputs($sp, $r);
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
$file="/home/public_html/{$table}";
fclose($sp);
         break;
		 
		  case "tbl_agency.sql":
		 $query_Recordset1= ("SELECT  agency_cod, agency_name, agency_mail, agency_access FROM tbl_agency WHERE agency_cod!={$agency}");
  	$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
	 $sp = fopen("/home/public_html/{$table}",'w+'); 
	 do {  
$r= sprintf($row_Recordset1['agency_cod'] . ", " . "'" . $row_Recordset1['agency_name'] . "'"  . ", " . "'" .$row_Recordset1['agency_mail'] . "'" . ", " . $row_Recordset1['agency_access'] ."\r\n");
fputs($sp, $r);
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
$file="/home/public_html/{$table}";
fclose($sp);
		  break;
		  
		   case "tbl_flats.sql":
		$query_Recordset1= ("SELECT  sale_cod, type_cod, So, Sz, Sk, plan_cod, wc_cod, balcon_cod, side_cod, cond_cod, flats_comments, tbl_flats.agent_cod, flats_date, flats_tel, street_cod, flats_price, room_cod, flats_floor, flats_floorest, material_cod, flats_adress, flats_confid, foto, sale, date_sale, price_sale".
	 " FROM tbl_flats, tbl_agent  WHERE tbl_flats.agent_cod =  tbl_agent.agent_cod AND  tbl_agent.agency_cod!={$agency}");
  	$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
	 $sp = fopen("/home/public_html/{$table}",'w+'); 
	 do {  
$r= sprintf($row_Recordset1['sale_cod'] . ", ".$row_Recordset1['type_cod'] . ", ".$row_Recordset1['So'] . ", ".$row_Recordset1['Sz']  . ", ".$row_Recordset1['Sk'] .  ", ".$row_Recordset1['plan_cod'] . ", ".$row_Recordset1['wc_cod'] . ", ".$row_Recordset1['balcon_cod'] . ", ".$row_Recordset1['side_cod'] . ", ".
$row_Recordset1['cond_cod'] . ", '".$row_Recordset1['flats_comments'] . "', ".$row_Recordset1['agent_cod'] . ", '".$row_Recordset1['flats_date'] . "', ".$row_Recordset1['flats_tel'] . ", ".$row_Recordset1['street_cod'] .", ".$row_Recordset1['flats_price'] .", ".$row_Recordset1['room_cod'] .", ".$row_Recordset1['flats_floor'] .", ".$row_Recordset1['flats_floorest'] .
", ".$row_Recordset1['material_cod'] .", ".$row_Recordset1['flats_adress'] .", ".$row_Recordset1['flats_confid'] .", ".$row_Recordset1['foto'] .", ".$row_Recordset1['sale'] .", '".$row_Recordset1['date_sale'] ."', ".$row_Recordset1['price_sale'] ."\r\n");
fputs($sp, $r);
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
$file="/home/public_html/{$table}";
fclose($sp);
		  break;
    default : 
        break;
}
	
 $archive = new PclZip('base/update.zip');
     $v_list = $archive->add($table);
     if ($v_list == 0) {
       die("Error : ".$archive->errorInfo(true));
     }
	 unset($table);
	 unset($agency);
	 unset($archive);
?>