<?php
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
	header('Cache-Control: no-store, no-cache, must-revalidate'); 
	header('Cache-Control: post-check=0, pre-check=0', FALSE); 
	header('Pragma: no-cache');
	require_once('_scriptsphp/r_conn.php');
	include('_scriptsphp/rdate/rdate.php');
	include('_scriptsphp/services.php');
	require_once('_scriptsphp/session.inc');
	session_start();
?>
<?php
	$query_detail = "SELECT f.flats_cod, f.UUID, DATE_FORMAT(f.flats_date, '%a %b %d %Y %H:%i:%s') as flats_date, f.So, f.Sz, f.Sk,
	f.flats_price, f.kind_calc, f.foto, f.flats_tel, f.flats_floor, f.flats_floorest, f.flats_comments, pr.project_name, t.type_s,
	r.room_cod, l.sale_name, c.cond_name, i.side_name, ci.city_name, a.region_name, s.street_name, w.wc_name, b.balcon_name, m.material_name,
	p.plan_name, f.Contact, f.Source, f.Treated, f.hot_affair_type, n.Name_Node as agent_name, na.Name_Node as agency_name, tp.phon, IF (na.Mail IS NULL, '', na.Mail) as agency_mail  FROM tbl_flats f
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
	$Recordset1 = mysql_query($query_detail, $realtorplus) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
	if (isset($_GET['totalRows_Recordset1'])) {
		$totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
	} else {
		$all_Recordset1 = mysql_query($query_detail);
		$totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Владивостокский Информационный Риэлторский Портал: Горячие предложения</title>
		<script type='text/javascript' src="/min/?g=jsframe"></script>
		<link href="/min/?g=cssframe" rel="stylesheet" type="text/css"/>
	</head>
	<body>
		<div id="card" style="display:none;padding:10px;"></div>
		<div id="objects">
		<ul style="list-style: none;margin:0 0 0 5px;padding:0;text-align: center;font-size: 0.8em;">
			<?php
				if($totalRows_Recordset1>0) {
					do { ?>
					<li style="display: inline; float: left; cursor: pointer;">
						<div onclick="showPopup(<?php echo $row_Recordset1['flats_cod']; ?>)" class="lucky-hot">
							<?php $o_head = objectHead($row_Recordset1['type_s'], $row_Recordset1['room_cod'], $row_Recordset1['city_name'], $row_Recordset1['region_name'], $row_Recordset1['street_name']);
								$tapeView="";
								$tapeView .= '<div class="hot_list"><span id="fc_'. $row_Recordset1['flats_cod'].'" style="display:none"></span><div style="color:#000066;">' . $o_head .'</div>' ;
								$tapeView .= (( $row_Recordset1['foto'] != 0) ? '<div style="margin-top:3px;"><img src="base5.php?id_image='. $row_Recordset1['flats_cod'] .'&amp;category=0&amp;image=0&amp;min=1&amp;percent=0.25" alt="" /></div>':'');
								$tapeView .= '<span class="comments" style="display:block; margin-top: 3px; text-align: left;">' . $row_Recordset1["flats_comments"] . '</span>';
								$tapeView .= '<span class="lentprice" style="display:block; color:#5D2E35;font-size: 1em; margin-top: 3px;">' . number_format($row_Recordset1['flats_price'], 0, '.', ' ') . ' руб.</span></div>';
								switch($row_Recordset1["hot_affair_type"]){
									case '1': $hot_type_image = '<img class="hot_type" src="_images/i_hot_affair/hot_type_price.png" alt="" />';
									break;
									case '2': $hot_type_image = '<img class="hot_type" src="_images/i_hot_affair/hot_type_sale.png" alt="" />';
									break;
									case '3': $hot_type_image = '<img class="hot_type" src="_images/i_hot_affair/hot_type_ready.png" alt="" />';
									break;
									case '4': $hot_type_image = '<img class="hot_type" src="_images/i_hot_affair/hot_type_exclusive.png" alt="" />';
									break;
									default:
									$hot_type_image='';
									break;
								}
								$tapeView .= $hot_type_image;
								echo $tapeView;
							?>
						</div>
					</li>
					<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
				<?php } else { echo "Отсутствуют объявления, удовлетворяющие условиям, Вашего запроса.";}?>
		</ul>
	</body>
</html>
<script type="text/javascript">
	var modeview = $.cookie("modeview");
	var obj_AvailableAgents="";
	$(document).ready(function(){
		if (modeview == null) {
			modeview = "review";
			$.cookie("modeview", "review");
		}
		createModeViewEx(modeview);
		$('span.comments').mTruncate({
			length: 65,
			minTrail: 5,
			ellipsisText: "..."
		});
		$("li").find(".hot_type").css({'position' : 'relative', 'left' : '-50px', 'top' : '-130px'});
		$.getJSON("../_scriptsphp/session_var.php", function(json){
			var use = json.use;
			if (use == 1) {
				if (parseInt(json.role) <= 1) {
					bind_id = json.id;
				}
				else {
					bind_id = json.group;
				}
				if($.cookie("inquery") === bind_id) {
					$('td.trs-exchanges').removeClass("hide").addClass("show");
					agent_t = $.ajax({
						url: "../_scriptsphp/get_parameters.php",
						data: "parameter=agent",
						async: false
					}).responseText;
					obj_AvailableAgents = eval("(" + agent_t + ")");
				} 
			}
		});
	});
</script>