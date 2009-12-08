<?php 
require_once('_scriptsphp/r_conn.php');
include('_scriptsphp/rdate/rdate.php');
include('_scriptsphp/services.php');
$query_Recordset2 = "SELECT e.Id, e.UUID, e.foto, DATE_FORMAT(e.Date, '%a %b %d %Y %H:%i:%s') as Date, e.Type_Exchange, e.Formula, e.Result, e.Description, e.Contact, e.Source, e.Treated, n.Name_Node as agent_name, na.Name_Node as agency_name, GROUP_CONCAT( t.num_tel SEPARATOR ', ') AS phon, IF (na.Mail IS NULL, '', na.Mail) as agency_mail FROM tbl_exchange e 
LEFT JOIN node n ON e.agent_cod = n.UUID 
LEFT JOIN node na ON na.participants_id = n.parents_id  
LEFT JOIN tbl_telag t ON t.agency_name = na.Name_Node 
WHERE e.Id=".intval($_GET['id'])." group by e.Id";	
$Recordset2 = mysql_query($query_Recordset2, $realtorplus) or die(mysql_error());
$first_json_str = json_encode(mysql_fetch_assoc($Recordset2));
$last_json_str = utf8_JSON_russian_cyr($first_json_str);
echo $last_json_str;
mysql_free_result($Recordset2);  
?> 
