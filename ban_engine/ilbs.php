<?PHP

function show_ilbs($w, $h, $p, $n, $b, $s, $randn){

global $PHP_SELF;

//переменные

$dbhost = "localhost";
$dbuname = "юзер";
$dbpass = "пароль";
$dbname = "база";
//////////////////////


$today=date("Y-m-d H:m:s");
$today2=date("Y-m-d");
$dtd="0000-00-00 00:00:00";

//$magic = md5 (uniqid (rand()));
$magic = uniqid (rand());
$magic=substr($magic,0,5);
//$magic = rand();
$dbban="ibs_ban";
$dbzones="ibs_zones";
$dbstats="ibs_stats";
$dbsites="ibs_sites";

//связь с базой

mysql_connect($dbhost, $dbuname, $dbpass);
mysql_select_db("$dbname") or die ("Unable to select database");

//определение зоны

$ztemplate=$PHP_SELF;
if ($ztemplate=="/") {$ztemplate="/index.php";}
$sql="SELECT zid FROM $dbzones WHERE ztemplate LIKE '$ztemplate' AND sid=$s";
$result=mysql_query($sql);
if ($result) {
	$row=mysql_fetch_array($result);
	$z=$row["zid"];
}
if ($z=="") {$z=0;}

//коммерческий баннер с зоной
$sql="SELECT id, percent FROM $dbban WHERE w=$w AND h=$h AND b LIKE '%$b%' AND percent>0 AND (s=$s OR s=0) AND (p='$p' OR p='any') AND z=$z AND t='k' AND (rdate<='$today' or rdate='$dtd') AND (sdate>'$today' or sdate='$dtd') ORDER BY percent*RAND() DESC LIMIT 0,1";
$result = mysql_query($sql);
if ($result) {
	$row=mysql_fetch_array($result);
	$id = $row["id"];
	$percent = $row["percent"];
	$sql="SELECT SUM(percent) AS total FROM $dbban WHERE w=$w AND h=$h AND b LIKE '%$b%' AND percent>0 AND (s=$s OR s=0) AND (p='$p' OR p='any') AND z=$z AND t='k' AND (rdate<='$today' or rdate='$dtd') AND (sdate>'$today' or sdate='$dtd')";
	$result = mysql_query($sql);
	$row=mysql_fetch_array($result);
	$total = $row["total"];
	if ($total<100) {
		$no=100-$total;
		$no=$no*rand(1,100);
		$percent=$percent*rand(1,100);
		if ($percent<$no) {$id="";}
	}
}

//коммерческий баннер
if (!$id) {
$sql="SELECT id, percent FROM $dbban WHERE w=$w AND h=$h AND b LIKE '%$b%' AND percent>0 AND (s=$s OR s=0) AND (p='$p' OR p='any') AND (z=$z OR z=0) AND t='k' AND (rdate<='$today' or rdate='$dtd') AND (sdate>'$today' or sdate='$dtd') ORDER BY percent*RAND() DESC LIMIT 0,1";
$result = mysql_query($sql);
if ($result) {
	$row=mysql_fetch_array($result);
	$id = $row["id"];
	$percent = $row["percent"];
	$sql="SELECT SUM(percent) AS total FROM $dbban WHERE w=$w AND h=$h AND b LIKE '%$b%' AND percent>0 AND (s=$s OR s=0) AND (p='$p' OR p='any') AND (z=$z OR z=0) AND t='k' AND (rdate<='$today' or rdate='$dtd') AND (sdate>'$today' or sdate='$dtd')";
	$result = mysql_query($sql);
	$row=mysql_fetch_array($result);
	$total = $row["total"];
	if ($total<100) {
		$no=100-$total;
		$no=$no*rand(1,100);
		$percent=$percent*rand(1,100);
		if ($percent<$no) {$id="";}
	}
}
}

//если нет коммерческого, то обычный
if (!$id) {
	$sql="SELECT id FROM $dbban WHERE w=$w AND h=$h AND b LIKE '%$b%' AND percent>0 AND (s=$s OR s=0) AND (p='$p' OR p='any') AND (z=$z OR z=0) AND (rdate<='$today' or rdate='$dtd') AND (sdate>'$today' or sdate='$dtd') ORDER BY percent*RAND() DESC LIMIT 0,1";
	$result = mysql_query($sql);
	if ($result) {
	$row=mysql_fetch_array($result);
	$id = $row["id"];
	} else {
	//если нет обычного, то по умолчанию
	$sql="SELECT id FROM $dbban WHERE w=$w AND h=$h AND b LIKE '%$b%' AND (p='$p' OR p='any') AND t='d'";
	$result = mysql_query($sql);
	$row=mysql_fetch_array($result);
	$id = $row["id"];
	}
}

//показываем
$sql="SELECT alt, image, htm FROM $dbban WHERE id=$id";
$result = mysql_query($sql);
$row=mysql_fetch_array($result);
$alt = $row["alt"];
$image = $row["image"];
$htm = $row["htm"];
$t=0;

if (!$htm) {
$image=ereg_replace ("!zrnd", $magic, $image);
echo "<center><a target=_blank href=http://ad.igray.ru/local/ilbsc.php?id=$id&s=$s&p=$p&z=$z&magic=$magic&ref=$PHP_SELF><img src=$image target=_blank width=$w height=$h border=0 alt=\"$alt\"></a></center>";
mysql_query("INSERT INTO $dbstats (bid,d,s,p,z,t) VALUES ('$id','$today2','$s','$p','$z','$t')");
mysql_query("UPDATE $dbzones set view=view+1 WHERE zid=$z");
mysql_query("UPDATE $dbsites set view=view+1 WHERE sid=$s");
mysql_query("UPDATE $dbban set view=view+1 WHERE id=$id");
} else {
echo "\n$htm\n";
}
mysql_free_result($result);
}
?>