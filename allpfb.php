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

$SQLQuery = "SELECT f.id_fs, f.d_fs, f.n_fs, f.m_fs, f.ap_fs, f.t_fs, f.price_fs, t.type_s, r.room_cod, a.region_name,  f.comm_fs".
						" FROM tbl_fbuy f, tbl_type t, tbl_room r, tbl_region a ".
						"WHERE f.type_cod = t.type_cod  AND f.room_cod = r.room_cod  AND f.region_cod = a.region_cod";
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

<body bgcolor="#F1DABC" >
<form  method="GET" name="form1" action="detail.php"  >
  <table  border="0"  bordercolor="#FF6633"  bordercolordark="#003300" width="100%" align="left"><!--DWLayoutTable-->
  <tr bgcolor="#FFD7AE"> 
    <td width="80"><div align="center"> <font size="2">Дата постановки</font></div></td>
    <td><div align="center"><font size="2">Тип</font></div></td>
    <td><div align="center"><font size="2">Комнат</font></div></td>
    <td><div align="center"><font size="2">Расположение</font></div></td>
    <td width="100%"><div align="center">Комментарии</div></td>
    <td width="50"><div align="center"><font size="2">Цена</font></div></td>
    <td><div align="center"><font size="2">Имя</font></div></td>
    <td width="200"><div align="center"><font size="2">Телефон</font></div></td>
     <td width="200"><div align="center"><font size="2">Иная связь</font></div></td>
	  <td>&nbsp;</td><td>&nbsp;</td></tr>
  <?php do { ?>
  <tr background="_images/fon.gif"align="center"   style="cursor: hand;"onmouseover="this.style.background='#FFCC33'" onmouseout="this.style.background=''" > 
    <td width="80"><div align="center"><font size="2"><?php echo $row_Recordset1['d_fs']; ?></font></div></td>
    <td><div align="center"><font size="2"><?php echo $row_Recordset1['type_s']; ?></font></div></td>
    <td><div align="center"><font size="2"><?php echo $row_Recordset1['room_cod']; ?></font></div></td>
    <td><div align="left"><font size="2"><?php echo $row_Recordset1['region_name']; ?></font></div></td>
    <td align="left" valign="middle"><font size="2"><?php echo $row_Recordset1['comm_fs']; ?></font></td>
    <td><div align="justify"><font size="2">                <?php echo $row_Recordset1['price_fs']; ?>                      </font></div></td>
    <td><div align="center"><font size="2"><?php echo $row_Recordset1['n_fs']; ?></font></div></td>
    <td align="center"><font size="2"><?php echo $row_Recordset1['t_fs']; ?></td>
     <td align="center"><font size="2"><?php echo $row_Recordset1['ap_fs']; ?></td>
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
  <td>&nbsp;</td></tr>
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
