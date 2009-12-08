<?php include('_scriptsphp/r_conn.php'); 
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
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
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tbl_flats (sale_cod, type_cod, So, Sz, Sk, plan_cod, wc_cod, balcon_cod, side_cod, cond_cod, flats_comments, agent_cod, flats_date, flats_tel, street_cod, flats_price, room_cod, flats_floor, flats_floorest, material_cod) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,  %s, Now(), %s, %s, %s, %s, %s, %s, %s)",
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
                       GetSQLValueString(isset($_POST['flats_tel']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['street_cod'], "int"),
                       GetSQLValueString($_POST['flats_price'], "int"),
                       GetSQLValueString($_POST['room_cod'], "int"),
                       GetSQLValueString($_POST['flats_floor'], "int"),
                       GetSQLValueString($_POST['flats_floorest'], "int"),
                       GetSQLValueString($_POST['material_cod'], "int"));
  mysql_select_db($database_realtorplus, $realtorplus);
  $Result1 = mysql_query($insertSQL, $realtorplus) or die(mysql_error());
  $insertGoTo = "base1.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
mysql_select_db($database_realtorplus, $realtorplus);
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
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="left" border="0" >
    <!--DWLayoutTable-->
    <tr  valign="baseline"> 
      <td align="right" nowrap><font size="2">Вид продажи:</font></td>
      <td> <font size="2"> 
        <select  style="width: 148px;"name="sale_cod">
          <?php 
do {  
?>
          <option value="<?php echo $row_Sale['sale_cod']?>" ><?php echo $row_Sale['sale_name']?></option>
          <?php
} while ($row_Sale = mysql_fetch_assoc($Sale));
?>
        </select>
        </font></td>
      <td align="right" nowrap><font size="2">Планировка:</font></td>
      <td > <font size="2"> 
        <select  style="width: 148px;"name="plan_cod">
          <?php 
do {  
?>
          <option value="<?php echo $row_Plan['plan_cod']?>"><?php echo $row_Plan['plan_name']?></option>
          <?php
} while ($row_Plan = mysql_fetch_assoc($Plan));
?>
        </select>
        </font></td>
    </tr>
    <tr background="_images/fon.gif" valign="baseline"> 
      <td align="right" nowrap><font size="2">Тип объекта:</font></td>
      <td><font size="2"> 
        <select  style="width: 148px;"name="type_cod">
          <?php 
do {  
?>
          <option value="<?php echo $row_Type['type_cod']?>"><?php echo $row_Type['type_s']?></option>
          <?php
} while ($row_Type = mysql_fetch_assoc($Type));
?>
        </select>
        </font></td>
      <td nowrap align="right"><font size="2">Санузел:</font></td>
      <td> <font size="2"> 
        <select  style="width: 148px;"name="wc_cod">
          <?php 
do {  
?>
          <option value="<?php echo $row_WC['wc_cod']?>"><?php echo $row_WC['wc_name']?></option>
          <?php
} while ($row_WC = mysql_fetch_assoc($WC));
?>
        </select>
        </font></td>
    </tr>
    <tr background="_images/fon.gif" valign="baseline"> 
       <td align="right" nowrap><font size="2">Улица:</font></td>
      <td> <font size="2"> 
        <select  style="width: 148px;"name="street_cod">
          <?php 
do {  
?>
          <option value="<?php echo $row_Street['street_cod']?>" ><?php echo $row_Street['street_name']?></option>
          <?php
} while ($row_Street = mysql_fetch_assoc($Street));
?>
        </select>
        </font></td>
      <td nowrap align="right"><font size="2">Балкон/лоджия:</font></td>
      <td> <font size="2"> 
        <select  style="width: 148px;"name="balcon_cod">
          <?php 
do {  
?>
          <option value="<?php echo $row_Balc['balcon_cod']?>" ><?php echo $row_Balc['balcon_name']?></option>
          <?php
} while ($row_Balc = mysql_fetch_assoc($Balc));
?>
        </select>
        </font></td>
    </tr>
    <tr background="_images/fon.gif" valign="baseline"> 
      <td align="right" nowrap><font size="2">Количество комнат:</font></td>
      <td> <font size="2"> 
        <select  style="width: 148px;"name="room_cod">
          <?php 
do {  
?>
          <option value="<?php echo $row_Room['room_cod']?>"><?php echo $row_Room['room_short']?></option>
          <?php
} while ($row_Room = mysql_fetch_assoc($Room));
?>
        </select>
        </font></td>
      <td nowrap align="right"><font size="2">Состояние:</font></td>
      <td> <font size="2"> 
        <select  style="width: 148px;"name="cond_cod">
          <?php 
do {  
?>
          <option value="<?php echo $row_Cond['cond_cod']?>"><?php echo $row_Cond['cond_name']?></option>
          <?php
} while ($row_Cond = mysql_fetch_assoc($Cond));
?>
        </select>
        </font></td>
    </tr>
    <tr background="_images/fon.gif" valign="baseline"> 
     <td align="right" nowrap><font size="2">Площади, (So/Sж/Sk):</font></td>
      <td><font size="2"> 
        <input type="text" name="So" value="" size="4">
        <input type="text" name="Sz" value="" size="4">
        <input type="text" name="Sk" value="" size="4">
        </font></td>
      <td nowrap align="right"><font size="2">Сторона света:</font></td>
      <td> <font size="2"> 
        <select  style="width: 148px;"name="side_cod">
          <?php 
do {  
?>
          <option value="<?php echo $row_Side['side_cod']?>"><?php echo $row_Side['side_name']?></option>
          <?php
} while ($row_Side = mysql_fetch_assoc($Side));
?>
        </select>
        </font></td>
    </tr>
    <tr background="_images/fon.gif" valign="baseline"> 
      <td align="right" nowrap><font size="2">Этаж:</font></td>
      <td><font size="2"> 
        <input type="text" name="flats_floor" value="" size="21">
        </font></td>
      <td nowrap align="right"><font size="2">Цена объекта:</font></td>
      <td><font size="2"> 
        <input type="text" name="flats_price" value="" size="21">
        </font></td>
    </tr>
    <tr background="_images/fon.gif" valign="baseline"> 
       <td align="right" nowrap><font size="2">Этажность:</font></td>
      <td><font size="2"> 
        <input type="text" name="flats_floorest" value="" size="21">
        </font></td>
      <td nowrap align="right"><font size="2">Телефонная точка:</font></td>
      <td><font size="2"> 
        <input  type="checkbox" name="flats_tel" value="" >
        </font></td>
    </tr>
    <tr background="_images/fon.gif" valign="baseline"> 
     <td align="right" nowrap><font size="2">Материал постройки:</font></td>
      <td> <font size="2"> 
        <select  style="width: 148px;"name="material_cod">
          <?php 
do {  
?>
          <option value="<?php echo $row_Mat['material_cod']?>" ><?php echo $row_Mat['material_name']?></option>
          <?php
} while ($row_Mat = mysql_fetch_assoc($Mat));
?>
        </select>
        </font></td>
      <td nowrap align="right"><font size="2">Foto:</font></td>
      <td><font size="2"> 
        <input type="text" name="foto" value="" size="21">
        </font></td>
    </tr>
    <tr background="_images/fon.gif" valign="baseline"> 
      <td align="right" nowrap><font size="2">Примечание:</font></td>
      <td></td>
     <td align="right" valign="top" nowrap><font size="2">Агент:</font></td>
      <td colspan="2" valign="top"> <font size="2"> 
        <select  style="width: 148px;"  name="agent_cod">
          <?php 
do {  
?>
          <option value="<?php echo $row_Agent['agent_cod']?>" <?php if (!(strcmp($row_Agent['agent_cod'], $row_Agent['agent_cod']))) {echo "SELECTED";} ?>><?php echo $row_Agent['agent_name']?></option>
          <?php
} while ($row_Agent = mysql_fetch_assoc($Agent));
?>
        </select >
        </font></td>
    </tr>
    <tr background="_images/fon.gif" valign="baseline"> 
      <td align="right" nowrap></td>
      <td colspan="3" valign="top" ><font size="2"> 
        <textarea name="flats_comments" cols="47" ></textarea>
        </font></td>
    </tr>
    <tr background="_images/fon.gif" valign="baseline"> 
      <td colspan="4" align="center" nowrap> <font size="2"> 
        <input type="submit" value="Добавить объект">
        </font></td>
    </tr>
  </table>
  <font size="2"> 
  <input type="hidden" name="MM_insert" value="form1">
  </font> 
</form>
<p>&nbsp;</p>
  
</body>
</html>
<?php
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
