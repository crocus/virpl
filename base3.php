<?php 
require_once('_scriptsphp/r_conn.php');
function utf8_JSON_russian_cyr($str){
$arr_replace_symbols = array
(
'\u0410' => 'А', '\u0430' => 'а',
'\u0411' => 'Б', '\u0431' => 'б',
'\u0412' => 'В', '\u0432' => 'в',
'\u0413' => 'Г', '\u0433' => 'г',
'\u0414' => 'Д', '\u0434' => 'д',
'\u0415' => 'Е', '\u0435' => 'е',
'\u0401' => 'Ё', '\u0451' => 'ё',
'\u0416' => 'Ж', '\u0436' => 'ж',
'\u0417' => 'З', '\u0437' => 'з',
'\u0418' => 'И', '\u0438' => 'и',
'\u0419' => 'Й', '\u0439' => 'й',
'\u041a' => 'К', '\u043a' => 'к',
'\u041b' => 'Л', '\u043b' => 'л',
'\u041c' => 'М', '\u043c' => 'м',
'\u041d' => 'Н', '\u043d' => 'н',
'\u041e' => 'О', '\u043e' => 'о',
'\u041f' => 'П', '\u043f' => 'п',
'\u0420' => 'Р', '\u0440' => 'р',
'\u0421' => 'С', '\u0441' => 'с',
'\u0422' => 'Т', '\u0442' => 'т',
'\u0423' => 'У', '\u0443' => 'у',
'\u0424' => 'Ф', '\u0444' => 'ф',
'\u0425' => 'Х', '\u0445' => 'х',
'\u0426' => 'Ц', '\u0446' => 'ц',
'\u0427' => 'Ч', '\u0447' => 'ч',
'\u0428' => 'Ш', '\u0448' => 'ш',
'\u0429' => 'Щ', '\u0449' => 'щ',
'\u042a' => 'Ъ', '\u044a' => 'ъ',
'\u042d' => 'Ы', '\u044b' => 'ы',
'\u042c' => 'Ь', '\u044c' => 'ь',
'\u042d' => 'Э', '\u044d' => 'э',
'\u042e' => 'Ю', '\u044e' => 'ю',
'\u042f' => 'Я', '\u044f' => 'я'
);
foreach($arr_replace_symbols as $from_gluk => $to_normal){
$str = str_replace ($from_gluk,$to_normal,$str);
}
return $str;
};
$age = $_GET['agency'];
$typ = $_GET['type'];
$rom = $_GET['room'];
$region = $_GET['region'];
$bal = $_GET['balcon'];
$flr = $_GET['floor'];
$ord = $_GET['order'];
/* echo  "$age ";  */
$GenerQuery = "SELECT f.flats_cod, f.flats_date, f.So, f.Sz, f.Sk, f.flats_price, f.foto, f.flats_floor, f.flats_floorest, t.type_s, r.room_cod, a.region_name, s.street_name, w.wc_short, b.balcon_short, m.material_short".
						" FROM tbl_flats f, tbl_type t, tbl_room r, tbl_region a, tbl_street s, tbl_wc w, tbl_balcon b, tbl_material m, tbl_agency g, tbl_agent n ".
						"WHERE f.type_cod = t.type_cod  AND f.room_cod = r.room_cod AND f.street_cod = s.street_cod AND s.region_cod = a.region_cod AND f.agent_cod = n.agent_cod AND n.agency_cod = g.agency_cod AND f.wc_cod = w.wc_cod AND f.balcon_cod = b.balcon_cod".
						" AND f.material_cod = m.material_cod";
$WhereQuery = " And";
$acon = " And";
$rcon = " And";
$bcon = " And";
$regcon = " And";
$flrcon = " And";

 switch ( $age ) {
    case NULL:
       $AgeQuery = (" f.agent_cod IS NOT NULL ");
        break;
    case "значение не задано":
         $AgeQuery = (" f.agent_cod IS NOT NULL ");
         break;
    default : 
        $AgeQuery  = " n.agency_cod = {$age}";
        break;
}
 switch ( $typ ) {
    case NULL:
       $TypQuery = (" f.type_cod IS NOT NULL ");
        break;
    case "значение не задано":
         $TypQuery = (" f.type_cod IS NOT NULL ");
         break;
    default : 
        $TypQuery  = " f.type_cod = {$typ}";
        break;
}
switch ( $rom ) {
    case NULL:
       $romQuery = (" f.room_cod IS NOT NULL ");
        break;
    case "значение не задано":
         $romQuery = (" f.room_cod IS NOT NULL ");
         break;
    default : 
        $romQuery  = " f.room_cod = {$rom}";
        break;
}
switch ( $bal  ) {
    case NULL:
       $balQuery = (" f.balcon_cod IS NOT NULL ");
        break;
    case "значение не задано":
        $balQuery = (" f.balcon_cod IS NOT NULL ");
         break;
    default : 
        $balQuery  = " f.balcon_cod = {$bal}";
        break;
}
switch ( $region ) {
    case NULL:
       $regQuery = (" f.street_cod IS NOT NULL ");
        break;
    case "значение не задано":
        $regQuery = (" f.street_cod IS NOT NULL ");
         break;
    default : 
        $regQuery  = " s.region_cod = {$region}";
        break;
}
switch ( $flr ) {
    case NULL:
       $flrQuery = (" f.flats_floor IS NOT NULL ");
        break;
    case "значение не задано":
        $flrQuery = (" f.flats_floor IS NOT NULL ");
         break;
    case "noferst":
        $flrQuery = (" f.flats_floor<>0 AND f.flats_floor<>1 ");
         break;
    case "nolast":
        $flrQuery = (" f.flats_floor<>f.flats_floorest ");
         break;
	 case "middle":
        $flrQuery = (" f.flats_floor<>0 AND f.flats_floor<>1 AND f.flats_floor<>f.flats_floorest ");
         break;
	default : 
        $flrQuery  = " f.flats_floor IS NOT NULL ";
        break;
}
switch ( $ord ) {
    case NULL:
       $ordQuery = (" ORDER BY f.flats_price");
        break;
    case "значение не задано":
        $ordQuery = (" ORDER BY r.room_cod");
         break;
    case "type":
        $ordQuery = (" ORDER BY  t.type_s");
         break;
	case "date":
        $ordQuery = (" ORDER BY f.flats_date DESC");
         break;
	case "room":
        $ordQuery = (" ORDER BY r.room_cod");
         break;
	case "price":
        $ordQuery = (" ORDER BY f.flats_price DESC");
         break;
	default : 
        $ordQuery  = " ORDER BY {$ord }";
        break;
}
$SQLQuery = $GenerQuery . $WhereQuery . $AgeQuery . $acon. $TypQuery . $rcon . $romQuery . $bcon . $balQuery . $regcon . $regQuery . $flrcon . $flrQuery . $ordQuery;

 /* echo $SQLQuery;  */
$num=0;
$Recordset3 = @mysql_query($GenerQuery , $realtorplus) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$num=mysql_affected_rows();
 function getJSON($resultSet,$affectedRecords){
 $numberRows=0;
 $arrfieldName=array();
 $i=0;
 $json="";
	//print("Test");
 	while ($i < mysql_num_fields($resultSet))  {
 		$meta = mysql_fetch_field($resultSet, $i);
		if (!$meta) {
		}else{
		$arrfieldName[$i]=$meta->name;
		}
		$i++;
 	}
	 $i=0;
	 // $json="{'". records ."':[";
	//  $json="{'". records ."':[";
	while($row=mysql_fetch_array($resultSet, MYSQL_NUM)) {
		$i++;
		//print("Ind ".$i."-$affectedRecords<br>"); 'name':'marco'
		$json.="{";
		for($r=0;$r < count($arrfieldName);$r++) {
			$json.="'" . $arrfieldName[$r] . "':'" . $row[$r]. "'";
			if($r < count($arrfieldName)-1){
				$json.=",";
			}else{
				$json.="";
			}
		}		
		 if($i!=$affectedRecords-1){
		 	$json.="},";
		 }else{
		 	$json.="}";
		 }
		 
		 
		
	}
	//$json.="]}";
	
	return $json;
 }
 
/*$m_json = getJSON($Recordset3,$num);
$first_json_str = json_encode($m_json);
$last_json_str = utf8_JSON_russian_cyr($first_json_str);
echo trim($last_json_str, "\"");*/
$arr = array();
//$last_json_str = "{ \"aaData\":";
while($obj = mysql_fetch_assoc($Recordset3)){
$arr[] = $obj;
}
$first_json_str = json_encode($arr);
$last_json_str = utf8_JSON_russian_cyr($first_json_str);
echo $last_json_str;
?>