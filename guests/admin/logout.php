<?php
	include("../data.php");	
	session_start();
	session_unregister("password");
	session_unregister("login");
	Header("Location: ../");exit; 
?>