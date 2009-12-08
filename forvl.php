<?php echo "<?xml version=\"1.0\" encoding=\"windows-1251\"?".">"; ?><?php require_once('_scriptsphp/r_conn.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
global $_GET;
mysql_select_db($database_realtorplus, $realtorplus);
$SQLQuery = "SELECT g.agency_name, f.flats_date, r.room_cod, k.sale_name" .
             ", a.region_name, s.street_name, f.So, f.Sz, f.Sk, f.flats_floor, f.flats_floorest" .
             ", m.material_short, p.plan_short, w.wc_short, b.balcon_short, f.flats_price, f.flats_cod, f.flats_tel " .
             ", t.type_s, d.side_name, l.cond_short, n.agent_name, f.flats_confid, f.flats_comments " .
             "FROM tbl_flats f, tbl_type t, tbl_sale k, tbl_room r," .
             "tbl_region a, tbl_street s, tbl_wc w, tbl_balcon b, tbl_side d, tbl_cond l," .
             " tbl_material m, tbl_agency g, tbl_agent n, tbl_plan p " .
             "WHERE f.type_cod = t.type_cod  AND f.room_cod = r.room_cod " .
             " AND f.sale_cod = k.sale_cod AND f.street_cod = s.street_cod" .
             " AND s.region_cod = a.region_cod  AND f.agent_cod = n.agent_cod AND n.agency_cod = g.agency_cod" .
             " AND f.wc_cod = w.wc_cod AND f.plan_cod = p.plan_cod AND f.balcon_cod = b.balcon_cod" .
             " AND f.material_cod = m.material_cod AND f.side_cod = d.side_cod AND f.cond_cod = l.cond_cod AND f.sale=0";
$query_Recordset1 = $SQLQuery;
$Recordset1 = mysql_query($query_Recordset1, $realtorplus) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
</head>
<script language="JavaScript">
<!--
function openwin(url,name) 
{ 
  var wn = window.open(url,name,'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,width=400,height=640,resizable=no,left=0,top=0');
  wn.focus();
  return false;
}
// -->
</script>
<center>
<body bgcolor="#F1DABC" >
<form  method="GET" name="form1" action="detail.php"  >
  <table  border="0"  bordercolor="#FF6633"  bordercolordark="#003300" width="580" align="left">
  <tr bgcolor="#FFD7AE"> 
    <td width="80"><div align="center"> <font size="2">Дата постановки</font></div></td>
    <td><div align="center"><font size="2">Тип</font></div></td>
    <td><div align="center"><font size="2">Комнат</font></div></td>
    <td><div align="center"><font size="2">Расположение</font></div></td>
    <td  width="100" align="center"><div align="center"><font size="2">Площади, (So/Sж/Sk)</font></div></td>
    <td><div align="center"><font size="2">С/У</font></div></td>
    <td width="50"><div align="center"><font size="2">Б/Л</font></div></td>
	<td width="50"><div align="center"><font size="2">Сторона света</font></div></td>
    <td><div align="center"><font size="2">Цена</font></div></td>
    <td width="200"><div align="center"><font size="2">Этаж</font></div></td>
	<td><div align="justify"><font size="2">Примечание</font></div></td>
	<td><div align="center"><font size="2">Агентство</font></div></td>
    </tr>
  <?php do { ?>
  <tr background="_images/fon.gif"align="center"   style="cursor: hand;"onMouseOver="this.style.background='#FFCC33'" onMouseOut="this.style.background=''" onClick="return openwin('detail.php?flats_cod=<?php echo $row_Recordset1['flats_cod']; ?>')" > 
    <td width="80"><div align="center"><font size="2"><?php echo $row_Recordset1['flats_date']; ?></font></div></td>
    <td><div align="center"><font size="2"><?php echo $row_Recordset1['type_s']; ?></font></div></td>
    <td><div align="center"><font size="2"><?php echo $row_Recordset1['room_cod']; ?></font></div></td>
    <td><div align="left"><font size="2"><?php echo $row_Recordset1['region_name']; ?><?php echo ","; ?><?php echo $row_Recordset1['street_name']; ?></font></div></td>
    <td width="100"><div align="center"><font size="2"><?php echo $row_Recordset1['So']; ?></font> <font size="2"><?php echo "/"; ?> <?php echo $row_Recordset1['Sz']; ?></font> <font size="2"><?php echo "/"; ?> <?php echo $row_Recordset1['Sk']; ?></font></div></td>
    <td><font size="2"><?php echo $row_Recordset1['wc_short']; ?></font></td>
    <td><font size="2"><?php echo $row_Recordset1['balcon_short']; ?></font></td>
	<td><font size="2"><?php echo $row_Recordset1['side_name']; ?></font></td>
    <td><div align="center"><font size="2"><?php echo $row_Recordset1['flats_price']; ?></font></div></td>
    <td align="center"><font size="2"><?php echo $row_Recordset1['flats_floor']; ?></font> <font size="2"><?php echo "/"; ?> <?php echo $row_Recordset1['flats_floorest']; ?></font> <font size="2"><?php echo $row_Recordset1['material_short']; ?></font></td>
     <td><div align="justify"><font size="2"><?php echo $row_Recordset1['flats_comments']; ?></font></div></td>
	 <td><font size="2"><?php echo $row_Recordset1['agency_name']; ?></font></td>
	 </tr>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
</form>
</body>
</center>
</html>
<?php
mysql_free_result($Recordset1);
?>
