<?php
include('r_conn.php');
include('services.php');
$prpt_agency_array = array();
$prpt_agency_array['name'] = $_GET['agencyname'];
/*$prpt_agency_array['inn'] = $_GET['inn'];*/
$prpt_agency_array['email'] = $_GET['agencymail'];
$prpt_agency_array['type_group'] = "8";
$prpt_agency_array['parent_group'] = "0";
$prpt_agency_array['moderated'] = "N";
$tmp_s_array = createParticipants();
$cr_prpt_query = createParticipant($prpt_agency_array, $tmp_s_array);
if(mysql_query( $cr_prpt_query )) {
	$prpt_phons = parsePhon($_GET['agencyphon']);
	print_r ($prpt_phons);
	$prpt_name = $prpt_agency_array['name'];
	foreach ($prpt_phons as $key => $phon) {
		$result = mysql_query("SELECT num_tel FROM tbl_telag WHERE num_tel = $phon" ) or die("Couldn t execute select query.".mysql_error());
		if (mysql_num_rows($result) > 0 ) {
			mysql_query("DELETE FROM tbl_telag WHERE num_tel = $phon" ) or die("Couldn t execute delete query.".mysql_error());
		}
		mysql_query("INSERT INTO tbl_telag (num_tel, agency_name ) VALUES ($phon, '$prpt_name')" ) or die("Couldn t execute insert query.".mysql_error());
	}
} else {
	die("Couldn t execute query.".mysql_error());
}

$prpt_al_array = array();
$prpt_al_array['name'] = $_GET['agencyleaderlastname'] ." ". $_GET['agencyleaderferstname'] ." ".$_GET['agencyleadersecondname'];
$prpt_al_array['role'] = "3";
$prpt_al_array['login'] = $_GET['agencyleaderlogin'];
$prpt_al_array['password'] = md5($_GET['agencyleaderconfpass']);
$prpt_al_array['type_group'] = "12";
$prpt_al_array['parent_group'] = $tmp_s_array[1];
$prpt_al_array['moderated'] = "N";
$tmp_al_array = createParticipants();
$cr_prpt_query = createParticipant($prpt_al_array, $tmp_al_array);
$result = mysql_query( $cr_prpt_query ) or die("Couldn t execute query.".mysql_error());
$prpt_am_array = array();
$prpt_am_array['name'] = $_GET['agencymenlastname'] ." ". $_GET['agencymenferstname']." ". $_GET['agencymensecondname'];
$prpt_am_array['role'] = "2";
$prpt_am_array['login'] = $_GET['agencymenlogin'];
$prpt_am_array['password'] = md5($_GET['agencymenconfpass']);
$prpt_am_array['type_group'] = "12";
$prpt_am_array['parent_group'] = $tmp_s_array[1];
$prpt_am_array['moderated'] = "N";
$tmp_am_array = createParticipants();
$cr_prpt_query = createParticipant($prpt_am_array, $tmp_am_array);
$result = mysql_query( $cr_prpt_query ) or die("Could not execute query.".mysql_error());
unset($tmp_s_array);
unset($tmp_al_array); 
unset($tmp_am_array); 
unset($prpt_agency_array); 
unset($prpt_am_array);
unset($prpt_al_array);      
?>