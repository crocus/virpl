<?php
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
	header('Cache-Control: no-store, no-cache, must-revalidate'); 
	header('Cache-Control: post-check=0, pre-check=0', FALSE); 
	header('Pragma: no-cache');
	require_once('r_conn.php');
	include('./rdate/rdate.php');
	include('services.php');
	require_once('session.inc');
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Владивостокский Информационный Риэлторский Портал: Сомнительные объекты</title>
	</head>
	<body>
		<!--<div><span style="color: red; font-size: 1.1em;">На конструкции! Демо! Не функционирует!!! </span></div>-->
		<div id="refuse-panel-head">
			<div class="refuse-types" style="">
				<div class="selected" style="width: 90px;display: inline-block; padding:0.2em 0.6em 0.3em;">
					<label for="refuse-action-search"><span>Поиск</span></label>
				</div>
				<div style="width: 114px;display: inline-block; padding:0.2em 0.6em 0.3em;">
					<label for="refuse-action-add"><span>Добавить</span></label>
				</div>
			</div>
			<div style="clear: both;"></div>
		</div>
		<div id="refuse_tape" style="width:590px; padding:10px; color:#2E6E9E; font-weight: bold;">
			<div class="form-container">
				<form id="refuse-form" name="refuse-form" style="margin:5px;" >
					<div class="econtainer">
						<h4>При заполнении формы допущены ошибки.</h4>
						<ol/>
					</div>
					<label for="refuse_city" class="inform">Населенный пункт:</label><select type="text" id="refuse_city" name="refuse_city" class="inform large" size="1"/><br />
					<label for="refuse_street" class="inform">Улица:</label><div class="inform" style="white-space: nowrap;"><input type="text" id="refuse_street" name="refuse_street" disabled="disabled"  style="width: 90%;" />&nbsp;
						<img class="hint" src="../_images/question-frame.png" width="16" height="16" alt="" style="vertical-align:middle; margin: 0 auto;" title="Отсутствует улица или не появляется 'список'?<br/>Кликни по значку!"/><br />
						<span style="white-space:normal;font-size: smaller;">(выбирается <span class="red">только</span> из списка, список появляется при наборе двух и более букв)</span>
						<input type="hidden" id="refuse_street_id" name="refuse_street_id" /></div>
					<input type="hidden" name="refuse_userurl" value="" id="refuse_userurl"/>
					<input type="text" name="a_keystring" value="" id="a_keystring" style="display:none;"/>
					<label for="refuse_house" class="inform">Дом, квартира:</label><input class="inform double secondary-op ignore" id="refuse_house" name="refuse_house"/><input class="inform double secondary-op ignore" id="refuse_flat" name="refuse_flat"/><br />
					<div id="refuse-action-search" class="refuse-action">
						<label for="refuse-find-btn" class="inform"></label><input id="refuse-find-btn" type="submit" value="Найти"/>
						<input class="refuse-reset-form" type="reset" style="width:75px;" value="Сброс" />
					</div>
					<div id="refuse-action-add" style="display: none;" class="refuse-action">
						<label for="refuse_reason" class="inform">Причина размещения:</label><textarea class="inform large active-add ignore" id="refuse_reason" name="refuse_reason" cols="100%" rows="6"></textarea><br />
						<label for="refuse_published" class="inform">Разместил:</label><textarea class="inform large active-add ignore" id="refuse_published" rows="2" cols="4" name="refuse_published"></textarea><br />					
						<label for="refuse-respond-btn" class="inform"></label><input id="refuse-add-btn" type="submit" value="Отправить"/></div>
					<input type="hidden" name="refuse_type_request" value="refuse-action-search" id="refuse_type_request"/>
				</form>
			</div>
		</div>
		<div id="refuse-response"></div>
		<br />
		<div class="faq_exchange" style="display: none">
			<div class="faq-body textondiv">Если Вы не нашли улицу:
				<p> - Проверьте, что в списке "Населенный пункт" Вы выбрали то, что Вам нужно.</p>
				<p> - Введите несколько букв из названия улицы (например для Садовой достаточно набрать "са")</p>
				<p> - Выберите в появившемся списке нужную улицу.</p>
				<p style="text-indent:25px;">Если необходимой Вам улицы в списке нет или список вообще не появляется, вероятно эта улица в настоящее время отсутствует в системе.<br/>
					Это справедливо в первую очередь для районов Приморского края, список там далеко не полный.</p>
				<p class="red" style="text-indent:25px;">Не пытайтесь самостоятельно заполнить поле, система не примет введенное вами название,
					выбор производится только из списка.</p>
				<p style="text-indent:25px;">Вы можете отправить предложение по добавлению улицы Администратору портала на admin@foliant.net.ru.</p>
				<p style="color:navy">Например в таком виде: Надеждинский р-он, ул.Лазо(п.Раздольное)</p>
				<p>Вы также можете привлечь внимание к своему предложению через форму "Оставьте свой отзыв"</p>
			</div>
		</div>
		<script type="text/javascript">
			//show_messages();
			//Default Starting Page Results
			simple_tooltip(".hint","tooltip");
			$("#refuse-response").load("../_scriptsphp/doubtful_show.php");
			/*	$("#pagination li:first")
			.css({'color' : '#FF0084'}).css({'border' : 'none'});
			$("#refuse-response").load("../_scriptsphp/doubtful_show.php?page=1",  function(){
			/*				alert("The last 25 entries in the feed have been loaded"); {page: 1},
			});*/
			/*$("#pagination li").live('click', function(){
			//Loading Data
			var pageNum = this.id;
			var queryString = $(this).find("span").text();
			$("#refuse-response").load("../_scriptsphp/doubtful_show.php?page=" + pageNum + queryString,  function(){
			});

			$("#pagination li")
			.css({'border' : 'solid #dddddd 1px'})
			.css({'color' : '#0063DC'});

			$(this)
			.css({'color' : '#FF0084'})
			.css({'border' : 'none'});
			});*/
			$(".pagination a").live('click', function(){
				//Loading Data
				var queryString = $(this).attr("href");
				$("#refuse-response").load("../_scriptsphp/doubtful_show.php" + queryString,  function(){});
				return false;
			});
			$.getJSON("../_scriptsphp/get_parameters.php", {
				parameter: "city"
			}, function(json){
				$('#refuse_city').fillSelect(json).attr('disabled', '');
				$('#refuse_city').change(function(){
					adjustStreet("refuse_city", "refuse_street");
					var id = $(this).attr("id");
					var name = $("#refuse_city option:selected").val();
					$("#refuse_street").removeAttr("value");
					$("#refuse_street_id").removeAttr("value");
					refuse_ac(id, name, "refuse_street" );
				}).change();
			});
			var spHead = $('#refuse-panel-head'),
			triggers = $('>div>div', spHead);
			$('label', triggers).click(function(){
				triggers.removeClass('selected');
				$(this).parent().addClass('selected');
				var form = $(this).attr('for');
				if(form === 'refuse-action-add'){
					$(".active-add, .secondary-op").removeClass("ignore");
				} else {
					$(".active-add, .secondary-op").addClass("ignore");
				}
				if ($("#"+form).children('.refuse-reset-form').length === 0)
					$("#"+form).append('<input class="refuse-reset-form" type="reset" style="width:75px;" value="Сброс" />');
				$("#refuse_type_request").val(form);
				$('.form-container').find('div.refuse-action').hide();
				$('#'+form).show();
			});

			var options = {
				resetForm: false,
				timeout: 3000
			};
			var econtainer = $('div.econtainer');
			var validator = $("#refuse-form").validate({
				ignore: ".ignore",
				rules: {
					refuse_street: {
						required: true
					},
					refuse_house: {
						required: true
					},
					refuse_reason: {
						required: true
					},
					refuse_published: {
						required: true
					}
				},
				messages: {
					refuse_street: {
						required: "Пожалуйста, выберите улицу из списка."
					},
					refuse_house: {
						required: "Пожалуйста, укажите номер дома."
					},
					refuse_reason: {
						required: "Пожалуйста, укажите причину размещения."
					},
					refuse_published: {
						required: "Пожалуйста, укажите кто разместил и контактные данные."
					}
				},
				submitHandler: function(form) {
					jQuery(form).ajaxSubmit(options);
					var d_street = $("#refuse_street_id").val();
					var d_house = $("#refuse_house").val();
					var d_flat = $("#refuse_flat").val();
					var a_keystring = $("#a_keystring").val();
					var hash  = $.cookie("_userhash");
					var refuse_type = $("#refuse_type_request").val();
					if(refuse_type === 'refuse-action-add'){
						var d_reason = $("#refuse_reason").val();
						var d_published = $("#refuse_published").val();
						$.ajax({
							type: "POST",
							url: "../_scriptsphp/doubtful_action.php",
							data: {
								"street":d_street,
								"house":d_house,
								"flat":d_flat,
								"reason":d_reason,
								"published":d_published,
								"keystring":a_keystring,
								"userhash": hash,
								"action":"add"
							},
							success: function(msg){
								$("#refuse-response").load("../_scriptsphp/doubtful_show.php");
							}
						});
					} else {
						$.ajax({
							type: "GET",
							url: "../_scriptsphp/doubtful_show.php",
							data: {
								"street":d_street,
								"house":d_house,
								"flat":d_flat,
								"keystring":a_keystring,
								"userhash": hash,
								"action":"find"
							},
							success: function(msg){
								$("#refuse-response").html(msg);
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
			$('.refuse-reset-form').live('click', function() {
				validator.resetForm();
				$("#refuse-response").load("../_scriptsphp/doubtful_show.php",  function(){
					/*				alert("The last 25 entries in the feed have been loaded"); {page: 1},*/
				});
				return false;
			});
			$(".hint").click(function () {
				$(".faq_exchange").toggle();
				var s = $(".hint");
				var position = s.position();
				var s_w = s.width();
				var s_h = s.height();
				var top = position.top + s_h + 5;
				var left = position.left + s_w -405;
				var cssObj = {
					'position':'absolute',
					'z-index':'999',
					'left': left,
					'top' : top,
					'border':'3px solid #dedede',
					'width':'400px',
					'font-size':'small'
				}
				$('.faq_exchange').css(cssObj);
				$('.faq-body').css("background-color", "#FFFFCC");
			});
			var timoutHandler = function () {
				$(".faq_exchange").fadeOut("slow");
			};
			var timeoutId = null;
			$(".faq_exchange").mouseout(function(){
				timeoutId = setTimeout(timoutHandler, 2000);
			}).mouseover(function(){
				clearTimeout(timeoutId);
			});
			function refuse_ac(id, name, control) {
				var random = hex_md5(Date()).substr(10, 8);
				$("#" + control).autocomplete("../_scriptsphp/street_autocomplit.php", {
					minChars:2,
					cacheLength:0,
					matchSubset:0,
					delay: 600,
					maxItemsToShow: 15,
					autoFill:true,
					onItemSelect: selectItem,
					/*    delay:10,
					minChars:2,
					matchSubset:1,
					autoFill:true,
					matchContains:1,
					cacheLength:10,*/
					extraParams:{
						s:name,
						r: random
					}
				});
				function selectItem(li) {
					if( li == null ) var sValue = "Ничего не выбрано!";
					if( !!li.extra ) var sValue = li.extra[2];
					else var sValue = li.selectValue;
					alert("Выбрана запись с ID: " + sValue);
				}
				$("#refuse_street").result(function(event, data, formatted) {
					if (data){
						$(this).parent().find("#refuse_street_id").val(data[1]);
					} 
				});
			}
		</script>
	</body>
	</html>