<?php 
	require_once('r_conn.php');
	include('services.php');
	require_once('session.inc');
	session_start();						
	$query_detail = "SELECT f.flats_cod, f.UUID, DATE_FORMAT(f.flats_date, '%a %b %d %Y %H:%i:%s') as flats_date, f.So, f.Sz, f.Sk, f.flats_price, f.kind_calc,
	f.foto, f.flats_tel, f.flats_floor, f.flats_floorest, f.flats_comments, pr.project_name, t.type_s, r.room_cod, l.sale_name, c.cond_name, i.side_name,
	ci.city_name, a.region_name, s.street_name, w.wc_name, b.balcon_name, m.material_name, p.plan_name, f.Contact, f.Source, f.hot_affair_type, f.Treated, n.Name_Node as agent_name, na.Name_Node as agency_name, tp.phon, IF (na.Mail IS NULL, '', na.Mail) as agency_mail  FROM tbl_flats f
	LEFT JOIN tbl_type t ON f.type_cod = t.type_cod 
	LEFT JOIN tbl_room r ON f.room_cod = r.room_cod 
	LEFT JOIN tbl_street s ON f.street_cod = s.street_cod  
	LEFT JOIN tbl_region a ON s.region_cod = a.region_cod  
	LEFT JOIN tbl_city ci ON s.city_cod = ci.city_cod 
	LEFT JOIN tbl_wc w ON f.wc_cod = w.wc_cod 
	LEFT JOIN tbl_balcon b ON f.balcon_cod = b.balcon_cod 
	LEFT JOIN tbl_project pr ON f.project_cod = pr.project_cod 
	LEFT JOIN tbl_material m ON f.material_cod = m.material_cod 
	LEFT JOIN node n ON f.agent_cod = n.UUID 
	LEFT JOIN node na ON na.participants_id = n.parents_id 
	LEFT JOIN tbl_plan p ON f.plan_cod = p.plan_cod 
	LEFT JOIN tbl_sale l ON f.sale_cod = l.sale_cod 
	LEFT JOIN tbl_cond c ON f.cond_cod = c.cond_cod 
	LEFT JOIN tbl_side i ON f.side_cod = i.side_cod 
	LEFT JOIN (SELECT 	agency_name,
	GROUP_CONCAT( num_tel SEPARATOR ', ') AS phon
	FROM tbl_telag
	GROUP BY agency_name) AS tp
	ON na.Name_Node = tp.agency_name 
	WHERE f.sale=0 AND f.flats_comments IS NOT NULL AND f.foto!=0 AND f.hot_affair=1";
	$result = mysql_query($query_detail, $realtorplus) or die(mysql_error());
	$count_array = array();
	$i=0;
	while($obj =mysql_fetch_assoc($result)) {
		$count_array["data"][] = $obj;
		$count_array["data"][$i]["flats_price_usd"]=number_format(round($count_array["data"][$i]['flats_price']/((isset($_SESSION['usd']))? $_SESSION['usd']:31)), 0, '.', ' ');	
		$i++;
	}
	$first_json_str = json_encode($count_array);
	$last_json_str = utf8_JSON_russian_cyr($first_json_str);
	echo $last_json_str;
	mysql_free_result($result);  
?> 
