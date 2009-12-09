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
		for($i = 0; $i < sizeof($id); $i++)
			$contentArray[$id[$i]-1] = "";
		$content = arrayToString($contentArray,$resetline);
		reWriteDataInFile ($content,"../data.inc");
		Header("Location: index.php");exit;
	}
?>