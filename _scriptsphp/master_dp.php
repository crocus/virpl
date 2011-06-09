<?php
	header ('Content-type: text/html; charset=utf-8');
?>
<script type='text/javascript' src="/min/?g=js"></script>

<?php
	/*ini_set ( 'max_execution_time', 5000);
	header ('Content-type: text/html; charset=utf-8');*/
	// Include the class definition file. 
	//require_once('class.html2text.inc');
	/*$rqqq='';
	for($i=1; $i <=25; $i++){
	//$rows = file('http://gazeta.dalpress.ru/category/view/id/214/page/'.$i);
	//$rqqq .= implode(",",$rows);
	$fp = fopen('http://gazeta.dalpress.ru/category/view/id/214/page/'.$i,"r"); 
	while (!feof($fp)) {
	$line = fgets($fp);
	$rqqq .= $line;
	}
	fclose($fp);
	}
	print_r ($rqqq);*/
	$count=$_GET['c'];
	$category='';
	switch ( $count ) {
		case 0:
			$category = 213;
			break;
		case 1:
			$category = 214;
			break;
		case 2:
			$category = 215;
			break;
		case 3:
			$category = 216;
			break;
		case 4:
			$category = 217;
			break;
		default :
			$category = 213;
			break;
	}
	$rqqq='';
	/*for($i=1; $i <=5; $i++){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, 'http://gazeta.dalpress.ru/category/view/id/214/page/'.$i);
	$html = curl_exec($ch);
	curl_close($ch);
	if($html !== false && preg_match('/<table class="other_adverts">(.+?)<\/table>/is', $html, $matches)){
	$div_content = $matches[1];
	$rqqq .=  $div_content;
	}
	}
	$pattern = '/<span class="date">(.+?)<\/span>/is';
	$rqqq=preg_replace($pattern, "", $rqqq);*/


	//$html = file_get_contents('http://gazeta.dalpress.ru/pages/arc?cid=391102&mr=%25&uact=1&srch=&no=5&cnt=1500');

	/*$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, 'http://gazeta.dalpress.ru/pages/arc?cid=391102&mr=%25&uact=1&srch=&no=5&cnt=400');
	$html = curl_exec($ch);
	curl_close($ch);
	if($html !== false && preg_match('/<table width="700" border="0">(.+?)<\/table>/', $html, $matches)){
	$div_content = $matches[1];
	$rqqq .=  $div_content;
	} else {echo "fail";}*/

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, 'http://www.dalpress.ru/gazeta/temp/print/print_all.php?url=http://gazeta.dalpress.ru/category/view/id/'.$category);
	$html = curl_exec($ch);
	curl_close($ch);
	$html = strip_attributes($html,"body","onload");
	echo ($html);
	/*	// The "source" HTML you want to convert. 
	$html = 'Sample string with HTML code in it'; 


	$h2t = new html2text($rqqq); 

	// Simply call the get_text() method for the class to convert 
	// the HTML to the plain text. Store it into the variable. 
	$text = $h2t->get_text(); 

	// Or, alternatively, you can print it out directly: 
	$h2t->print_text(); */

	function strip_attributes($msg, $tag, $attr, $suffix = "")
{
	 $lengthfirst = 0;
	 while (strstr(substr($msg, $lengthfirst), "<$tag ") != "") {
		  $tag_start = $lengthfirst + strpos(substr($msg, $lengthfirst), "<$tag ");

		  $partafterwith = substr($msg, $tag_start);

		  $img = substr($partafterwith, 0, strpos($partafterwith, ">") + 1);
		  $img = str_replace(" =", "=", $img);

		  $out = "<$tag";
		  for($i = 0; $i < count($attr); $i++) {
			   if (empty($attr[$i])) {
					continue;
			   }
			   $long_val =
			   (strpos($img, " ", strpos($img, $attr[$i] . "=")) === false) ?
			   strpos($img, ">", strpos($img, $attr[$i] . "=")) - (strpos($img, $attr[$i] . "=") + strlen($attr[$i]) + 1) :
			   strpos($img, " ", strpos($img, $attr[$i] . "=")) - (strpos($img, $attr[$i] . "=") + strlen($attr[$i]) + 1);
			   $val = substr($img, strpos($img, $attr[$i] . "=") + strlen($attr[$i]) + 1, $long_val);
			   if (!empty($val)) {
					$out .= " " . $attr[$i] . "=" . $val;
			   }
		  }
		  if (!empty($suffix)) {
			   $out .= " " . $suffix;
		  }

		  $out .= ">";
		  $partafter = substr($partafterwith, strpos($partafterwith, ">") + 1);
		  $msg = substr($msg, 0, $tag_start) . $out . $partafter;
		  $lengthfirst = $tag_start + 3;
	 }
	 return $msg;
}

?>

<script type="text/javascript">
	$(document).ready(function(){
		$('body').removeAttr("onclose").removeAttr("onload").find("td").each(function(){
			$(this).find("hr").remove();
			$(this).find("center").remove();
		});
	});
	</script>