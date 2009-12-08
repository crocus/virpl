<?php
	include("../data.php");
	session_start();
	if($login != $adminName && $password != $secretPassword)
	{
		session_destroy();
		Header("Location: login.php?page=".$page);exit;
	}
	else
	{
		include("../lib.php");
		$content = outputFormatedContent(outputPageContent(readDataFromFile("../data.inc"),$messageToPage));
?>
<html>
<head>
<title>admbook :: version <?=$version?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$textCharset?>">
<link href="../style.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/javascript">
<!--
function check(stat) {
	var len = document.forms[0].elements.length;
	for( var i=0; i < len; i++ ) {
		chbox = document.forms[0].elements[i];
		if(chbox.type == "checkbox")
			chbox.checked = stat;
	}
}
//-->
</script>
</head>
<body bgcolor="<?=$bgColor?>" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0">
<table width="760" border="0" cellpadding="0" cellspacing="0" align="center" height="100%">
<form action="delete.php" method="get">
<input type="hidden" name="page" value="<?=$page?>">
<tr>
	<td valign="top" colspan="2">
<?php
	if (numberOfPages("index.php") != null)
	{
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
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
	$z = $page*$messageToPage - ($messageToPage-1);
	$messageElements = sizeof($content)-1;
	while($i < $messageElements - 12)
	{
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td bgcolor="<?=$borderColor?>">
		<table width="100%" border="0" cellpadding="2" cellspacing="1">
<?php
// ip : host >>
		if ($content[$i] != "")
		{
?>		<tr>
			<td bgcolor="<?=$headerColor?>" width="3%"><input type="checkbox" name="id[]" value="<?=$z;?>"></td>
			<td bgcolor="<?=$headerColor?>" width="15%" class="text">&nbsp;<a href="delete.php?id=<?=$z;?>">Del</a> | <a href="edit.php?id=<?=$z;?>&page=<?=$page?>">Edit</a><?php
			if ($content[$i+9] == "" && $content[$i+10] == "" && $content[$i+11] == "" && $content[$i+12] == "")
			{
				?> | <a href="reply.php?id=<?=$z;?>&page=<?=$page?>">Reply</a><?php
			}
?></td>
			<td bgcolor="<?=$headerColor?>" width="82%" class="text" style="cursor:hand">&nbsp;IPv4 : <?=$content[$i]?><?if ($content[$i+1] != "") print " - host : ".$content[$i+1]?><?if ($content[$i+2] != "") print " - proxy: ".$content[$i+2]; ?></td>
		</tr>
<?php
		}
// ip : host <<
?>
<?php
// name and email as link >>
		$i=$i+3;
		if ($content[$i] != "")
		{
?>		<tr>
			<td colspan="3" class="text" bgcolor="<?=$headerColor?>" style="cursor:hand"><?php if ($content[$i+2] != "") { ?><a href="mailto:<?=$content[$i+2]?>"><? } ?><?=$content[$i]?><?php if ($content[$i+2] != "") { ?></a><? } ?></td>
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
?>		<tr>
			<td colspan="3" class="text" bgcolor="<?=$headerColor?>" style="cursor:hand"><a href="<?=$content[$i]?>"><?=$content[$i]?></a></td>
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
?>		<tr>
			<td colspan="3" class="text" bgcolor="<?=$messageColor?>"><?=checkSmile($content[$i],"../img/");?></td>
		</tr>
<?php
		}
// message <<
?>
<?php
// date and time >>
		$i++;
		if ($content[$i] != "")
		{
?>		<tr>
			<td colspan="3" class="text" bgcolor="<?=$headerColor?>" style="cursor:hand">[<?=$content[$i].", ".$content[$i+1];?>]</td>
		</tr>
<?php
		}
// date and time <<
		$i=$i+2;
// admin name >>
		if ($content[$i] != "")
		{
?>		<tr>
			<td colspan="3" class="text" bgcolor="<?=$adminHeaderColor?>"><b><?=$content[$i]?></b></td>
		</tr>
<?php
		}
// admin name <<
		$i++;
// admin message >>
		if ($content[$i] != "")
		{
?>		<tr>
			<td colspan="3" class="text" bgcolor="<?=$adminMessageColor?>"><?=checkSmile($content[$i],"../img/")?></td>
		</tr>
<?php
		}
// admin message <<
		$i++;
// date and time >>
		if ($content[$i] != "" && $content[$i+1] != "")
		{
?>		<tr>
			<td colspan="3" class="text" bgcolor="<?=$adminHeaderColor?>" style="cursor:hand"><?=$content[$i].", ".$content[$i+1];?></td>
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
		$z++;
	}
?>
		<table border="0" cellpadding="0" cellspacing="0" align="center">
		<tr>
			<td><input type="submit" value="delete" class="button"></td>
			<td><input type="button" value="check all" class="button" onClick="javascript:check(true)"></td>
			<td><input type="button" value="configuration" class="button" onClick="javascript:location.href='configuration.php?page=<?=$page?>'"></td>
			<td><input type="button" value="add to censored" class="button" onClick="javascript:location.href='add-censored.php?page=<?=$page?>'"></td>			
		</tr>
		<tr>
			<td><input type="button" value="logout" class="button" onClick="javascript:location.href='logout.php'"></td>
			<td><input type="button" value="uncheck all" class="button" onClick="javascript:check(false)"></td>
			<td><input type="button" value="help" class="button" onClick="javascript:location.href='<?=$helpPage?>'"></td>
			<td><input type="button" value="back" class="button" onClick="javascript:location.href='../index.php?page=<?=$page?>'"></td>
		</tr>
		</table><br>
		<?php @include("top.inc"); ?>
	</td>
	</form>
</tr>
<tr>
	<td valign="bottom"><?php @include("../counter.inc"); ?><br></td>
	<td valign="bottom" align="right"><div><span class="text">&copy;&nbsp;</span><a href="mailto:trent@id.ru" class="redtext">trent</a>&nbsp;<a href="http://www.dagros.id.ru/" class="text">http://www.dagros.id.ru</a></div></td>
</tr>
</table>
</body>
<?php @include("in-counter.inc"); ?>
</html>
<?
	}
?>