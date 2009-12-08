<?php
	include('r_conn.php');
	include('services.php');
	require_once('session.inc');
	session_start();
	$parameter = (isset($_REQUEST['parameter']) && strval($_REQUEST['parameter'] && !empty($_REQUEST['parameter']))) ? htmlspecialchars(trim(rtrim($_REQUEST['parameter']))) : null;
	$prpt =(isset($_REQUEST['participant']) && strval($_REQUEST['participant'] && !empty($_REQUEST['participant']))) ? htmlspecialchars(trim(rtrim($_REQUEST['participant']))) : null;
	$aname= (isset($_GET['aname']) && strval($_GET['aname'] && !empty($_GET['aname']))) ? $_GET['aname'] : null;
	$id = (isset($_REQUEST['id']) && intval($_REQUEST['id'] && !empty($_REQUEST['id']))) ? $_REQUEST['id'] : null;
	if ($parameter == 'agency') {
		$query_param = "SELECT pc.participants_id as Id, pn.value_property as Name
		FROM tbl_participants_catalog pc 
		LEFT JOIN tbl_participants_catalog pn on (pn.participants_id = pc.participants_id AND pn.participants_property_id = 1)
		WHERE pc.participants_property_id = 7 And pc.value_property = 8";
		$Recordset = mysql_query($query_param, $realtorplus) or die(mysql_error());
		$arr = array();
		while($obj = mysql_fetch_assoc($Recordset)) {
			$arr[] = $obj;
		}
		$first_json_str = json_encode($arr);
		$last_json_str = utf8_JSON_russian_cyr($first_json_str);
		echo $last_json_str;
	}
	/* для перевода - временено	*/
	/*if ($parameter == 'agent') {
	$query_param = "SELECT a.agent_cod AS Id, a.agent_name AS Name, ag.agency_name AS Agency_Nmae
	FROM tbl_agent a
	INNER JOIN tbl_agency ag ON ag.agency_cod = a.agency_cod
	AND ag.agency_name ='{$aname}'";
	$Recordset = mysql_query($query_param, $realtorplus) or die(mysql_error());
	$arr = array();
	while($obj = mysql_fetch_assoc($Recordset)) {
	$arr[] = $obj;
	}
	$first_json_str = json_encode($arr);
	$last_json_str = utf8_JSON_russian_cyr($first_json_str);
	echo $last_json_str;
	}*/
	//	
	if ($parameter == 'participant') {
		$query_param = "SELECT
		pc.Participants_id AS participants_id,
		pp.value_property  AS parents_id,
		ps.value_property  AS Name,
		pe.value_property  AS Role,
		pl.value_property  AS Login,
		sp.value_property  AS Show_phon,
		pm.value_property  AS Mail
		FROM tbl_participants pc
		LEFT JOIN tbl_participants_catalog ps
		ON pc.Participants_id = ps.Participants_id
		AND ps.Participants_property_id = 1
		LEFT JOIN tbl_participants_catalog pe
		ON pc.Participants_id = pe.Participants_id
		AND pe.Participants_property_id = 3
		LEFT JOIN tbl_participants_catalog pl
		ON pc.Participants_id = pl.Participants_id
		AND pl.Participants_property_id = 5
		LEFT JOIN tbl_participants_catalog pp
		ON pc.Participants_id = pp.Participants_id
		AND pp.Participants_property_id = 14
		LEFT JOIN tbl_participants_catalog pm
		ON pc.Participants_id = pm.Participants_id
		AND pm.Participants_property_id = 2
		LEFT JOIN tbl_participants_catalog sp
		ON pc.Participants_id = sp.Participants_id
		AND sp.Participants_property_id = 11
		LEFT JOIN (SELECT agency_name,
		GROUP_CONCAT( num_tel SEPARATOR ', ') AS phon
		FROM tbl_telag
		GROUP BY agency_name) AS tp
		ON ps.value_property = tp.agency_name
		WHERE pc.Participants_id = {$id}";

		$Recordset = mysql_query($query_param, $realtorplus) or die(mysql_error());
		$arr = array();
		while($obj = mysql_fetch_assoc($Recordset)) {
			$arr[] = $obj;
		}
		$first_json_str = json_encode($arr);
		$last_json_str = utf8_JSON_russian_cyr($first_json_str);
		echo $last_json_str;
	}
	if ($parameter == 'update') {
		$prpt_agent_array = (array) json_decode(stripslashes($_REQUEST['json_obj']));
		/*$prpt_agent_array['name'] = $_GET['subleaderferstname']." ". $_GET['subleadersecondname']." ". $_GET['subleaderlastname'] ;
		$prpt_agent_array['role'] = "3";
		$prpt_agent_array['login'] = $_GET['subleaderlogin'];
		$prpt_agent_array['password'] = md5($_GET['subleaderconfpass']);
		$prpt_agent_array['type_group'] = "12";
		$prpt_agent_array['parent_group'] = $tmp_s_array[1];
		$prpt_agent_array['moderated'] = "N";*/
		$tmp_agent_array = createParticipants();
		$cr_prpt_query = createParticipant($prpt_agent_array, $tmp_agent_array);
		echo $cr_prpt_query;
		//$result = mysql_query( $cr_prpt_query ) or die("Couldn t execute query.".mysql_error());
	}
	if ($parameter == 'prepare_delete') {
		$r_uuid= mysql_query("SELECT vw.UUID as UUID  FROM vw_participants vw WHERE vw.participants_id = $id", $realtorplus) or die(mysql_error());
		$UUID = mysql_result($r_uuid,0);
		$r_flats_count = mysql_query("SELECT COUNT( * ) AS count FROM tbl_flats WHERE agent_cod = '{$UUID}' GROUP BY agent_cod", $realtorplus) or die(mysql_error());
		$row_flats = mysql_fetch_array($r_flats_count,MYSQL_ASSOC);
		$flats_count =  $row_flats['count'];
		$r_exchange_count = mysql_query("SELECT COUNT( * ) AS count FROM tbl_exchange WHERE agent_cod = '{$UUID}' GROUP BY agent_cod", $realtorplus) or die(mysql_error());
		$row_exchange = mysql_fetch_array($r_exchange_count,MYSQL_ASSOC);
		$exchange_count = $row_exchange['count'];
		$rows = array();
		if($flats_count>0)
			$responce->rows[0]['cell']= "- объектов на продажу: $flats_count \n";
		if($exchange_count>0)
			$responce->rows[1]['cell']= "- объявлений в разделе обмены: $exchange_count \n";
		if(count($responce)>0) {
			$first_json_str = json_encode($responce);
			$last_json_str = utf8_JSON_russian_cyr($first_json_str);
			echo $last_json_str;
		}
	}
	if ($parameter == 'insert') {
		$prpt_agent_array = (array) json_decode(stripslashes($_REQUEST['json_obj']));
		$tmp_agent_array = createParticipants();
		$cr_prpt_query = createParticipant($prpt_agent_array, $tmp_agent_array);
		echo $cr_prpt_query;
		$result = mysql_query( $cr_prpt_query ) or die("Couldn t execute query.".mysql_error());
	}
	if ($parameter == 'show') {
		$query_param = "SELECT vw.participants_id as Id, vw.Name as Name, vw.Role as Role, vw.Login as Login, IF (vw.Mail IS NULL, '', vw.Mail) as Mail FROM vw_participants vw WHERE vw.participants_id = $prpt AND vw.Status_Group in (11,12)
		UNION SELECT fvw.participants_id, fvw.Name, fvw.Role, fvw.Login as Login, IF (fvw.Mail IS NULL, '', fvw.Mail) as Mail FROM vw_participants vw 
		INNER JOIN vw_participants fvw on fvw.parents_id = vw.participants_id  WHERE fvw.parents_id = $prpt AND fvw.Status_Group in (11,12)
		UNION SELECT lvw.participants_id, lvw.Name, lvw.Role as Role, lvw.Login as Login, IF (lvw.Mail IS NULL, '', lvw.Mail) as Mail FROM (SELECT fvw.participants_id FROM vw_participants vw 
		INNER JOIN vw_participants fvw on fvw.parents_id = vw.participants_id  WHERE fvw.parents_id = $prpt ) AS gvw 
		INNER JOIN vw_participants lvw on lvw.parents_id = gvw.participants_id AND lvw.Status_Group in (11,12)";
		$Recordset = mysql_query($query_param, $realtorplus) or die(mysql_error());
		$arr = array();
		while($obj = mysql_fetch_assoc($Recordset)) {
			$arr[] = $obj;
		}
		$first_json_str = json_encode($arr);
		$last_json_str = utf8_JSON_russian_cyr($first_json_str);
		echo $last_json_str;
	} 
?>