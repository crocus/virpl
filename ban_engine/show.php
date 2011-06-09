<?PHP

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

mysql_connect($dbhost, $dbuname, $dbpass);
@mysql_select_db("$dbname") or die ("Unable to select database");

$sql="SELECT * FROM $dbban WHERE id=$id";
$result = mysql_query($sql);
$row=mysql_fetch_array($result);
$alt = $row["alt"];
$image = $row["image"];
$link = $row["link"];
$w = $row["w"];
$h = $row["h"];
$htm = $row["htm"];
$today=date("Y-m-d");
$t=0;

echo "<center><h3>Баннер $id</h3></center>";

if (!$htm) {
$image=ereg_replace ("!zrnd", $magic, $image);
echo "<center><a target=_top href=$link><img src=$image target=_blank width=$w height=$h border=0 alt=\"$alt\"></a></center>";
} else {
echo "\n$htm\n";
}
?>