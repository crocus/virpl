<?php
	error_reporting(0);
	if ($action != "save")
		include("../data.php");
	session_start();
	if($login != $adminName && $password != $secretPassword)
	{
		session_destroy();
		Header("Location: login.php");exit;
	}
	else if ($action == "save")
	{
		if ($newPass != "" && $newPass == $confirmPass)
			$secretPassword = md5($newPass);
		else if ($newPass == "" or $confirmPass = "")
			$secretPassword = $oldPassword;
		if (isset($b)) $b = "true"; else $b = "false";
		if(isset($i)) $i = "true"; else $i = "false";
		if(isset($a)) $a = "true"; else $a = "false";
		if(isset($smile)) $smile = "true"; else $smile = "false";
		if($textCharset == "") $textCharset = "ISO-8859-1";
		if($locale == "") $locale = "GB";
		$content = "<?\n\t\$maxLengthMessage = ".$maxLengthMessage.";\n\t\$messageToPage = ".$messageToPage.";\n\t\$maxWordLength = ".$maxWordLength.";\n\t\$mail = \"".$mail."\";\n\t\$adminName = \"".$adminName."\";\n\t\$secretPassword = \"".$secretPassword."\";\n\t\$div = \"".$div."\";\n\t\$resetline = \"".$resetline."\";\n\t\$errColor = \"".$errColor."\";\n\t\$b = ".$b.";\n\t\$i = ".$i.";\n\t\$a = ".$a.";\n\t\$smile = ".$smile.";\n\t\$version = \"".$version."\";\n\t\$helpPage = \"".$helpPage."\";\n\t\$bgColor = \"".$bgColor."\";\n\t\$messageColor = \"".$messageColor	."\";\n\t\$headerColor = \"".$headerColor."\";\n\t\$adminHeaderColor = \"".$adminHeaderColor."\";\n\t\$adminMessageColor = \"".$adminMessageColor."\";\n\t\$borderColor = \"".$borderColor."\";\n\t\$activePage = \"".$activePage."\";\n\t\$textCharset = \"".$textCharset."\";\n\t\$locale = \"".$locale."\";\n\tif(!isset(\$page))\n\t\t\$page = 1;\n\terror_reporting(0);\n?>";
		@$openFile = @fopen("../data.php","w+") or die ("Don't save data... <b>security</b>. <a href=\"index.php?page=".$page."\">Return</a> to admin");
			@fwrite($openFile,$content);
		fclose($openFile);
		@Header("Location: index.php?page=".$page);exit;
	}
	else
	{
		include("../data.php");
		include("../lib.php");
?>
<html>
<head>
<title>admbook :: version <?=$version?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$textCharset?>">
<link href="../style.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
input.field {
	width : 250px
}

input.button {
	width: 440px;
}
-->
</style>
<script>
function check()
{
	v1 = document.conf.newPass.value;
	v2 = document.conf.confirmPass.value;
	if (v1 == v2)
		document.conf.submit();
	else
	{
		document.conf.newPass.value = "";
		document.conf.confirmPass.value = "";
	}
}
</script>
</head>
<body bgcolor="<?=$bgColor?>" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0">
<table width="760" border="0" cellpadding="0" cellspacing="0" align="center" height="100%">
<tr>
	<form action="configuration.php?action=save" method="post" name="conf">
	<input type="hidden" name="page" value="<?=$page?>">
	<input type="hidden" name="div" value="<?=$div?>">
	<input type="hidden" name="resetline" value="<?=$resetline?>">
	<input type="hidden" name="resetline" value="<?=$resetline?>">
	<input type="hidden" name="helpPage" value="<?=$helpPage?>">
	<input type="hidden" name="version" value="<?=$version?>">
	<input type="hidden" name="oldPassword" value="<?=$secretPassword?>">
	<td valign="top" class="text">
		<?php @include("top.inc"); ?><br><br>
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td class="text">max messages length:</td>
			<td width="10"><spacer width="10" height="1" type="block"></td>
			<td><input type="text" size="20" name="maxLengthMessage" value="<?=$maxLengthMessage?>" maxlength="50" <?=$inputProperty?> class="field"></td>
		</tr>
		<tr>
			<td class="text">messages by page:</td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="text" size="20" name="messageToPage" value="<?=$messageToPage?>" maxlength="50" <?=$inputProperty?> class="field"></td>
		</tr>
		<tr>
			<td class="text">active pages:</td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="text" size="20" name="activePage" value="<?=$activePage?>" maxlength="50" <?=$inputProperty?> class="field"></td>
		</tr>
		<tr>
			<td class="text">max word length</td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="text" size="20" name="maxWordLength" value="<?=$maxWordLength?>" maxlength="50" <?=$inputProperty?> class="field"></td>
		</tr>
		<tr>
			<td class="text">e-mail for send user message: </td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="text" size="20" name="mail" value="<?=$mail?>" maxlength="50" <?=$inputProperty?> class="field"></td>
		</tr>
		<tr>
			<td class="text">error message color: </td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="text" size="20" name="errColor" value="<?=$errColor?>" maxlength="50" <?=$inputProperty?> class="field"></td>
		</tr>
		<tr>
			<td class="text">background color: </td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="text" size="20" name="bgColor" value="<?=$bgColor?>" maxlength="50" <?=$inputProperty?> class="field"></td>
		</tr>
		<tr>
			<td class="text">header background color: </td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="text" size="20" name="headerColor" value="<?=$headerColor?>" maxlength="50" <?=$inputProperty?> class="field"></td>
		</tr>
		<tr>
			<td class="text">message background color: </td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="text" size="20" name="messageColor" value="<?=$messageColor?>" maxlength="50" <?=$inputProperty?> class="field"></td>
		</tr>
		<tr>
			<td class="text">border color: </td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="text" size="20" name="borderColor" value="<?=$borderColor?>" maxlength="50" <?=$inputProperty?> class="field"></td>
		</tr>
		<tr>
			<td class="text">admin header background color: </td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="text" size="20" name="adminHeaderColor" value="<?=$adminHeaderColor?>" maxlength="50" <?=$inputProperty?> class="field"></td>
		</tr>
		<tr>
			<td class="text">admin message background color: </td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="text" size="20" name="adminMessageColor" value="<?=$adminMessageColor?>" maxlength="50" <?=$inputProperty?> class="field"></td>
		</tr>
		<tr>
			<td class="text">charset: </td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="text" size="20" name="textCharset" value="<?=$textCharset?>" maxlength="50" <?=$inputProperty?> class="field"></td>
		</tr>
		<tr>
			<td class="text">locale: </td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="text" size="20" name="locale" value="<?=$locale?>" maxlength="50" <?=$inputProperty?> class="field"></td>
		</tr>
		<tr>
			<td class="text">new admin name: </td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="text" size="20" name="adminName" value="<?=$adminName?>" maxlength="50" <?=$inputProperty?> class="field"></td>
		</tr>
		<tr>
			<td class="text">new password: </td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="password" size="20" name="newPass" value="" maxlength="50" <?=$inputProperty?> class="field"></td>
		</tr>
		<tr>
			<td class="text">confirm new password: </td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="password" size="20" name="confirmPass" value="" maxlength="50" <?=$inputProperty?> class="field"></td>
		</tr>
		<tr>
			<td class="text">&lt;b&gt;&lt;/b&gt;</td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="checkbox" name="b" <?if ($b){?>value="1" checked<?} else { ?>value="0"<? }?>  <?=$checkProperty?>></td>
		</tr>
		<tr>
			<td class="text">&lt;a href=""&gt;&lt;/a&gt;</td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="checkbox" name="a" <?if ($a){?>value="1" checked<?} else { ?>value="0"<? }?> <?=$checkProperty?>></td>
		</tr>
		<tr>
			<td class="text">&lt;i&gt;&lt;/i&gt;</td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="checkbox" name="i" <?if ($i){?>value="1" checked<?} else { ?>value="0"<? }?> <?=$checkProperty?>></td>
		</tr>
		<tr>
			<td class="text">convert smile to picture</td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="checkbox" name="smile" <?if ($smile){?>value="1" checked<?} else { ?>value="0"<? }?> <?=$checkProperty?>></td>
		</tr>
		<tr>
			<td colspan="3" height="10"><spacer width="1" height="10" type="block"></td>
		</tr>
		<tr>
			<td colspan="3"><input type="button" value="update" onClick="check()" class="button"></td>
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