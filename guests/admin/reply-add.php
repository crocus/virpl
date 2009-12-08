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
		$replyIp = $editArray[0];
		$replyHost = $editArray[1];
		$replyProxy = $editArray[2];
		$replyName = $editArray[3];
		$replyUrl = $editArray[4];
		$replyMail = $editArray[5];
		$replyMessage = $editArray[6];
		$replyDate = $editArray[7];
		$replyTime = $editArray[8];
		session_register("replyAdminName");
		session_register("replyAdminMessage");
		if ($replyAdminName == "")
		{
			Header("Location: reply.php?id=".$id."&page=".$page."&error=adminname");exit;
		}
		else if ($replyAdminMessage == "")
		{
			Header("Location: reply.php?id=".$id."&page=".$page."&error=adminmessage");exit;
		}
		else
		{
			$updateContent = $replyIp.$div.$replyHost.$div.$replyProxy.$div.translateHtml($replyName).$div.translateHtml($replyUrl).$div.translateHtml($replyMail).$div.translateHtml($replyMessage).$div.$replyDate.$div.$replyTime.$div.translateHtml($replyAdminName).$div.translateHtml($replyAdminMessage).$div.currDate().$div.currTime();
			if ($id != 1)
				$contentArray[$id-1] = "\n".$updateContent;
			else
				$contentArray[$id-1] = $updateContent;
			$content = arrayToString($contentArray,$resetline);
			reWriteDataInFile ($content,"../data.inc");

			session_unregister("replyAdminMessage");

			Header("Location: index.php?page=$page");exit;
		}
	}
?>