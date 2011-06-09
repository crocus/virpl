<?php
	include('../_scriptsphp/r_conn.php');
	require_once('../_scriptsphp/session.inc');
	session_start();
	// получаем переменные из формы
	$claim_author=$_REQUEST['claim_author'];
	$claim_contact=$_REQUEST['claim_contact'];
	$claim_description=$_REQUEST['claim_description'];
	$UUID=$_REQUEST['UUID'];
	$action=$_REQUEST['action'];
	$id=$_REQUEST['id'];
	$response=$_REQUEST['response'];	
	if ($action=="add")
	{
		// добавление данных в БД 
		if ( $_SESSION['userhash'] != $_POST['userhash'] && !empty($_REQUEST['keystring']) ){
			//if ( $_SESSION['userhash'] != $_REQUEST['userhash'] && !empty($_REQUEST['keystring']) ){
		} else {
			$sql="INSERT INTO tbl_claim (Author, Contact, Description, UUID) VALUES ( '$claim_author', '$claim_contact', '$claim_description', '$UUID')";
			$r=mysql_query ($sql);
			$sql="UPDATE tbl_flats SET flats_claim = 1 WHERE UUID = '$UUID'";
			$r=mysql_query ($sql);
			echo "Ваша заявка на просмотр отправлена. В ближайшее время с Вами свяжется менеджер или агент!";
		}
	}

	if ($action=="delete")
	{
		// удаление из  базы гостевой
		//		$sql="DELETE FROM gb WHERE id=$id";
		$sql="SELECT Claim_id from tbl_claim  WHERE Flag=0 And UUID = '$UUID'";
		$r=mysql_query($sql);
		$num_rows = mysql_num_rows($r);
		if($num_rows == 1){
			$sql="UPDATE tbl_flats SET flats_claim =0 WHERE UUID = '$UUID'";
			$r=mysql_query($sql);
		} 
		$sql="UPDATE tbl_claim SET Flag = 1 WHERE Claim_id = $id";
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
