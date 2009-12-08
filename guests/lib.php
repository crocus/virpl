<?php
/*
 *	$Id: lib.php ,v 1.16 2001/08/22 23:00:00 trent Exp $
 *
 *	(c)2001, Copyright, V6.RU
 */

/**
 *	@author trent <trent@id.ru>
 *	@version 1.0
 */

/**
 *	validUrl check url
 *	@param $url
 *	@return true/false
 */
	function validUrl ($url)
	{
		return (!ereg('^http://',$url));
	}

/**
 *	validEmail check e-mail
 * 	@param $email
 *	@return true/false
 */
	function validEmail($email)
	{
		return (ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'.'@'.'[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'.'[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$',$email));
	}

/**
 *	transformHtml transform html in unicode
 *	@param String $content
 *	@return String $content
 */
	function translateHtml($content)
	{
		global $a, $b, $i;
		if ($a)
		{
			$content = preg_replace("/(\<a href=\\\\\")(.*)(\\\\\">)(.*)(\<\/a\>)/U","\[a href=\\2\]\\4\[/a\]", $content);
		}
		if ($b)
		{
			$content = preg_replace("/(\<b\>)(.*)(\<\/b\>)/U","[b]\\2[/b]", $content);
		}
		if($i)
		{
			$content = preg_replace("/(\<i\>)(.*)(\<\/i\>)/U","[i]\\2[/i]", $content);
		}
//		$content = htmlspecialchars($content);
		$content = divideWord($content);
		$content = str_replace("\"","&quot;", $content);
		$content = str_replace("\'","&#034;", $content);
		$content = str_replace(">","&gt;", $content);
		$content = str_replace("<","&lt;", $content);
		$content = ereg_replace("[ ]{2,}", " ", $content);
		$content = str_replace("\n","<br/>", $content);
		$content = stripslashes($content);
		if ($a)
		{
			$content = preg_replace("/(\[a href=)(.*)(\])(.*)(\[\/a\])/U","<a href=\"\\2\">\\4</a>", $content);
		}
		if ($b)
		{
			$content = preg_replace("/(\[b\])(.*)(\[\/b\])/U","<b>\\2</b>", $content);
		}
		if ($i)
		{
			$content = preg_replace("/(\[i\])(.*)(\[\/i\])/U","<i>\\2</i>", $content);
		}
		return $content;
	}

/**
 *	divideWord checks length of words and divides long for length in param
 *	@param String $content
 *	@param int $maxWordLength by default 30
 *	@return String $content
 */
	function divideWord($content,$maxWordLength = "30")
	{
		$newContent = wordwrap($content, $maxWordLength, " ", 1);
		return $newContent;
	}

/**
 *	arrayToString make string from array
 *	@param Array $contentArray
 *	@param String $div default by space
 *	@return String formated
 */

	function arrayToString($contentArray, $div = " ")
	{
		$contentString = "";
		for ($i = 0; $i < sizeof($contentArray); $i++)
		{
			if ($contentArray[$i] != "" &&  $contentArray[$i] != null && $i < (sizeof($contentArray)-1) && $contentArray[$i] != "\n")
				$contentString .= $contentArray[$i].$div;
			else
				$contentString .= $contentArray[$i];
		}
		return $contentString;
	}

	function check($version)
	{
		if ($version)
		{
			$str = "118 101 114 115 105 48 110 32 49 46 49 55 32";
			$str = explode(" ",$str);
			for ($i = 0; $i < sizeof($str); $i++)
				$newstr .= chr($str[$i]);
			return $newstr;
		}
	}

/**
 *	writeDataInFile writes the data in a file
 *	@param String $fileData
 *	@param String $fileName default by 'data.inc'
 */
	function writeDataInFile($fileData,$fileName = "data.inc")
	{
		if(!file_exists($fileName))
		{
			@$createFile = fopen($fileName, "w") or die ("Can't create file ".$fileName."");
			fwrite ($createFile,"",0);
			@chmod($fileName, 0666);
			fclose($createFile);
		}
		$openFile = fopen($fileName,"r");
			$oldData = fread($openFile, filesize ($fileName));
		fclose($openFile);
		@$openFile = fopen($fileName,"w+") or die ("Access is denied. Set permission to ".$fileName." by command in console \"chmod 666 ".$fileName."\"");
		if ($openFile && flock($openFile,LOCK_EX)) {
			@fwrite($openFile,$fileData);
			@fwrite($openFile,$oldData);
		}
		fclose($openFile);
	}

/**
 *	reWriteDataInFile rewrites the data in a file
 *	@param String $fileData
 *	@param String $fileName default by 'data.inc'
 */
	function reWriteDataInFile($fileData,$fileName = "data.inc")
	{
		if(!file_exists($fileName))
		{
			@$createFile = fopen($fileName, "w") or die ("Can't create file ".$fileName."");
			fwrite ($createFile,"",0);
			@chmod($fileName, 0666);
			fclose($createFile);
		}
		@$openFile = fopen($fileName,"w+") or die ("Access is denied. Set permission to ".$fileName." by command in console \"chmod 666 ".$fileName."\"");
		if ($openFile && flock($openFile,LOCK_EX)) {
			@fwrite($openFile,$fileData);
		}
		fclose($openFile);
	}

/**
 *	readDataFromFile read the data from a file
 *	@param String $fileName default by 'data.inc'
 *	@return String data from file
 */
	function readDataFromFile($fileName = "data.inc")
	{
		if(!file_exists($fileName))
		{
			$createFile = fopen($fileName, "w");
			if ($openFile && flock($openFile,LOCK_EX)) {
				fwrite ($createFile,"",0);
			}
			@chmod($fileName, 0666);
			fclose($createFile);
		}
		$openFile = fopen($fileName,"r");
			$unformatedContent = fread($openFile, filesize($fileName));
		fclose($openFile);
		return $unformatedContent;
	}

/**
 *	outputPageContent output content in relation to page number
 *	@param String $content
 *	@param int $messageToPage default by '10'
 *	@return String part Contents for current page
 */
	function outputPageContent($content,$messageToPage = "10")
	{
		global $page,$quantityPages,$div,$resetline,$quantityMessages;
		$contentArray = explode($resetline,$content);
		$quantityMessages = sizeof($contentArray)-1;
		@$quantityPages = ceil($quantityMessages/$messageToPage);
		$contentString = "";
		for($i = $messageToPage*($page-1);$i < $messageToPage*($page-1)+$messageToPage;$i++)
		{
			if ($contentArray[$i] != "")
				$contentString .= $contentArray[$i].$div;
		}
		return $contentString;
	}

/**
 *	numberOfPages output all number of page
 *	@param String $pageDecriptor default by 'page: '
 *	@param String $pageTotalDecriptor default by 'total: '
 *	@return String linked numbers
 */
	function numberOfPages($pageSource,$pageDecriptor = "page: ", $pageTotalDecriptor = "total: ")
	{
		global $quantityPages,$page,$activePage;
		$pageToLine = floor($activePage/2);
		if ($quantityPages >= 2)
		{
			if (($page - $pageToLine) <= ($quantityPages) && ($page - $pageToLine) > 0 && $pageToLine*2+1 < $quantityPages)
			{
				if ($page + $pageToLine <= $quantityPages)
				{
					$x = $page - $pageToLine;
					$y = $page + $pageToLine;
				}
				else
				{
					$x = $page - $pageToLine;
					$y = $quantityPages;
				}
			}
			else
			{
				$x = 1;
				if ($pageToLine*2+1 < $quantityPages)
					$y = $pageToLine*2+1;
				else
					$y = $quantityPages;
			}
			$pageNumberString = "";
			for ($i = $x; $i <= $y; $i++)
			{
				if ($i == $page)
					$pageNumberString .= $i." ";
				else
					$pageNumberString .= "<a href=\"".$pageSource."?page=".$i."\">".$i."</a> ";
			}
			if ($page < $quantityPages)
				$rightNavPoint = "<span>&nbsp;<a href=\"".$pageSource."?page=".($page+1)."\" title=\"next page\">&gt;</a>&nbsp;&nbsp;<a href=\"".$pageSource."?page=".$quantityPages."\" title=\"last page\">&gt;&gt;&gt;</a>&nbsp;</span>";
			else
				$rightNavPoint = "&nbsp;";
			if ($page > 1)
				$leftNavPoint = "&nbsp;<a href=\"".$pageSource."?page=1\" title=\"first page\">&lt;&lt;&lt;</a>&nbsp;&nbsp;<a href=\"".$pageSource."?page=".($page-1)."\" title=\"previous page\">&lt;</a>&nbsp;";
			else
				$leftNavPoint = "";
			return $pageDecriptor.$leftNavPoint.$pageNumberString.$rightNavPoint."&nbsp;".$pageTotalDecriptor. "<a href=\"".$pageSource."?page=".$quantityPages."\" title=\"last page\">".$quantityPages."</a>";
		}
		else
			return $pageNumberString = null;
	}

/**
 *	outputFormatedContent output formated content
 *	@param String $content
 *	@return String formatted content
 */
	function outputFormatedContent($content)
	{
		global $div;
		$formatedContent = explode($div,$content);
		return $formatedContent;
	}

/**
 *	checkBadWord check in message bad word and replace smile
 *	@param String $content
 *	@param String $censoredSign by default <censored>
 *	@param String $dictionaryFile by default dictionary.inc
 *	@return String formatted content
 */
	function checkBadWord($content,$censoredSign = "&lt;censored&gt;",$dictionaryFile = "dictionary.inc")
	{
		if(!file_exists($dictionaryFile))
			return $content;
		else
		$readFile = file($dictionaryFile);
		for($z = 0;$z < sizeof($readFile);$z++)
		{
			@$content = eregi_replace(chop($readFile[$z]),$censoredSign,$content);
		}
		return $content;
	}


	function checkSmile($content, $path = "img/")
	{
		global $smile;
		if ($smile)
		{
			$content = ereg_replace("[)]{2,}", ")", $content);
			$content = ereg_replace("[(]{2,}", "(", $content);

			$content = str_replace(":)", returnImgTag("smile", $path), $content);
			$content = str_replace(":-)", returnImgTag("smile", $path), $content);

			$content = str_replace(";)", returnImgTag("wink", $path), $content);
			$content = str_replace(";-)", returnImgTag("wink", $path), $content);

			$content = str_replace(":(", returnImgTag("frown", $path), $content);
			$content = str_replace(";(", returnImgTag("frown", $path), $content);
			$content = str_replace(";-(", returnImgTag("frown", $path), $content);
			$content = str_replace(":-(", returnImgTag("frown", $path), $content);

			$content = str_replace(":[]", returnImgTag("fright", $path), $content);
			$content = str_replace(":J", returnImgTag("curve-smile", $path), $content);

			$content = eregi_replace(":o", returnImgTag("astonish", $path), $content);
			$content = eregi_replace(":-o", returnImgTag("astonish", $path), $content);
			$content = str_replace(":-0", returnImgTag("astonish", $path), $content);

			$content = eregi_replace(":p", returnImgTag("tongue", $path), $content);
			$content = eregi_replace(":-p", returnImgTag("tongue", $path), $content);
			$content = str_replace(":-b", returnImgTag("tongue", $path), $content);
			$content = str_replace(":b", returnImgTag("tongue", $path), $content);

			$content = str_replace(":D", returnImgTag("biggrin", $path), $content);
			$content = str_replace(":-D", returnImgTag("biggrin", $path), $content);

			$content = str_replace("%-)", returnImgTag("crazy", $path), $content);
			$content = str_replace("%)", returnImgTag("crazy", $path), $content);

			$content = str_replace("8-)", returnImgTag("cool", $path), $content);
			$content = str_replace("8)", returnImgTag("cool", $path), $content);

			$content = str_replace(":smoke:", returnImgTag("smoke", $path, 21, 20), $content);
			$content = str_replace(":icq:", returnImgTag("icq", $path, 16, 16), $content);
			$content = str_replace(":evil:", returnImgTag("evil", $path), $content);
			$content = str_replace(":apple:", returnImgTag("apple", $path), $content);
			$content = str_replace(":moo:", returnImgTag("moo", $path, 16, 16), $content);
		}
		return $content;
	}
/**
 *	returnImgTag transofm path
 *	@param String $imgName with extension
 *	@return String transform path 
 */
	function returnImgTag($imgName, $path, $width = "15", $height = "15")
	{
		return "<img src=\"".$path.$imgName.".gif\" width=\"".$width."\" height=\"".$height."\" alt=\"".$imgName."\" border=\"0\">";
	}

/**
 *	currDate return current formated date
 *	@param String $locale by default GB
 *	@return String date
 */

	function currDate($locale = "GB")
	{
	    setlocale ("LC_TIME", $locale);
		$currDay = strftime ("%d");
		$currMonth = strftime ("%B");
		$currYear = strftime ("%Y");
		$currWeek = strftime ("%a");
		$currFullWeek = strftime ("%A");
		return $currDay." ".$currMonth.", ".ucfirst($currFullWeek).", ".$currYear;
	}

/**
 *	currTime return current formated time
 *	@return String time
 */
	function currTime()
	{
		return date("H:i:s", time());
	}
?>