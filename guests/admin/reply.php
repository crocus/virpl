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
		if ($error == "adminname")
		{
			$style = ".adminname {color:$errColor}";
		}
		if ($error == "adminmessage")
		{
			$style = ".adminmessage {color:$errColor}";
		}
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
<?=$style?>
-->
</style>
<script language="JavaScript" type="text/javascript">
<!--
function setSmile( symbol ) {
	obj = document.guestbook.replyAdminMessage;
	obj.value =	obj.value + symbol;
	obj.focus();
}
//-->
</script>
</head>
<body bgcolor="<?=$bgColor?>" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0">
<table width="760" border="0" cellpadding="0" cellspacing="0" align="center" height="100%">
<tr>
	<form action="reply-add.php" method="post" name="guestbook">
	<input type="hidden" name="page" value="<?=$page?>">
	<input type="hidden" name="id" value="<?=$id?>">
	<td valign="top" class="text">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td bgcolor="<?=$borderColor?>">
				<table width="100%" border="0" cellpadding="2" cellspacing="1">
				<tr>
					<td class=text bgcolor="<?=$headerColor?>" style="cursor:hand"><a href="mailto:<?=$editArray[5]?>"><?=$editArray[3]?></a></td>
				</tr>
				<tr>
					<td class=text bgcolor="<?=$headerColor?>" style="cursor:hand"><a href="<?=$editArray[4]?>"><?=$editArray[4]?></a></td>
				</tr>
				<tr>
					<td class=text bgcolor="<?=$messageColor?>"><?=checkSmile($editArray[6], "../img/");?></td>
				</tr>
				<tr>
					<td class=text bgcolor="<?=$headerColor?>" style="cursor:nw-resize">[<?=$editArray[7].", ".$editArray[8]?>]</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
		<br>
		<?php @include("top.inc"); ?>
		<table width="230" border="0" cellpadding="0" cellspacing="0">
<?php
	if (isset($replyAdminName))
	{
?>
		<tr>
			<td class="text"><span class="adminname">Name: </span></td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="text" size="20" name="replyAdminName" value="<?=$replyAdminName?>" maxlength="50" class="field"></td>
		</tr>
<?php
		session_unregister("replyAdminName");
	}
	else
	{
?>
		<tr>
			<td class="text"><span class="adminname">Name: </span></td>
			<td><spacer width="1" height="1" type="block"></td>
			<td><input type="text" size="20" name="replyAdminName" value="<?=$adminName?>" maxlength="50" class="field"></td>
		</tr>
<?php
	}
?>
<?php
	if (isset($replyAdminMessage))
	{
?>
		<tr>
			<td colspan="3" class="text"><span class="adminmessage">Message:</span></td>
		</tr>
		<tr>
			<td colspan="3" align="right"><textarea name="replyAdminMessage" rows="9" cols="30" wrap="virtual"><?=$replyAdminMessage?></textarea></td>
		</tr>
<?php
		session_unregister("replyAdminMessage");
	}
	else
	{
?>
		<tr>
			<td colspan="3" class="text"><span class="adminmessage">Message:</span></td>
		</tr>
		<tr>
			<td colspan="3" align="right"><textarea name="replyAdminMessage" rows="9" cols="30" wrap="vitual"></textarea></td>
		</tr>
<?php
	}
?>
		<tr>
			<td colspan="3" height="10"><spacer width="1" height="10" type="block"></td>
		</tr>
<?php
			if($smile)
			{
?>		
		<tr>
			<td colspan="3" class="text">
				<a href="javascript:setSmile(' :) ')"><img src="../img/smile.gif" width="15" height="15" border="0"></a>
				<a href="javascript:setSmile(' ;) ')"><img src="../img/wink.gif" width="15" height="15" border="0"></a>
				<a href="javascript:setSmile(' 8) ')"><img src="../img/cool.gif" width="15" height="15" border="0"></a>
				<a href="javascript:setSmile(' :J ')"><img src="../img/curve-smile.gif" width="15" height="15" border="0"></a>
				<a href="javascript:setSmile(' :P ')"><img src="../img/tongue.gif" width="15" height="15" border="0"></a>
				<a href="javascript:setSmile(' :D ')"><img src="../img/biggrin.gif" width="15" height="15" border="0"></a>
				<a href="javascript:setSmile(' :( ')"><img src="../img/frown.gif" width="15" height="15" border="0"></a>
				<a href="javascript:setSmile(' :o ')"><img src="../img/astonish.gif" width="15" height="15" border="0"></a>
				<a href="javascript:setSmile(' %) ')"><img src="../img/crazy.gif" width="15" height="15" border="0"></a>
				<a href="javascript:setSmile(' :[] ')"><img src="../img/fright.gif" width="15" height="15" border="0"></a>
				<a href="javascript:setSmile(' :smoke: ')"><img src="../img/smoke.gif" width="21" height="20" border="0"></a>				
				<a href="javascript:setSmile(' :evil: ')"><img src="../img/evil.gif" width="15" height="15" border="0"></a>
				<a href="javascript:setSmile(' :apple: ')"><img src="../img/apple.gif" width="15" height="15" border="0"></a>
				<a href="javascript:setSmile(' :moo: ')"><img src="../img/moo.gif" width="16" height="16" border="0"></a>
				<a href="javascript:setSmile(' :icq: ')"><img src="../img/icq.gif" width="16" height="16" border="0"></a>
			</td>
		</tr>
		<tr>
			<td colspan="3" height="10"><spacer height="10" width="1" type="block"></td>
		</tr>
<?php
			}
?>
		<tr>
			<td colspan="3" align="right"><input type="submit" value="send" class="button"></td>
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