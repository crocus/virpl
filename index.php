<?php
	ob_start("ob_gzhandler"); 
	include('_scriptsphp/getCurrency.php');
	include("_scriptsphp/main.inc");
	$titlepage = "MainVIRPL";
	require_once("powercounter/count.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="pragma" content="no-cache" />
		<meta name="verify-reformal" content="3a386d143fa2c3953814ac3c" />
		<title>Владивостокский Информационный Риэлторский Портал</title>
		<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/jquery-ui.min.js"></script>-->
		<script type='text/javascript' src="/min/?g=js"></script>
		<!--[if IE 6]>
		<style type="text/css">
		body { width: expression((document.documentElement.clientWidth < 1010) ? '1000px' : '100%'); }
		*html > body {
		height: 100%;
		}
		.d_table tbody td{
		font-size: small;
		}
		#content {width: 63.8%;}
		.big_content {
		width: 94%;
		height: 500px;
		overflow: auto;
		}
		</style>
		<![endif]-->
		<link href="/min/?g=css" rel="stylesheet" type="text/css" />
		<link rel="icon" href="/favicon.ico" type="image/x-icon"/>
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
	</head>
	<body>
		<noscript>В Вашем браузере выключена поддержка JavaScript, пожалуйста включите для корректной работы сайта.</noscript>
		<script type="text/javascript" src="../_js/script/preloader.js"></script>

		<div id="header">
			<div id="logoslide" style="vertical-align:middle">
				<div> <a href="http://www.foliant.net.ru"> <img src="_images/logo_fol_m.jpg" alt="" /></a></div>
				<div><img src="_images/aliance_logo.jpeg" alt="" /> </div>
				<div><a href="http://www.avega.vl.ru"><img src="_images/avega_logo.gif" alt="" /></a></div>
				<div><a href="http://www.omegatd.ru"><img src="_images/omega_logo.jpg" alt="" /></a></div>
			</div>
			<div id="site_name">Владивостокский<br />
				Информационный<br />
				Риэлторский<br />
				ПортаЛ
			<span style="white-space:nowrap"></span> </div>
			<div id="accsess">
				<div style="text-align: right;"><a href="#" id="enter_priv" style="white-space:nowrap;"> <span style="font-size:1.3em">Вход в личный кабинет</span></a></div>
				<!--<a href="#" id="registr">Регистрация</a><a href="#" id="remember" style="padding-left: 45px; white-space:nowrap;">Забыли пароль?</a>-->
				<div id="header-announcement">
					<b>Сегодня на сайте</b>
					<br/>
					Объявлений о продаже - <span id="anonce_total"></span>
					<br/>
					Минимальная стоимость - <span id="anonce_min"></span>&nbsp;руб.
					<br/>
					Максимальная стоимость - <span id="anonce_max"></span>&nbsp;руб.
					<br/>
					Информация обновлена <span id="anonce_tleft"></span>&nbsp;назад
				</div>
				<div id="autorization-dialog" title="Авторизация">
					<form id="login" method="post" action="">
						<label for="name" class="label">Логин:</label>
						<input type="text" name="user_name" id="name" class="input_a_form"/>
						<br/>
						<label for="password" class="label">Пароль:</label>
						<input type="password" name="user_pass" id="password" class="input_a_form" value=""/>
					</form>
				</div>
			</div>
			<div id="myslidemenu" class="jqueryslidemenu">
				<ul>
					<!--<li><a href="#" id="add_vacancy">Вакансии</a></li>-->
					<li><a href="#for-private" rel="history" >Частным лицам</a>
						<ul>
							<li><a href="#proposal-buy" id="proposal-buy" rel="history">Оставить заявку на покупку</a></li>
						</ul>
					</li>
					<li><a href="#"><span style=" font-size:medium">Добавить объявление</span></a>
						<ul>
							<li><a href="#add_advert" id="add_advert" rel="history">Продажа</a></li>
							<li><a href="#add_exchange" id="add_exchange" rel="history">Обмен</a></li>
						</ul>
					</li>
					<li><a href="#" class="tolawyer">Вопросы к юристу</a></li>
					<!--<li><a href="#">Вопросы и ответы</a></li>-->
				</ul>
				<br style="clear:left;" />
			</div>
			<!---->
		</div>
		<div id="container">
		<div id="left">
			<div id="leftmenu">
				<h2><a href="#" id="inhabitad"><span style=" font-size:1.1em">Жилая недвижимость</span></a></h2>
				<div style="margin:0; padding:10px;">
					<ul>
						<!--<ul class="h_menu">-->
						<li><a href="#fl" id="fl" class="mlink" rel="history">Все квартиры</a><span id="count_all_fl" class="count"></span></li>
						<li><a href="#pods" id="pods" class="mlink" rel="history">Подселения</a><span id="count_pods" class="count"></span></li>
						<li><a href="#0_fl" id="0_fl" class="mlink" rel="history">Гостинки</a><span id="count_0" class="count"></span></li>
						<li><a href="#1_fl" id="1_fl" class="mlink" rel="history">1-комнатные</a><span id="count_1" class="count"></span></li>
						<li><a href="#2_fl" id="2_fl" class="mlink" rel="history">2-комнатные</a><span id="count_2" class="count"></span></li>
						<li><a href="#3_fl" id="3_fl" class="mlink" rel="history">3-комнатные</a><span id="count_3" class="count"></span></li>
						<li><a href="#4_fl" id="4_fl" class="mlink" rel="history">4-комнатные</a><span id="count_4" class="count"></span></li>
					</ul>
				</div>
				<h2><a href="#">Коммерческая недвижимость</a></h2>
				<div style="margin:0; padding:10px;">
					<ul>
						<li><a href="#" id="office" class="mlink">Офисы</a><span id="count_office" class="count"></span></li>
						<li><a href="#" id="stroyeniya" class="mlink">Отдельностоящие строения</a><span id="count_str" class="count"></span></li>
						<li><a href="#" id="proizvod" class="mlink">Производственно-складские помещения</a><span id="count_pr" class="count"></span></li>
						<li><a href="#" id="torgovlya" class="mlink">Торговые помещения</a><span id="count_torg" class="count"></span></li>
					</ul>
				</div>
				<h2><a href="#">Дома, участки и дачи</a></h2>
				<div style="margin:0; padding:10px;">
					<ul>
						<li><a href="#" id="dom" class="mlink">Дома</a><span id="count_dom" class="count"></span></li>
						<li><a href="#" id="kottedg" class="mlink">Коттеджи</a><span id="count_kot" class="count"></span></li>
						<li><a href="#" id="grounds" class="mlink">Земельные участки</a><span id="count_gr" class="count"></span></li>
						<li><a href="#" id="dachi" class="mlink">Дачи</a><span id="count_dach" class="count"></span></li>
					</ul>
				</div>
				<h2><a href="#" id="s_exchanges">Обмены</a></h2>
				<div></div>
				<h2><a href="#" id="link_ext_seach">Расширенный поиск</a></h2>
				<div></div>
			</div>
		</div>
		<div id="right">
			<div id="accordion">
				<h2>Вопросы юристам</h2>
				<div class="pane">
					<ul id="advice"></ul>
					<p style="margin: 0 5px 5px 5px; font-size:0.8em;"><a href="#" class="tolawyer">читать >></a></p>		
				</div>
				<h2>Новости</h2>
				<div class="pane"><ul>
						<li>22 августа 2009<br />
							Большому кораблю - большое плавание.
						</li>
					</ul><p></p></div>
			</div>
		</div>
		<div id="content">
			<div id="tabs">
				<ul>
					<li><a href="#objects">Продажа</a></li>
				</ul>
				<div id="objects"> <div style="padding:5px 0 10px 10px;">В виде:<a href="#" id="view_switch" title="Представление" style =" padding-left: 10px;">Таблицы/Ленты</a></div>
					<div id="lenta" class="hide">
						<iframe id="v_lenta" src="v_lenta.php" marginwidth="0" marginheight="0" style="width:100%;height:850px;overflow:hidden; border:0;" frameborder="0" scrolling="no"> </iframe>
					</div>
					<div id="table" class="show">
						<iframe id="v_table" src="v_table.php" style="width:100%;height:800px;overflow:hidden; border:0;" frameborder="0" scrolling="no"> </iframe>
					</div>
				</div>
			</div>
		</div>
		<div id="footer">
			<p><div class="first" style="float: left; padding-left: 12px; font-size: .8em; text-transform: uppercase;"><span>Размещение рекламы — тел. +7 (4232) 441806 </span></div><div class="first" style="float: right; padding-right: 12px;"><span> &copy; 2009 ООО &quot;Фолиант&quot;</span><br />
					<!--LiveInternet counter-->
					<script type="text/javascript">
						document.write("<a href='http://www.liveinternet.ru/click' "+
						"target=_blank><img src='http://counter.yadro.ru/hit?t25.3;r"+
						escape(document.referrer)+((typeof(screen)=="undefined")?"":
						";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
						screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
						";"+Math.random()+"' alt='' title='LiveInternet: показано число посетителей за"+
						" сегодня' "+"border='0' width='88' height='15'><\/a>")
					</script>
					<!--/LiveInternet-->
			</div> </p>
			<!--<div>Контакты: <a href="skype:crocus13?call" onload="return skypeCheck()"><img src="http://mystatus.skype.com/smallclassic/crocus13" style="border: none;" width="114" height="20" alt="Мой статус" /></a></div>
			<br/><img src="http://web.icq.com/whitepages/online?icq=261428978&img=5" alt="Статус" />
			</div>-->
		</div>
		<div  id="loading" style="position:absolute; top: 300px; left:400px; color:red; font-size:large; display:none">Загрузка</div>
		<script type="text/javascript">
			var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
			document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
		</script>
		<script type="text/javascript">
			try {
				var pageTracker = _gat._getTracker("UA-10583093-2");
				pageTracker._trackPageview();
			} catch(err) {}
			</script>    
	</body>
</html>
<script type="text/javascript" src="../_js/script/common.js"/></script>
 <!--<script type="text/javascript" language="JavaScript" src="http://reformal.ru/tab.js?title=%C2%EB%E0%E4%E8%E2%EE%F1%F2%EE%EA%F1%EA%E8%E9+%C8%ED%F4%EE%F0%EC%E0%F6%E8%EE%ED%ED%FB%E9+%D0%E8%FD%EB%F2%EE%F0%F1%EA%E8%E9+%CF%EE%F0%F2%E0%EB&domain=virpl&color=949088&align=right&charset=utf-8&ltitle=&lfont=&lsize=&waction=0&regime=0">
 </script>-->
<!--<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>-->
<?php ob_end_flush();?> 