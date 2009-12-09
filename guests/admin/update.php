<?php
	include("../data.php");
	session_start();
	if($login != $adminName && $password != $secretPassword)
	{
		session_destroy();
		Header("Location: login.php");exit;
	}
	else
	{

		include("../lib.php");

		$content = readDataFromFile("../data.inc");
		$contentArray = explode($resetline,$content);
		$content = "";
		$editArray = explode($div,$contentArray[$id-1]);
		for ($i = 0; $i < sizeof($editArray); $i++)
		{
			$editArray[$i] = ereg_replace("<br/>","",$editArray[$i]);
		}
		$editIp = $editArray[0];
		$editHost = $editArray[1];
		$editProxy = $editArray[2];
		$editDate = $editArray[7];
		$editTime = $editArray[8];
		$editAdminDate = $editArray[11];
		$editAdminTime = $editArray[12];
		$updateContent = $editIp.$div.$editHost.$div.$editProxy.$div.translateHtml($editName).$div.translateHtml($editUrl).$div.translateHtml($editMail).$div.translateHtml($editMessage).$div.$editDate.$div.$editTime.$div.translateHtml($editAdminName).$div.translateHtml($editAdminMessage).$div.$editAdminDate.$div.$editAdminTime;
		if ($id != 1)
			$contentArray[$id-1] = "\n".$updateContent;
		else
			$contentArray[$id-1] = $updateContent;
		$content = arrayToString($contentArray,$resetline);
		reWriteDataInFile ($content,"../data.inc");
		Header("Location: index.php?page=$page");exit;
	}
?>