<?php
	ob_start("ob_gzhandler"); 
	include "_scriptsphp/auth.inc";
	ini_set("session.gc_maxlifetime", "3600");
	$expireTime = 60*60;
	session_set_cookie_params($expireTime);
	session_start();
	unset($_SESSION['user_p']);
	if (!isset($_SESSION['use'])) {
		header("Location: index.php");
		exit;
	};
	echo $_SESSION['t']++;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="pragma" content="no-cache" />
		<meta id="robots" content="noindex,nofollow" />
		<title>Владивостокский Информационный Риэлторский Портал</title>
		<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/jquery-ui.min.js"></script>-->

		<script type='text/javascript' src="/min/?g=js"></script>
		<!--<script type="text/javascript" src="./_js/script/jquery-idleTimeout.js"></script>-->
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
		<!--<link href="_js/jquery/themes/smoothness/ui.all.css" rel="stylesheet" type="text/css" />-->
		<link href="/min/?g=css" rel="stylesheet" type="text/css" />
		<link rel="icon" href="/favicon.ico" type="image/x-icon"/>
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
	</head>
	<body>
		<noscript>В Вашем браузере выключена поддержка JavaScript, пожалуйста включите для корректной работы сайта.</noscript>
		<script type="text/javascript" src="../_js/script/preloader.js"></script>
		<div id="header">
			<div id="logoslide" style="vertical-align:middle">
				<div> <a href="/"> <img src="_images/logo_fol_m.jpg" alt="" /></a></div>
				<div><img src="_images/aliance_logo.jpeg" alt="" /></div>
				<div><a href="http://www.avega.vl.ru"><img src="_images/avega_logo.gif" alt="" /></a></div>
				<div style="border: 2px solid #3A77BE;padding: 5px;"><a href="http://www.omegatd.ru"><img src="_images/omega_logo.png" width="250px" height="57px" alt="" /></a></div>
				<div><a href="http://www.industry-r.ru"><img src="_images/industru-logo.png" width="280px" height="71px" alt="" /></a></div>
					<!--<img src="_images/moy-poverenuy.jpg" width="133px" height="100px" alt="" style="display:block; margin:0 auto; vertical-align:middle;"/>-->
			</div>
			<div id="site_name">Владивостокский<br />Информационный<br />Риэлторский<br />ПортаЛ
				</div>
			<div id="accsess">
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
			</div>
			<div id="myslidemenu" class="jqueryslidemenu">
				<ul>
					<!--<li><a href="#" id="add_vacancy">Вакансии</a></li>-->
					<li><a href="#">Добавить объявление</a>
						<ul>
							<li><a href="#" id="add_advert">Продажа</a></li>
							<li><a href="#" id="add_exchange">Обмен</a></li>
						</ul>
					</li>
					<li><a href="#">Вопросы к специалистам</a>
						<ul>
							<li><a href="#" class="tolawyer">К юристам</a></li>
							<li><a href="#" class="toreappraisers">К оценщикам</a></li>
						</ul>
					</li>
					<li><a href="#" class="toBanks">Новости от банков-партнеров</a></li>
				</ul>
				<br style="clear:left;" />
			</div>
		</div>
		<div id="container">
			<div id="left">
				<div id="accordion" class="on-main-block">
					<h2>Личный кабинет</h2>
					<div class="pane">
						<div style="margin: 5px;">
							<!--<img src="../_images/laofficef.jpg" style="float: right; padding-left: 10px; padding-bottom: 10px;" width="116" height="80" alt=""  />-->
							<span style="font-size:1.2em; color:#333;">Здравствуйте,<br />
								<?php echo substr($_SESSION['name'], strpos($_SESSION['name'], " "));?>.
							</span>
							<?php if($_SESSION['role'] !="4" && $_SESSION['role'] !="15")
									echo '<p style="margin: 5px; font-size:1.1em;">Ваши объявления:</p>
									<ul style="list-style: none; ">
									<li> <span style="font: bold 10pt helvetica, verdana, sans-serif;">Продажа</span>
									<ul class="nested">					
									<li><a href="#" id="actual_flats" class="mlink">- актуальные</a><span id="count_sa" class="count"></span></li>
									<li><a href="#" id="old_flats" class="mlink">- устаревшие</a><span id="count_so" class="count"></span></li>
									<li><a href="#" id="claim_flats" class="mlink">- заявки на просмотр</a><span id="count_ca" class="count"></span></li>		
									</ul>
									</li>
									<li><span style="font: bold 10pt helvetica, verdana, sans-serif;">Обмены</span>
									<ul class="nested">
									<li><a href="#" id="actual_exchanges" class="mlink">- актуальные</a><span id="count_exa" class="count"></span></li>
									<li><a href="#" id="old_exchanges" class="mlink">- устаревшие</a><span id="count_exo" class="count"></span></li>
									</ul>
									</li>
									</ul>';
							?>
							<!--<li><a href="#" id="now_old_flats" class="mlink">- устареют сегодня</a><span id="count_sn" class="count"></span></li>-->
							<p><a href="/" id="logout" style="font-size:1.1em">Выйти из личного кабинета</a></p>
						</div>					
					</div>	
				</div>
				<div id="is-hot-test" class="on-main-block">				
				</div>
				<div id="leftmenu">
					<h2><a href="#" id="inhabitad">Жилая недвижимость</a></h2>
					<div style="margin:0; padding:10px;">
						<ul>
							<!--   <ul class="h_menu">-->
							<li><a href="#" id="fl" class="mlink">Все квартиры</a><span id="count_all_fl" class="count"></span></li>
							<li><a href="#" id="pods" class="mlink">Подселения</a><span id="count_pods" class="count"></span></li>
							<li><a href="#" id="0_fl" class="mlink">Гостинки</a><span id="count_0" class="count"></span></li>
							<li><a href="#" id="1_fl" class="mlink">1-комнатные</a><span id="count_1" class="count"></span></li>
							<li><a href="#" id="2_fl" class="mlink">2-комнатные</a><span id="count_2" class="count"></span></li>
							<li><a href="#" id="3_fl" class="mlink">3-комнатные</a><span id="count_3" class="count"></span></li>
							<li><a href="#" id="4_fl" class="mlink" >4-комнатные</a><span id="count_4" class="count"></span></li>
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
					<h2><a href="#" id="proposal-buy-a">Заявки на приобретение</a></h2>
					<div style="margin:0; padding:10px;">
						<!--<ul>
						<li><a href="#"  class="mlink">Покупают</a></li>
						</ul>-->
					</div>
					<h2><a href="#">Профили сотрудников</a></h2>
					<div style="margin:0; padding:10px;">
						<ul>
							<li><a href="#" id="add_agent" class="mlink">Сотрудники</a></li>
							<!--<li><a href="#" id="agents_cur" class="mlink">Временно Сотрудники</a><span id="count_agents" class="count"></span></li>
							<li><a href="#" id="uparticipant" class="mlink">Обновление сотрудника</a></li>-->
						</ul>
					</div>
					<h2><a href="#" id="no_legal_objects_l">Сомнительные объекты</a></h2>
					<div></div>
					<!--<h2><a href="#">Мои объявления</a></h2>
					<div style="margin:0; padding:10px;">
					<ul>
					<li>
					<ul>
					<li> <span style="font: bold 10pt helvetica, verdana, sans-serif;">Продажа</span></li>
					<li style="padding-left:10px;"><a href="#" id="actual_flats" class="mlink">- актуальные</a><span id="count_sa" class="count"></span></li>
					<li style="padding-left:10px;"><a href="#" id="old_flats" class="mlink">- устаревшие</a><span id="count_so" class="count"></span></li>
					</ul>
					</li>
					<li>
					<ul>
					<li><span style="font: bold 10pt helvetica, verdana, sans-serif;">Обмены</span></li>
					<li style="padding-left:10px;"><a href="#" id="actual_exchanges" class="mlink">- актуальные</a><span id="count_exa" class="count"></span></li>
					<li style="padding-left:10px;"><a href="#" id="old_exchanges" class="mlink">- устаревшие</a><span id="count_exo" class="count"></span></li>
					</ul>
					</li>
					</ul>
					</div>-->
				</div>
				<div class="on-main-block">
					<h2>Новости</h2>
					<div class="pane">
						<ul>
							<li>2 февраля 2010<br />
								<span class="red">Новые возможности!</span><br />
								В режиме редактирования вы можете ставить "Особые отметки" ( продажа по единой цене, "горячее предложение"- от каждого агентства по одному объекту), отмечать новострои  и объекты, подходящие под ипотеку.
								<span style="border-bottom: 1px solid red;">На сайте были произведены значительные изменения, поэтому для корректной работы настоятельно рекомендую почистить кэш в браузерах.</span>
							</li>
							<li>16 сентября 2009<br />
								Теперь можно "накидывать" комиссионные, а также распечатывать отчеты.
								Вы также можете предложить свои макеты отчетов, наиболее интересные будут применены на сайте. 
							</li>
						</ul>
					</div>
					<h2>Вопросы юристам</h2>
					<div class="pane">
						<ul id="advice"></ul>	
						<p style="margin: 0 5px 5px 5px; font-size:0.8em;"><a href="#" class="tolawyer">читать >></a></p>					
					</div>

				</div>
			</div>
			<!--<div id="right"></div>-->
			<div id="content">
				<div id="tabs">
					<ul>
						<li><a href="#objects">Продажа</a></li>
					</ul>
					<div id="objects">
						<div style="padding:5px 0 10px 10px;">В виде:<a href="#" id="view_switch" title="Представление" style =" padding-left: 10px;">Таблицы/Ленты</a></div>
						<div id="lenta" class="hide">
							<iframe id="v_lenta" src="" marginwidth="0" marginheight="0" style="width:100%;height:1850px;overflow:hidden; border:0;" frameborder="0" scrolling="no"> </iframe>
						</div>
						<div id="table" class="show">
							<iframe id="v_table"  src="" style="width:100%;height:1650px;overflow:hidden; border:0;" frameborder="0" scrolling="no"> </iframe>
						</div>
					</div>
				</div>
			</div>
			<div id="footer">
				<p> <span class="first">Размещение рекламы — тел. +7 (4232) 441806 </span><span class="first" style="float: right; padding-right: 12px;">&copy; 2009 ООО &quot;Фолиант&quot;</span> </p>
			</div>
		</div>
		<!--<script type="text/javascript">
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
		</script>
		<script type="text/javascript">
		try {
		var pageTracker = _gat._getTracker("UA-10583093-2");
		pageTracker._trackPageview();
		} catch(err) {}</script>-->  
	</body>
</html>
<script type="text/javascript" src="../_js/script/common.js"></script>
<script type="text/javascript">
	$(function() {
		$(document).idleTimeout({
		inactivity: 3500000, 
		noconfirm: 15000, 
		sessionAlive: false,
		logout_url: false
		});
		$.getJSON("../_scriptsphp/session_var.php", function(json){
			var use = json.use;
			if (use == 1) {
				if (parseInt(json.role) <= 1) {
					$.cookie("inquery", json.id);
				}
				else {
					$.cookie("inquery", json.group);
				}                        
			}
			var parent_group = json.parent_group;
			if (parent_group == 1) {
				$("#myslidemenu ul:first").append('<li><a href="#" class="metodology">Обучающие материалы</a></li>');
						
			}  
			if ($.cookie("inquery") != null){
				setTimeout(function () {
					getCountPrivate();  
				}, 5000);
			}

		});
		$("#uparticipant").click(function (){
			if ($("#uprpt").length === 0) {
				$("#tabs").tabs("add", '#uprpt', 'Обновление сотрудника');
				$("#uprpt").css({
					"position": "relative",
					"height": "auto"
				});
				$.get('_scriptsphp/update_participant.php', {}, function(response){
					$("#uprpt").append(response).fadeIn('slow');
					$("#uprpt").append('<p><a href="#" class="tabs-close-button" title="Закрыть вкладку"><img src="../_images/remove.png" width="32" height="32" alt="Закрыть вкладку" /></a></p>' + "<br />");
				});
			}
			$("#tabs").tabs('option', 'selected', '#uprpt');
			return false;
		});		
		$("#actual_flats").click(function (){
			$("#tabs").tabs('option', 'selected', '#objects');
			$('#v_lenta').attr('src','v_lenta.php?s_prpt=' + $.cookie("inquery") );
			$('#v_table').attr('src','v_table.php?s_prpt=' + $.cookie("inquery") );
		});

		$("#old_flats").click(function (){
			$("#tabs").tabs('option', 'selected', '#objects');
			$('#v_lenta').attr('src','v_lenta.php?s_prpt=' + $.cookie("inquery") +"&pussy=14" );
			$('#v_table').attr('src','v_table.php?s_prpt=' + $.cookie("inquery") +"&pussy=14" );
		});
		$("#claim_flats").click(function (){
			$("#tabs").tabs('option', 'selected', '#objects');
			$('#v_lenta').attr('src','v_lenta.php?s_prpt=' + $.cookie("inquery")+"&claim=1" );
			$('#v_table').attr('src','v_table.php?s_prpt=' + $.cookie("inquery")+"&claim=1" );
		});
		$("#old_exchanges").click(function (){
			createExchangeTab();
			$('#_exchanges').attr('src', 'exchanges.php?s_prpt=' + $.cookie("inquery") +"&pussy=14" );
		});
		$("#actual_exchanges").click(function (){
			createExchangeTab();
			$('#_exchanges').attr('src', 'exchanges.php?s_prpt=' + $.cookie("inquery") );
		});

		$("#logout").click(function (){
			logOut();
		});
		$(window).unload( function () {
			logOut();
		});
	});
	function createExchangeTab(){
		if ($("#exchanges").length == 0) {
			$("#tabs").tabs("add", '#exchanges', 'Варианты обменов');
			$("#exchanges").css({
				"position": "relative",
				"padding": "10px 0 0 0",
				"height": "auto"
			});
			$("#exchanges").append('<iframe id="_exchanges" src="exchanges.php" style="width:100%;height:1050px;overflow:hidden;" frameborder="0" scrolling="no"></iframe><p><a href="#" class="tabs-close-button" title="Закрыть вкладку"><img src="../_images/remove.png" width="32" height="32" alt="Закрыть вкладку" /></a></p>' + "<br />");
		}
		$("#tabs").tabs('option', 'selected', '#exchanges');
	}
</script>
<!--<script type="text/javascript" language="JavaScript" src="http://reformal.ru/tab.js?title=%C2%EB%E0%E4%E8%E2%EE%F1%F2%EE%EA%F1%EA%E8%E9+%C8%ED%F4%EE%F0%EC%E0%F6%E8%EE%ED%ED%FB%E9+%D0%E8%FD%EB%F2%EE%F0%F1%EA%E8%E9+%CF%EE%F0%F2%E0%EB&domain=virpl&color=949088&align=right&charset=utf-8&ltitle=&lfont=&lsize=&waction=0&regime=0"></script>	-->

<?php ob_end_flush();?>
