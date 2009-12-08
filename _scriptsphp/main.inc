<?php 
// вырезка всех нежелательных символов
require_once('_scriptsphp/r_conn.php');
require_once('_scriptsphp/session.inc');
$login_glob = $_POST["user_name"];
$login = preg_replace("/[^\w_\.\-]/", "", $login_glob);
$pass = trim($_POST["user_pass"]);
  // проверка логина и пароля
  if(!empty($login) || !empty($pass)){
$query_base= "SELECT pc.value_property as login, pp.value_property as pass
FROM `tbl_participants_catalog` pc
INNER JOIN `tbl_participants_catalog` pp ON pc.Participants_id = pp.Participants_id
AND pp.Participants_property_id =6
AND pp.value_property = MD5( '{$pass}' ) 
WHERE pc.Participants_property_id =5
AND pc.value_property = '{$login}'";
 // $query_base= "SELECT * FROM tbl_access WHERE  login='{$login}' AND pass='".md5($pass)."'";
  $user_result = mysql_query($query_base, $realtorplus) or die(mysql_error());
  $user_row = mysql_fetch_assoc($user_result);
  /* если возникла ошибка в базе (например, пользователь всунул в сессию дли-и-инную 
  переменную, которую база переваривать не захотела) или получилась не одна строка, 
  отфутболиваем пользователя */
if (@mysql_num_rows($user_result) != 1){
    $error = "Неверное имя пользователя или пароль.";
  // если всё нормально, выбираем данные, запускаем сессию
 } else {
session_start();
    $user = $user_row['login'];
    $user_p = $user_row['pass'];
$_SESSION['user']=$user; 
$_SESSION['user_p']=$user_p;
    header("Location: private_users.php");
    exit();
    }
  }
 ?>