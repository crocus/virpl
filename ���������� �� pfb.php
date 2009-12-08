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
  $insertSQL = sprintf("INSERT INTO tbl_fbuy (d_fs, n_fs, t_fs, m_fs, ap_fs, type_cod, room_cod, region_cod, price_fs, comm_fs) VALUES (Now(), %s, %s, %s, %s, %s, %s, %s, %s, %s)",
					   GetSQLValueString($_POST['n_fs'], "text"),
					   GetSQLValueString($_POST['t_fs'], "int"),
					   GetSQLValueString($_POST['m_fs'], "text"),
					   GetSQLValueString($_POST['ap_fs'], "text"),
					   GetSQLValueString($_POST['type_cod'], "int"),
					   GetSQLValueString($_POST['room_cod'], "int"),
					   GetSQLValueString($_POST['region_cod'], "int"),
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

$query_Region = "SELECT * FROM tbl_region";
$Region = mysql_query($query_Region, $realtorplus) or die(mysql_error());
$row_Region = mysql_fetch_assoc($Region);
$totalRows_Region = mysql_num_rows($Region);

$query_Room= "SELECT * FROM tbl_room";
$Room = mysql_query($query_Room, $realtorplus) or die(mysql_error());
$row_Room = mysql_fetch_assoc($Room);
$totalRows_Room = mysql_num_rows($Room);

$query_Type= "SELECT * FROM tbl_type";
$Type = mysql_query($query_Type, $realtorplus) or die(mysql_error());
$row_Type = mysql_fetch_assoc($Type);
$totalRows_Type = mysql_num_rows($Type);

?>
<?php echo "<?xml version=\"1.0\" encoding=\"utf-8\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Заявка на приобретение недвижимости</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="left" border="0" >
	<caption>
	<font size="4"><strong>ЗАЯВКА НА ПОКУПКУ</strong></font>
	</caption>
	<tr  valign="baseline">
	  <td align="right" nowrap>Тип объекта:</td>
	  <td><select  style="width: 148px;" name="type_cod">
		  <?php 
do {  
?>
		  <option value="<?php echo $row_Type['type_cod']?>"><?php echo $row_Type['type_s']?></option>
		  <?php
} while ($row_Type = mysql_fetch_assoc($Type));
?>
		</select></td>
	<tr  valign="baseline">
	  <td align="right" nowrap>Районы:</td>
	  <td><select  style="width: 148px;" name="region_cod">
		  <?php 
do {  
?>
		  <option value="<?php echo $row_Region['region_cod']?>" ><?php echo $row_Region['region_name']?></option>
		  <?php
} while ($row_Region = mysql_fetch_assoc($Region));
?>
		</select></td>
	<tr  valign="baseline">
	  <td align="right" nowrap>Количество комнат:</td>
	  <td><select  style="width: 148px;" name="room_cod">
		  <?php 
do {  
?>
		  <option value="<?php echo $row_Room['room_cod']?>"><?php echo $row_Room['room_short']?></option>
		  <?php
} while ($row_Room = mysql_fetch_assoc($Room));
?>
		</select></td>
	</tr>
	<tr  valign="baseline">
	  <td align="right" nowrap>Цена не более*
		:</td>
	  <td><input type="text" name="price_fs" value="" style="width:148px;" size="21"></td>
	</tr>
	<tr  valign="baseline">
	  <td align="right">*Дополнительные  сведения:</td>
	</tr>
	<tr  valign="baseline">
	  <td  colspan="2" valign="top" ><textarea name="comm_fs" cols="30"  style=" width:410px; height: 100px;"></textarea></td>
	</tr>
	<tr><td colspan="2">    <label class="label" style="font-size:medium;"><strong>Контактная информация</strong></label>
	<br/>
	<label for="fio" class="label">ФИО:</label>
	<br/>
	<input id="fio" name="fio" type="text"/>
	<br/>
	<label for="phon" class="label"><span class="red">*</span>Телефон:</label>
	<br/>
	<input id="phon" name="phon" type="text"/>
	<br />
	<label for="e_mail" class="label">E-mail:</label>
	<br/>
	<input id="e_mail" name="e_mail" type="text"/>
	<p> <span class="redline">Поля, отмеченные <span class="red">&quot;*&quot;</span>, обязательны к заполнению.</span></p>
</td></tr>
	<tr  valign="baseline">
	  <td colspan="2" align="center" nowrap><input type="submit" value="Отправить заявку"></td>
	</tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
</body>
</html>
<?php
mysql_free_result($Type);
mysql_free_result($Room);
mysql_free_result($Region);
?>
