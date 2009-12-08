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
      $theValue = ($theValue != "") ? str_replace ("-", "", $theValue) : "NULL";
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
  $insertSQL = sprintf("INSERT INTO tbl_fsale (d_fs, n_fs, t_fs, m_fs, ap_fs, type_cod, room_cod, street_cod, price_fs, comm_fs) VALUES (Now(), %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['n_fs'], "text"),
                       GetSQLValueString($_POST['t_fs'], "int"),
					   GetSQLValueString($_POST['m_fs'], "text"),
					   GetSQLValueString($_POST['ap_fs'], "text"),
					   GetSQLValueString($_POST['type_cod'], "int"),
                       GetSQLValueString($_POST['room_cod'], "int"),
                       GetSQLValueString($_POST['street_cod'], "int"),
					   GetSQLValueString($_POST['price_fs'], "int"),
					   GetSQLValueString($_POST['comm_fs'], "text"));

  mysql_select_db($database_realtorplus, $realtorplus);
  $Result1 = mysql_query($insertSQL, $realtorplus) or die(mysql_error());

  $insertGoTo = "pub_base.php";
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

$query_Room= "SELECT * FROM tbl_room";
$Room = mysql_query($query_Room, $realtorplus) or die(mysql_error());
$row_Room = mysql_fetch_assoc($Room);
$totalRows_Room = mysql_num_rows($Room);

$query_Type= "SELECT * FROM tbl_type";
$Type = mysql_query($query_Type, $realtorplus) or die(mysql_error());
$row_Type = mysql_fetch_assoc($Type);
$totalRows_Type = mysql_num_rows($Type);

?>
<?php echo "<?xml version=\"1.0\" encoding=\"windows-1251\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ООО&quot;Фолиант&quot;- заявка на продажу</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
</head>
<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="left" border="0" >
   <caption><font color="#336666" size="4"><strong>ЗАЯВКА НА ПРОДАЖУ</strong></font></caption><tr background="_images/fon.gif" valign="baseline"> 
      <td height="24" align="right" nowrap><font size="2">Ваш телефон<font color="#FF3333">*</font> 
        :</font></td>
      <td><font size="2"> 
        <input type="text" name="t_fs" value="" style="width: 148px;" size="6">
        </font></td>
    <td height="26" align="right" nowrap><font size="2">Тип объекта:</font></td>
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
    <tr background="_images/fon.gif" valign="baseline"> 
      <td height="24" align="right" nowrap><font size="2">Кого спрашивать<font color="#FF0033">*</font> 
        :</font></td>
      <td><font size="2"> 
        <input type="text" name="n_fs" value="" style="width: 148px;" size="20">
        </font></td>
	<td height="26" align="right" nowrap><font size="2">Улица:</font></td>
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
	<tr background="_images/fon.gif" valign="baseline"> 
      <td height="24" align="right" nowrap><font size="2">Ваш e-mail::</font></td>
      <td><font size="2"> 
        <input type="text" name="m_fs" value="" style="width: 148px;" size="20">
        </font></td>
	<td height="26" align="right" nowrap><font size="2">Количество комнат:</font></td>
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
	    </tr>
        <tr background="_images/fon.gif" valign="baseline"> 
     <td height="24" align="right" nowrap><font color="#FF0000" size="2">Иная связь :</font></td>
      <td><font size="2"> 
        <input type="text" name="ap_fs" value="" style="width: 148px;"size="21">
        </font></td>
	  <td height="24" align="right" nowrap><font size="2">Цена объекта<font color="#FF0033">*</font>:</font></td>
      <td><font size="2"> 
        <input type="text" name="price_fs" value="" style="width: 148px;"size="21">
        </font></td>
    </tr>
    <tr background="_images/fon.gif" valign="baseline"> 
      <td colspan="2" style="width: 148px;"  align="right"><div align="justify"> 
          <pre><font color="#FF0033">*</font>Дополнительные  сведения:
(Вы можете указать любую информацию 
о Вашем объекте недвижимости или о 
том, как с Вами можно связаться.)</pre>
        </div></td>
      <td  colspan="2"valign="top" ><font size="2"> 
        <textarea name="comm_fs" cols="30"  style="height: 100px;"></textarea>
        </font></td>
    </tr>
    <tr background="_images/fon.gif" valign="baseline" style="width: 200px;" > 
      <td   colspan="4"align="center" nowrap><div align="left"> 
          <pre><font color="#FF0000">Внимание!!! Поле "Иная связь" следует заполнять, только в случае,
если с Вами отсутствует  телефонная связь!!! 
(Пожалуйста!!! Оставьте свой пейджер или адрес 
по которому с Вами можно связаться!!!)
Поля отмеченные звездочкой (*) обязательны для заполнения!!!</font></pre>
        </div></td>
    </tr>
  <tr background="_images/fon.gif" valign="baseline"> 
      <td height="26" colspan="4"align="center" nowrap> <font size="2"> 
        <input type="submit" value="Добавить объект">
        </font></td>
    </tr>
  </table>
  </table>
  <font size="2"> 
  <input type="hidden" name="MM_insert" value="form1">
  </font> 
</form>  
</body>
</html>
<?php
mysql_free_result($Type);
mysql_free_result($Room);
mysql_free_result($Street);
?>
