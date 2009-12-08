<?php 
require_once('_scriptsphp/r_conn.php');
$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction
if(!$sidx) $sidx =1;

$result = mysql_query("SELECT COUNT(*) AS count FROM tbl_flats f, tbl_type t, tbl_room r, tbl_region a, tbl_street s, tbl_wc w, tbl_balcon b, tbl_material m, tbl_agency g, tbl_agent n WHERE f.type_cod = t.type_cod  AND f.room_cod = r.room_cod AND f.street_cod = s.street_cod AND s.region_cod = a.region_cod AND f.agent_cod = n.agent_cod AND n.agency_cod = g.agency_cod AND f.wc_cod = w.wc_cod AND f.balcon_cod = b.balcon_cod AND f.material_cod = m.material_cod")or die("Couldn t execute query.".mysql_error());
$row = mysql_fetch_array($result,MYSQL_ASSOC);
$count = $row['count'];
if( $count >0 ) {
	$total_pages = ceil($count/$limit);
} else {
	$total_pages = 0;
}
if ($page > $total_pages) $page=$total_pages;

$start = $limit*$page - $limit; // do not put $limit*($page - 1)

$SQL ="SELECT f.flats_cod, f.flats_date, f.So, f.Sz, f.Sk, f.flats_price, f.foto, f.flats_floor, f.flats_floorest, t.type_s, r.room_cod, a.region_name, s.street_name, w.wc_short, b.balcon_short, m.material_short".
						" FROM tbl_flats f, tbl_type t, tbl_room r, tbl_region a, tbl_street s, tbl_wc w, tbl_balcon b, tbl_material m, tbl_agency g, tbl_agent n ".
						"WHERE f.type_cod = t.type_cod  AND f.room_cod = r.room_cod AND f.street_cod = s.street_cod AND s.region_cod = a.region_cod AND f.agent_cod = n.agent_cod AND n.agency_cod = g.agency_cod AND f.wc_cod = w.wc_cod AND f.balcon_cod = b.balcon_cod".
						" AND f.material_cod = m.material_cod";
						//" AND f.material_cod = m.material_cod ORDER BY $sidx $sord LIMIT $start , $limit";
$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
echo ($SQL);
$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;
$i=0;
while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
    $responce->rows[$i]['id']=$row[flats_cod];
    $responce->rows[$i]['cell']=array($row[foto],$row[flats_cod],$row[flats_date],$row[room_cod],$row[So]. "/". $row[Sz]. "/". $row[Sk],$row[region_name] . ", ". $row[street_name],$row[wc_short],$row[balcon_short],$row[flats_price],$row[flats_floor]. "/". $row[flats_floorest]. " " . $row[material_short]);
    $i++;
}        
echo json_encode($responce);
?>