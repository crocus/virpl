<?PHP
$dbhost = "localhost";
$dbuname = "юзер";
$dbpass = "пароль";
$dbname = "база";
/////////////////////
$dbzones="ibs_zones";
$dbstats="ibs_stats";
$dbsites="ibs_sites";
mysql_connect($dbhost, $dbuname, $dbpass);
@mysql_select_db("$dbname") or die ("Unable to select database");
$sql="SELECT link FROM $dbban WHERE id=$id";
$result = mysql_query($sql);
$row=mysql_fetch_array($result);
$link = $row["link"];
$today=date("Y-m-d");
$t=1;
mysql_query("INSERT INTO $dbstats (bid,d,s,p,z,t) VALUES ('$id','$today','$s','$p','$z','$t')");
mysql_query("UPDATE $dbzones set click=click+1 WHERE zid=$z");
mysql_query("UPDATE $dbsites set click=click+1 WHERE sid=$s");
mysql_query("UPDATE $dbban set click=click+1 WHERE id=$id");
$link=ereg_replace ("!zrnd", $magic, $link);
header ("Location: $link");
?>