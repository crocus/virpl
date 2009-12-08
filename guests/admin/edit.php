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
		$inputProperty = "readonly";
?>
<html>
<head>
<title>admbook :: version <?=$version?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$textCharset?>">
<link href="../style.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
input.field {
	width : 170px
}

input.button {
	width: 230px;
}
-->
</style>
</head>
<body bgcolor="<?=$bgColor?>" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0">
<table width="760" border="0" cellpadding="0" cellspacing="0" align="center" height="100%">
<tr>
	<form action="update.php" method="post">
	<input type="hidden" name="page" value="<?=$page?>">
	<input type="hidden" name="id" value="<?=$id?>">
	<td valign="top" class="text">
		<?php @include("top.inc"); ?>
		<table width="230" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="50" class="text">ip:</td>
			<td width="10"><spacer width="10" height="1" type="block"></td>
			<td width="170" class="text"><?=$editArray[0]?></td>
		</tr>
		<tr>
			<td class="text">Host: </td>
			<td><spacer width="1" height="1" type="block"></td>
			<td class="text"><?=$editArray[1]?></td>
		</tr>
		<tr>
			<td class="text">Proxy: </td>
			<td><spacer width="1" height="1" type="block"></td>
			<td class="text"><?=$editArray[2]?></td>
		</tr>
		<tr>
			<td class="text">Name: </td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="text" size="20" name="editName" value="<?=$editArray[3]?>" maxlength="50" class="field"></td>
		</tr>
		<tr>
			<td class="text">Url: </td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="text" size="20" name="editUrl" value="<?=$editArray[4]?>" maxlength="50" class="field"></td>
		</tr>
		<tr>
			<td class="text">e-mail: </td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="text" size="20" name="editMail" value="<?=$editArray[5]?>" maxlength="50" class="field"></td>
		</tr>
		<tr>
			<td class="text">Date: </td>
			<td><spacer width="1" height="1" type="block"></td>
			<td class="text"><?=$editArray[7].", ".$editArray[8];?></td>
		</tr>
		<tr>
			<td colspan="3" class="text">Message:</td>
		</tr>
		<tr>
			<td colspan="3" align="right"><textarea name="editMessage" rows="9" cols="30" wrap="virtual"><?=$editArray[6]?></textarea></td>
		</tr>
		<tr>
			<td colspan="3" height="10"><spacer width="1" height="10" type="block"></td>
		</tr>
<?php
	if ($editArray[9] != "") {
?>
		<tr>
			<td class="text">Admin name: </td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="text" size="20" name="editAdminName" value="<?=$editArray[9]?>" maxlength="50" class="field"></td>
		</tr>
<?
	}
	if ($editArray[10] != "") {
?>
		<tr>
			<td colspan="3" height="10"><spacer width="1" height="10" type="block"></td>
		</tr>
		<tr>
			<td colspan="3" class="text">Admin message:</td>
		</tr>
		<tr>
			<td colspan="3" align="right"><textarea name="editAdminMessage" rows="9" cols="30" wrap="vitual"><?=$editArray[10]?></textarea></td>
		</tr>
<?
	}
	if ($editArray[11] != "" && $editArray[12] != "") {
?>
		<tr>
			<td class="text">Date: </td>
			<td><spacer width="1" height="1" type="block"></td>
			<td class="text"><?=$editArray[11].", ".$editArray[12];?></td>
		</tr>
<?
	}
?>
		<tr>
			<td colspan="3" height="10"><spacer width="1" height="10" type="block"></td>
		</tr>
		<tr>
			<td colspan="3" align="right"><input type="submit" value="update" class="button"></td>
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