<?php
require_once('_scriptsphp/r_conn.php');
require_once('pclzip.lib.php');    
	 mysql_select_db($database_realtorplus, $realtorplus);
	$query_Recordset1= ("SHOW TABLE STATUS");
  	$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
	 $sp = fopen("/home/public_html/tbl_check_mod.sql",'w+'); 
	 do {  
$r= sprintf("'" . $row_Recordset1['Name'] ."'" .  ", " . "'" . $row_Recordset1['Update_time'] . "'"  ."\r\n");
//$r= sprintf($row_Recordset1['Name'] . ";" . $row_Recordset1['Update_time'] ."\r\n");
fputs($sp, $r);
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
$file="/home/public_html/tbl_check_mod.sql";
fclose($sp);
$archive = new PclZip('base/mod_tables.zip');
     $v_list = $archive->create('tbl_check_mod.sql');
     if ($v_list == 0) {
       die("Error : ".$archive->errorInfo(true));
     }
?>