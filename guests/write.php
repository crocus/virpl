<?php
	include("lib.php");
	include("data.php");
	session_start();
/**
 *	$ip and $host set IP address, Proxy address and Host Name
 */
	if	(getenv(HTTP_X_FORWARDED_FOR))
	{
		$ip = getenv("HTTP_X_FORWARDED_FOR");
		$ip_proxy = getenv("REMOTE_ADDR");
		$ip_host = gethostbyaddr($ip);
	} 
	else {
		$ip = getenv("REMOTE_ADDR");
		$ip_host = gethostbyaddr($REMOTE_ADDR);
		$ip_proxy = "";
	}
	$browser = $HTTP_USER_AGENT;
	$server = $HTTP_HOST;

/**
 *	Send email to master
 */
	$originalMailBody = "Name: ".$nick."\nMessage: \n".$message."\nUrl: ".$url."\ne-mail: ".$email."\n";

	session_register("nick");
	session_register("url");
	session_register("email");
	session_register("message");

	if ($nick == "")
	{
		Header("Location: index.php?error=nick");exit;
	}
/*	else if (validUrl($url))
	{
		Header("Location: index.php?error=url");exit;
	}*/
	else if ($email != "" && !validEmail($email))
	{
		if (!validEmail($email))
		Header("Location: index.php?error=email");exit;
	}
	else if ($message == "")
	{
		Header("Location: index.php?error=message");exit;
	}
	else if (strlen($message) > ($maxLengthMessage-1))
	{
		Header("Location: index.php?error=message");exit;
	}
	else
	{
		$nick = translateHtml($nick);
		$url = translateHtml($url);
		$email = translateHtml($email);
		$message = ereg_replace($div,"",$message);
		$message = ereg_replace($resetline."\n","",$message);
		$message = translateHtml($message);
		$content = $ip.$div.$ip_host.$div.$ip_proxy.$div.$nick.$div.$url.$div.$email.$div.$message.$div.currDate($locale).$div.currTime().$div.$div.$div.$div.$resetline."\n";
		writeDataInFile ($content);
		$formatedMailBody = "Name: ".$nick."\nMessage: \n".$message."\nDate: [".currDate().",".currTime()."]\nUrl: ".$url."\ne-mail: ".$email."\nServer: http://".$server."\nBrowser: ".$browser."\nIP: ".$ip."\nHost: ".$ip_host."\nProxy: ".$ip_proxy;
		@mail("$mail", "guestbook", $formatedMailBody."\n\n".$originalMailBody, "Content-Type: text/plain; charset=windows-1251\nContent-Transfer-Encoding: 8bit");

		session_unregister("nick");
		session_unregister("url");
		session_unregister("email");
		session_unregister("message");

		@Header("Location: index.php");exit;
	}
?>