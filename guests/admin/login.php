<?php
	include("../data.php");
	session_start();
	if ($login != null)
	{
		session_register("login");
	}
	else
	{
		session_unregister("login");
	}
	if ($password != null)
	{
		session_register("password");
		$password = md5($password);
	}
	else
	{
		session_unregister("password");
	}
	if($login == $adminName && $password == $secretPassword)
	{
		Header("Location: index.php?page=".$page."&PHPSESSID=".$PHPSESSID);exit;
	}
	else
	{
		if(isset($login) || isset($password))
		{
			@sleep(2);
			$warning = "<b>Access is denied</b>";
		}
		session_unregister("password");
		session_unregister("login");
?>
<html>
<head>
<title>admbook :: version <?=$version?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$textCharset?>">
<link href="../style.css" type="text/css" rel="stylesheet">
</head>
<body bgcolor="<?=$bgColor?>" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0">
<table width="760" border="0" cellpadding="0" cellspacing="2" height="100%" align="center">
<form action="login.php?page=<?=$page?>&PHPSESSID=<?=$PHPSESSID?>" method="post">
<tr>
	<td valign="bottom" class="text">
		<p>Please, log-in: <?=$warning?>
		<p>login:<br><input type="text" name="login" value="" maxlength="255" size="15" class="field">
		<p>password:<br><input type="password" name="password" value="" maxlength="255" size="15" class="field">
		<p><input type="submit" value="login" class="button"><br>
		<input type="button" value="generate md5 password" class="button" onClick="javascript:location.href='generate.php'"><br>
		<input type="button" value="back" class="button" onClick="javascript:window.location.href='logout.php'">
		<p>login: admin<br>password: pass
		<br><br>
		<?php @include("top.inc"); ?>
	</td>
</tr>
</table>
</form>
</body>
<?php @include("in-counter.inc"); ?>
</html>
<?
	}
?>