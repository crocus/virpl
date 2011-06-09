<?php 
require_once('_scriptsphp/r_conn.php');
require_once('_scriptsphp/session.inc');
//$SERVER_ROOT = "http://foliant.net.ru/foliantn/public_html/";
// вырезка всех нежелательных символов
/* убиваем переменную user, чтобы нельзя было, нарисовав форму, отправить данные 
  в post-запросе. */
unset($user);
unset($user_p);
// флаг "ошибка сессии" — если он включён, работа прекратится.
$session_error = false;
session_start();
if (!$session_error) {
$query_auth ="SELECT pc.Participants_id AS Id, pn.value_property AS Name, pr.value_property AS Role, pg.value_property AS Groupe, ppg.value_property AS parentGroupe
FROM `tbl_participants_catalog` pc
INNER JOIN `tbl_participants_catalog` pn ON pc.Participants_id = pn.Participants_id
AND pn.Participants_property_id =1
INNER JOIN `tbl_participants_catalog` pr ON pc.Participants_id = pr.Participants_id
AND pr.Participants_property_id =3
INNER JOIN `tbl_participants_catalog` pg ON pc.Participants_id = pg.Participants_id
AND pg.Participants_property_id =14
INNER JOIN `tbl_participants_catalog` ppg ON pg.value_property=ppg.Participants_id
AND ppg.Participants_property_id =14
INNER JOIN `tbl_participants_catalog` pp ON pc.Participants_id = pp.Participants_id
AND pp.Participants_property_id =6
AND pp.value_property = '{$_SESSION['user_p']}' 
WHERE pc.Participants_property_id =5
AND pc.value_property = '{$_SESSION['user']}'";
  // $query_auth = "SELECT id FROM tbl_access WHERE login='{$_SESSION['user']}' AND pass='{$_SESSION['user_p']}'";
   $user_result = mysql_query($query_auth, $realtorplus) or die(mysql_error());
  $user_row = mysql_fetch_assoc($user_result);
  if (mysql_error() || @mysql_num_rows($user_result) != 1){
	$session_error = true;
  } else {
	$_SESSION['id']=$user_row['Id'];
	$_SESSION['name']=$user_row['Name'];
	$_SESSION['role']=$user_row['Role'];
	$_SESSION['group']=$user_row['Groupe'];
	$_SESSION['parent_group']=$user_row['parentGroupe'];
	$_SESSION['use']=@mysql_num_rows($user_result); 
   };
};
if ($session_error) {
 session_unset();
 session_destroy();
 header("Location: index.php");
 exit();
  };
mysql_free_result($user_result);
?>