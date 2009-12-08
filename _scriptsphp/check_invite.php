<?php
include('r_conn.php');
$invite = (isset($_REQUEST['invite']) && strval($_REQUEST['invite'] && !empty($_REQUEST['invite']))) ? htmlspecialchars(trim(rtrim($_REQUEST['invite']))) : null;
if (!empty($invite)) {
    $query = "SELECT Participants_id FROM tbl_participants_catalog WHERE Participants_property_id = 17 AND value_property = '{$invite}'";
    $recordset = mysql_query($query) or die ("Запрос не выполнен.".mysql_error());
    if (mysql_num_rows($recordset) > 0) {
        echo 'true';
    } else {
        echo 'false';
    }
} else {
    echo 'false';
}
unset($invite);
?>
