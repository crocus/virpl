<?PHP
$dbhost = "localhost";
$dbuname = "юзер";
$dbpass = "пароль";
$dbname = "база";
//////////////////////

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
$dtd="0000-00-00 00:00:00";

$Tt="<td colspan=3 bgcolor=eeeeee>Сегодня</td>";
$Ty="<td colspan=3 bgcolor=eeeeee>Вчера</td>";
$Td="<td colspan=3 bgcolor=eeeeee>За ".$tdays." дней</td>";
$Ta="<td colspan=3 bgcolor=eeeeee>Всего</td>";

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

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE s=$sid AND d>'$tday' AND t=0 GROUP BY s";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE s=$sid AND d>'$tday' AND t=1 GROUP BY s";
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

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE p='$p' AND s=$sid AND d>'$tday' AND t=0 GROUP BY p";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE p='$p' AND s=$sid AND d>'$tday' AND t=1 GROUP BY p";
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

echo "Статистика: <a href=stats.php>Сайты</a> | <a href=stats.php?action=ads>Баннеры</a><p>";

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

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE z=$id  AND s=$site AND d>'$tday' AND t=0 GROUP BY z";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE z=$id  AND s=$site AND d>'$tday' AND t=1 GROUP BY z";
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

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE z=0  AND s=$site AND d>'$tday' AND t=0 GROUP BY z";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE z=0 AND s=$site AND d>'$tday' AND t=1 GROUP BY z";
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

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE p='$p' AND s=$site AND d>'$tday' AND t=0 GROUP BY p";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE p='$p' AND s=$site AND d>'$tday' AND t=1 GROUP BY p";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$click = $row2["click"];
	ilbs_ctr($view, $click);


echo "</tr>";
}
echo "</table>";

break;

case "ads":

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
	$aid = $row["acc"];
	$aname = $row["aname"];
	$w = $row["w"];
	$h = $row["h"];
	echo "<tr><td bgcolor=eeeeee><a title=\"Подробнее...\" href=stats.php?action=bads&aid=$aid>$aname</a></td><td bgcolor=eeeeee>$w/$h</td>";
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
echo "<tr><td bgcolor=eeeeee>id</td><td bgcolor=eeeeee>Владелец</td><td bgcolor=eeeeee>Размер</td>
<td bgcolor=eeeeee>HTML</td>
<td bgcolor=eeeeee>Процент</td>
<td bgcolor=eeeeee>Сайт</td>
<td bgcolor=eeeeee>Положение</td>
<td bgcolor=eeeeee>Тип</td>
";
echo "$Tt";
echo "$Ty";
echo "$Td";
echo "$Ta";
echo "<td></td></tr>";
$sql="SELECT * FROM $dbban, $dbacc WHERE acc=aid AND percent>0 AND (sdate>'$today' OR sdate='$dtd') AND (rdate<='$today' OR rdate='$dtd') ";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
	$id = $row["id"];
	$aname = $row["aname"];
	$w = $row["w"];
	$s = $row["s"];
if ($s!=0){
$sql2="SELECT sname, url FROM $dbsites WHERE sid=$s";
$result2 = mysql_query($sql2);
$sr=mysql_fetch_array($result2);
	$s = $sr["sname"];
	$url = $sr["url"];
$s="<a href=$url target=_blank>$s</a>";
} else {$s="Любой";}
	$p = $row["p"];
	$h = $row["h"];
	$t = $row["t"];
	$html = $row["htm"];
	$percent = $row["percent"];
if ($t=="k") {$t="Коммерческий";}
if ($t=="d") {$t="Дефолтовый";}
if ($t=="u") {$t="Обычный";}
if ($p=="any") {$p="Любое";}
if ($p=="top") {$p="Верх";}
if ($p=="middle") {$p="Середина";}
if ($p=="bottom") {$p="Низ";}
if ($html!="") {$htm="+";} else {$htm="-";}
	echo "<tr><td bgcolor=eeeeee>$id</td><td bgcolor=eeeeee>$aname</td><td bgcolor=eeeeee>$w/$h</td>
<td bgcolor=eeeeee>$htm</td>
<td bgcolor=eeeeee>$percent%</td>
<td bgcolor=eeeeee>$s</td>
<td bgcolor=eeeeee>$p</td>
<td bgcolor=eeeeee>$t</td>
";

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

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE bid=$id AND d>'$tday' AND t=0 GROUP BY bid";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE bid=$id AND d>'$tday' AND t=1 GROUP BY bid";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$click = $row2["click"];
	ilbs_ctr($view, $click);

	$view = $row["view"];
	$click = $row["click"];
	ilbs_ctr($view, $click);
	echo "<td><a target=_blank href=show.php?id=$id>показать баннер</td></tr>";
}
echo "</table>";

break;

case "bads":
$sql="SELECT * FROM $dbacc WHERE aid=$aid";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
	$an = $row["aname"];
}

echo "<p>Баннеры ($an):";
echo "<table cellpadding=1 cellspacing=1 border=0>";
echo "<tr><td bgcolor=eeeeee>id</td><td bgcolor=eeeeee>Размер</td>
<td bgcolor=eeeeee>Статус</td>
<td bgcolor=eeeeee>HTML</td>
<td bgcolor=eeeeee>Процент</td>
<td bgcolor=eeeeee>Сайт</td>
<td bgcolor=eeeeee>Положение</td>
<td bgcolor=eeeeee>Тип</td>
<td bgcolor=eeeeee>Дата старта</td>
<td bgcolor=eeeeee>Дата стопа</td>
";
echo "$Tt";
echo "$Ty";
echo "$Td";
echo "$Ta";
echo "<td></td></tr>";
$sql="SELECT * FROM $dbban WHERE acc=$aid";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
	$id = $row["id"];
	$w = $row["w"];
	$s = $row["s"];
if ($s!=0){
$sql2="SELECT sname, url FROM $dbsites WHERE sid=$s";
$result2 = mysql_query($sql2);
$sr=mysql_fetch_array($result2);
	$s = $sr["sname"];
	$url = $sr["url"];
$s="<a href=$url target=_blank>$s</a>";
} else {$s="Любой";}
	$p = $row["p"];
	$h = $row["h"];
	$t = $row["t"];
	$html = $row["htm"];
	$percent = $row["percent"];
if ($t=="k") {$t="Коммерческий";}
if ($t=="d") {$t="Дефолтовый";}
if ($t=="u") {$t="Обычный";}
if ($p=="any") {$p="Любое";}
if ($p=="top") {$p="Верх";}
if ($p=="middle") {$p="Середина";}
if ($p=="bottom") {$p="Низ";}
if ($html!="") {$htm="+";} else {$htm="-";}

	$sdate = $row["sdate"];
	$rdate = $row["rdate"];
	$sdate=substr($sdate,0,10);
	$rdate=substr($rdate,0,10);

$act="Вкл";
if ($percent<1) {$act="Выкл";}
if ($percent>0 && $rdate>$today && $rdate!="0000-00-00") {$act="Выкл";}
if ($percent>0 && $sdate<=$today && $sdate!="0000-00-00") {$act="Выкл";}
if ($sdate=="0000-00-00") {$sdate="";}
if ($rdate=="0000-00-00") {$rdate="";}
	echo "<tr><td bgcolor=eeeeee>$id</td><td bgcolor=eeeeee>$w/$h</td>
<td bgcolor=eeeeee>$act</td>
<td bgcolor=eeeeee>$htm</td>
<td bgcolor=eeeeee>$percent%</td>
<td bgcolor=eeeeee>$s</td>
<td bgcolor=eeeeee>$p</td>
<td bgcolor=eeeeee>$t</td>
<td bgcolor=eeeeee>$rdate</td>
<td bgcolor=eeeeee>$sdate</td>
";

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

	$sql2="SELECT COUNT(id) AS view FROM $dbstats WHERE bid=$id AND d>'$tday' AND t=0 GROUP BY bid";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$view = $row2["view"];
	$sql2="SELECT COUNT(id) AS click FROM $dbstats WHERE bid=$id AND d>'$tday' AND t=1 GROUP BY bid";
	$result2 = mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$click = $row2["click"];
	ilbs_ctr($view, $click);

	$view = $row["view"];
	$click = $row["click"];
	ilbs_ctr($view, $click);
	echo "<td><a target=_blank href=show.php?id=$id>показать баннер</td></tr>";
}
echo "</table>";

break;

default:
echo "<p>Сайты:";
$site=0;
ilbs_site($site);
break;
}
?>
</body>
</html>