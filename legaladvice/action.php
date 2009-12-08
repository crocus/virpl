<?php
	include('../_scriptsphp/r_conn.php');
	require_once('../_scriptsphp/session.inc');
	session_start();
	// получаем переменные из формы
	$username=$_REQUEST['username'];
	$msg=$_REQUEST['msg'];
	$action=$_REQUEST['action'];
	$id=$_REQUEST['id'];
	$response=$_REQUEST['response'];	
	if ($action=="add")
	{
		// добавление данных в БД 
		if ( $_SESSION['userhash'] != $_POST['userhash'] && !empty($_REQUEST['keystring']) ){
			//if ( $_SESSION['userhash'] != $_REQUEST['userhash'] && !empty($_REQUEST['keystring']) ){
			return false;
		} else {
			$sql="INSERT INTO gb(username, dt, msg) VALUES ('$username', NOW(), '$msg')";
			$r=mysql_query ($sql);
		}
	}

	if ($action=="delete")
	{
		// удаление из  базы гостевой
		$sql="DELETE FROM gb WHERE id=$id";
		$r=mysql_query($sql);
	}
	if ($action=="update")
	{
		// обновление базы гостевой
		$sql="UPDATE gb SET response ='$response' WHERE id=$id";
		$r=mysql_query($sql);
	}	
	//header("Location: ../legaladvice/index.php");
?>
