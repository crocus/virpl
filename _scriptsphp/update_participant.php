<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Обновление данных пользователя системы</title>
	</head>
	<body>
		<div id="f_prpt_update" style="padding:0px;">
			<div style="padding:5px;"><form id="update-participant" name="update-participant" action="_scriptsphp/fish.php" method="get">
					<div class="econtainer">
						<h4>При внесениии изменений в профиль были допущены ошибки, смотрите ниже для уточнения.</h4>
						<ol/>
					</div>
					<label for="p_agency" class="minform">Агентство:</label><select id="p_agency" name="p_agency" class="inform" size="1"/><br />
					<input id="p_logged_a" name="p_logged_a" type="hidden" value="" />
					<label for="p_lastname" class="minform">Фамилия:</label><input type="text" id="p_lastname" name="p_lastname" class="inform"/><br />
					<label for="p_ferstname" class="minform">Имя:</label><input type="text" id="p_ferstname" name="p_ferstname" class="inform"/><br />
					<label for="p_secondname" class="minform">Отчество:</label><input type="text" id="p_secondname" name="p_secondname" class="inform"/><br />
					<label for="p_phon" class="minform">Телефоны:</label><input type="text" id="p_phon" name="p_phon" class="inform"/><br />
					<label for="p_show_phon" class="minform">Показывать телефоны:</label><input type="checkbox" id="p_show_phon" name="p_show_phon"/><br />
					<label for="p_mail" class="minform">Электронная почта:</label><input type="text" id="p_mail" name="p_mail" class="inform"/><br />
					<label for="p_login" class="minform">Логин:</label><input type="text" id="p_login" name="p_login" class="inform"/><br />
					<label for="p_pass" class="minform">Пароль:</label><input type="text" id="p_pass" name="p_pass" class="inform"/><br />
				</form></div></div><br />
	</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){
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
		var options = {
			target: "#prpt_response",
			//success: showResponseParticipants,
			resetForm: true,
			timeout: 3000 // тайм-аут
		};
		var econtainer = $('div.econtainer');
		var validator = $("#update-participant").validate({
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
	});
	/*function showResponseParticipants(responseText, statusText)  {
			$("#f_prpt_manipulation").dialog('close');
		 //$('#pfb_body').removeClass('show').addClass('hide');
			 //$('#pfb_response').removeClass('hide').addClass('show');
	};*/
</script>