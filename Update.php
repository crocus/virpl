<?php  require_once('_scriptsphp/r_conn.php'); 
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;
  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . $_SERVER['QUERY_STRING'];
}
	$ButName = $_POST['action'];
	 if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	switch ($ButName) {
	case "Обновить":
	$SQLpost = sprintf("UPDATE tbl_flats SET sale_cod=%s, type_cod=%s, So=%s, Sz=%s, Sk=%s, plan_cod=%s, wc_cod=%s, balcon_cod=%s, side_cod=%s, cond_cod=%s, flats_comments=%s, agent_cod=%s, flats_date=%s, flats_tel=%s, street_cod=%s, flats_price=%s, room_cod=%s, flats_floor=%s, flats_floorest=%s, material_cod=%s, flats_adress=%s, flats_confid=%s, foto=%s, sale=%s, date_sale=%s, price_sale=%s WHERE flats_cod=%s",
                       GetSQLValueString($_POST['sale_cod'], "int"),
                       GetSQLValueString($_POST['type_cod'], "int"),
                       GetSQLValueString($_POST['So'], "double"),
                       GetSQLValueString($_POST['Sz'], "double"),
                       GetSQLValueString($_POST['Sk'], "double"),
                       GetSQLValueString($_POST['plan_cod'], "int"),
                       GetSQLValueString($_POST['wc_cod'], "int"),
                       GetSQLValueString($_POST['balcon_cod'], "int"),
                       GetSQLValueString($_POST['side_cod'], "int"),
                       GetSQLValueString($_POST['cond_cod'], "int"),
                       GetSQLValueString($_POST['flats_comments'], "text"),
                       GetSQLValueString($_POST['agent_cod'], "int"),
                       GetSQLValueString($_POST['flats_date'], "date"),
                       GetSQLValueString(isset($_POST['flats_tel']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['street_cod'], "int"),
                       GetSQLValueString($_POST['flats_price'], "int"),
                       GetSQLValueString($_POST['room_cod'], "int"),
                       GetSQLValueString($_POST['flats_floor'], "int"),
                       GetSQLValueString($_POST['flats_floorest'], "int"),
                       GetSQLValueString($_POST['material_cod'], "int"),
                       GetSQLValueString($_POST['flats_adress'], "text"),
                       GetSQLValueString($_POST['flats_confid'], "text"),
                       GetSQLValueString($_POST['foto'], "text"),
                       GetSQLValueString(isset($_POST['sale']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['date_sale'], "date"),
                       GetSQLValueString($_POST['price_sale'], "int"),
                       GetSQLValueString($_POST['flats_cod'], "int")); 
      break;
    case "Удалить":
	 $SQLpost = sprintf("DELETE FROM tbl_flats WHERE flats_cod=%s",
 						GetSQLValueString($_POST['flats_cod'], "int")); 
      break;
  	default : 
	  $SQLpost = sprintf("DELETE FROM tbl_flats WHERE flats_cod=%s",
 						GetSQLValueString($_POST['flats_cod'], "int")); 
      break; 
	 }
  mysql_select_db($database_realtorplus, $realtorplus);
  $Result1 = mysql_query($SQLpost, $realtorplus) or die(mysql_error());
  $updateGoTo = "base1.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
$SQLValueStringUp = $_GET['flats_cod']; 
mysql_select_db($database_realtorplus, $realtorplus);
$query_Recordset1 = "SELECT * FROM tbl_flats WHERE flats_cod={$SQLValueStringUp}";		
$Recordset1 = mysql_query($query_Recordset1, $realtorplus) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$query_Street = "SELECT * FROM tbl_street";
$Street = mysql_query($query_Street, $realtorplus) or die(mysql_error());
$row_Street = mysql_fetch_assoc($Street);
$totalRows_Street = mysql_num_rows($Street);

$query_Plan= "SELECT * FROM tbl_plan";
$Plan = mysql_query($query_Plan, $realtorplus) or die(mysql_error());
$row_Plan = mysql_fetch_assoc($Plan);
$totalRows_Plan = mysql_num_rows($Plan);

$query_Room= "SELECT * FROM tbl_room";
$Room = mysql_query($query_Room, $realtorplus) or die(mysql_error());
$row_Room = mysql_fetch_assoc($Room);
$totalRows_Room = mysql_num_rows($Room);

$query_Cond= "SELECT * FROM tbl_cond";
$Cond = mysql_query($query_Cond, $realtorplus) or die(mysql_error());
$row_Cond = mysql_fetch_assoc($Cond);
$totalRows_Cond = mysql_num_rows($Cond);

$query_Balc= "SELECT * FROM tbl_balcon";
$Balc = mysql_query($query_Balc, $realtorplus) or die(mysql_error());
$row_Balc = mysql_fetch_assoc($Balc);
$totalRows_Balc = mysql_num_rows($Balc);

$query_Mat= "SELECT * FROM tbl_material";
$Mat = mysql_query($query_Mat, $realtorplus) or die(mysql_error());
$row_Mat = mysql_fetch_assoc($Mat);
$totalRows_Mat = mysql_num_rows($Mat);

$query_WC= "SELECT * FROM tbl_wc";
$WC = mysql_query($query_WC, $realtorplus) or die(mysql_error());
$row_WC = mysql_fetch_assoc($WC);
$totalRows_WC = mysql_num_rows($WC);

$query_Sale= "SELECT * FROM tbl_sale";
$Sale = mysql_query($query_Sale, $realtorplus) or die(mysql_error());
$row_Sale = mysql_fetch_assoc($Sale);
$totalRows_Sale = mysql_num_rows($Sale);

$query_Type= "SELECT * FROM tbl_type";
$Type = mysql_query($query_Type, $realtorplus) or die(mysql_error());
$row_Type = mysql_fetch_assoc($Type);
$totalRows_Type = mysql_num_rows($Type);

$query_Side= "SELECT * FROM tbl_side";
$Side = mysql_query($query_Side, $realtorplus) or die(mysql_error());
$row_Side = mysql_fetch_assoc($Side);
$totalRows_Side = mysql_num_rows($Side);

$query_Agent= "SELECT * FROM tbl_agent";
$Agent = mysql_query($query_Agent, $realtorplus) or die(mysql_error());
$row_Agent = mysql_fetch_assoc($Agent);
$totalRows_Agent = mysql_num_rows($Agent);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ООО"Фолиант"- недвижимость Владивостока</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
</head>
<body bgcolor="#F1DABC">
<form  method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="let"  border="0" >
        <tr background="_images/fon.gif" bgcolor="#FFD7AE" valign="baseline"> 
      <td height="28" align="right" valign="top" nowrap><font size="2">Дата постановки:</font></td>
      <td width="136" valign="top" ><font size="2"> 
        <input type="text" name="flats_date" value="<?php echo $row_Recordset1['flats_date']; ?>" size="21">
        </font></td>
      <td width="103" align="right" valign="top" nowrap><font size="2">Планировка:</font></td>
      <td colspan="2"  align="left" nowrap> <select  style="width: 148px;"  name="plan_cod">
          <?php 
do {  
?>
          <option value="<?php echo $row_Plan['plan_cod']?>" <?php if (!(strcmp($row_Plan['plan_cod'], $row_Recordset1['plan_cod']))) {echo "SELECTED";} ?>><?php echo $row_Plan['plan_name']?></option>
          <?php
} while ($row_Plan = mysql_fetch_assoc($Plan));
?>
        </select ></td>
    <tr bgcolor="#F1DABC" valign="baseline"> 
      <td height="28" align="right" nowrap><font size="2">Вид продажи:</font></td>
      <td valign="top"> <font size="2"> 
        <select  style="width: 148px;"name="sale_cod">
          <?php 
do {  
?>
          <option value="<?php echo $row_Sale['sale_cod']?>" <?php if (!(strcmp($row_Sale['sale_cod'], $row_Recordset1['sale_cod']))) {echo "SELECTED";} ?>><?php echo $row_Sale['sale_name']?></option>
          <?php
} while ($row_Sale = mysql_fetch_assoc($Sale));
?>
        </select >
        </font></td>
      <td align="right" valign="top" nowrap><font size="2">Санузел:</font></td>
      <td colspan="2" valign="top"> <font size="2"> 
        <select  style="width: 148px;"  name="wc_cod">
          <?php 
do {  
?>
          <option value="<?php echo $row_WC['wc_cod']?>" <?php if (!(strcmp($row_WC['wc_cod'], $row_Recordset1['wc_cod']))) {echo "SELECTED";} ?>><?php echo $row_WC['wc_name']?></option>
          <?php
} while ($row_WC = mysql_fetch_assoc($WC));
?>
        </select >
        </font></td>
    </tr>
    <tr background="_images/fon.gif" bgcolor="#FFD7AE" valign="baseline"> 
      <td height="28" align="right" nowrap><font size="2">Тип объекта:</font></td>
      <td valign="top"> <font size="2"> 
        <select  style="width: 148px;"  name="type_cod">
          <?php 
do {  
?>
          <option value="<?php echo $row_Type['type_cod']?>" <?php if (!(strcmp($row_Type['type_cod'], $row_Recordset1['type_cod']))) {echo "SELECTED";} ?>><?php echo $row_Type['type_s']?></option>
          <?php
} while ($row_Type = mysql_fetch_assoc($Type));
?>
        </select >
        </font></td>
      <td align="right" valign="top" nowrap><font size="2">Балкон/лоджия:</font></td>
      <td colspan="2" valign="top"> <font size="2"> 
        <select  style="width: 148px;"  name="balcon_cod">
          <?php 
do {  
?>
          <option value="<?php echo $row_Balc['balcon_cod']?>" <?php if (!(strcmp($row_Balc['balcon_cod'], $row_Recordset1['balcon_cod']))) {echo "SELECTED";} ?>><?php echo $row_Balc['balcon_name']?></option>
          <?php
} while ($row_Balc = mysql_fetch_assoc($Balc));
?>
        </select >
        </font></td>
    </tr>
    <tr background="_images/fon.gif" bgcolor="#FFD7AE" valign="baseline"> 
      <td height="28" align="right" nowrap><font size="2">Улица:</font></td>
      <td valign="top"> <font size="2"> 
        <select  style="width: 148px;"  name="street_cod">
          <?php 
do {  
?>
          <option value="<?php echo $row_Street['street_cod']?>" <?php if (!(strcmp($row_Street['street_cod'], $row_Recordset1['street_cod']))) {echo "SELECTED";} ?>><?php echo $row_Street['street_name']?></option>
          <?php
} while ($row_Street = mysql_fetch_assoc($Street));
?>
        </select >
        </font></td>
      <td align="right" valign="top" nowrap><font size="2">Состояние:</font></td>
      <td colspan="2" valign="top"> <font size="2"> 
        <select  style="width: 148px;"  name="cond_cod">
          <?php 
do {  
?>
          <option value="<?php echo $row_Cond['cond_cod']?>" <?php if (!(strcmp($row_Cond['cond_cod'], $row_Recordset1['cond_cod']))) {echo "SELECTED";} ?>><?php echo $row_Cond['cond_name']?></option>
          <?php
} while ($row_Cond = mysql_fetch_assoc($Cond));
?>
        </select >
        </font></td>
    </tr>
    <tr background="_images/fon.gif" bgcolor="#FFD7AE" valign="baseline"> 
      <td height="28" align="right" nowrap><font size="2">Количество комнат:</font></td>
      <td valign="top"> <font size="2"> 
        <select  style="width: 148px;"  name="room_cod">
          <?php 
do {  
?>
          <option value="<?php echo $row_Room['room_cod']?>" <?php if (!(strcmp($row_Room['room_cod'], $row_Recordset1['room_cod']))) {echo "SELECTED";} ?>><?php echo $row_Room['room_short']?></option>
          <?php
} while ($row_Room = mysql_fetch_assoc($Room));
?>
        </select >
        </font></td>
      <td align="right" valign="top" nowrap><font size="2">Сторона света:</font></td>
      <td colspan="2" valign="top"> <font size="2"> 
        <select  style="width: 148px;"  name="side_cod">
          <?php 
do {  
?>
          <option value="<?php echo $row_Side['side_cod']?>" <?php if (!(strcmp($row_Side['side_cod'], $row_Recordset1['side_cod']))) {echo "SELECTED";} ?>><?php echo $row_Side['side_name']?></option>
          <?php
} while ($row_Side = mysql_fetch_assoc($Side));
?>
        </select >
        </font></td>
    </tr>
    <tr background="_images/fon.gif" bgcolor="#FFD7AE" valign="baseline"> 
      <td height="26" align="right" nowrap><font size="2">Площади, (So/Sж/Sk):</font></td>
      <td valign="top"><font size="2"> 
        <input type="text" name="So" value="<?php echo $row_Recordset1['So']; ?>" size="4">
        <input type="text" name="Sz" value="<?php echo $row_Recordset1['Sz']; ?>" size="4">
        <input type="text" name="Sk" value="<?php echo $row_Recordset1['Sk']; ?>" size="4">
        </font></td>
      <td align="right" valign="top"nowrap><font size="2">Цена объекта:</font></td>
      <td colspan="2" valign="top"><font size="2"> 
        <input type="text" name="flats_price" value="<?php echo $row_Recordset1['flats_price']; ?>" size="21">
        </font></td>
    </tr>
    <tr background="_images/fon.gif" bgcolor="#FFD7AE" valign="baseline"> 
      <td height="26" align="right" nowrap><font size="2">Этаж:</font></td>
      <td valign="top"><font size="2"> 
        <input type="text" name="flats_floor" value="<?php echo $row_Recordset1['flats_floor']; ?>" size="21">
        </font></td>
      <td align="right" valign="top"nowrap><font size="2">Телефонная точка:</font></td>
      <td colspan="2" valign="top"><font size="2"> 
        <input  type="checkbox" name="flats_tel" value="" <?php if (!(strcmp($row_Recordset1['flats_tel'],1))) {echo "checked";} ?>>
        </font></td>
    </tr>
    <tr background="_images/fon.gif" bgcolor="#FFD7AE" valign="baseline"> 
      <td height="26" align="right" nowrap><font size="2">Этажность:</font></td>
      <td valign="top"><font size="2"> 
        <input type="text" name="flats_floorest" value="<?php echo $row_Recordset1['flats_floorest']; ?>" size="21">
        </font></td>
      <td align="right" valign="top" nowrap><font size="2">Foto:</font></td>
      <td colspan="2" valign="top"><font size="2"> 
        <input type="text" name="foto" value="<?php echo $row_Recordset1['foto']; ?>" size="21">
        </font></td>
    </tr>
    <tr background="_images/fon.gif" bgcolor="#FFD7AE" valign="baseline"> 
      <td height="28" align="right" nowrap><font size="2">Материал постройки:</font></td>
      <td valign="top"> <font size="2"> 
        <select  style="width: 148px;"  name="material_cod">
          <?php 
do {  
?>
          <option value="<?php echo $row_Mat['material_cod']?>" <?php if (!(strcmp($row_Mat['material_cod'], $row_Recordset1['material_cod']))) {echo "SELECTED";} ?>><?php echo $row_Mat['material_name']?></option>
          <?php
} while ($row_Mat = mysql_fetch_assoc($Mat));
?>
        </select >
        </font></td>
      <td align="right" valign="top" nowrap><font size="2">Агент:</font></td>
      <td colspan="2" valign="top"> <font size="2"> 
        <select  style="width: 148px;"  name="agent_cod">
          <?php 
do {  
?>
          <option value="<?php echo $row_Agent['agent_cod']?>" <?php if (!(strcmp($row_Agent['agent_cod'], $row_Recordset1['agent_cod']))) {echo "SELECTED";} ?>><?php echo $row_Agent['agent_name']?></option>
          <?php
} while ($row_Agent = mysql_fetch_assoc($Agent));
?>
        </select >
        </font></td>
    </tr>
    <tr background="_images/fon.gif" bgcolor="#FFD7AE" valign="baseline"> 
      <td height="26" align="right" nowrap><font size="2">Продана:</font></td>
      <td valign="top"> <font size="2"> 
        <input  type="checkbox" name="sale" value="" <?php if (!(strcmp($row_Recordset1['sale'],1))) {echo "checked";} ?>>
        </font></td>
      <td align="right" valign="top" nowrap><font size="2">Дата продажи:</font></td>
      <td colspan="2" valign="top"><font size="2"> 
        <input type="text" name="date_sale" value="<?php echo $row_Recordset1['date_sale']; ?>" size="21">
        </font></td>
    </tr>
    <tr background="_images/fon.gif" bgcolor="#FFD7AE" valign="baseline"> 
      <td height="26" align="right" nowrap><font size="2">Цена продажи:</font></td>
      <td valign="top"><font size="2"> 
        <input type="text" name="price_sale" value="<?php echo $row_Recordset1['price_sale']; ?>" size="21">
        </font></td>
      <td align="right" valign="top" nowrap><font size="2">Код объекта:</font></td>
      <td colspan="2" valign="top"><font size="2"><?php echo $row_Recordset1['flats_cod']; ?></font></td>
    </tr>
    <tr background="_images/fon.gif" bgcolor="#FFD7AE" valign="baseline"> 
      <td height="74" align="right" nowrap><font size="2">Примечание:</font></td>
      <td colspan="4" valign="top" ><font size="2"> 
        <textarea name="flats_comments" cols="47" rows="3" lang="ru"><?php echo $row_Recordset1['flats_comments']; ?></textarea>
        </font></td>
    </tr>
    <tr background="_images/fon.gif" bgcolor="#FFD7AE" valign="baseline"> 
      <td height="28" colspan="7" align="center" nowrap> <font size="2"> 
        <input type="submit"  name="action" value="Обновить" >
        <input type="submit"  name="action" value="Удалить" >
		</font></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="flats_cod" value="<?php echo $row_Recordset1['flats_cod']; ?>">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
mysql_free_result($Type);
mysql_free_result($Sale);
mysql_free_result($Plan);
mysql_free_result($Room);
mysql_free_result($Side);
mysql_free_result($Cond);
mysql_free_result($Balc);
mysql_free_result($Mat);
mysql_free_result($WC);
mysql_free_result($Agent);
mysql_free_result($Street);
?>