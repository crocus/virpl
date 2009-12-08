<?php
session_start();
	if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] == $_POST['keystring']){
		echo 'true';
		unset($_SESSION['captcha_keystring']);
	}else{
		echo 'false';
	}
?>