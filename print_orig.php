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
	$maxRows_Recordset1 = 20;
	$pageNum_Recordset1 = 0;
	if (isset($_GET['maxRows_Recordset1'])) {
		$maxRows_Recordset1 = $_GET['maxRows_Recordset1'];
	}
	if (isset($_GET['pageNum_Recordset1'])) {
		$pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
	}
	$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

	if (isset($_GET['s_prpt']) && strval($_GET['s_prpt'] && !empty($_GET['s_prpt']))) {
		$participants = searchFromParticipants($_GET['s_prpt']);
	} else {
		$participants = null;
	}
	if (isset( $_GET['type']) && $_GET['type']!= 'undefined') {
		$typ = implode(",", $_GET['type']);
	}
	if (isset( $_GET['room']) && $_GET['room']!= 'undefined') {
		$rom = implode(",", $_GET['room']);
	}
	if (isset( $_GET['project'])) {
		$project = implode(",", $_GET['project']);
	}
	if (isset( $_GET['region'])) {
		$region = implode(",", $_GET['region']);
	}
	if (isset( $_GET['sale'])) {
		$sale = implode(",", $_GET['sale']);
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
	$minprice = (isset($_GET['minprice']) && intval($_GET['minprice'] && !empty($_GET['minprice']))) ? preg_replace('/([^\d])/', "", $_GET['minprice']) : null;
	$maxprice = (isset($_GET['maxprice']) && intval($_GET['maxprice'] && !empty($_GET['maxprice']))) ? preg_replace('/([^\d])/', "", $_GET['maxprice']) : null;
	$flr = $_GET['floor'];
	$ord = $_GET['order'];
	$byid = (isset($_GET['byid']) && strval($_GET['byid'] && !empty($_GET['byid']))) ? htmlspecialchars(trim(rtrim($_GET['byid']))) : null;
	$age = (isset($_GET['pussy']) && strval($_GET['pussy'] && !empty($_GET['pussy']))) ? ' > '  . trim(rtrim($_GET['pussy'])) : ' <= 14 ';

	if ( empty($minprice) && empty($maxprice) ) {
		$priceQuery = "";
	} elseif ( empty($minprice) && !empty($maxprice) ) {
		$priceQuery = " AND f.flats_price <= $maxprice";
	} elseif ( !empty($minprice) && empty($maxprice) ) {
		$priceQuery = " AND f.flats_price >= $minprice";
	} else {
		$priceQuery = " AND f.flats_price BETWEEN $minprice AND $maxprice";
	}
	if (isset( $_SESSION['forprint']) && !empty($_SESSION['forprint']) && isset($_GET['selected']) ) {
		$includeId = $_SESSION['forprint'];
	} elseif (isset( $_SESSION['hiddenRow']) && !empty($_SESSION['hiddenRow'])) {
		$excludeId = $_SESSION['hiddenRow'];
	}
	if (isset( $_SESSION['thisChecked']) && !empty($_SESSION['thisChecked'])) {
		$feefor = $_SESSION['thisChecked'];
	} else {
		$feefor="0";
	}
	if (isset($_SESSION['margin']) && !is_null($_SESSION['margin'])) {
		$marga = ($_SESSION['margin'] >= 0 )? "f.flats_price+" . $_SESSION['margin'] : "f.flats_price" . $_SESSION['margin'];
		$marga_sum = $_SESSION['margin'];
	} else {
		$marga_sum="0";
		$marga="f.flats_price";
	}
	if (isset($_COOKIE['report']) && $_COOKIE['report'] == 0) {
		if (isset($_SESSION['id']) && !is_null($_SESSION['id'])) {
			$aquery="SELECT n.value_property as agent_name, pp.value_property as agency_name, tp.phon from tbl_participants p
			LEFT JOIN tbl_participants_catalog n ON p.Participants_id = n.Participants_id AND n.Participants_property_id = 1
			LEFT JOIN tbl_participants_catalog np ON p.Participants_id = np.Participants_id AND np.Participants_property_id = 14
			LEFT JOIN tbl_participants_catalog pp ON pp.Participants_id = np.value_property AND pp.Participants_property_id = 1
			LEFT JOIN (SELECT	agency_name,
			GROUP_CONCAT( num_tel SEPARATOR ', ') AS phon
			FROM tbl_telag
			GROUP BY agency_name) AS tp
			ON pp.value_property = tp.agency_name 
			WHERE p.Participants_id = {$_SESSION['id']}";
			$aRecordset = mysql_query($aquery, $realtorplus) or die(mysql_error());
			$row_aRecordset = mysql_fetch_assoc($aRecordset);
			$logged_user_info = ', ' . '("Контактное лицо: ' . $row_aRecordset['agent_name']
			. '<br/>Агентство: '. htmlentities($row_aRecordset['agency_name'], ENT_QUOTES, "UTF-8")
			. '<br/>Телефоны: '. $row_aRecordset['phon'] . '") as logged_user ';
		} else { 
			$logged_user_info = null;
		}
	} else { 
		$logged_user_info = null;
	}

	$GenerQuery = "SELECT f.flats_cod, f.UUID, f.flats_date, f.So, f.Sz, f.Sk, IF (f.flats_cod NOT IN ({$feefor}), f.flats_price, {$marga}) as flats_price,".
	"IF (f.flats_cod NOT IN ({$feefor}), '', {$marga_sum}) as marga, f.kind_calc, f.flats_floor, f.flats_floorest, t.type_s, r.room_cod, ci.city_name,".
	"a.region_name, s.street_name, w.wc_name, b.balcon_short, m.material_short, f.flats_comments, n.value_property  AS agent_name, pp.value_property AS agency_name,".
	"tp.phon, f.Source, f.Treated, UNIX_TIMESTAMP(f.last_update) as last_update {$logged_user_info} FROM tbl_flats f
	LEFT JOIN tbl_type t ON f.type_cod = t.type_cod 
	LEFT JOIN tbl_room r ON f.room_cod = r.room_cod 
	LEFT JOIN tbl_street s ON f.street_cod = s.street_cod  
	LEFT JOIN tbl_region a ON s.region_cod = a.region_cod  
	LEFT JOIN tbl_city ci ON s.city_cod = ci.city_cod 
	LEFT JOIN tbl_wc w ON f.wc_cod = w.wc_cod 
	LEFT JOIN tbl_balcon b ON f.balcon_cod = b.balcon_cod 
	LEFT JOIN tbl_material m ON f.material_cod = m.material_cod
	LEFT JOIN tbl_participants pc ON pc.UUID = f.agent_cod
	LEFT JOIN tbl_participants_catalog n ON pc.Participants_id = n.Participants_id AND n.Participants_property_id = 1
	LEFT JOIN tbl_participants_catalog np ON pc.Participants_id = np.Participants_id AND np.Participants_property_id = 14
	LEFT JOIN tbl_participants_catalog pp ON pp.Participants_id = np.value_property AND pp.Participants_property_id = 1
	LEFT JOIN (SELECT
	agency_name,
	GROUP_CONCAT( num_tel SEPARATOR ', ') AS phon
	FROM tbl_telag
	GROUP BY agency_name) AS tp
	ON pp.value_property = tp.agency_name ";
	//na.Name_Node as agency_name,
	//LEFT OUTER JOIN tbl_telag e ON na.Name_Node = e.agency_name 
	//GROUP_CONCAT( e.num_tel SEPARATOR ', ') as phon,
	//LEFT JOIN node n ON f.agent_cod = n.UUID 
	//LEFT JOIN node na ON na.participants_id = n.parents_id 
	if(isset($_SESSION['user'])&& !empty($_SESSION['user'])) {
		$GenerQuery.= "WHERE DATEDIFF(NOW(), f.last_update) $age And f.sale = 0";
	} else {
		$GenerQuery.= "WHERE DATEDIFF(NOW(), f.last_update) $age AND f.Treated = 1 And f.sale = 0";
	}
	$and = " And";
	$AgeQuery = (isset($participants) && !empty($participants)) ? " And f.agent_cod in ($participants)" : null;
	$byidQuery = (isset($byid) && !empty($byid)) ? " And f.UUID LIKE '$byid%'" : null;
	$includeIdQuery = (isset($includeId) && !empty($includeId)) ? " And f.flats_cod IN ($includeId)" : null;
	$excludeIdQuery = (isset($excludeId) && !empty($excludeId)) ? " And f.flats_cod NOT IN ($excludeId)" : null;
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
	switch ( $project ) {
		case NULL:
		case 'undefined':
		case '-':
			$projectQuery = (" f.project_cod IS NOT NULL ");
			break;
		default :
			$projectQuery  = " f.project_cod IN ({$project})";
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
	switch ( $sale  ) {
		case NULL:
			$saleQuery = (" f.sale_cod IS NOT NULL ");
			break;
		default :
			$saleQuery  = " f.sale_cod IN ({$sale})";
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
		case "foto":
			$ordQuery = (" And f.foto !=0");
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
	$SQLQuery = $GenerQuery . $includeIdQuery . $excludeIdQuery. $AgeQuery . $byidQuery. $and. $TypQuery . $and . $projectQuery
	. $and . $romQuery . $and . $regQuery . $and . $balQuery. $and . $saleQuery .$and.$wcQuery 
	. $and . $planQuery . $and . $flrQuery . $priceQuery . $ordQuery;
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
