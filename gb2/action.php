<!--
 	Пример гостевой книги с динамическим обновлением содержимого.
	(с) Михаил Пестречихин, 2009
	http://useful.pestr.ru/ 
-->

<?php
	include ("dbconnect.php");

	// получаем переменные из формы
	$username=$_REQUEST['username'];
	$msg=$_REQUEST['msg'];
	$action=$_REQUEST['action'];
	
	if ($action=="add")
	{
		// добавление данных в БД 
		$sql="INSERT INTO gb(username, dt, msg) VALUES ('$username', NOW(), '$msg')";
		$r=mysql_query ($sql);
	}
	
	if ($action=="delete")
	{
		// удаление базы гостевой
		$sql="DELETE FROM gb";
		$r=mysql_query($sql);
	}
	
	header("Location: index.php");
?>