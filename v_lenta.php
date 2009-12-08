<?php
	ob_start("ob_gzhandler");
	/*header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
	header('Cache-Control: no-store, no-cache, must-revalidate'); 
	header('Cache-Control: post-check=0, pre-check=0', FALSE); 
	header('Pragma: no-cache');*/
	//include('base2.php');
	//include('_scriptsphp/rdate/rdate.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Представление в виде ленты</title>
		<script type='text/javascript' src="/min/?g=jsframe"></script>
		<link href="/min/?g=cssframe" rel="stylesheet" type="text/css"/>
	</head>
	<body>
		<div id="objects">
			
		</div>
		<div id="card" style="display:none;padding:10px;">
		</div>
		<script type='text/javascript' src="/min/?g=jstape"></script>
	</body>
</html>
<?php
	ob_end_flush();
?>
