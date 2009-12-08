<?php
require_once('_scriptsphp/r_conn.php');
require_once('pclzip.lib.php');    
 $archive = new PclZip('base/paper.zip');
     $v_list = $archive->delete(PCLZIP_OPT_BY_NAME, 'tbl_agent.sql');
     if ($v_list == 0) {
       die("Error : ".$archive->errorInfo(true));
     }
	 mysql_select_db($database_realtorplus, $realtorplus);
	$query_Recordset1= ("SHOW TABLE STATUS");
  	$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
	 $sp = fopen("/home/public_html/tbl_agent_status.sql",'w+'); 
	 do {  
$r= sprintf("'" . $row_Recordset1['Name'] ."'" .  ", " . "'" . $row_Recordset1['Update_time'] . "'"  ."\r\n");
//$r= sprintf($row_Recordset1['Name'] . ";" . $row_Recordset1['Update_time'] ."\r\n");
fputs($sp, $r);
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
$file="/home/public_html/tbl_agent_status.sql";
fclose($sp);

$lines = file("/home/public_html/tbl_agent_status.sql");
$query_Recordset2= ("INSERT IGNORE INTO `tbl_agent_status` (Name, Update_time) VALUES ");
 foreach ($lines as $line_num => $line) {
 //for ($line = 2; $lines as $line_num => $line; $line++) {
    $z = sprintf("(" . $line . ");\r\n"); 
   $update_agency =$query_Recordset2 . $z;
   $Recordset2 = mysql_query($update_agency) or die(mysql_error());
}
?>