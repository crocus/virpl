<?php
session_start();
require_once('_scriptsphp/r_conn.php');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
iconv_set_encoding("input_encoding", "WINDOWS-1251");
setlocale(LC_TIME, "RU");
?>
<?php 
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
	//парсинг формулы /////////////////////
	$formula = $_POST['formula'];
	trim ( $formula);
	while ( strpos($formula,' ')!==false )
 {
   $formula = str_replace(' ','',$formula);
 } 
 while ( strpos($formula,'.')!==false )
 {
   $formula = str_replace('.','',$formula);
 } 
$findme  = '=';
$pos = strpos($formula, $findme);

if ($pos === false) {
  //  echo "Не корректно задана формула.";
} else {
//   echo "Строка '$findme' найдена в строке '$mystring1'";
  //  echo " в позиции $pos";
}
$rest = substr(strpbrk($formula, '='), 1); 
$before_eqv = substr($formula, 0, $pos);
 
 if($pos == NULL){
 } elseif($pos <= "2" ){
		$formula = $rest;
		$result = $before_eqv;
		if($type==NULL && $pos!= NULL)
		$type='1';
	 } else {
	  	$formula = $before_eqv;
		$result = $rest;
		if($type==NULL && $pos!= NULL)
		$type='0';
	 }
////////////////////////////
	$SQLpost = sprintf("UPDATE tbl_exchange SET Type_Exchange=%s, Formula=%s, Result=%s, Description=%s, agent_cod=%s, Treated=%s  WHERE Id=%s",
                       GetSQLValueString($type, "int"),
                       GetSQLValueString($formula, "text"),
                       GetSQLValueString($result, "text"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['agent_cod'], "int"),
					   GetSQLValueString('1', "int"),
                       GetSQLValueString($_POST['id'], "int")); 
      break;
    case "Удалить":
	 $SQLpost = sprintf("DELETE FROM tbl_exchange WHERE Id=%s",
 						GetSQLValueString($_POST['id'], "int")); 
      break;
  	default : 
	  $SQLpost = sprintf("DELETE FROM tbl_exchange WHERE Id=%s",
 						GetSQLValueString($_POST['id'], "int")); 
      break; 
	 }
 mysql_select_db($database_realtorplus, $realtorplus);
 $Result1 = mysql_query($SQLpost, $realtorplus) or die(mysql_error());
   $updateGoTo = "./exchanges_a.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
   }
  header(sprintf("Location: %s", $updateGoTo));
}
$SQLValueStringUp = $_GET['Id']; 
mysql_select_db($database_realtorplus, $realtorplus);
$query_Recordset1 = "SELECT * FROM tbl_exchange WHERE Id={$SQLValueStringUp}";		
$Recordset1 = mysql_query($query_Recordset1, $realtorplus) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$query_Agent= "SELECT * FROM tbl_agent";
$Agent = mysql_query($query_Agent, $realtorplus) or die(mysql_error());
$row_Agent = mysql_fetch_assoc($Agent);
$totalRows_Agent = mysql_num_rows($Agent);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>ООО"Фолиант"- недвижимость Владивостока: обмены</title>
<link rel="shortcut icon" href="http://foliant/realtorplus.ico">
<style type="text/css">
<!--
body {
	background-color: #F1DABC;
}
.full {
	width: 100% /* Ширина в процентах */
}
.half {
	width: 50% /* Ширина в процентах */
}
.qvarter {
	width: 25% /* Ширина в процентах */
}
FIELDSET {
	padding: 10px /* Поля вокруг группы */
}
LEGEND {
	font-weight: bold;
	color:#710000 /* Цвет заголовка группы */
}
#layer1 {
	padding: 5px; /* Поля вокруг текста */
	float: left; /* Обтекание по правому краю */
	width: 45%; /* Ширина слоя */
}
#layer2 {
	padding: 5px; /* Поля вокруг текста */
	width: 45%; /* Ширина слоя */
	float: left; /* Обтекание по правому краю */
}
.style1 {
	color: #FF0000;
	font-size: small;
}
.style2 {
	color: #FF0000
}
.style3 {
	font-size: smaller
}
-->
</style>
<link href="/foliant.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<script type="text/javascript">
onload = function() { tableBG() };
function tableBG()
{
var table = window.document.getElementById("main_rez");
	var rows = table.getElementsByTagName('tr');
	for(var i = 0; i < rows.length; i++)
	{
(i%2==0)? rows.item(i).style.backgroundColor = "#EDF1BC" : rows.item(i).style.backgroundColor = "#F1DABC"
	}
}
</script>
<script type="text/javascript">
function fnCheckFields(form_obj){

    var error_msg = "Пожалуйста, заполните все обязательные поля.";
    var is_error = false;
    for (var i = 0; form_obj_elem = form_obj.elements[i]; i++)
        if (form_obj_elem.type == "textarea" || form_obj_elem.type == "text")
            if (form_obj_elem.getAttribute("required") && !form_obj_elem.value)
                is_error = true;

    if (is_error) alert(error_msg);
    return !is_error;
}
</script>
<table border="0"  align="left" class="half" >
  <tr>
    <td colspan="4" ><fieldset>
      <legend>Изменение варианта обмена</legend>
      <form  id="form1" name="form1" 
action="<?php  echo $editFormAction; ?>" method="post" class="full"   onsubmit="return fnCheckFields(this);">
        <table>
          <tr>
            <td><span class="style2">*</span>Формула:</td>
          </tr>
          <tr>
            <td><input type="text" name="formula" id="textfield2" value="<?php 
			($row_Recordset1['Type_Exchange'] == "0")?  print  $row_Recordset1['Formula']."=". $row_Recordset1['Result'] : print $row_Recordset1['Result']."=". $row_Recordset1['Formula']; ?>" required="required" />
            </td>
          </tr>
          <tr>
            <td colspan="3"><span class="style1">&nbsp;Порядок написания формулы! В длинной части ("1+г+допл"), сначала указываем объект большей площади, затем меньшей, и в заключении, если необходимо, доплата.<br/> Например: <br/>
            если Вы разъезжаетесь - 4=1+г+допл <br/>
            или съезжаетесь - 2+1+допл=4<br/> 
            Гостинки - г, дома - д, подселения - подс, доплата - допл.</span></td>
          </tr>
        </table>
        <label ><span class="style2">*</span>Описание<br/>
        <textarea name="description" cols="45" rows="5" class="full" id="textarea"  required="required" ><?php echo $row_Recordset1['Description']; ?></textarea>
        </label>
        <br/>
      <?php  if($row_Recordset1['Source']!='1' && $row_Recordset1['Treated']=='0'){
         echo '<br/><label>Контакты, разместившего объявление:<br/>';
        echo $row_Recordset1['Contact'];
		}
        ?>
         </label>
        <br/>
        <label>Агент:<br/>
        <select  name="agent_cod" disabled="1">
          <?php 
do {  
?>
          <option value="<?php echo $row_Agent['agent_cod']?>" <?php if (!(strcmp($row_Agent['agent_cod'], $row_Recordset1['agent_cod']))) {echo "SELECTED";} ?>><?php echo $row_Agent['agent_name']?></option>
          <?php
} while ($row_Agent = mysql_fetch_assoc($Agent));
?>
        </select ></label>
        <p>
        <span class="style3">&nbsp;&nbsp;&nbsp;&nbsp;Поля, отмеченные <span class="style2">"*"</span>, обязательны к заполнению.</span></p>
        
        <input type="submit"  name="action" value="Обновить" >
        <input type="submit"  name="action" value="Удалить" >
        <input type="hidden" name="MM_update" value="form1">
  		<input type="hidden" name="uid" value="<?php echo $row_Recordset1['Uid']; ?>">
        <input type="hidden" name="id" value="<?php echo $row_Recordset1['Id']; ?>">
        </label>
      </form>
      </fieldset></td>
  </tr>
</table>
</body>
</html>
