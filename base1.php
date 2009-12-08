<?php 
require_once('_scriptsphp/r_conn.php'); 
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_realtorplus, $realtorplus);
$age = $_GET['agency'];
$typ = $_GET['type'];
$rom = $_GET['room'];
$region = $_GET['region'];
$bal = $_GET['balcon'];
$flr = $_GET['floor'];
$ord = $_GET['order'];
/* echo  "$age ";  */
$GenerQuery = "SELECT f.flats_cod, f.flats_date, f.So, f.Sz, f.Sk, f.flats_price, f.foto, f.flats_floor, f.flats_floorest, t.type_s, r.room_cod, a.region_name, s.street_name, w.wc_short, b.balcon_short, m.material_short".
						" FROM tbl_flats f, tbl_type t, tbl_room r, tbl_region a, tbl_street s, tbl_wc w, tbl_balcon b, tbl_material m, tbl_agency g, tbl_agent n ".
						"WHERE f.type_cod = t.type_cod  AND f.room_cod = r.room_cod AND f.street_cod = s.street_cod AND s.region_cod = a.region_cod AND f.agent_cod = n.agent_cod AND n.agency_cod = g.agency_cod AND f.wc_cod = w.wc_cod AND f.balcon_cod = b.balcon_cod".
						" AND f.material_cod = m.material_cod";
$WhereQuery = " And";
$acon = " And";
$rcon = " And";
$bcon = " And";
$regcon = " And";
$flrcon = " And";
?>
<?php
 switch ( $age ) {
    case NULL:
       $AgeQuery = (" f.agent_cod IS NOT NULL ");
        break;
    case "значение не задано":
         $AgeQuery = (" f.agent_cod IS NOT NULL ");
         break;
    default : 
        $AgeQuery  = " n.agency_cod = {$age}";
        break;
}
 switch ( $typ ) {
    case NULL:
       $TypQuery = (" f.type_cod IS NOT NULL ");
        break;
    case "значение не задано":
         $TypQuery = (" f.type_cod IS NOT NULL ");
         break;
    default : 
        $TypQuery  = " f.type_cod = {$typ}";
        break;
}
switch ( $rom ) {
    case NULL:
       $romQuery = (" f.room_cod IS NOT NULL ");
        break;
    case "значение не задано":
         $romQuery = (" f.room_cod IS NOT NULL ");
         break;
    default : 
        $romQuery  = " f.room_cod = {$rom}";
        break;
}
switch ( $bal  ) {
    case NULL:
       $balQuery = (" f.balcon_cod IS NOT NULL ");
        break;
    case "значение не задано":
        $balQuery = (" f.balcon_cod IS NOT NULL ");
         break;
    default : 
        $balQuery  = " f.balcon_cod = {$bal}";
        break;
}
switch ( $region ) {
    case NULL:
       $regQuery = (" f.street_cod IS NOT NULL ");
        break;
    case "значение не задано":
        $regQuery = (" f.street_cod IS NOT NULL ");
         break;
    default : 
        $regQuery  = " s.region_cod = {$region}";
        break;
}
switch ( $flr ) {
    case NULL:
       $flrQuery = (" f.flats_floor IS NOT NULL ");
        break;
    case "значение не задано":
        $flrQuery = (" f.flats_floor IS NOT NULL ");
         break;
    case "noferst":
        $flrQuery = (" f.flats_floor<>0 AND f.flats_floor<>1 ");
         break;
    case "nolast":
        $flrQuery = (" f.flats_floor<>f.flats_floorest ");
         break;
	 case "middle":
        $flrQuery = (" f.flats_floor<>0 AND f.flats_floor<>1 AND f.flats_floor<>f.flats_floorest ");
         break;
	default : 
        $flrQuery  = " f.flats_floor IS NOT NULL ";
        break;
}
switch ( $ord ) {
    case NULL:
       $ordQuery = (" ORDER BY f.flats_price");
        break;
    case "значение не задано":
        $ordQuery = (" ORDER BY r.room_cod");
         break;
    case "type":
        $ordQuery = (" ORDER BY  t.type_s");
         break;
	case "date":
        $ordQuery = (" ORDER BY f.flats_date DESC");
         break;
	case "room":
        $ordQuery = (" ORDER BY r.room_cod");
         break;
	case "price":
        $ordQuery = (" ORDER BY f.flats_price DESC");
         break;
	default : 
        $ordQuery  = " ORDER BY {$ord }";
        break;
}
$SQLQuery = $GenerQuery . $WhereQuery . $AgeQuery . $acon. $TypQuery . $rcon . $romQuery . $bcon . $balQuery . $regcon . $regQuery . $flrcon . $flrQuery . $ordQuery;
$query_Recordset1 = $SQLQuery;

 /* echo $SQLQuery;  */
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $realtorplus) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . implode("&", $newParams);
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ООО"Фолиант"- недвижимость Владивостока</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
</head>
<script language="JavaScript">
<!--
function openwin(url,name) 
{ 
  var wn = window.open(url,name,'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,width=420,height=680,resizable=no,left=0,top=0');
  wn.focus();
  return false;
}
// -->
</script>

<body bgcolor="#F1DABC" >
Внимание!!! При постановке объектов на продажу в поле "Примечание" не используйте символ ";"!!!<br>
<form  method="GET" name="form1" action="detail.php"  >
  <table  border="0"  bordercolor="#FF6633"  bordercolordark="#003300" width="580" align="left">
  <tr bgcolor="#FFD7AE"> 
    <td width="80"><div align="center"> <font size="2">Дата постановки</font></div></td>
    <td><div align="center"><font size="2">Тип</font></div></td>
    <td><div align="center"><font size="2">Комнат</font></div></td>
    <td><div align="center"><font size="2">Расположение</font></div></td>
    <td  width="100" align="center"><div align="center"><font size="2">Площади, (So/Sж/Sk)</font></div></td>
    <td bgcolor="#FFD7AE"><div align="center"><font size="2">С/У</font></div></td>
    <td width="50"><div align="center"><font size="2">Б/Л</font></div></td>
    <td><div align="center"><font size="2">Цена</font></div></td>
    <td width="200"><div align="center"><font size="2">Этаж</font></div></td>
      </tr>
  <?php do { ?>
  <tr background="_images/fon.gif"align="center"   style="cursor: hand;"onmouseover="this.style.background='#FFCC33'" onmouseout="this.style.background=''" onclick="document.location='Update.php?flats_cod=<?php echo $row_Recordset1['flats_cod']; ?>'" > 
    <td width="80"><div align="center"><font size="2"><?php echo $row_Recordset1['flats_date']; ?></font></div></td>
    <td><div align="center"><font size="2"><?php echo $row_Recordset1['type_s']; ?></font></div></td>
    <td><div align="center"><font size="2"><?php echo $row_Recordset1['room_cod']; ?></font></div></td>
    <td><div align="left"><font size="2"><?php echo $row_Recordset1['region_name']; ?><?php echo ","; ?><?php echo $row_Recordset1['street_name']; ?></font></div></td>
    <td width="100"><div align="center"><font size="2"><?php echo $row_Recordset1['So']; ?></font> <font size="2"><?php echo "/"; ?> <?php echo $row_Recordset1['Sz']; ?></font> <font size="2"><?php echo "/"; ?> <?php echo $row_Recordset1['Sk']; ?></font></div></td>
    <td><font size="2"><?php echo $row_Recordset1['wc_short']; ?></font></td>
    <td><font size="2"><?php echo $row_Recordset1['balcon_short']; ?></font></td>
    <td><div align="center"><font size="2"><?php echo $row_Recordset1['flats_price']; ?></font></div></td>
    <td align="center"><font size="2"><?php echo $row_Recordset1['flats_floor']; ?></font> <font size="2"><?php echo "/"; ?> <?php echo $row_Recordset1['flats_floorest']; ?></font> <font size="2"><?php echo $row_Recordset1['material_short']; ?></font></td>
     </tr>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>

  <tr> 
    <td  colspan="3" align="center"> <font size="2"> 
      <?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="_images/First.gif" border=0></a> 
      <?php } // Show if not first page ?>
      </font></td>
    <td  colspan="2" align="center"> <font size="2"> 
      <?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="_images/Previous.gif" border=0></a> 
      <?php } // Show if not first page ?>
      </font></td>
    <td colspan="2"align="center"> <font size="2"> 
      <?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="_images/Next.gif" border=0></a> 
      <?php } // Show if not last page ?>
      </font></td>
    <td colspan="3"align="center"> <font size="2"> 
      <?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="_images/Last.gif" border=0></a> 
      <?php } // Show if not last page ?>
      </font></td>
  </tr>
  <tr> 
    <td height="38" colspan="11" align="center"valign="center" ><font size="2">Объекты с <?php echo ($startRow_Recordset1 + 1) ?> по <?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> из <?php echo $totalRows_Recordset1 ?> найденных в базе данных</font></td>
  </tr>


</table>
</form>
<p><font size="2"><br>
  </font></p>

</body>
</html>
<?php
mysql_free_result($Recordset1);
?>




