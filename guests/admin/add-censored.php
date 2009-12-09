<?php
	include("../data.php");
	session_start();
	if($login != $adminName && $password != $secretPassword)
	{
		session_destroy();
		Header("Location: login.php");exit;
	}
	else if ($action == "add")
	{
		include("../lib.php");
		$content = readDataFromFile("../dictionary.inc");
		$content = $content."\n".$word;
		reWriteDataInFile($content,"../dictionary.inc");
		@Header("Location: index.php?page=".$page);exit;
	}
	else
	{
		include("../lib.php");
?>
<html>
<head>
<title>admbook :: version <?=$version?></title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link href="../style.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
input.field {
	width : 170px
}

input.button {
	width: 290px;
}
-->
</style>
</head>
<body bgcolor="<?=$bgColor?>" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0">
<table width="760" border="0" cellpadding="0" cellspacing="0" align="center" height="100%">
<tr>
	<form action="add-censored.php?action=add" method="post">
	<input type="hidden" name="page" value="<?=$page?>">
	<td valign="top" class="text">
		<?php @include("top.inc"); ?><br><br>
		<table width="230" border="0" cellpadding="0" cellspacing="0">
		</table>
		<table width="230" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td class="text" nowrap>new censored word:</td>
			<td width="10"><spacer width="10" height="1" type="block"></td>
			<td width="170"><input type="text" size="20" name="word" value="" maxlength="50" class="field"></td>
		</tr>
		<tr>
			<td colspan="3" height="10"><spacer width="1" height="10" type="block"></td>
		</tr>
		<tr>
			<td colspan="3"><input type="submit" value="add" class="button"></td>
		</tr>
		<tr>
			<td colspan="3"><input type="button" value="logout" class="button" onClick="javascript:window.location.href='logout.php'"></td>
		</tr>
		<tr>
			<td colspan="3"><input type="button" value="back" class="button" onClick="javascript:window.location.href='index.php?page=<?=$page?>'"></td>
		</tr>
		</table>
	</td>
	</form>
</tr>
</table>
</body>
<?php @include("in-counter.inc"); ?>
</html>
<?
	}
?>