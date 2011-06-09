<?PHP

$admin_login="Admin";
$admin_password="admin";
$dbhost = "localhost";
$dbuname = "юзер";
$dbpass = "пароль";
$dbname = "база";
///////////////////////////////
$magic = md5 (uniqid (rand()));
$dbban="ibs_ban";
$dbzones="ibs_zones";
$dbstats="ibs_stats";
$dbsites="ibs_sites";
$dbacc="ibs_acc";
$dbpos="ibs_pos";
$today=date("Y-m-d");
$today_m = mktime(0,0,0,date("m"),date("d"),date("Y"));
$days=86400;
$tdays=10;
$yday_m=$today_m-$days;
$yday=date("Y-m-d", $yday_m);
$tday_m=$today_m-$tdays*$days;
$tday=date("Y-m-d", $tday_m);
$noinf="<font color=aaaaaa>n/a</font>";

$Tt="<td colspan=3 bgcolor=eeeeee>Сегодня</td>";
$Ty="<td colspan=3 bgcolor=eeeeee>Вчера</td>";
$Td="<td colspan=3 bgcolor=eeeeee>За ".$tdays." дней</td>";
$Ta="<td colspan=3 bgcolor=eeeeee>Всего</td>";


if (!isset($PHP_AUTH_USER)) {
header('WWW-Authenticate: Basic realm="Protected Area"');
header('HTTP/1.0 401 Unauthorized');
exit;
} else if (isset($PHP_AUTH_USER)) {
if ($admin_login==$PHP_AUTH_USER && $admin_password==$PHP_AUTH_PW) {
} else {
echo "Неверный логин/пароль!";
exit;}
} else {
header('WWW-Authenticate: Basic realm="Protected Area"');
header('HTTP/1.0 401 Unauthorized');
echo 'Authorization Required.';
exit;
}


function ilbs_site($site) {
global $dbban, $dbsites, $dbstats, $dbpos, $dbzones, $dbacc, $today, $yday, $tday, $tdays, $Tt, $Ty, $Td, $Ta, $noinf;

echo "<table cellpadding=1 cellspacing=1 border=0>";
echo "<tr><td bgcolor=eeeeee>ID</td><td bgcolor=eeeeee>Название</td>";
echo "$Tt";
echo "$Ty";
echo "$Td";
echo "$Ta";
echo "</tr>";

if ($site==0) {
	$sql="SELECT * FROM $dbsites";
} else {
	$sql="SELECT * FROM $dbsites WHERE sid=$site";
}
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
	$sid = $row["sid"];
	$sname = $row["sname"];
	$url = $row["url"];

	echo "<tr><td bgcolor=eeeeee>$sid</td><td bgcolor=eeeeee><a href=admin.php?action=site&site=$sid>$sname</a></td>";

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE s=$sid AND d='$today' AND t=0 GROUP BY s";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE s=$sid AND d='$today' AND t=1 GROUP BY s";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$click = $row2["click"];
	ilbs_ctr($view, $click);

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE s=$sid AND d='$yday' AND t=0 GROUP BY s";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE s=$sid AND d='$yday' AND t=1 GROUP BY s";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$click = $row2["click"];
	ilbs_ctr($view, $click);

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE s=$sid AND d>$tday AND t=0 GROUP BY s";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE s=$sid AND d>$tday AND t=1 GROUP BY s";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$click = $row2["click"];
	ilbs_ctr($view, $click);

	$view = $row["view"];
	$click = $row["click"];
	ilbs_ctr($view, $click);

	echo "</tr>";

	$sql3="SELECT p, pname FROM $dbpos, $dbstats WHERE pid=p AND s=$sid GROUP BY p ORDER BY p DESC";
	$result3 = mysql_query($sql3);
	while ($row3=mysql_fetch_array($result3)) {
	$p = $row3["p"];
	$pname = $row3["pname"];
	echo "<tr><td></td>";
	echo "<td bgcolor=eeeeee>$pname</td>";

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE p='$p' AND s=$sid AND d='$today' AND t=0 GROUP BY p";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE p='$p' AND s=$sid AND d='$today' AND t=1 GROUP BY p";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$click = $row2["click"];
	ilbs_ctr($view, $click);

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE p='$p' AND s=$sid AND d='$yday' AND t=0 GROUP BY p";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE p='$p' AND s=$sid AND d='$yday' AND t=1 GROUP BY p";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$click = $row2["click"];
	ilbs_ctr($view, $click);

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE p='$p' AND s=$sid AND d>$tday AND t=0 GROUP BY p";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE p='$p' AND s=$sid AND d>$tday AND t=1 GROUP BY p";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$click = $row2["click"];
	ilbs_ctr($view, $click);

echo "<td bgcolor=eeeeee colspan=3>$noinf</td></tr>";
}

}
echo "</table>";
}

function ilbs_ctr($view, $click) {
	if ($view>0) {
		$res = 100*$click/$view;
	} else { 
		$res=0;
		$view=0;
		$click=0;
	}
	if (!$click) {$click=0;}
	echo "<td bgcolor=eeeeee><font color=0000aa>$click</font></td><td bgcolor=eeeeee><font color=00aa00>$view</font></td><td bgcolor=eeeeee><font color=aa0000>";
	echo (number_format($res,2));
	echo "%</font></td>";
}

mysql_connect($dbhost, $dbuname, $dbpass);
@mysql_select_db("$dbname") or die ("Unable to select database");

$sitename="i L B S - баннерный движок";
$bg1="ffffff";
$mcolor="000000";
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//RU\">\n";
echo "<html>\n<head>\n";
echo "<title>$sitename</title>\n";
echo "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=windows-1251\">\n";
echo "<META NAME=\"AUTHOR\" CONTENT=\"$sitename\">\n";
echo "<META NAME=\"COPYRIGHT\" CONTENT=\"Copyright (c) 2001 by $sitename\">\n";
echo "<LINK REL=\"STYLESHEET\" HREF=\"style.css\">";
echo "</head>\n";
echo "<body text=$mcolor bgcolor=$bg1 topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 link=000000 vlink=000000>\n";

echo "<a href=admin.php>Статистика</a><p>";

switch ($action) {

case "site":
echo "<p>Статистика по сайту:";
ilbs_site($site);

echo "<p>Зоны сайта:";
echo "<table cellpadding=1 cellspacing=1 border=0>";
echo "<tr><td bgcolor=eeeeee>ID</td><td bgcolor=eeeeee>Зона</td>";
echo "$Tt";
echo "$Ty";
echo "$Td";
echo "$Ta";
echo "</tr>";
$sql="SELECT * FROM $dbzones WHERE sid=$site";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
	$id = $row["zid"];
	$zname = $row["zname"];
	echo "<tr><td bgcolor=eeeeee>$id</td><td bgcolor=eeeeee>$zname</td>";

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE z=$id and s=$site AND d='$today' AND t=0 GROUP BY z";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE z=$id  AND s=$site AND d='$today' AND t=1 GROUP BY z";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$click = $row2["click"];
	ilbs_ctr($view, $click);

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE z=$id  AND s=$site AND d='$yday' AND t=0 GROUP BY z";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE z=$id  AND s=$site AND d='$yday' AND t=1 GROUP BY z";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$click = $row2["click"];
	ilbs_ctr($view, $click);

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE z=$id  AND s=$site AND d>$tday AND t=0 GROUP BY z";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE z=$id  AND s=$site AND d>$tday AND t=1 GROUP BY z";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$click = $row2["click"];
	ilbs_ctr($view, $click);

	$view = $row["view"];
	$click = $row["click"];
	ilbs_ctr($view, $click);
	echo "</tr>";
	}

	echo "<tr><td bgcolor=eeeeee>0</td><td bgcolor=eeeeee>Другие страницы</td>";

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE z=0 and s=$site AND d='$today' AND t=0 GROUP BY z";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE z=0 AND s=$site AND d='$today' AND t=1 GROUP BY z";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$click = $row2["click"];
	ilbs_ctr($view, $click);

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE z=0  AND s=$site AND d='$yday' AND t=0 GROUP BY z";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE z=0 AND s=$site AND d='$yday' AND t=1 GROUP BY z";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$click = $row2["click"];
	ilbs_ctr($view, $click);

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE z=0  AND s=$site AND d>$tday AND t=0 GROUP BY z";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE z=0 AND s=$site AND d>$tday AND t=1 GROUP BY z";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$click = $row2["click"];
	ilbs_ctr($view, $click);
	echo "<td colspan=3 bgcolor=eeeeee>$noinf</td>";
	echo "</tr>";

echo "</table>";

echo "<p>Расположение баннеров:";
echo "<table cellpadding=1 cellspacing=1 border=0>";
echo "<tr><td bgcolor=eeeeee>Положение на странице</td>";
echo "$Tt";
echo "$Ty";
echo "$Td";
echo "</tr>";
$sql="SELECT p, pname FROM $dbstats, $dbpos WHERE p=pid AND s=$site GROUP BY p ORDER BY p DESC";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
	$p = $row["p"];
	$pname = $row["pname"];
	echo "<tr><td bgcolor=eeeeee>$pname</td>";

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE p='$p' AND s=$site AND d='$today' AND t=0 GROUP BY p";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE p='$p' AND s=$site AND d='$today' AND t=1 GROUP BY p";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$click = $row2["click"];
	ilbs_ctr($view, $click);

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE p='$p' AND s=$site AND d='$yday' AND t=0 GROUP BY p";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE p='$p' AND s=$site AND d='$yday' AND t=1 GROUP BY p";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$click = $row2["click"];
	ilbs_ctr($view, $click);

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE p='$p' AND s=$site AND d>$tday AND t=0 GROUP BY p";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE p='$p' AND s=$site AND d>$tday AND t=1 GROUP BY p";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$click = $row2["click"];
	ilbs_ctr($view, $click);


echo "</tr>";
}
echo "</table>";

break;

////////////////////
case "del_banner":
////////////////////
mysql_query("DELETE FROM $dbstats WHERE bid=$id");
mysql_query("DELETE FROM $dbban WHERE id=$id");
echo "Баннер $id удален.";
break;


////////////////////
case "no_stats":
////////////////////
mysql_query("DELETE FROM $dbstats");
mysql_query("UPDATE $dbzones set view=0");
mysql_query("UPDATE $dbsites set view=0");
mysql_query("UPDATE $dbban set view=0");
mysql_query("UPDATE $dbzones set click=0");
mysql_query("UPDATE $dbsites set click=0");
mysql_query("UPDATE $dbban set click=0");
echo "Статистика сброшена.";
break;

////////////////////
case "del_stats":
////////////////////
mysql_query("DELETE FROM $dbstats where d<'$tday'");
echo "Статистика сброшена.";
break;

default:
echo "<p>Сайты:";
$site=0;
ilbs_site($site);

echo "<p>Баннеры (по размерам):";
echo "<table cellpadding=1 cellspacing=1 border=0>";
echo "<tr><td bgcolor=eeeeee>Размер</td>";
echo "$Ta";
echo "</tr>";
$sql="SELECT id, w, h, SUM(view) as view, SUM(click) as click FROM $dbban GROUP BY w";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
	$id = $row["id"];
	$w = $row["w"];
	$h = $row["h"];
	$view = $row["view"];
	$click = $row["click"];
	echo "<tr><td bgcolor=eeeeee>$w/$h</td>";
	ilbs_ctr($view, $click);
	echo "</tr>";
}
$sql="SELECT SUM(view) as view, SUM(click) as click FROM $dbban";
$result = mysql_query($sql);
$row=mysql_fetch_array($result);
$click = $row["click"];
$view = $row["view"];
echo "<tr><td align=right>Итого:</td>";
ilbs_ctr($view, $click);
echo "</tr>";
echo "</table>";

echo "<p>Баннеры (по владельцам):";
echo "<table cellpadding=1 cellspacing=1 border=0>";
echo "<tr><td bgcolor=eeeeee>Владелец</td><td bgcolor=eeeeee>Размер</td>";
echo "$Ta";
echo "</tr>";
$sql="SELECT *, SUM(view) as view, SUM(click) as click FROM $dbban, $dbacc WHERE acc=aid GROUP BY acc";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
	$id = $row["id"];
	$aname = $row["aname"];
	$w = $row["w"];
	$h = $row["h"];
	echo "<tr><td bgcolor=eeeeee>$aname</td><td bgcolor=eeeeee>$w/$h</td>";
	$view = $row["view"];
	$click = $row["click"];
	ilbs_ctr($view, $click);
	echo "</tr>";
}
$sql="SELECT SUM(view) as view, SUM(click) as click FROM $dbban";
$result = mysql_query($sql);
$row=mysql_fetch_array($result);
$click = $row["click"];
$view = $row["view"];
echo "<tr><td></td><td align=right>Итого:</td>";
ilbs_ctr($view, $click);
echo "</tr>";
echo "</table>";


echo "<p>Баннеры:";
echo "<table cellpadding=1 cellspacing=1 border=0>";
echo "<tr><td bgcolor=eeeeee>Владелец</td><td bgcolor=eeeeee>Размер</td>";
echo "$Tt";
echo "$Ty";
echo "$Td";
echo "$Ta";
echo "<td></td></tr>";
$sql="SELECT * FROM $dbban, $dbacc WHERE acc=aid";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
	$id = $row["id"];
	$aname = $row["aname"];
	$w = $row["w"];
	$h = $row["h"];
	echo "<tr><td bgcolor=eeeeee>$aname</td><td bgcolor=eeeeee>$w/$h</td>";

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE bid=$id AND d='$today' AND t=0 GROUP BY bid";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE bid=$id AND d='$today' AND t=1 GROUP BY bid";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$click = $row2["click"];
	ilbs_ctr($view, $click);

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE bid=$id AND d='$yday' AND t=0 GROUP BY bid";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE bid=$id AND d='$yday' AND t=1 GROUP BY bid";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$click = $row2["click"];
	ilbs_ctr($view, $click);

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE bid=$id AND d>$tday AND t=0 GROUP BY bid";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE bid=$id AND d>$tday AND t=1 GROUP BY bid";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$click = $row2["click"];
	ilbs_ctr($view, $click);

	$view = $row["view"];
	$click = $row["click"];
	ilbs_ctr($view, $click);
	echo "<td><a href=admin.php?action=del_banner&id=$id>удалить</a></td></tr>";
}
echo "</table>";

echo "<p><a href=admin.php?action=no_stats>Сбросить всю статистику</a>";	
echo "<p><a href=admin.php?action=del_stats>Сбросить старую статистику</a>";	
break;
}
?>
</body>
</html>