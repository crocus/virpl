<?php
header('Content-Type: text/html; charset=utf-8');
include('r_conn.php');
require_once('services.php');
$id=$_GET['s'];
$query_param= "SELECT street_cod as Id, street_name as Name 
FROM tbl_street WHERE city_cod = {$id} ORDER BY Name ASC";
$Recordset = mysql_query($query_param, $realtorplus) or die(mysql_error());
$items = array();
$i=0;
while($obj =mysql_fetch_array($Recordset)){
$items[$obj['Name']] = $obj['Id'];
$i++;
}
$q = strtolower_utf8($_GET["q"]);
if (!$q) return;
foreach ($items as $key=>$value) {
    if (strpos(strtolower_utf8($key), $q) !== false) {
        echo "$key|$value\n";
    }
}
unset($id);
?>