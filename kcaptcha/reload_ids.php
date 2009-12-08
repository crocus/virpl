<?php
include('kcaptcha.php');
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
unset($_SESSION['captcha_keystring']);
//$captcha = new KCAPTCHA();
//$_SESSION['captcha_keystring'] = $captcha->getKeyString();
//session_regenerate_id();
//$new_sessionid = session_id();
//print_r( $new_sessionid);
?>