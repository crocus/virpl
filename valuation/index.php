<?php
	header ("Content-Type: text/html; charset=utf-8");
	header ("Cache-control: no-cache");	
	require_once('../_scriptsphp/session.inc');
	session_start();
	//защита формы
	$_SESSION['userhash'] = md5( time() . $_SERVER['REMOTE_ADDR'] . 'Обломись, падла!! Ня!' );  
	setcookie("_userhash", $_SESSION['userhash'], 0, "/");
	////////////////////////////////////
?>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="../legaladvice/jquery.faq.css" />
	</head>
	<body>
		<div style="margin-left:5px;"><h1>Консультации оценщиков</h1>
			<img src="../_images/logo_industry_r.gif" style="float: left; margin: 0 5px 5px 0;" width="116" height="80" alt="" style="padding: 0 5px 5px 0;" /><span style="font-size:10pt; display: block;">Консультации по вопросам оценки ведут специалисты компании "Индустрия-Р".</span>
			<span style="font-size:10pt; display: block;">г. Владивосток, пр. Красного Знамени 59, офис 604, 617
				Остановка траспорта "Гоголя", Здание института "Промстрой НИИ проект", 6-ой этаж.
			Тел. +7 (4232) 30-28-70, 30-11-52, 45-77-18, 45-69-97 
			e-mail: <a href="mailto:Dsn2001@mail.ru">Dsn2001@mail.ru; </a>
			сайт: <a href="http://www.industry-r.ru">http://www.industry-r.ru</a></span>
</div><br>
		<div style="margin-left:5px;">
			<ul>
				<li>Оценка имущества (квартиры, дома, транспорт, оборудование, суда, коммерческая недвижимость, здания и сооружения, земельных участков, оргтехники, акция предприятий, ценных бумаг)</li>
				<li>Оценка ущерба квартир, помещений от затопления, пожара.</li>
			</ul>
			<h3>Для целей – залога, раздела имущества, наследства, внесение в Уставный капитал, страхование, рассмотрения дел в суде</h3>
			<ul>
				<li>Консалтинговые услуги на рынке недвижимости, аналитические исследования рынка коммерческой недвижимости Владивостока и Приморского края</li>
			</ul>
		</div>
		<div id="vp_tape">
		</div><br />
		<?php
			if(!isset($_SESSION['user'])|| empty($_SESSION['user']) ) {
				echo '<div class="form-container-block">
				<h3 class="form-container-h">Задайте Ваш вопрос</h3>
				<div class="form-container""><form id="vp-question-form" name="vp-question-form">
				<div class="econtainer"><h4>При заполнении формы допущены ошибки.</h4><ol/></div>
				<label for="vp_author" class="inlinetext">Имя<span class="red">*</span></label><br /><input type="text" id="vp_author" name="vp_author" class="inform large"/><br />
				<input type="hidden" name="vp_userurl" value="'.$_SESSION['userhash'].'" id="vp_userurl"/>
				<input type="text" name="vp_keystring" value="" id="vp_keystring" style="display:none;"/>
				<label for="vp_email" class="inlinetext">E-mail<span class="red">*</span> (не публикуется)</label><br /><input type="text" id="vp_email" name="vp_email" class="inform large"/><br />
				<label for="vp_question" class="inlinetext">Ваш вопрос<span class="red">*</span></label><br />
				<textarea id="vp_question" name="vp_question" class="inform large" cols="100%" rows="6"></textarea>
				<p><span class="red">*</span> - обязательные для заполнения поля</p>
				<p><input id="vp_respond_btn" type="submit" value="Задать вопрос"/></p>
				</form></div></div><br />';
			}
		?>
		<script type="text/javascript">
			$(document).ready(function(){
				show_messages();
				$(".pagination a").live('click', function(){
					//Loading Data
					var queryString = $(this).attr("href");
					$.ajax({
						url: "../valuation/show.php" + queryString,
						cache: false,
						success: function(html){
							$("#vp_tape").html(html).makeFAQ({
								indexTitle: "Содержание",
								displayIndex: false,
								faqHeader: "h2"
							});
						}
					});
					return false;
				});
				$("#vp_question").maxlength({
					maxChars: 350, 
					leftChars: "символов осталось" 
				});
				$('._redact').live('click', function(){
					element = $(this);
					var eparent = $(this).parents(".faqcontent");
					var id_message = $($(eparent).find('p.ready-answer')).find('span').remove().end().text();
					if ($(eparent).find('.danswer').length === 0){
						var answer = '<div class="danswer"><textarea id="answer" name="answer" cols="100%" rows="10" style="width:520px;"></textarea>' +
						'<p><input class="send_answer" type="button" value="Ответить"/><input class="chancel_answer" type="button" value="Отменить"/></p></div>';
						$(eparent).find('p.ready-answer').remove();
						$(eparent).append(answer);
						$(eparent).find('#answer').html(id_message);
					}
					$('.chancel_answer').live('click', function(){
						var eparent = $(this).parents(".faqcontent");
						var answer = $(eparent).find('#answer').val();
						if(answer!=''){
							$(eparent).append('<p class="ready-answer"><span>Ответ:</span>'+ answer +'</p>').find('.danswer').remove();
						} else{
							$(eparent).find('.danswer').remove();
						}
					});
					$('.send_answer').live('click', function(){
						var eparent = $(this).parents(".faqcontent");
						var answer = $(eparent).find('#answer').val();
						var id = $(eparent).find('label').text();
						if(answer!=''){
							$.ajax({
								type: "POST",
								url: "../valuation/action.php",
								data: "id="+ id +"&response="+ answer +"&action=update",
								success: function(msg){
									show_messages();
								}
							});
						}
					});
					return false;
				});

				$('._delete').live('click', function(){
					element = $(this);
					var id_message = $(this).parent().find('label').text();
					$.ajax({
						type: "POST",
						url: "../valuation/action.php",
						data: {
							"id": id_message,
							"action":"delete"
						},
						success: function(msg){
							show_messages();
						}
					});
					return false;
				});
				var options = {
					resetForm: true,
					timeout: 3000
				};
				var econtainer = $('div.econtainer');
				var validator = $("#vp-question-form").validate({
					ignore: ".ignore",
					rules: {
						vp_author: {
							required: true
						},
						vp_question: {
							required: true
						},
						vp_email: {
							required: true
						}
					},
					messages: {
						vp_author: {
							required: "Пожалуйста, укажите Ваше имя."
						},
						vp_question: {
							required: "Пожалуйста, сформулируйте Ваш вопрос."
						},
						vp_email: {
							required: "Пожалуйста, укажите Ваш E-mail."
						}
					},
					submitHandler: function(form) {
						jQuery(form).ajaxSubmit(options);
						var name = $("#vp_author").val();
						var vp_keystring = $("#vp_keystring").val();
						var msg  = $("#vp_question").val();
						var hash  = $.cookie("_userhash");
						var userurl  = $("#vp_userurl").val();
						if(userurl===hash){
							$.ajax({
								type: "POST",
								url: "../valuation/action.php",
								data: {
									"username":name,
									"msg":msg,
									"keystring":vp_keystring,
									"userhash": hash,
									"action":"add"
								},
								success: function(msg){
									show_messages();
								}
							});
						}					
						//////////////////////
						return false;
					},
					success: function(label){
						label.parent().remove();
					},
					errorContainer: econtainer,
					errorLabelContainer: $("ol", econtainer),
					wrapper: 'li',
					errorElement: "p",
					onkeyup: false,
					onfocusout: false,
					onclick: false
				});
			});
			function show_messages()
			{
				$.ajax({
					url: "../valuation/show.php",
					cache: false,
					success: function(html){
						$("#vp_tape").html(html).makeFAQ({
							indexTitle: "Содержание",
							displayIndex: false,
							faqHeader: "h2"
						});
					}
				});
			}
		</script>
	</body>
</html>