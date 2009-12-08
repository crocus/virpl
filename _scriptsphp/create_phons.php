<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Документ без названия</title>
</head>

<body>
</body>
</html>
<?php
$phons = "1253,. sdgh4565,hjf%^%^ 3456.., +7 (4232)444450";
$pattern = '/([^\d,])/';
$replacement = "";
$phons = preg_replace($pattern, $replacement, $phons);
$pieces_array = explode(",", $phons);
$i=0;
foreach ($pieces_array as $phon) {
    if(strlen($phon)===11){
        $pieces_array[$i] = str_replace($phon, substr_replace($phon,'', 0, 1),$phon);
    }
 $i++;
}
 print_r ($pieces_array);
?>