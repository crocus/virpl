<?php
	include("../data.php");
?>
<html>
<head>
<title>admbook :: version <?=$version?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$textCharset?>">
<link href="../style.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
input.field {
	width : 230px
}

input.button {
	width: 230px;
}
-->
</style>
</head>
<body bgcolor="<?=$bgColor?>" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0">
<?php
	if ((!isset($admin)) || ($admin == "clear"))
		$admin = "";
	else
		$admin = md5($admin);

	if ((!isset($password)) || ($password == "clear"))
	{
		$password = "";
	}
	else
	{
		$password = md5($password);
	}
?>
<table width="760" border="0" cellpadding="0" cellspacing="0" align="center" height="100%">
<tr>
	<form action="generate.php" method="post">
	<td valign="top">
		<?php @include("top.inc"); ?><br>
		<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="<?=$bgColor?>">
		<tr>
			<td width="1%" class="text">password: <spacer width="10" height="1" type="block"></td>
			<td width="99%" class="text"><input type="password" size="25" name="password" value="" maxlength="50" class="field"></td>
		</tr>
<?php
		if ($password != "")
		{
?>
		<tr>
			<td width="1%" class="text">md5 password: <spacer width="10" height="1" type="block"></td>
			<td width="99%" class="text"><input type="text" size="25" name="md5pass" value="<?=$password?>" maxlength="50" class="field"></td>
		</tr>
<?php
		}
?>
		<tr>
			<td width="1%" class="text"><spacer width="10" height="1" type="block"></td>
			<td><input type="submit" value="generate" class="button"></td>
		</tr>
		<tr>
			<td width="1%" class="text"><spacer width="10" height="1" type="block"></td>
			<td><input type="button" value="exit" class="button" onClick="javascript:location.href='../'"></td>
		</tr>
		</table>
	</td>
</tr>
</table>
</body>
<?php @include("in-counter.inc"); ?>
</html>
