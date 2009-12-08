<?php
header('Content-Type: text/html; charset=utf-8');
include ('r_conn.php');
include ('services.php');
$query_0 = "SELECT n.participants_id as Id, n.Name_Node as Name FROM node n WHERE n.parents_id = 0 And n.Status_Group in (7)";
$level_0 = mysql_query($query_0) or die ("Couldn t execute query.".mysql_error());
$i = 0;
while ($object_0 = mysql_fetch_array($level_0)) {
    $query_1 = "SELECT n.participants_id as Id, n.parents_id as Parent, n.Name_Node as Name FROM node n WHERE n.parents_id = $object_0[Id] And n.Status_Group = 8";
    $level_1 = mysql_query($query_1) or die ("Couldn t execute query.".mysql_error());

    if (mysql_num_rows($level_1) > 0) {
        $k = 0;
        while ($object_1 = mysql_fetch_array($level_1)) {
            $query_2= "SELECT n.participants_id as Id, n.parents_id as Parent, n.Name_Node as Name FROM node n WHERE n.parents_id = $object_1[Id] And n.Status_Group in (11,12)";
            $level_2 = mysql_query($query_2) or die ("Couldn t execute query.".mysql_error());
            if (mysql_num_rows($level_2) > 0) {
                $j = 0;
                while ($object_2 = mysql_fetch_array($level_2)) {
                    $tmp_array_2["text"] = $object_2[Name];
                    $tmp_array_2['id']= $object_2[Id];
                    //$tmp_array_2['id']=$i.$k.$j;
                    //$tmp_array_2['class'] = "child";
                    $array_2[]=$tmp_array_2;
                    $j++;
                }
            }
            $tmp_array_1["text"] = $object_1[Name];
            //$tmp_array_1['id'] = $i.$k;
            $tmp_array_1['id'] = $object_1[Id];
            //$tmp_array_2['class'] = "parent";
            $tmp_array_1["children"] = $array_2;
            $array_1[] = $tmp_array_1;
            $k++;
            unset ($array_2);
        }
    }
    $array_0["text"] = $object_0[Name];
    $array_0['id'] = $object_0[Id];
    $array_0['expanded'] = true;
    $array_0["children"] = $array_1;
    $array_result[] = $array_0;
    $i++;
    unset ($array_1);
}
 unset ($array_0);
$first_json_str = json_encode($array_result);
$last_json_str = utf8_JSON_russian_cyr($first_json_str);
//echo "[".$last_json_str."]";
echo $last_json_str;
?>