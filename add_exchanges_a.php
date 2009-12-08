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

if(isset($_POST['fio'])&& $_POST['fio'] != NULL)
{
$contact =  $contact . $_POST['fio'] . '<br/>';
}
if(isset($_POST['phon']) && $_POST['phon'] != NULL)
{
$contact = $contact . '���:&nbsp;' . $_POST['phon']. '<br/>';
}
if(isset($_POST['e_mail'])&& $_POST['e_mail'] != NULL)
{
$contact = $contact . '��. �����:&nbsp;' . $_POST['e_mail'];
}
//������� ������� /////////////////////
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
  //  echo "�� ��������� ������ �������.";
} else {
//   echo "������ '$findme' ������� � ������ '$mystring1'";
  //  echo " � ������� $pos";
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
$uid = substr(md5(uniqid(mt_rand())),0,5);
  $insertSQL = sprintf("INSERT INTO tbl_exchange (Uid, Date, Type_Exchange, Formula, Result, Description, agent_cod, Source, Treated) VALUES (%s, Now(), %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($uid, "text"),
					   GetSQLValueString($type, "int"),
                       GetSQLValueString($formula, "text"),
                       GetSQLValueString($result, "text"),
                       GetSQLValueString($_POST['description'], "text"),
					   GetSQLValueString($_POST['agent_cod'], "int"),
					   GetSQLValueString('1', "int"),
					   GetSQLValueString('1', "int"));
  mysql_select_db($database_realtorplus, $realtorplus);
  if (isset($_POST['action']) && $_POST['action'] == 'submitted') {
  $Result1 = mysql_query($insertSQL, $realtorplus) or die(mysql_error());
  } else { echo "����������";}
}
  mysql_select_db($database_realtorplus, $realtorplus);
  $query_Agent= "SELECT * FROM tbl_agent";
$Agent = mysql_query($query_Agent, $realtorplus) or die(mysql_error());
$row_Agent = mysql_fetch_assoc($Agent);
$totalRows_Agent = mysql_num_rows($Agent);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>���"�������"- ������������ ������������: ������</title>
<link rel="shortcut icon" href="http://foliant/realtorplus.ico">
<style type="text/css">
<!--
body {
	background-color: #F1DABC;
}
.full {
	width: 100% /* ������ � ��������� */
}
.half {
	width: 50% /* ������ � ��������� */
}
.qvarter {
	width: 25% /* ������ � ��������� */
}
FIELDSET {
	padding: 10px /* ���� ������ ������ */
}
LEGEND {
	font-weight: bold;
	color:#710000 /* ���� ��������� ������ */
}
#layer1 {
	padding: 5px; /* ���� ������ ������ */
	float: left; /* ��������� �� ������� ���� */
	width: 45%; /* ������ ���� */
}
#layer2 {
	padding: 5px; /* ���� ������ ������ */
	width: 45%; /* ������ ���� */
	float: left; /* ��������� �� ������� ���� */
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

    var error_msg = "����������, ��������� ��� ������������ ����.";
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
      <legend>���������� �������� ������</legend>
      <?php
if (isset($_POST['action']) && $_POST['action'] == 'submitted') {
if(count($_POST)>0){
	if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] == $_POST['keystring']){
		//echo "Correct";
	}else{
		//echo "Wrong";
	}
}
unset($_SESSION['captcha_keystring']);
 echo '�� �������� ���������� � ������:&nbsp;&nbsp;';
	($type == "0")?  print "�����." : print "�������.";
	 echo '<br/>';
	echo '������� ������:&nbsp;&nbsp;';
//	($_POST['type_exchange'] == "0")?  print $_POST['formula']."=". $_POST['result'] : print $_POST['result']."=". $_POST['formula'];
	 	 ($type == "0")?  print '&nbsp;' . $formula."=". $result : print '&nbsp;' . $result ."=". $formula; 
	 echo '<br/>';
	echo '����� ����������:'. '<br/>';
	echo $_POST['description']. '<br/>';	
    echo '<a href="exchanges_a.php">��������� � ��������� ������</a>';
	//echo '</pre>'; 
} else {
?>
      <form  id="form1" name="form1" 
action="<?php  echo $editFormAction; 
echo $_SERVER['PHP_SELF']; ?>" method="post" class="full"   onsubmit="return fnCheckFields(this);">
        <input type="hidden" name="MM_insert" value="form1">
        <table>
          <tr>
            <td><span class="style2">*</span>�������:</td>
          </tr>
          <tr>
            <td><input type="text" name="formula" id="textfield2" required="required" />
            </td>
          </tr>
          <tr>
            <td colspan="3"><span class="style1">&nbsp;������� ��������� �������! � ������� ����� ("1+�+����"), ������� ��������� ������ ������� �������, ����� �������, � � ����������, ���� ����������, �������.<br/> ��������: <br/>
            ���� �� ������������� - 4=1+�+���� <br/>
            ��� ����������� - 2+1+����=4<br/> 
            �������� - �, ���� - �, ���������� - ����, ������� - ����.</span></td>
          </tr>
        </table>
        <label ><span class="style2">*</span>��������<br/>
        <textarea name="description" cols="45" rows="5" class="full" id="textarea" required="required"></textarea>
        </label>
        <br/>
        <label>�����:<br/>
        <select  name="agent_cod">
          <?php 
do {  
?>
          <option value="<?php echo $row_Agent['agent_cod']?>" <?php if (!(strcmp($row_Agent['agent_cod'], $row_Agent['agent_cod']))) {echo "SELECTED";} ?>><?php echo $row_Agent['agent_name']?></option>
          <?php
} while ($row_Agent = mysql_fetch_assoc($Agent));
?>
        </select ></label>
        <p>
        <span class="style3">&nbsp;&nbsp;&nbsp;&nbsp;����, ���������� <span class="style2">"*"</span>, ����������� � ����������.</span></p>
        <label>
        ������� ����� � ��������:<br/>
        <img src="./kcaptcha/?<?php echo session_name()?>=<?php echo session_id()?>">
        <p>
          <input name="keystring" type="text">
        </p>
        <input name="button" type="submit" id="button" value="������������" align="center"  />
        <input type="hidden" name="action" value="submitted" />
        </label>
      </form>
      <?php
if(count($_POST)>0){
	if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] == $_POST['keystring']){
		//echo "Correct";
		$legate = true;
	}else{
		//echo "Wrong";
		$legate = false;
	}
}
unset($_SESSION['captcha_keystring']);
?>
      <?php
}
?>
      </fieldset></td>
  </tr>
</table>
</body>
</html>
