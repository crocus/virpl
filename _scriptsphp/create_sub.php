<?php
include('r_conn.php');
include('services.php');
$prpt_sub_array = array();
$prpt_sub_array['name'] = $_GET['subdname'];
$prpt_sub_array['email'] = $_GET['subemail'];
$prpt_sub_array['type_group'] = "8";
if (isset( $_GET['h_companyname']) && !empty($_GET['h_companyname'])) {
    $prpt_sub_array['parent_group'] = getParentGroup($_GET['h_companyname']);// getit
} else if (isset( $_GET['companyname']) && !empty($_GET['companyname'])) {
        $prpt_sub_array['parent_group'] = $_GET['companyname'];
    }
//$prpt_sub_array['parent_group'] = getParentGroup($parent_name);// getit
$prpt_sub_array['moderated'] = "N";
$tmp_s_array = createParticipants();
$cr_prpt_query = createParticipant($prpt_sub_array, $tmp_s_array);
if(mysql_query( $cr_prpt_query )) {
    $prpt_phons = parsePhon($_GET['subdphon']);
    print_r ($prpt_phons);
    $prpt_name = $prpt_sub_array['name'];
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

$prpt_sublider_array = array();
$prpt_sublider_array['name'] = $_GET['subleaderlastname'] ." ". $_GET['subleaderferstname'] ." ".$_GET['subleadersecondname'];
$prpt_sublider_array['role'] = "3";
$prpt_sublider_array['login'] = $_GET['subleaderlogin'];
$prpt_sublider_array['password'] = md5($_GET['subleaderconfpass']);
$prpt_sublider_array['type_group'] = "12";
$prpt_sublider_array['parent_group'] = $tmp_s_array[1];
$prpt_sublider_array['moderated'] = "N";
$tmp_sl_array = createParticipants();
$cr_prpt_query = createParticipant($prpt_sublider_array, $tmp_sl_array);
$result = mysql_query( $cr_prpt_query ) or die("Couldn t execute query.".mysql_error());
$prpt_sm_array = array();
$prpt_sm_array['name'] = $_GET['submenlastname'] ." ". $_GET['submenferstname']." ". $_GET['submensecondname'];
$prpt_sm_array['role'] = "2";
$prpt_sm_array['login'] = $_GET['submenlogin'];
$prpt_sm_array['password'] = md5($_GET['submenconfpass']);
$prpt_sm_array['type_group'] = "12";
$prpt_sm_array['parent_group'] = $tmp_s_array[1];
$prpt_sm_array['moderated'] = "N";
$tmp_sm_array = createParticipants();
$cr_prpt_query = createParticipant($prpt_sm_array, $tmp_sm_array);
$result = mysql_query( $cr_prpt_query ) or die("Could not execute query.".mysql_error());
unset($tmp_s_array);
unset($tmp_sl_array); 
unset($tmp_sm_array); 
unset($prpt_sub_array); 
unset($prpt_sublider_array);
unset($prpt_sm_array);      
?>