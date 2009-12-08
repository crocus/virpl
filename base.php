<?php 
require_once('_scriptsphp/r_conn.php');
header('Pragma: no-cache'); 
$age = $_GET['agency'];
$typ = $_GET['type'];
$rom = $_GET['room'];
$region = $_GET['region'];
$bal = $_GET['balcon'];
$flr = $_GET['floor'];
$ord = $_GET['order'];
/* echo  "$age ";  */
$GenerQuery = "SELECT f.flats_cod, f.flats_date, f.So, f.Sz, f.Sk, f.flats_price, f.foto, f.flats_floor, f.flats_floorest, t.type_s, r.room_cod, a.region_name, s.street_name, w.wc_short, b.balcon_short, m.material_short FROM tbl_flats f, tbl_type t, tbl_room r, tbl_region a, tbl_street s, tbl_wc w, tbl_balcon b, tbl_material m, tbl_agency g, tbl_agent n WHERE f.type_cod = t.type_cod  AND f.room_cod = r.room_cod AND f.street_cod = s.street_cod AND s.region_cod = a.region_cod AND f.agent_cod = n.agent_cod AND n.agency_cod = g.agency_cod AND f.wc_cod = w.wc_cod AND f.balcon_cod = b.balcon_cod AND f.material_cod = m.material_cod";
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
$SQLQuery = $GenerQuery . $WhereQuery . $AgeQuery . $acon. $TypQuery . $rcon . $romQuery . $bcon . $balQuery . $regcon . $regQuery . $flrcon . $flrQuery . " ORDER BY f.flats_cod ASC";
$query_Recordset1 = $SQLQuery;

 /* echo $SQLQuery;  */

$Recordset1 = mysql_query($SQLQuery, $realtorplus) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
?>
