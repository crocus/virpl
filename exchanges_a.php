<?php
require_once('_scriptsphp/r_conn.php');
iconv_set_encoding("input_encoding", "WINDOWS-1251");
setlocale(LC_TIME, "RU");
$locale['months'] = " |Января|Февраля|Марта|Апреля|Мая|Июня|Июля|Августа|Сентября|Октября|Ноября|Декабря";
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;
global $_GET;
mysql_select_db($database_realtorplus, $realtorplus);
$type = $_GET['type_exchange'];
$agency = $_GET['agency'];
$code = $_GET['uid'];
//парсинг формулы /////////////////////
	$formula = $_GET['formula'];
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
 //   echo "Не корректно задана формула.";
} else {
 //  echo "Строка '$findme' найдена в строке '$mystring1'";
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
	 //попытка обработки равноценных 
/*if(strlen($formula)== strlen($result)){
$type = NULL;
($formula>=$result && $type==NULL && $pos!= NULL)? $type='0':$type='1';
} */
	 ////////////////////
$GenerQuery = "SELECT e.Id, e.Uid, e.Date, e.Type_Exchange, e.Formula, e.Result, e.Description, e.Contact, e.Source, e.Treated, n.agency_name, g.agent_name, GROUP_CONCAT( t.num_tel) AS phon, n.agency_mail FROM tbl_exchange e 
LEFT JOIN tbl_agent g on e.agent_cod = g.agent_cod 
LEFT JOIN tbl_agency n on g.agency_cod = n.agency_cod  
LEFT JOIN tbl_telag t  on t.agency_name=n.agency_name 
WHERE e.Uid IS NOT NULL";
$connector = " And";
$groupment = " group by e.Id";
$order =  " ORDER BY e.Date DESC";
switch ( $code ) {
    case NULL:
       $uid = (" e.Uid IS NOT NULL");
        break;
    case "  ":
         $uid = (" e.Uid IS NOT NULL");
         break;
    default :
        $uid  = (" e.Uid = '{$code}'");
        break;
}
switch ( $type ) {
    case NULL:
       $Type_Exchange = (" e.Type_Exchange IS NOT NULL");
        break;
    case "  ":
         $Type_Exchange = (" e.Type_Exchange IS NOT NULL");
         break;
    default :
        $Type_Exchange  = (" e.Type_Exchange = {$type}");
        break;
}

switch ( $formula  ) {
    case NULL:
       $formula_pq = (" e.Formula IS NOT NULL");
        break;
    case "  ":
        $formula_pq = (" e.Formula IS NOT NULL");
         break;
    default :
        $formula_pq  = " e.Formula = '{$formula}'";
        break;
}
switch ( $result ) {
     case NULL:
      	$result_pq = (" e.Result IS NOT NULL");
        break;
    case "  ":
        $result_pq = (" e.Result IS NOT NULL");
         break;
    default :
        $result_pq  = " e.Result = '{$result}'";
        break;
}
switch ( $agency ) {
    case NULL:
       $AgeQuery = ("");
        break;
    case "значение не задано":
         $AgeQuery = ("");
         break;
    default : 
        $AgeQuery  = $connector . " e.Source = 1 AND n.agency_cod = {$agency}";
        break;
}
switch ( $ord ) {
    case NULL:
       $ordQuery = (" ORDER BY f.flats_price");
        break;
    case "  ":
        $ordQuery = (" ORDER BY r.room_cod");
         break;
    case "type":
        $ordQuery = (" ORDER BY  t.type_s");
         break;
	case "date":
        $ordQuery = (" ORDER BY e.Date DESC");
         break;
	default :
        $ordQuery  = " ORDER BY {$ord }";
        break;
}
$Exchange = $GenerQuery . $connector . $Type_Exchange . $connector . $formula_pq . $connector . $result_pq . $connector . $uid .  $AgeQuery . $groupment . $order;
$query_Recordset1 = $Exchange;
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $realtorplus) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false &&
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . implode("&", $newParams);
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
?>
<?php
function getTypeExchange($t_ex){
switch ( $t_ex) {
    case "0":
        echo "съезд:";
        break;
    case "1":
       echo "разъезд:";
         break;
    default:
        echo "обмениваю:";
        break;
}
	} 
function getFFormula($t_ex, $rez, $form){	
}
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
  .qvarter{
  width: 25% /* Ширина в процентах */
  }
FIELDSET {
padding: 10px /* Поля вокруг группы */
}

LEGEND {
font-weight: bold;
color:#710000 /* Цвет заголовка группы */
}
.style2 {
	color: #FF0000;
	font-size: small;
}
.btn_onpix {
	width: 140px;
}
-->
</style>

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
<table border="0"  align="left" class="half" >
  <tr>
    <td colspan="4" ><fieldset>
      <legend>Обмены</legend>
      <?php
if (isset($_GET['action']) && $_GET['action'] == 'submitted') {
 // preparedQuery();
  //  echo '<pre>';
  if(strpos($_GET['formula'], '=') != strripos($_GET['formula'], '=')){
  echo 'Вероятно Вы допустили ошибку при написании формулы.' . '<br/>';
  } else {  
	echo 'Вы ищете в разделе ';
	getTypeExchange($type);
	echo  '&nbsp;';	
	if($_GET['formula'] == NULL){
	print "все предложения.";
	} elseif 
	($type == "0") {
	print $formula."=". $result; }
	else {
	print $result."=". $formula; }
	echo '<br/>';
	}
    echo '<a href="'. $_SERVER['PHP_SELF'] .'">Изменить условия поиска</a>';
	//echo '</pre>';
} else {
?>
      <form  id="search" name="search" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" >
        <label>Формула:<br />
        <input type="text" name="formula" id="textfield2"/>
        </label><br/>
        <span class="style2">&nbsp;Порядок написания формулы! В длинной части ("1+г+допл"), сначала указываем объект большей площади, затем меньшей, и в заключении, если необходимо, доплата.<br/> 
       Например: <br/>
            если Вы разъезжаетесь - 4=1+г+допл <br/>
            или съезжаетесь - 2+1+допл=4<br/> 
            Гостинки - г, дома - д, подселения - подс, доплата - допл.</span><br/>
        <label>
        <input type="radio" name="type_exchange" id="2" value="1" />
        Разъезд</label>
        <br />
        <label>
        <input type="radio" name="type_exchange"  id="1" value="0" />
        Съезд</label>
        <br/>
        <label>
        Код объявления: <br/>
        <input type="text" name="uid" id="uid" />
        </label>
        <br/>
                <label>Агентство :</label>
          <br>
          <select name="agency" >
            <option selected> значение не задано </option>
            <?php
	 mysql_select_db($database_realtorplus, $realtorplus);
	$query_agency= "SELECT * FROM tbl_agency ORDER BY agency_name asc;";
  	$agency_Recordset = mysql_query($query_agency) or die(mysql_error());
	$row_agency = mysql_fetch_assoc($agency_Recordset);
   ?>
            <?php do { ?>
            <option value ="<?php echo $row_agency['agency_cod'] ; ?>"><?php echo $row_agency['agency_name']; ?></option>
            <?php } while ($row_agency = mysql_fetch_assoc($agency_Recordset)); ?>
          </select>
          <br>
        <br/>
        <input name="button" type="submit" class="btn_onpix" id="button" value="Поиск" align="center"  />
        <input type="hidden" name="action" value="submitted" />
      </form>
      <?php
}
?>
      </fieldset></td>
  </tr>
  <tr>
    <td  colspan="4"><form  method="POST" name="query_result" action=""  >
        <table  border="0"  align="left" class="full" id="main_rez">
          <?php 
		  if($totalRows_Recordset1>0){
		  
		  do { ?>
            <tr style="cursor: hand;"onmouseover="this.style.background='#FFCC33'" onmouseout="tableBG();" onclick="document.location='exchanges_upd_a.php?Id=<?php echo $row_Recordset1['Id']; ?>'">
              <td >
              <?php echo  "<div align=\"left\"> <font size=\"2\">Код объявления:&nbsp;</font>". $row_Recordset1['Uid']."</div>";?>
              <div align="left"> <strong><font size="3"  color="#703800">
                  <?php
	 if (isset($row_Recordset1['Date'])) {
		$o_date = strftime("%d %B %Y", strtotime($row_Recordset1['Date']));
	if(iconv_get_encoding('input_encoding') != "WINDOWS-1251"){ 
	echo  $ru_date = iconv("WINDOWS-1251", "UTF-8", $o_date);
	} else {echo  $o_date; }
}
	?>  </font></strong>
  <?php  
	 getTypeExchange($row_Recordset1['Type_Exchange']);	
	 ($row_Recordset1['Type_Exchange'] == "0")?  print '&nbsp;' . $row_Recordset1['Formula']."=". $row_Recordset1['Result'] : print '&nbsp;' . $row_Recordset1['Result']."=". $row_Recordset1['Formula']; 
	// echo  '&nbsp;' . $row_Recordset1['Formula'];
	?>
                </div>
             <p><?php echo  $row_Recordset1['Description'] . "<p>"; ?></p>
             <?php  echo "<div align=\"left\"> <font size=\"3\" color=\"#703800\">" . "Контактная информация:" ."</font> </div>" ;?>
             <?php if($row_Recordset1['Source']!=NULL && $row_Recordset1['Treated']=='1'){
			 echo 'Агентство:' . $row_Recordset1['agency_name'].'<br/>';
                 echo 'E-mail: <a href="mailto:' . $row_Recordset1['agency_mail'] . '">'. $row_Recordset1['agency_mail']. '</a><br/>';
                 echo 'Тел.:' . $row_Recordset1['phon'];
				 } else {
				 echo $row_Recordset1['Contact'];
				 }?> </td>
                  <td align="left" valign="top"><?php 
				  if($row_Recordset1['Source']=='0' && $row_Recordset1['Treated']=='0'){
				  echo 'Получено с сайта.<br/>Необработано.';
				  } elseif($row_Recordset1['Source']=='0' && $row_Recordset1['Treated']=='1'){
				  echo 'Получено с сайта.<br/>Обработал(а):<br/>'. $row_Recordset1['agent_name'];
				  } else {
				  echo 'Добавил(а):<br/>'. $row_Recordset1['agent_name'];
				  };
				   ?></td>
            </tr>
            <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        </table>
      </form></td>
  </tr>
  <tr align="center">
    <td class="qvarter" ><font size="2">
      <?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="_images/First.gif" border=0 /></a>
        <?php } // Show if not first page ?>
      </font></td>
    <td class="qvarter"><font size="2" >
      <?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="_images/Previous.gif" border=0 /></a>
        <?php } // Show if not first page ?>
      </font></td>
    <td class="qvarter"><font size="2" >
      <?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="_images/Next.gif" border=0 /></a>
        <?php } // Show if not last page ?>
      </font></td>
    <td class="qvarter"><font size="2">
      <?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="_images/Last.gif" border=0 /></a>
        <?php } // Show if not last page ?>
      </font></td>
  </tr>
  <tr>
    <td height="38" align="center" valign="center" colspan="4" ><font size="2">Объявления с <?php echo ($startRow_Recordset1 + 1) ?> по <?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> из <?php echo $totalRows_Recordset1 ?> найденных в базе данных</font>
    <?php } else { echo "Отсутствуют объявления, удовлетворяющие условиям, Вашего запроса.";}?></td>
  </tr>
</table>
</body>
</html>