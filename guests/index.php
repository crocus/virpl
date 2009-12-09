<?php
	include("lib.php");
	include("data.php");
	session_start();
	$content = outputFormatedContent(outputPageContent(readDataFromFile(),$messageToPage));
	if ($error == "nick")
	{
		$style = ".nick {color:$errColor}";
	}
	if ($error == "url")
	{
		$style = ".url {color:$errColor}";
	}
	if ($error == "email")
	{
		$style = ".email {color:$errColor}";
	}
	if ($error == "message")
	{
		$style = ".message {color:$errColor}";
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>admbook :: version <?=$version?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$textCharset?>">
<link href="style.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
input.field {
	width : 170px
}

input.button {
	border-style: outset;
	width: 230px;
	cursor: hand;
	background : rgb(212,208,200);
/*	background: #96A096*/
}
<?=$style?>
-->
</style>
<script language="JavaScript" type="text/javascript">
<!--
function setSmile( symbol ) {
	obj = document.guestbook.message;
	obj.value =	obj.value + symbol;
	obj.focus();
}
//-->
</script>
</head>
<body bgcolor="<?=$bgColor?>" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0">
<table width="760" border="0" cellpadding="0" cellspacing="0" align="center" height="100%">
<tr>
	<td valign="top" width="230">
		<table width="230" border="0" cellpadding="0" cellspacing="0">
		<form action="write.php" method="post" name="guestbook">
<?php
		if (isset($nick))
		{
?>
		<tr>
			<td width="50" class="text"><span class="nick">Nick: </span></td>
			<td width="10"><spacer width="10" height="1" type="block"></td>
			<td width="170"><input type="text" size="16" name="nick" value="<?=$nick?>" maxlength="50" class="field"></td>
		</tr>
<?php
			session_unregister("nick");
		}
		else
		{
?>
		<tr>
			<td width="50" class="text"><span class="nick">Nick: </span></td>
			<td width="10"><spacer width="10" height="1" type="block"></td>
			<td width="170"><input type="text" size="16" name="nick" value="" maxlength="50" class="field"></td>
		</tr>
<?php
		}
		if (isset($url))
		{
?>
		<tr>
			<td class="text"><span class="url">Url: </span></td>
			<td><spacer width="10" height="1" type="block"></td>
			<td><input type="text" size="16" name="url" maxlength="50" value="<?=$url?>" class="field"></td>
		</tr>
<?php
			session_unregister("url");
		}
		else
		{
?>
		<tr>
			<td class="text"><span class="url">Url: </span></td>
			<td><spacer width="10" height="1" type="block"></td>
			<td><input type="text" size="16" name="url" maxlength="50" value="http://" class="field"></td>
		</tr>
<?php
		}
		if (isset($email))
		{
?>
		<tr>
			<td class="text"><span class="email">E-mail: </span></td>
			<td><spacer width="10" height="1" type="block"></td>
			<td><input type="text" size="16" name="email" value="<?=$email?>" maxlength="50" class="field"></td>
		</tr>
<?php
			session_unregister("email");
		}
		else
		{
?>
		<tr>
			<td class="text"><span class="email">E-mail: </span></td>
			<td><spacer width="10" height="1" type="block"></td>
			<td><input type="text" size="16" name="email" value="" maxlength="50" class="field"></td>
		</tr>
<?php
		}
		if (isset($message))
		{
				$message = stripslashes($message);
?>
		<tr>
			<td colspan="3" class="text"><span class="message">Message:</span><?php if ($error == "message") {?> message length more than <?=$maxLengthMessage?> symbols or empty<?php } ?></td>
		</tr>
		<tr>
			<td colspan="3" align="right"><textarea name="message" rows="9" cols="25" wrap="virtual"><?=$message?></textarea></td>
		</tr>
<?php
			session_unregister("message");
		}
		else
		{
?>
		<tr>
			<td colspan="3" class="text"><span class="message">Message:</span><?php if ($error == "message") {?> message length more than <?=$maxLengthMessage?> symbols or empty<?php } ?></td>
		</tr>
		<tr>
			<td colspan="3" align="right"><textarea name="message" rows="9" cols="26" class="fields" wrap="vitual"></textarea></td>
		</tr>
<?php
		}
?>
		<tr>
			<td colspan="3" align="right"><input type="submit" value="send" class="button"></td>
		</tr>
<?php
			if($smile)
			{
?>		
		<tr>
			<td colspan="3" height="3"><spacer height="3" width="1" type="block"></td>
		</tr>
		<tr>
			<td colspan="3" class="text">
				<a href="javascript:setSmile(' :) ')"><img src="img/smile.gif" width="15" height="15" border="0"></a>
				<a href="javascript:setSmile(' ;) ')"><img src="img/wink.gif" width="15" height="15" border="0"></a>
				<a href="javascript:setSmile(' 8) ')"><img src="img/cool.gif" width="15" height="15" border="0"></a>
				<a href="javascript:setSmile(' :J ')"><img src="img/curve-smile.gif" width="15" height="15" border="0"></a>
				<a href="javascript:setSmile(' :P ')"><img src="img/tongue.gif" width="15" height="15" border="0"></a>
				<a href="javascript:setSmile(' :D ')"><img src="img/biggrin.gif" width="15" height="15" border="0"></a>
				<a href="javascript:setSmile(' :( ')"><img src="img/frown.gif" width="15" height="15" border="0"></a>
				<a href="javascript:setSmile(' :o ')"><img src="img/astonish.gif" width="15" height="15" border="0"></a>
				<a href="javascript:setSmile(' %) ')"><img src="img/crazy.gif" width="15" height="15" border="0"></a>
				<a href="javascript:setSmile(' :[] ')"><img src="img/fright.gif" width="15" height="15" border="0"></a>
				<a href="javascript:setSmile(' :smoke: ')"><img src="img/smoke.gif" width="21" height="20" border="0"></a>				
				<a href="javascript:setSmile(' :evil: ')"><img src="img/evil.gif" width="15" height="15" border="0"></a>
				<a href="javascript:setSmile(' :apple: ')"><img src="img/apple.gif" width="15" height="15" border="0"></a>
				<a href="javascript:setSmile(' :moo: ')"><img src="img/moo.gif" width="16" height="16" border="0"></a>
				<a href="javascript:setSmile(' :icq: ')"><img src="img/icq.gif" width="16" height="16" border="0"></a>
			</td>
		</tr>
<?php
			}
?>
		<tr>
			<td colspan="3" class="text"><br>
				<br><a href="admin/index.php?page=<?=$page?>" class="text">administration</a>
				<br><br><a href="http://www.mycgiserver.com/~sample/guestbook.zip" class="text">download sources</a>
				<br><a href="readme-ru.html" class="text"><b>read this (rus)</b></a>
				<br><a href="readme-en.html" class="text"><b>read this (eng)</b></a><br><br>
			</td>
		</tr>
		</form>
		</table>
	</td>
	<td width="10"><spacer height="1" width="10" type="block"><br>&nbsp;</td>
	<td valign="top" width="520" class="text2">
<?php @include("top.inc"); ?>
<?php
	if (numberOfPages("index.php") != null)
	{
?>		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td bgcolor="<?=$borderColor?>">
				<table width="100%" border="0" cellpadding="2" cellspacing="1">
				<tr>
					<td bgcolor="<?=$headerColor?>" class="redtext"><?=check($v);?><?=numberOfPages("index.php","<span class=\"text\">page: </span>", "<span class=\"text\">total: </span>");?></td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
<br>
<?php
	}
?>
<?php
	$i = 0;
	$messageElements = sizeof($content)-1;
	while($i < $messageElements - 12)
	{
?>		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td bgcolor="<?=$borderColor?>">
				<table width="100%" border="0" cellpadding="2" cellspacing="1">
<?php
// name and email as link >>
		$i=$i+3;
		if ($content[$i] != "")
		{
?>				<tr>
					<td class=text bgcolor="<?=$headerColor?>" style="cursor:hand"><?php if ($content[$i+2] != "") { ?><a href="mailto:<?=$content[$i+2]?>"><? } ?><?=checkBadWord($content[$i])?><?php if ($content[$i+2] != "") { ?></a><? } ?></td>
				</tr>
<?php
		}
// name and email as link <<
?>
<?php
// url >>
		$i++;
		if ($content[$i] != "http://")
		{
?>				<tr>
					<td class=text bgcolor="<?=$headerColor?>" style="cursor:hand"><a href="<?=$content[$i]?>"><?=checkBadWord($content[$i])?></a></td>
				</tr>
<?php
		}
// url <<
?>
<?php
// message >>
		$i=$i+2;
		if ($content[$i] != "")
		{
?>				<tr>
					<td class=text bgcolor="<?=$messageColor?>"><?=checkSmile(checkBadWord($content[$i]));?></td>
				</tr>
<?php
		}
// message <<
?>
<?php
// date and time >>
		$i++;
		if ($content[$i] != "" && $content[$i+1] != "")
		{
?>				<tr>
					<td class=text bgcolor="<?=$headerColor?>" style="cursor:hand">[<?=$content[$i].", ".$content[$i+1];?>]</td>
				</tr>
<?php
		}
// date and time <<
		$i=$i+2;
// admin name >>
		if ($content[$i] != "")
		{
?>				<tr>
					<td class="text" bgcolor="<?=$adminHeaderColor?>"><b><?=$content[$i]?></b></td>
				</tr>
<?php
		}
// admin name <<
		$i++;
// admin message >>
		if ($content[$i] != "")
		{
?>				<tr>
					<td class="text" bgcolor="<?=$adminMessageColor?>"><?=checkSmile($content[$i])?></td>
				</tr>
<?php
		}
// admin message <<
		$i++;
// date and time >>
		if ($content[$i] != "" && $content[$i+1] != "")
		{
?>				<tr>
					<td class="text" bgcolor="<?=$adminHeaderColor?>" style="cursor:hand"><?=$content[$i].", ".$content[$i+1];?></td>
				</tr>
<?php
		}
// date and time <<
		$i=$i+2;
?>
				</table>
			</td>
		</tr>
		</table>
		<br>
<?php
	}
?>
	</td>
</tr>
<tr>
	<form action="http://www.hotscripts.com/cgi-bin/rate.cgi" method="post">
	<td class="text" valign="bottom"><?php @include("counter.inc"); ?><spacer width="1" height="1" type="block"></td>
	<td valign="bottom"><spacer width="10" height="1" type="block"></td>
	<td valign="bottom" align="right"><?php @include("vote.inc"); ?><div><span class="text">&copy;&nbsp;</span><a href="mailto:trent@id.ru" class="redtext">trent</a>&nbsp;<a href="http://www.dagros.id.ru/" class="text">http://www.dagros.id.ru</a></div></td>
	</form>
</tr>
</table>
</body>
<?php @include("in-counter.inc"); ?>
</html>