<?php
require_once('_scriptsphp/r_conn.php');
require_once('pclzip.lib.php');    
$agency = $_POST['agency']; 
 mysql_select_db($database_realtorplus, $realtorplus);
	$query_Recordset1= ("SELECT  agency_cod, agency_name, agency_mail, agency_access FROM tbl_agency WHERE agency_cod!={$agency}");
  	$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
	 $sp = fopen("/home/public_html/tbl_agency.sql",'w+'); 
	 do {  
$r= sprintf($row_Recordset1['agency_cod'] . ", " . "'" . $row_Recordset1['agency_name'] . "'"  . ", " . "'" .$row_Recordset1['agency_mail'] . "'" . ", " . $row_Recordset1['agency_access'] ."\r\n");
fputs($sp, $r);
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
$file="/home/public_html/tbl_agency.sql";
fclose($sp);
 $archive = new PclZip('base/update.zip');
     $v_list = $archive->add('tbl_agency.sql');
     if ($v_list == 0) {
       die("Error : ".$archive->errorInfo(true));
     }
?>