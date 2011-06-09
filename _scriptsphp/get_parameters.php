<?php
ob_start("ob_gzhandler");
include('r_conn.php');
include('services.php');
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
	$parameter = (isset($_REQUEST['parameter']) && strval($_REQUEST['parameter'] && !empty($_REQUEST['parameter']))) ? htmlspecialchars(trim(rtrim($_REQUEST['parameter']))) : null;
$id = (isset($_REQUEST['id']) && intval($_REQUEST['id'] && !empty($_REQUEST['id']))) ? $_REQUEST['id'] : null;	
	  switch ($parameter) {
	case "city":
	  $query_param = "SELECT city_cod as Id, city_name as Name FROM tbl_city";
	  break;    
	case "street":
	 // $query_param = "SELECT street_cod as Id, street_name as Name FROM tbl_street";
	  $query_param= "SELECT street_cod as Id, street_name as Name 
FROM tbl_street WHERE city_cod = {$id} ORDER BY Name ASC";
	  break;
	  case "room":
	  $query_param = "SELECT room_cod as Id, room_short as Name FROM tbl_room";
	  break;
	case "sale":
	  $query_param = "SELECT sale_cod as Id, sale_name as Name FROM tbl_sale";
	  break;
	case "project":
	  $query_param = "SELECT project_cod as Id, project_name as Name FROM tbl_project";
	  break;
	case "type":
	  $query_param = "SELECT type_cod as Id, type_s as Name FROM tbl_type";
	  break;
 case "material":
	  $query_param = "SELECT material_cod as Id, material_name as Name FROM tbl_material";
	  break;  
	case "plan":
	  $query_param = "SELECT plan_cod as Id, plan_name as Name FROM tbl_plan";
	  break; 
	case "balcon":
	  $query_param = "SELECT balcon_cod as Id, balcon_name as Name FROM tbl_balcon";
	  break; 
	case "side":
	  $query_param = "SELECT side_cod as Id, side_name as Name FROM tbl_side";
	  break;
	case "cond":
	  $query_param = "SELECT cond_cod as Id, cond_name as Name FROM tbl_cond";
	  break;
	case "agent":
	$prpt_id =  $_COOKIE["inquery"];
	if(isset($prpt_id) && !empty($prpt_id)){
	 // $query_param = "SELECT UUID as Id, Name_Node as Name FROM node WHERE Status_Group = 11";
	 $query_param = "SELECT n.UUID as Id, n.Name_Node as Name FROM node n WHERE n.participants_id = $prpt_id AND n.Status_Group in (11,12)
UNION SELECT fn.UUID, fn.Name_Node FROM node n 
INNER JOIN node fn on fn.parents_id = n.participants_id  WHERE fn.parents_id = $prpt_id AND fn.Status_Group in (11,12)
UNION SELECT ln.UUID, ln.Name_Node FROM (SELECT fn.participants_id, fn.Name_Node FROM node n 
INNER JOIN node fn on fn.parents_id = n.participants_id  WHERE fn.parents_id = $prpt_id ) AS g 
INNER JOIN node ln on ln.parents_id = g.participants_id AND ln.Status_Group in (11,12)";
	}
	  break;
  }
if(isset($query_param) && !empty($query_param)){
$Recordset = mysql_query($query_param, $realtorplus) or die(mysql_error());
$arr = array();
while($obj = mysql_fetch_assoc($Recordset)){
$arr[] = $obj;
}
$first_json_str = json_encode($arr);
$last_json_str = utf8_JSON_russian_cyr($first_json_str);
echo $last_json_str;
}
}
?>
<?php
ob_end_flush();
?> 