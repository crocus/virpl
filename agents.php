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
/* echo  "$age ";  */
$Agent_Query = "SELECT  n.agent_cod, g.agency_name, n.agent_name, n.agent_mail, n.agent_pass".
						" FROM tbl_agency g, tbl_agent n ".
						"WHERE n.agency_cod = g.agency_cod ";
$query_Recordset1 = $Agent_Query ;
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
<form  method="GET" name="form1" action="detail.php"  >
  <table  border="0"  bordercolor="#FF6633"  bordercolordark="#003300" width="580" align="left">
  <tr bgcolor="#FFD7AE"> 
    <td bgcolor="#FFD7AE"><div align="center"><font size="2">Агентство</font></div></td>
    <td width="50"><div align="center"><font size="2">Имя агента</font></div></td>
    <td><div align="center"><font size="2">Е-mail</font></div></td>
      <td><div align="center">Пароль</div></td>
	 </tr>
  <?php do { ?>
  <tr background="_images/fon.gif"align="center"   style="cursor: hand;"onmouseover="this.style.background='#FFCC33'" onmouseout="this.style.background=''" onclick="document.location='reload_ag.php?agent_cod=<?php echo $row_Recordset1['agent_cod']; ?>'" > 
    <td><font size="2"><?php echo $row_Recordset1['agency_name']; ?></font></td>
    <td><font size="2"><?php echo $row_Recordset1['agent_name']; ?></font></td>
    <td><div align="center"><font size="2"><a href="mailto:<?php echo $row_Recordset1['agent_mail']; ?>"><?php echo $row_Recordset1['agent_mail']; ?></a></font></div></td>
     <td><div align="center"><font size="2"><?php echo $row_Recordset1['agent_pass']; ?></font></div></td>
	 </tr>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>

  <tr> 
    <td   align="center"> <font size="2"> 
      <?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="_images/First.gif" border=0></a> 
      <?php } // Show if not first page ?>
      </font></td>
    <td  align="center"> <font size="2"> 
      <?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="_images/Previous.gif" border=0></a> 
      <?php } // Show if not first page ?>
      </font></td>
    <td align="center"> <font size="2"> 
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
      <td height="38" colspan="11" align="center"valign="center" ><font size="2">Агенты</font><font size="2"> 
        с <?php echo ($startRow_Recordset1 + 1) ?> по <?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> из <?php echo $totalRows_Recordset1 ?> </font></td>
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
