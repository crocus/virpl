<?php echo "<?xml version=\"1.0\" encoding=\"windows-1251\"?".">"; ?><?php 
require_once('_scriptsphp/r_conn.php'); 
$uploaddir = '/home/public_html/';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir . 
	$_FILES['userfile']['name'])) {
    print "Файл существует и благополучно переправлен на сервер!!!";
} else {
    print "Какие-то ошибки при отправке файла!";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ООО&quot;Фолиант&quot; - обновление сервера</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
</head>

<body bgcolor="#F1DABC">
<br>Внимание!!! Будьте внимательны при выборе агенства, ни в коем случае не выбирайте 
&quot;значение не задано&quot;, либо Фолиант или ДВРК <strong><u> БЕЗ НОМЕРА!!!</u></strong><br>
<p></p>
<table width="186" border="0" cellpadding="0" cellspacing="0">
 <tr>
<td><FORM style="width: 170px;" METHOD="GET" ACTION="fopen.php">
<label>Агентство :</label>
          <br>
          <select style="width: 180px;"name="agency" >
            <option selected> значение не задано </option>
            <?php
	 mysql_select_db($database_realtorplus, $realtorplus);
	$query_Recordset1= "SELECT * FROM tbl_agency";
  	$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
   ?>
            <?php do { ?>
            <option value ="<?php echo $row_Recordset1['agency_cod'] ; ?>"><?php echo $row_Recordset1['agency_name']; ?></option>
            <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
          </select><br>
<input style="width: 180px;"name="Update" type="submit" value="Если уверены, нажмите!" >
</form>
</td></tr>
</table>
</body>
</html>

