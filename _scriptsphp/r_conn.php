<?php
$hostname_realtorplus = "localhost:3306";
$database_realtorplus = "farhome";
$username_realtorplus = "root";
$password_realtorplus = "";
$realtorplus = mysql_connect($hostname_realtorplus, $username_realtorplus, $password_realtorplus) or die(mysql_error());
mysql_query("SET NAMES 'utf8'", $realtorplus) or die(mysql_error());
mysql_select_db($database_realtorplus, $realtorplus);
?>