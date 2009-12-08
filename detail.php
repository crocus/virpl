<?php require_once('_scriptsphp/r_conn.php'); ?>
<?php
$SQLValueString = $_GET['flats_cod']; 
mysql_select_db($database_realtorplus, $realtorplus);
$query_Recordset1 = "SELECT f.flats_cod, f.flats_date, f.So, f.Sz, f.Sk, f.flats_price, f.foto, f.flats_tel, f.flats_floor, f.flats_floorest, f.flats_comments, t.type_name, r.room_cod, l.sale_name, c.cond_name, i.side_name, a.region_name, s.street_name, w.wc_short, b.balcon_short, m.material_short, p.plan_name, n.agency_name,  e.num_tel, n.agency_mail".
						" FROM tbl_flats f, tbl_type t, tbl_room r, tbl_region a, tbl_street s, tbl_wc w, tbl_balcon b, tbl_material m, tbl_plan p, tbl_sale l, tbl_cond c, tbl_side i, tbl_agency n, tbl_agent g, `tbl_telag` e  ".
						"WHERE f.type_cod = t.type_cod  AND f.room_cod = r.room_cod AND f.street_cod = s.street_cod AND s.region_cod = a.region_cod AND f.wc_cod = w.wc_cod AND f.balcon_cod = b.balcon_cod AND f.agent_cod = g.agent_cod AND g.agency_cod = n.agency_cod AND e.agency_name=n.agency_name".
						" AND f.material_cod = m.material_cod AND f.plan_cod = p.plan_cod AND f.sale_cod = l.sale_cod AND f.cond_cod = c.cond_cod AND f.side_cod = i.side_cod AND f.sale=0 AND f.flats_cod={$SQLValueString}";		
$Recordset1 = mysql_query($query_Recordset1, $realtorplus) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?> 
<?php echo "<?xml version=\"1.0\" encoding=\"windows-1251\"?".">"; ?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Подробная информация об объекте</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
</head>
<body bgcolor="#F1DABC">
<table border="0" cellpadding="1" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td rowspan="2" valign="top"><img src="_images/logo.gif" alt="logo_foliant" width="76" height="57"></td>
    <td  background="_images/fon.gif" valign="middle"><img src="_images/name.gif" width="298" height="40"></td>
      </tr>
    <tr> 
    <td  background="_images/fon.gif"align="center" valign="middle"> <div align="center"><font color="#710000"><strong>Все 
        операции с недвижимостью</strong></font></div></td>
      </tr>
 </table></br>
<table>
<tr>
<td valign="middle" ><p><font size="2">Дата постановки: <?php echo $row_Recordset1['flats_date']; ?> <br>
        Вид продажи: <?php echo $row_Recordset1['sale_name']; ?> <br>
        Тип объекта: <?php echo $row_Recordset1['type_name']; ?> <br>
        Количество комнат: <?php echo $row_Recordset1['room_cod']; ?> <br>
        Район: <?php echo $row_Recordset1['region_name']; ?> <br>
        Улица: <?php echo $row_Recordset1['street_name']; ?> <br>
        Площади, (So/Sж/Sk): <?php echo $row_Recordset1['So']; ?> / <?php echo $row_Recordset1['Sz']; ?> / <?php echo $row_Recordset1['Sk']; ?> <br>
        Этаж: <?php echo $row_Recordset1['flats_floor']; ?> <br>
        Этажность: <?php echo $row_Recordset1['flats_floorest']; ?> <br>
        Материал постройки: <?php echo $row_Recordset1['material_short']; ?> <br>
        Планировка: <?php echo $row_Recordset1['plan_name']; ?> <br>
        Балкон/лоджия: <?php echo $row_Recordset1['balcon_short']; ?> <br>
        Санузел: <?php echo $row_Recordset1['wc_short']; ?> <br>
        Состояние: <?php echo $row_Recordset1['cond_name']; ?> <br>
        Сторона света: <?php echo $row_Recordset1['side_name']; ?> <br>
        Телефонная точка: 
        <input  type="checkbox" name="sale" value="" <?php if (!(strcmp($row_Recordset1['flats_tel'],1))) {echo "checked";} ?>>
        <br>
        Цена объекта: <?php echo $row_Recordset1['flats_price']; ?> y.e. <br>
        Фотография: <?php echo $row_Recordset1['foto']; ?> <br>
        Примечание: 
        <textarea name="flats_comments" cols="30" rows="3" lang="ru"><?php echo $row_Recordset1['flats_comments']; ?></textarea>
        </font><br>
       <br> Контактная информация: <br><font size="2">
	   Агентство: <?php echo $row_Recordset1['agency_name']; ?> </font> <br>
	  <font size="2">E-mail: <a href="mailto:<?php echo $row_Recordset1['agency_mail']; ?>"><?php echo $row_Recordset1['agency_mail']; ?></a></font>
		<br>
	  <font size="2">Тел.: 
	   <?php do { ?>
	   <?php echo $row_Recordset1['num_tel']; ?>, 
        <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?></font>
		</td>
	</tr>
<tr><td>
<center>
<form action="" method="get">
 <input style="width: 148px;"type="button" value="Закрыть карточку" onclick="javascript: window.close()">
</form></center></td></tr>
</table>

</body>
</html>
<?php
mysql_free_result($Recordset1);
?> <br>