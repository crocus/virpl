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
		<!--<script type="text/javascript" src="../_js/jquery/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="../_js/jquery/external/cookie/jquery.cookie.min.js"></script>
		<script type="text/javascript" src="../_js/plugins/jquery.validate.min.js"></script>
		<script type="text/javascript" src="../_js/plugins/jquery.form.js"></script>
		<script type="text/javascript" src="../legaladvice/jquery.faq.js"></script>-->	
		<link href="../_style/test.css" rel="stylesheet" type="text/css"/>
		<link type="text/css" rel="stylesheet" href="../legaladvice/jquery.faq.css" />
	</head>
	<body>
		<div style="margin-left:5px;"><h1>Юридическая консультация</h1>
			<img src="../_images/laofficef.jpg" style="float: left; margin: 0 5px 5px 0;" width="116" height="80" alt="" style="padding: 0 5px 5px 0;" /><span style="font-size:10pt">На Ваши вопросы отвечают юристы конторы адвокатов "Колесникова О.А. и партнеры".
				<p>Руководитель - Колесникова Оксана Александровна</p>
				<p>г. Владивосток, ул. Семеновская д.7, 2 этаж</p>
				Телефоны: (4232)223623, (4232)205175</span></div>
		<div style="width:520px;margin-left:5px;"><h2>Наши услуги</h2>
		<img src="../_images/kol_logo.png" style="float: right; margin: 0 5px 5px 5px; padding: 0 5px 5px 5px;"  alt=""/>
			<ul>
				<li>Жилищные споры (вселение, выселение, признание права проживания, признание права собственности и т.д.)</li>
				<li>Представление интересов на жилищной комиссии, договоры соц.найма, общежития, служебное жилье.</li>
				<li>Согласование перепланировки и переустройства квартир и нежилых помещений. Сохранение помещений в перепланированном состоянии.</li>
				<li>Перевод жилых помещений в нежилой фонд, нежилых помещений в жилой фонд.</li>
				<li>Оформление земельных участков в собственность и в аренду. Земельный департамент, УМИГА, госземкадастр. Земельные споры в суде.</li>
				<li>Представление интересов в суде общей юрисдикции (трудовые, семейные, наследственные споры, защита прав потребителей, взыскание долгов, ущерба и т.д.)</li>
				<li>Арбитражные споры.</li>
				<li>Регистрация и перерегистрация предприятий, ИП.</li>
				<li>Правовое сопровождение бизнеса.</li>
				<li>Защита по уголовным делам: дознание, следствие, суд.</li>
				<li>Все виды согласований: СЭС. пожарники, разрешения на торговлю.</li></ul>
			</div>
		<div id="faq">
		</div><br />
		<?php
			if(!isset($_SESSION['user'])|| empty($_SESSION['user']) ) {
				echo '<div style="width:520px; padding:10px;">
				<h3 style="border-bottom:1px solid #B8B8B8;color:#444444; padding:0.5em 0 0.2em;">Задайте Ваш вопрос</h3>
				<div style="padding:5px;"><form id="question-form" name="question-form">
				<div class="econtainer">
				<h4>При заполнении формы допущены ошибки.</h4>
				<ol/>
				</div>
				<input type="text" id="author" name="author" class="inform"/><label for="author" class="inlinetext">Имя *</label><br />
				<input type="hidden" name="userurl" value="'.$_SESSION['userhash'].'" id="userurl"/>
				<input type="text" name="a_keystring" value="" id="a_keystring" style="display:none;"/>
				<input type="text" id="email" name="email" class="inform"/><label for="email" class="inlinetext">E-mail (не публикуется) *</label><br />
				<p>* - обязательные для заполнения поля</p>
				<span>Ваш вопрос:</span>
				<textarea id="question" name="question" cols="100%" rows="6" style="width:520px;"></textarea><br />
				<p><input id="respond-btn" type="submit" value="Задать вопрос"/></p>
				</form></div></div><br />';
			}
		?>

		<script type="text/javascript">
			$(document).ready(function(){
				show_messages();
				$("#question").maxlength({
					maxChars: 300, 
					leftChars: "символов осталось" 
				});
				$('.ladvice_redact').live('click', function(){
					element = $(this);
					//var id_advice = $(this).parent().find('label').text();
					var eparent = $(this).parents(".faqcontent");
					var id_advice = $($(eparent).find('p.ready-answer')).find('span').remove().end().text();
					if ($(eparent).find('.danswer').length === 0){
						var answer = '<div class="danswer"><textarea id="answer" name="answer" cols="100%" rows="10" style="width:520px;"></textarea>' +
						'<p><input class="send_answer" type="button" value="Ответить"/><input class="chancel_answer" type="button" value="Отменить"/></p></div>';
						//$(this).parents(".faqcontent").find('p.ready-answer').remove(":contains('"+ id_advice +"')");
						$(eparent).find('p.ready-answer').remove();
						$(eparent).append(answer);
						$(eparent).find('#answer').html(id_advice);
					}
					$('.chancel_answer').live('click', function(){
						var eparent = $(this).parents(".faqcontent");
						var answer = $(eparent).find('#answer').val();
						if(answer!=''){
							$(eparent).append('<p class="ready-answer"><span>Ответ:</span>'+ answer +'</p>').find('.danswer').remove();
						} else{
							//$(eparent).append('<p class="ready-answer"><span>Ответ:</span>'+ id_advice +'</p>').find('.danswer').remove();
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
								url: "../legaladvice/action.php",
								data: "id="+ id +"&response="+ answer +"&action=update",
								success: function(msg){
									show_messages();
									//$(eparent).append('<p class="ready-answer"><span>Ответ:</span>'+ answer +'</p>').find('.danswer').remove();
								}
							});
						}
					});
					return false;
				});

				$('.ladvice_delete').live('click', function(){
					element = $(this);
					var id_advice = $(this).parent().find('label').text();
					$.ajax({
						type: "POST",
						url: "../legaladvice/action.php",
						data: {
							"id": id_advice,
							"action":"delete"
						},
						success: function(msg){
							show_messages();
						}
					});
					return false;
				});
				var options = {
					//target: "#lawyer",
					//success: showResponseParticipants,
					resetForm: true,
					timeout: 3000
				};
				var econtainer = $('div.econtainer');
				var validator = $("#question-form").validate({
					ignore: ".ignore",
					rules: {
						author: {
							required: true
						},
						question: {
							required: true
						},
						email: {
							required: true
						}
					},
					messages: {
						author: {
							required: "Пожалуйста, укажите Ваше имя."
						},
						question: {
							required: "Пожалуйста, сформулируйте Ваш вопрос."
						},
						email: {
							required: "Пожалуйста, укажите Ваш E-mail."
						}
					},
					submitHandler: function(form) {
						jQuery(form).ajaxSubmit(options);
						var name = $("#author").val();
						var a_keystring = $("#a_keystring").val();
						var msg  = $("#question").val();
						var hash  = $.cookie("_userhash");
						var userurl  = $("#userurl").val();
						if(userurl===hash){
							$.ajax({
								type: "POST",
								url: "../legaladvice/action.php",
								data: {
									"username":name,
									"msg":msg,
									"keystring":a_keystring,
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
					url: "../legaladvice/show.php",
					cache: false,
					success: function(html){
						$("#faq").html(html).makeFAQ({
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