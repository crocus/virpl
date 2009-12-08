<?php
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
header('Cache-Control: no-store, no-cache, must-revalidate'); 
header('Cache-Control: post-check=0, pre-check=0', FALSE); 
header('Pragma: no-cache');
/****************************************************************/
// RUSDate version 5.1/Beta/Professional			//
// Модифицированная версия скрипта для вывода даты		//
// и времени название месяца и недели на русском языке		//
// ------------------------------------------------------------ //
// Copyright (C) 2003-2004 Bier Artur aka IZ@TOP		//
// EMail: izatop@mail.ru //// Http: ultra.dax.ru		//
/****************************************************************/ 


error_reporting(0); // Отключает сообщения об ошибках, если Вы отлаживаете скрипт, поставьте параметром
// данной функции константу E_ALL (error_reporting(E_ALL);).

function rdate($exp, $current_date) {
// Входные аргементы:
// Param $exp - обязательный параметр, передает шаблон для отображения даты и времени 
// (синтаксис подобен функции в PHP - date(); подробнее тут - http://ru.php.net/manual/ru/function.date.php),
// За исключением некоторых особенностей, например можно встаить посторонний текст - "Сегодня w, d m Y года H:i минут."
// Где 'w' выведет название недели, 'm' месяц, 'd' число, 'Y' год (полный - 2004, возможен не полный формат 'y' 04), 'H' час и 'i' минуты.

//здесь создается массив с названиями дней недели и месяцев на Русском языке

	$r_w = array(
		'0'=>"воскресенье",
		'1'=>"понедельник",
		'2'=>"вторник",
		'3'=>"среда",
		'4'=>"четверг",
		'5'=>"пятница",
		'6'=>"суббота"
	);

	$r_w_s = array(
		'0'=>"вс",
		'1'=>"пн",
		'2'=>"вт",
		'3'=>"ср",
		'4'=>"чт",
		'5'=>"пт",
		'6'=>"сб"
	);

	$r_m = array(
		'01'=>"января",
		'02'=>"февраля",
		'03'=>"марта",
		'04'=>"апреля",
		'05'=>"мая",
		'06'=>"июня",
		'07'=>"июля",
		'08'=>"августа",
		'09'=>"сентября",
		'10'=>"октября",
		'11'=>"ноября",
		'12'=>"декабря"
	);

	$r_m_s = array(
		'01'=>"янв",
		'02'=>"фев",
		'03'=>"марта",
		'04'=>"апр",
		'05'=>"мая",
		'06'=>"июня",
		'07'=>"июля",
		'08'=>"авг",
		'09'=>"сент",
		'10'=>"окт",
		'11'=>"нояб",
		'12'=>"дек"
	);

	//далее создаем константы текущей даты при помощи функции date()

	define('N_MONTH', date("m", $current_date));		// Номер месяца
	define('N_WEEK', date("w",$current_date));		// Номер недели

	$out_dates = array(
		$r_w[N_WEEK],			// Назване недели на русском языке
		$r_m[N_MONTH],			// Название месяца на русском языке
		date("H", $current_date),			// Час (формат 1 - H)
		date("i", $current_date),			// Минуты (формат 1 - i)
		date("Y", $current_date),			// Год - полный формат
		date("y", $current_date),			// Год - короткий формат
		date("d", $current_date),			// Число
		date("j", $current_date),			// День месяца без ведущих нулей
		$r_w_s[N_WEEK],			// Сокращенное обозначение дня недели
		$r_m_s[N_MONTH],		// Сокращенное обозначение месяцаб
		date("s", $current_date)			// секунды
	);
	$in_dates = array(
		"[w]",
		"[m]",
		"[H]",
		"[i]",
		"[Y]",
		"[y]",
		"[d]",
		"[j]",
		"[D]",
		"[M]",
		"[s]"
	);

	$exp_assembly = preg_replace("%(\W)([a-zA-Z])(?=[\W])%is","\\1[\\2]\\3",$exp); // Сборка входных аргументов даты в коды для перезаписи их в шаблоне.
	$result = str_replace($in_dates, $out_dates, $exp_assembly);
	return $result;
}
function nicetime($input, $time = false) {
	$search = array('January','February','March','April','May','June','July','August','September','October','November','December');
	$replace = array('января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
	$seconds = strtotime($input);
	if ($time == true)
		$data = date("H:i j F", $seconds);
	else
		$data = date("j F Y", $seconds);
	$data = str_replace($search, $replace, $data);
	return $data;
} 
function timeLeft($last_update) {
	$sec = 1209600 - (time() - $last_update);
	return cron_time2string($sec);
}
function timeLeftOnFact($last_update) {
	$sec = (time() - $last_update);
	return cron_time2stringonfact($sec);
}
// cron_time2string($time) 
define('_AM_CRON_DAY1', 'день'); 
define('_AM_CRON_DAY2', 'дня'); 
define('_AM_CRON_DAY3', 'дней'); 
define('_AM_CRON_HOUR1', 'час'); 
define('_AM_CRON_HOUR2', 'часа'); 
define('_AM_CRON_HOUR3', 'часов'); 
define('_AM_CRON_MIN1', 'минута'); 
define('_AM_CRON_MIN2', 'минуты'); 
define('_AM_CRON_MIN3', 'минут'); 
define('_AM_CRON_SEC1', 'секунда'); 
define('_AM_CRON_SEC2', 'секунды'); 
define('_AM_CRON_SEC3', 'секунд');

function cron_wordCase($number, $w1, $w2, $w5) {
	if ( floor(($number%100)/10) == 1)
		return $w5;
	if ($number%10 >= 2 and $number%10 <= 4)
		return $w2;
	if ($number%10 == 1)
		return $w1;
	return $w5;
} 

function cron_formatNumWord($number, $w1, $w2, $w5) {
	return $number > 0?($number . ' ' . cron_wordCase($number, $w1, $w2, $w5) . ' '):'';
} 

function cron_time2string($time) {
	$s = $time % 60;
	$m = floor($time / 60) % 60;
	$h = floor($time / (60 * 60)) %24;
	$d = floor($time / (60 * 60 * 24));
	if($d >= 0){
	return
	'еще ' . cron_formatNumWord($d, _AM_CRON_DAY1, _AM_CRON_DAY2, _AM_CRON_DAY3) .
		cron_formatNumWord($h, _AM_CRON_HOUR1, _AM_CRON_HOUR2, _AM_CRON_HOUR3);
	} else {
		return
		'устарело';
	}
}
function cron_time2stringonfact($time) {
	$s = $time % 60;
	$m = floor($time / 60) % 60;
	$h = floor($time / (60 * 60)) %24;
	$d = floor($time / (60 * 60 * 24));
	if($m <= 0 && $h <= 0 && $d <= 0){
	return cron_formatNumWord($s, _AM_CRON_SEC1, _AM_CRON_SEC2, _AM_CRON_SEC3);
	} else {
		return cron_formatNumWord($d, _AM_CRON_DAY1, _AM_CRON_DAY2, _AM_CRON_DAY3) .
		cron_formatNumWord($h, _AM_CRON_HOUR1, _AM_CRON_HOUR2, _AM_CRON_HOUR3) .
		cron_formatNumWord($m, _AM_CRON_MIN1, _AM_CRON_MIN2, _AM_CRON_MIN3) ;
	}
//cron_formatNumWord($m, _AM_CRON_MIN1, _AM_CRON_MIN2, _AM_CRON_MIN3) . 
//cron_formatNumWord($s, _AM_CRON_SEC1, _AM_CRON_SEC2, _AM_CRON_SEC3); 
}
?>