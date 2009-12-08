<?php
session_start ();
$_SESSION['code'] = substr(md5(uniqid(mt_rand())),0,5);
//function CreateIm(){
//$a= image;
switch ($a) {
	case "image":
		$im = @imagecreate (180, 60) or die ("Cannot initialize new GD image stream!");
		$bg = imagecolorallocate ($im, 232, 238, 247);
		$char = $_SESSION['code'];
		//$char = "23456789abcdeghkmnpqsuvxyz"; 
		//создаём шум на фоне
		for ($i=0; $i<=128; $i++) {
			$color = imagecolorallocate ($im, rand(0,255), rand(0,255), rand(0,255)); //задаём цвет
			imagesetpixel($im, rand(2,180), rand(2,60), $color); //рисуем пиксель
		}

		//выводим символы кода
		for ($k = 0; $k < strlen($char); $k++) {
			$color = imagecolorallocate ($im, rand(0,255), rand(0,128), rand(0,255)); //задаём цвет
			$x = 5 + $k * 20;
			$y = rand(1, 30);
			//$r_char = rand(1,$k);
		//	imagechar ($im, 5, $x, $y, $char[$rchar], $color);
			imagechar ($im, 5, $x, $y, $char[$k], $color);
		}

		/*/упрощённый вариант
		$color = imagecolorallocate($img, 0, 0, 0);
		imagestring($im, 3, 5, 3, $char, $color);*/

		//антикеширование
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		//создание рисунка в зависимости от доступного формата
		if (function_exists("imagepng")) {
		   header("Content-type: image/png");
		   imagepng($im);
		} elseif (function_exists("imagegif")) {
		   header("Content-type: image/gif");
		   imagegif($im);
		} elseif (function_exists("imagejpeg")) {
		   header("Content-type: image/jpeg");
		   imagejpeg($im);
		} else {
		   die("No image support in this PHP server!");
		}
		imagedestroy ($im);	
	break;
	case 'submit':
		//проверка кода
		if (empty($_GET['code']) or empty($_SESSION['code'])) {
			echo 'Вы не указали код подтверждения';
		} elseif ($_GET['code'] != $_SESSION['code']) {
			echo 'Код подтверждения не совпадает';
		} else {
			echo 'Всё Ok!';
		}
	break;
	default:
	//	$_SESSION['code'] = substr(md5(uniqid("")),0,4);
		//function CreateIm();
		print '<form action="captcha.php" method="get"/>'.
			'<input type="hidden" name="a" value="submit">'.
			'<label for="code">Код подтверждения:</label>'.
			'<br/>'.
			'<input type="text" id="code" name="code" size="4" maxlength="4">'.
			'<br/>'.
			'<img align="absmiddle" src=\'captcha.php?a=image\'>'.
			'<br/>'.
			'<input type="submit" value="Go">';
	break;
}
<?php
if (!isset($_POST['screen'])) {
?>
<form action="" method="post">
<script language="javascript">
var mnf = window.document.getElementById("mainFrame");
document.write ('<input name="screen" type="hidden" value="'+ document.body.clientWidth +'_'+document.body.clientHeight + '"></form>');
//document.write ('<input name="screen" type="hidden" value="'+ screen.width +'_'+screen.height + '"></form>');
document.forms[0].submit();
</script>
<?php
}
if (isset($_POST['screen'])) echo $_POST['screen'];
?>
?>