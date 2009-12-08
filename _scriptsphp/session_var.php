<?php
require_once ('session.inc');
session_start();
if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
  echo '{ "user":"' . $_SESSION['user'] . '", "use":"' . $_SESSION['use'] . '", "name":"' 
  . $_SESSION['name'] . '", "role":"' . $_SESSION['role'] . '", "group":"' 
  . $_SESSION['group'] . '", "id":"' . $_SESSION['id'] . '", "thisChecked":"' 
  . $_SESSION['thisChecked']. '", "margin":"' . $_SESSION['margin']. '", "forprint":"'. $_SESSION['forprint']. '"}';
}
?>