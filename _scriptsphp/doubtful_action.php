<?php
	include('r_conn.php');
	require_once('session.inc');
	session_start();
	// получаем переменные из формы
	$street=$_REQUEST['street'];
	$house=$_REQUEST['house'];
	$flat=$_REQUEST['flat'];
	$reason=$_REQUEST['reason'];
	$published=$_REQUEST['published'];
	$action=$_REQUEST['action'];
	$id=$_REQUEST['id'];
	$response=$_REQUEST['response'];	
	if ($action=="add")
	{
			$sql="INSERT INTO tbl_refuse (street, house, flat, reason, published) VALUES ($street, $house, $flat, '$reason', '$published')";
			$r=mysql_query ($sql) or die(mysql_error());
	}

	if ($action=="delete")
	{
		// удаление из  базы гостевой
		$sql="DELETE FROM tbl_refuse WHERE Id=$id";
		$r=mysql_query($sql);
	}
	if ($action=="update")
	{
		// обновление базы гостевой
		$sql="UPDATE tbl_refuse SET response ='$response' WHERE id=$id";
		$r=mysql_query($sql);
	}	
	//header("Location: ../legaladvice/index.php");
?>
