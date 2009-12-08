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
	$SQLpost = sprintf("UPDATE tbl_agent SET agency_cod=%s, agent_mail=%s, agent_pass=%s, agent_name=%s WHERE agent_cod=%s",
                       GetSQLValueString($_POST['agency_cod'], "int"),
                       GetSQLValueString($_POST['agent_mail'], "text"),
                       GetSQLValueString($_POST['agent_pass'], "text"),
                       GetSQLValueString($_POST['agent_name'], "text"),
					   GetSQLValueString($_POST['agent_cod'], "int")); 
      break;
	case "Новый":
	$SQLpost = sprintf("INSERT INTO tbl_agent (agency_cod, agent_mail, agent_pass, agent_name) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['agency_cod'], "int"),
                       GetSQLValueString($_POST['agent_mail'], "text"),
                       GetSQLValueString($_POST['agent_pass'], "text"),
                       GetSQLValueString($_POST['agent_name'], "text"));
      break;
    case "Удалить":
	 $SQLpost = sprintf("DELETE FROM tbl_agent WHERE agent_cod=%s",
 						GetSQLValueString($_POST['agent_cod'], "int")); 
      break;
  	default : 
	  $SQLpost = sprintf("DELETE FROM tbl_agent WHERE agent_cod=%s",
 						GetSQLValueString($_POST['agent_cod'], "int")); 
      break; 
	 }
  mysql_select_db($database_realtorplus, $realtorplus);
  $Result1 = mysql_query($SQLpost, $realtorplus) or die(mysql_error());
  $insertGoTo = "agents.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
$SQLValueStringUp = $_GET['agent_cod']; 
mysql_select_db($database_realtorplus, $realtorplus);
$query_Recordset1 = "SELECT * FROM tbl_agent WHERE agent_cod={$SQLValueStringUp}";		
$Recordset1 = mysql_query($query_Recordset1, $realtorplus) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$query_Agency= "SELECT * FROM tbl_agency";
$Agency = mysql_query($query_Agency, $realtorplus) or die(mysql_error());
$row_Agency = mysql_fetch_assoc($Agency);
$totalRows_Agency = mysql_num_rows($Agency);
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
      <td height="28" align="right" valign="top" nowrap><font size="2">Агентство:</font></td>
      <td width="136" valign="top" ><font size="2"> 
        <select  style="width: 172px;"name="agency_cod">
          <?php 
do {  
?>
          <option value="<?php echo $row_Agency['agency_cod']?>" <?php if (!(strcmp($row_Agency['agency_cod'], $row_Recordset1['agency_cod']))) {echo "SELECTED";} ?>><?php echo $row_Agency['agency_name']?></option>
          <?php
} while ($row_Agency = mysql_fetch_assoc($Agency));
?>
        </select >
        </font></td>
      <td width="103" align="right" valign="top" nowrap><font size="2">Имя агента:</font></td>
      <td  align="left" nowrap> <input type="text" name="agent_name" value="<?php echo $row_Recordset1['agent_name']; ?>" size="25"></td>
    <tr bgcolor="#F1DABC" valign="baseline"> 
      <td height="28" align="right" nowrap><font size="2">E-mail:</font></td>
      <td valign="top"> <font size="2"> 
        <input type="text" name="agent_mail" value="<?php echo $row_Recordset1['agent_mail']; ?>" size="25"  >
        </font></td>
      <td align="right" valign="top" nowrap><font size="2">Пароль:</font></td>
      <td valign="top"> <font size="2"> 
        <input type="text" name="agent_pass" value="<?php echo $row_Recordset1['agent_pass']; ?>" size="25">
        </font></td>
    </tr>
    <tr background="_images/fon.gif" bgcolor="#FFD7AE" valign="baseline"> 
      <td height="28" colspan="6" align="center" nowrap> <font size="2"> 
        <input type="submit"  name="action" value="Обновить" >
		<input type="submit"  name="action" value="Новый" >
        <input type="submit"  name="action" value="Удалить" >
        </font></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="agent_cod" value="<?php echo $row_Recordset1['agent_cod']; ?>">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
mysql_free_result($Agency);
?>