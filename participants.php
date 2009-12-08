<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Участникм рынка недвижимости</title>
	</head>
	<body>
		<div id="f_prpt_update" style="display:none; margin:10px;">
			<div style="padding:5px;"><form id="update-participant" name="update-participant" action="_scriptsphp/fish.php" method="get">
					<div id="ec_for_update" class="econtainer">
						<h4>При внесениии изменений в профиль были допущены ошибки, смотрите ниже для уточнения.</h4>
						<ol/>
					</div>
					<label for="pu_agency" class="inform">Агентство:</label><select id="pu_agency" name="pu_agency" class="inform" size="1"/><br />
					<input id="pu_logged_a" name="pu_logged_a" type="hidden" value="" />
					<label for="pu_lastname" class="inform">Фамилия:</label><input type="text" id="pu_lastname" name="pu_lastname" class="inform"/><br />
					<label for="pu_firstname" class="inform">Имя:</label><input type="text" id="pu_firstname" name="pu_firstname" class="inform"/><br />
					<label for="pu_secondname" class="inform">Отчество:</label><input type="text" id="pu_secondname" name="pu_secondname" class="inform"/><br />
					<label for="pu_phon" class="inform">Телефоны:</label><input type="text" id="pu_phon" name="pu_phon" class="inform"/><br />
					<label for="pu_show_phon" class="inform">Показывать телефон:</label><input type="checkbox" id="pu_show_phon" name="pu_show_phon"/><br />
					<label for="pu_mail" class="inform">Электронная почта:</label><input type="text" id="pu_mail" name="pu_mail" class="inform"/><br />
					<label for="pu_login" class="inform">Логин:</label><input type="text" id="pu_login" name="pu_login" class="inform"/><br />
					<label for="pu_pass" class="inform">Пароль:</label><span class="inform"><input type="password" id="pu_pass" name="pu_pass" style="width:90%;" />
						<img id="up_eye" src="../_images/eye--exclamation.png" width="16" height="16" alt="" style="vertical-align:middle; cursor: pointer;" title=""/></span><br />
					<label class="inform"></label><input type="button" id="up_submit" name="up_submit" class="" value="Применить изменения"/><br />
					<p><a title="Вернуться" id="up_to_back" href="#">Вернуться</a></p>
				</form></div></div><br />
		<div id="pr_manipulation" style="margin:10px;">
			<div id="n_prpt" class="d-link"><img src="_images/User_48x48.png" width="48" height="48" alt="Новый сотрудник" /><br /><a href="#" id="n_participant" class="mlink">Добавить сотрудника</a></div><br />
			<div id="pr_test" style="margin:10px;"></div><br />
			<div id="f_prpt_manipulation" style="padding:0px;">
				<div style="padding:5px;"><form id="new-participant" name="new-participant" action="_scriptsphp/fish.php" method="get">
						<div class="econtainer">
							<h4>При добавлении сотрудника были допущены ошибки, смотрите ниже для уточнения.</h4>
							<ol/>
						</div>
						<label for="p_agency" class="minform">Агентство:</label><select id="p_agency" name="p_agency" class="inform" size="1"/><br />
						<input id="p_logged_a" name="p_logged_a" type="hidden" value="" />
						<label for="p_lastname" class="minform">Фамилия:</label><input type="text" id="p_lastname" name="p_lastname" class="inform"/><br />
						<label for="p_ferstname" class="minform">Имя:</label><input type="text" id="p_ferstname" name="p_ferstname" class="inform"/><br />
						<label for="p_secondname" class="minform">Отчество:</label><input type="text" id="p_secondname" name="p_secondname" class="inform"/><br />
						<label for="p_mail" class="minform">Электронная почта:</label><input type="text" id="p_mail" name="p_mail" class="inform"/><br />
						<label for="p_login" class="minform">Логин:</label><input type="text" id="p_login" name="p_login" class="inform"/><br />
						<label for="p_pass" class="minform">Пароль:</label><input type="text" id="p_pass" name="p_pass" class="inform"/><br />
					</form></div></div>
		</div><br />
	</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){
		fillAgency("pu_agency");
		//	$("#up_eye").click(function() { 
		$("#up_eye").toggle(
		function () {
			var is_pass= $("#pu_pass").val();
			$("#pu_pass").replaceWith("<input type='text' id='pu_pass' name='pu_pass' style='width:90%;' />");
			$("#pu_pass").val(is_pass);
		},
		function () {
			var is_pass= $("#pu_pass").val();
			$("#pu_pass").replaceWith("<input type='password' id='pu_pass' name='pu_pass' style='width:90%;' />");
			$("#pu_pass").val(is_pass);
		}
		);
		//	});
		var infohtml = '<div id="infomessage" class="i-message ui-corner-bottom"><div class="textondiv redline"></div></div>';
		$.getJSON("../_scriptsphp/session_var.php", function(json){
			var group = json.group;
			var use = json.use;
			if(use == 1){
				$('#p_logged_a').val(group);
				if ( parseInt(json.role) <= 1) {
					bind_id = json.id;
				} else {
					bind_id = json.group;
					$('#n_prpt').toggle();
				}
				$.cookie("inquery", bind_id);
			}
		});
		$.getJSON("../_scriptsphp/participant_reg.php", {
			parameter: "show",
			participant: $.cookie("inquery")
		}, function(json){
			var divs="";
			$.each(json, function(i, attribut){
				divs += '<div id="_' + i + '" class="dinform"><div style=" width:85%; float:left;"><img src="_images/noavatar.gif" align="left" width="60" height="60" alt="" style="padding: 0 5px 5px 0;" /><input name="p_id" type="hidden" value="'+ attribut.Id +'" /><label for="name">' + attribut.Name + '</label><br />'
				+ ((attribut.Role != "") ? '<span class="span-field">Должность: </span><label for="role">' + attribut.Role + '</label><br />': "")
				+ ((attribut.Mail != "") ? '<span class="span-field">Эл. почта: </span>' + attribut.Mail + '<br />' : "")
				+ ((attribut.Login != "") ? '<span class="span-field">Логин: </span>' + attribut.Login + '<br />' : "")
				+ '</div><div style="width:10%; float:right; padding-top:5px; text-align:right; display:none;" class="redact-prpt">'
				+ '<a href="#" class="p_update" title="Изменить"><img src="_images/Refresh_16x16.png" alt="Изменить" /></a><br /><a href="#" class="p_delete" title="Удалить"><img src="_images/Delete_16x16.png" alt="Удалить" style="margin-top:5px;"/></a></div></div>';
			});
			$("#pr_test").prepend(divs);
		});
		$('#n_participant').click( function(){
			fillAgency("p_agency");
			$('#f_prpt_manipulation').dialog('open');
		});
		$('.dinform').live('mouseover', function(){
			$(this).css("background-color", "#E3F2E1").find('.redact-prpt').show();
		}).live('mouseout', function(){
			$(this).css("background-color", "#fff").find('.redact-prpt').hide();
		});
		$('#up_to_back').click( function(){
			$('#pr_manipulation').show();
			$('#f_prpt_update').hide();
		});
		$("#f_prpt_manipulation").dialog({
			title: 'Новый сотрудник',
			bgiframe: true,
			autoOpen: false,
			width: 430,
			modal: true,
			buttons: {
				'Закрыть': function(){
					validator.resetForm();
					$(this).dialog('close');
				},
				'Добавить': function(){
					$("#new-participant").submit();
					// $(this).dialog('close');
				}
			}
		});
		/*		$("#f_prpt_update").dialog({
		title: 'Изменение профиля',
		bgiframe: true,
		autoOpen: false,
		width: 430,
		modal: true,
		buttons: {
		'Закрыть': function(){
		//up_validator.resetForm();
		$(this).dialog('close');
		},
		'Добавить': function(){
		//$("#update-participant").submit();
		// $(this).dialog('close');
		}
		}
		});*/
		$('.p_update').live('click', function(){

			$('#f_prpt_update').block({ 
				//message: '<h3>Загружаю...</h3>', 
				message: null
				/*css: { 
				top:  ($('#f_prpt_update').height() - 500) /2 + 'px', 
				left: ($('#f_prpt_update').width() - 500) /2 + 'px', 
				border: '1px solid #CCC'
				} */
			});  
			//$.blockUI();
			var element = $(this);
			var prpt_id = element.parents("div.dinform").find('input[name="p_id"]').val();	
			$('#pr_manipulation').hide();
			$('#f_prpt_update').show();
			$.getJSON("../_scriptsphp/participant_reg.php", {
				parameter: "participant",
				id: prpt_id
			}, function(json){
				//	alert(json[0].parents_id);
				var p_obj = json[0];
				$("#pu_agency option[value='" + p_obj.parents_id + "']").attr("selected", "selected");
				var array_name = p_obj.Name.split(" ");
				$("#pu_lastname").val(array_name[0]);
				$("#pu_firstname").val(array_name[1]);
				$("#pu_secondname").val(array_name[2]);
				$("#pu_mail").val(p_obj.Mail);
				if (p_obj.Show_phon == 1)
					$("#pu_show_phon").attr("checked", "checked");
				$("#pu_login").val(p_obj.Login);
				$("#pu_pass").val('');
			});
			//				$('#f_prpt_update').dialog('open');
			//$.unblockUI();
			/*$('.blockOverlay').attr('title','Click to unblock').live('click', function()
			{
			$('#f_prpt_update').unblock();
			});*/ 
			setTimeout(function() { 
				$('#f_prpt_update').unblock();
			}, 1000); 
			//$('#f_prpt_update').unblock();
			return false;
		});
		var message_dialog = '<div class="message-dialog"><div class="message-dialog-header"><div class="message-dialog-body"></div><div class="message-dialog-footer"></div></div>';
		$("#p_agents").append(message_dialog);
		$(".message-dialog").dialog({
			title: 'Удаление сотрудника',
			//beforeclose: function(event, ui) { $('.message-dialog-body').empty(); },
			bgiframe: true,
			autoOpen: false,
			width: 350,
			modal: true,
			buttons: {
				'Отмена': function(){
					$('.message-dialog-body').empty();
					$(this).dialog('close');
				},
				'Удалить': function(){

					// $(this).dialog('close');
				}
			}
		});
		$('.p_delete').live('click', function(){
			element = $(this);
			// $("#p_ferstname").val($(that.parents().find('label[for="name"]').text()));
			var t_yame = $(this).parent().parent().find('label[for="name"]').text();
			var prpt_id = element.parents("div.dinform").find('input[name="p_id"]').val();
			$.getJSON("../_scriptsphp/participant_reg.php", { parameter: "prepare_delete", id: prpt_id },
			function(data){
				if(data.rows != null){
					var message_array = new Array();
					var str;
					message_array.push('<div class="textweb20">За пользователем закреплено:<br />');
					$.each(data.rows, function(i, val) {
						message_array.push('<span style="padding-left:25px">');
						message_array.push(val.cell);
						message_array.push('</span><br />');
					});
					message_array.push('</div><div style="padding-top:10px;"><span class="red">При нажатии на кнопку "Удалить" пользователь и все, закрепленные за ним объекты(объявления), будут безвозвратно удалены. Вы уверены?</span></div>');
					str =  message_array.join("");
					$('.message-dialog-body').html(str);
					$('.message-dialog').dialog('open');
				} else {return false;}
			});
			return false;
		});
		var options = {
			target: "#prpt_response",
			//success: showResponseParticipants,
			resetForm: true,
			timeout: 3000 // тайм-аут
		};
		var econtainer = $('div.econtainer');
		var validator = $("#new-participant").validate({
			ignore: ".ignore",
			rules: {
				p_ferstname: {
					required: true
				},
				p_secondname: {
					required: true
				},
				p_lastname: {
					required: true
				},
				p_mail: {
					required: true
				},
				p_login: {
					required: true
				},
				p_pass: {
					required: true
				}
			},
			messages: {
				p_ferstname: {
					required: "Пожалуйста, введите имя."
				},
				p_secondname: {
					required: "Пожалуйста, введите отчество."
				},
				p_lastname: {
					required: "Пожалуйста, введите фамилию."
				},
				p_mail: {
					required: "Пожалуйста, укажите Ваш электронный адрес (e-mail)."
				},
				p_login: {
					required: "Пожалуйста, укажите логин сотрудника."
				},
				p_pass: {
					required: "Пожалуйста, укажите пароль сотрудника."
				}
			},
			submitHandler: function(form) {
				jQuery(form).ajaxSubmit(options);
				//////////////////////
				if ($("#p_agency").val() != $("#p_logged_a").val() ){
					var infotext = "Вы не можете добавлять сотрудников вне своего подразделения.";
					$("#f_prpt_manipulation").prepend(infohtml);
					$("#f_prpt_manipulation").find("#infomessage div:first-child").text(infotext).fadeIn("fast");
					removeMessageBox();
					return false;
				}
				var obj_update = {
					"name":  $("#p_lastname").val() + " " + $("#p_ferstname").val() + " " +$("#p_secondname").val(),
					"role": 1,
					"login": $("#p_login").val(),
					"password": hex_md5($("#p_pass").val()),
					"type_group": 11,
					"parent_group": $("#p_agency").val(),
					"moderated": "N",
					"blocked": "N"
				};
				$.post("../_scriptsphp/participant_reg.php", {
					parameter: "insert",
					json_obj: $.toJSON(obj_update)
				}, function(json){
					$("#f_prpt_manipulation").dialog('close');
				});
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
/*	валидация формы обновления	*/
		var u_econtainer = $('#ec_for_update');
		var validator = $("#new-participant").validate({
			ignore: ".ignore",
			rules: {
				p_ferstname: {
					required: true
				},
				p_secondname: {
					required: true
				},
				p_lastname: {
					required: true
				},
				/*p_mail: {
					required: true
				},*/
				p_login: {
					required: true
				}
			},
			messages: {
				p_ferstname: {
					required: "Пожалуйста, введите имя."
				},
				p_secondname: {
					required: "Пожалуйста, введите отчество."
				},
				p_lastname: {
					required: "Пожалуйста, введите фамилию."
				},
				/*p_mail: {
					required: "Пожалуйста, укажите Ваш электронный адрес (e-mail)."
				},*/
				p_login: {
					required: "Пожалуйста, укажите логин сотрудника."
				}
			},
			submitHandler: function(form) {
				jQuery(form).ajaxSubmit(options);
				//////////////////////
				if ($("#p_agency").val() != $("#p_logged_a").val() ){
					var infotext = "Вы не можете добавлять сотрудников вне своего подразделения.";
					$("#f_prpt_manipulation").prepend(infohtml);
					$("#f_prpt_manipulation").find("#infomessage div:first-child").text(infotext).fadeIn("fast");
					removeMessageBox();
					return false;
				}
				var obj_update = {
					"name":  $("#p_lastname").val() + " " + $("#p_ferstname").val() + " " +$("#p_secondname").val(),
					"role": 1,
					"login": $("#p_login").val(),
					"password": hex_md5($("#p_pass").val()),
					"type_group": 11,
					"parent_group": $("#p_agency").val(),
					"moderated": "N",
					"blocked": "N"
				};
				$.post("../_scriptsphp/participant_reg.php", {
					parameter: "insert",
					json_obj: $.toJSON(obj_update)
				}, function(json){
					$("#f_prpt_manipulation").dialog('close');
				});
				//////////////////////
				return false;
			},
			success: function(label){
				label.parent().remove();
			},
			errorContainer: u_econtainer,
			errorLabelContainer: $("ol", u_econtainer),
			wrapper: 'li',
			errorElement: "p",
			onkeyup: false,
			onfocusout: false,
			onclick: false
		});
/* конец валидации формы обновления		*/
	});
	function fillAgency(element)  {
		$.getJSON("../_scriptsphp/participant_reg.php", {
			parameter: "agency"
		}, function(json){
			$('#' + element).fillSelect(json).removeAttr("disabled");
		});
	}
	/*function showResponseParticipants(responseText, statusText)  {
	$("#f_prpt_manipulation").dialog('close');
	//$('#pfb_body').removeClass('show').addClass('hide');
	//$('#pfb_response').removeClass('hide').addClass('show');
	};*/
</script>