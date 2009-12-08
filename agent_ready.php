<?php
require_once('_scriptsphp/r_conn.php');
require_once('pclzip.lib.php');    
$agency = $_POST['agency'];
$agency_name = $_POST['name'];
$agency_mail = $_POST['mail'];
 
 mysql_select_db($database_realtorplus, $realtorplus);
 $query_Recordset2= ("INSERT INTO tbl_agent (agency_cod, agent_mail, agent_name ) VALUES ({$agency}, '{$agency_mail}', '{$agency_name}');");
  	$Recordset2 = mysql_query($query_Recordset2) or die(mysql_error());
	
	$query_Recordset1= ("SELECT agent_cod, agency_cod, agent_mail, agent_pass, agent_name FROM tbl_agent WHERE tbl_agent.agency_cod={$agency}");
  	$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
	 $sp = fopen("/home/public_html/tbl_agent.sql",'w+'); 
	 do {  
$r= sprintf($row_Recordset1['agent_cod'] . ", ".$row_Recordset1['agency_cod'] . ", " . "'" .$row_Recordset1['agent_mail'] . "'" . ", " . "'" . $row_Recordset1['agent_pass'] . "'"  . ", " . "'" . $row_Recordset1['agent_name'] . "'" ."\r\n");
fputs($sp, $r);
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
$file="/home/public_html/tbl_agent.sql";
fclose($sp);
 $archive = new PclZip('base/update.zip');
     $v_list = $archive->add('tbl_agent.sql');
     if ($v_list == 0) {
       die("Error : ".$archive->errorInfo(true));
     }
?>