<?php
//это возможно пренести в service_tb вызов из деталей обмена
include('r_conn.php');
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
	$id = (isset($_GET['id']) && intval($_GET['id'] && !empty($_GET['id']))) ? $_GET['id'] : null;
    $uuid = (isset($_GET['uuid']) && strval($_GET['uuid'] && !empty($_GET['uuid']))) ? htmlspecialchars(trim(rtrim($_GET['uuid']))) : null;
	$section = (isset($_GET['section']) && strval($_GET['section'] && !empty($_GET['section']))) ? htmlspecialchars(trim(rtrim($_GET['section']))) : null;
	 switch ( $section ) {
    case "buy":
       $Recordset1 = mysql_query("UPDATE tbl_flats SET agent_cod='{$id}', Treated = 1 WHERE UUID='{$uuid}';") or die(mysql_error());
        break;
	case "exchange":
       $Recordset1 = mysql_query("UPDATE tbl_exchange SET agent_cod='{$id}', Treated = 1 WHERE UUID='{$uuid}';") or die(mysql_error());
        break;		
    default : 
        exit();
        break;
}
echo "Объявление успешно закреплено за выбранным агентом.";
}
?> 