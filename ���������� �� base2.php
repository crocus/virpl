<?php 
/*header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
header('Cache-Control: no-store, no-cache, must-revalidate'); 
header('Cache-Control: post-check=0, pre-check=0', FALSE); 
header('Pragma: no-cache');*/
require_once('_scriptsphp/r_conn.php');
require_once('_scriptsphp/services.php');
require_once('_scriptsphp/session.inc');
session_start();
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

if (isset($_GET['s_prpt']) && strval($_GET['s_prpt'] && !empty($_GET['s_prpt']))){
$participants = searchFromParticipants($_GET['s_prpt']);
} else {
$participants =null;
}
//print_r ($participants);
if (isset( $_GET['type']) && $_GET['type']!= 'undefined') {
$typ = implode(",", $_GET['type']);
}
if (isset( $_GET['room']) && $_GET['room']!= 'undefined') {
$rom = implode(",", $_GET['room']);
}
if (isset( $_GET['region'])) {
 $region = implode(",", $_GET['region']);
}
if (isset( $_GET['wc'])) {
 $wc = implode(",", $_GET['wc']);
}
if (isset( $_GET['plan'])) {
 $plan= implode(",", $_GET['plan']);
}
if (isset( $_GET['balcon'])) {
 $bal = implode(",", $_GET['balcon']);
}
$minprice = (isset($_GET['minprice']) && intval($_GET['minprice'] && !empty($_GET['minprice']))) ? htmlspecialchars(trim(rtrim($_GET['minprice']))) : null;
$maxprice = (isset($_GET['maxprice']) && intval($_GET['maxprice'] && !empty($_GET['maxprice']))) ? htmlspecialchars(trim(rtrim($_GET['maxprice']))) : null;
$flr = $_GET['floor'];
$ord = $_GET['order'];
$id = $_GET['id'];
 if ( empty($minprice) && empty($maxprice) ) {
        $priceQuery = "";
 } elseif ( empty($minprice) && !empty($maxprice) )  {
	 	$priceQuery = " AND f.flats_price <= $maxprice";
	} elseif ( !empty($minprice) && empty($maxprice) )  {
	 	$priceQuery = " AND f.flats_price >= $minprice";
    } else {
        $priceQuery = " AND f.flats_price BETWEEN $minprice AND $maxprice";
    }

/*$GenerQuery = "SELECT f.flats_cod, f.flats_date, f.So, f.Sz, f.Sk, f.flats_price, f.foto, f.flats_floor, f.flats_floorest, t.type_s, r.room_cod,ci.city_name, a.region_name, s.street_name, w.wc_short, b.balcon_short, m.material_short, n.agent_name,  f.Source, f.Treated FROM tbl_flats f, tbl_type t, tbl_room r,  tbl_city ci, tbl_region a, tbl_street s, tbl_wc w, tbl_balcon b, tbl_material m, tbl_agency g, tbl_agent n WHERE f.type_cod = t.type_cod  AND f.room_cod = r.room_cod AND f.street_cod = s.street_cod AND s.city_cod = ci.city_cod AND s.region_cod = a.region_cod AND f.agent_cod = n.agent_cod AND n.agency_cod = g.agency_cod AND f.wc_cod = w.wc_cod AND f.balcon_cod = b.balcon_cod AND f.material_cod = m.material_cod";*/

/*LEFT JOIN tbl_agent n ON f.agent_cod = n.agent_cod 
LEFT JOIN tbl_agency g ON n.agency_cod = g.agency_cod */
$GenerQuery = "SELECT f.flats_cod, f.flats_date, f.So, f.Sz, f.Sk, f.flats_price, f.foto, f.flats_floor, f.flats_floorest, t.type_s, r.room_cod, ci.city_name, a.region_name, s.street_name, w.wc_short, b.balcon_short, m.material_short, n.value_property as agent_name,  f.Source, f.Treated FROM tbl_flats f 
LEFT JOIN tbl_type t ON f.type_cod = t.type_cod 
LEFT JOIN tbl_room r ON f.room_cod = r.room_cod 
LEFT JOIN tbl_street s ON f.street_cod = s.street_cod  
LEFT JOIN tbl_region a ON s.region_cod = a.region_cod  
LEFT JOIN tbl_city ci ON s.city_cod = ci.city_cod 
LEFT JOIN tbl_wc w ON f.wc_cod = w.wc_cod 
LEFT JOIN tbl_balcon b ON f.balcon_cod = b.balcon_cod 
LEFT JOIN tbl_material m ON f.material_cod = m.material_cod 
LEFT JOIN tbl_participants pc ON pc.UUID = f.agent_cod 
LEFT JOIN tbl_participants_catalog n ON pc.Participants_id = n.Participants_id And n.Participants_property_id=1 ";
/*LEFT JOIN node n ON f.agent_cod = n.UUID 
LEFT JOIN node na ON na.participants_id = n.parents_id */
if(isset($_SESSION['user'])&& !empty($_SESSION['user'])){
	    $GenerQuery.= "WHERE f.UUID IS NOT NULL And f.sale = 0";
	} else {
		$GenerQuery.= "WHERE f.Treated = 1 And f.sale = 0";
	}
$and = " And";
$AgeQuery = (isset($participants) && !empty($participants)) ? " And f.agent_cod in ($participants)" : null;
/* switch ( $age ) {
    case NULL:
       $AgeQuery = (" f.agent_cod IS NOT NULL ");
        break;
    case "значение не задано":
         $AgeQuery = (" f.agent_cod IS NOT NULL ");
         break;
    default : 
        $AgeQuery  = " n.agency_cod = {$age}";
        break;
}*/
 switch ( $typ ) {
    case NULL:
       $TypQuery = (" f.type_cod IS NOT NULL ");
        break;
	case 'undefined':
       $TypQuery = (" f.type_cod IS NOT NULL ");
        break;		
    default : 
        $TypQuery  = " f.type_cod IN ({$typ})";
        break;
}
switch ( $rom ) {
    case NULL:
       $romQuery = (" f.room_cod IS NOT NULL ");
        break;
	case 'undefined':
       $romQuery = (" f.room_cod IS NOT NULL ");
        break;	
    default : 
		$romQuery  = " f.room_cod IN ({$rom})";
        break;
}
switch ( $region ) {
    case NULL:
       $regQuery = (" f.street_cod IS NOT NULL ");
        break;
	case 'undefined':
       $regQuery = (" f.street_cod IS NOT NULL ");
        break;	
    default : 
        $regQuery  = " s.region_cod IN ({$region})";
        break;
}
switch ( $wc  ) {
    case NULL:
       $wcQuery = (" f.wc_cod IS NOT NULL ");
        break;
    default : 
        $wcQuery  = " f.wc_cod IN ({$wc})";
        break;
}
switch ( $bal  ) {
    case NULL:
       $balQuery = (" f.balcon_cod IS NOT NULL ");
        break;
	case 'undefined':
       $balQuery = (" f.balcon_cod IS NOT NULL ");
        break;		
    default : 
        $balQuery  = " f.balcon_cod IN ({$bal})";
        break;
}
switch ( $plan  ) {
    case NULL:
	case 'undefined':
        $planQuery = (" f.plan_cod IS NOT NULL ");
        break;		
    default : 
        $planQuery  = " f.plan_cod IN ({$plan})";
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
	case NULL:	 
	case "nothing":	 
	default : 
        $ordQuery = (" ORDER BY f.flats_date DESC");
        break;
}
$SQLQuery = $GenerQuery . $AgeQuery . $and. $TypQuery . $and . $romQuery . $and . $regQuery . $and . $balQuery. $and . $wcQuery . $and . $planQuery . $and . $flrQuery . $priceQuery . $ordQuery;
//echo $SQLQuery;
$query_Recordset1 = $SQLQuery;
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

