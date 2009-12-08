<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Регистрация пользователя</title>
	</head>
	<body>
		<div id="inv-message" class="textondiv"><span class="red redline">В настоящее время регистрация доступна только по коду приглашения (инвайту).</span>
		</div>
		<div class="econtainer">
			<h4>При заполнении формы регистрации были допущены ошибки, смотрите ниже для уточнения.</h4>
			<ol/>
		</div><br />
		<div id="createpass" class="hide">
			<div class="textondiv">
				Вы испытываете трудности в создании пароля?
				<br/>
				Воспользуйтесь <a href="#" id="genpass" class="genpass link">Генератором паролей</a>
				<br/>
				<br/>
				<textarea id="setpass" class="setpass" name="setpass" rows="3" style="width:150px;text-align:center; overflow:hidden; overflow-y: hidden;overflow-x: hidden;">
				</textarea>
			</div>
		</div>
		<div id="regpage">
			<p>
				<strong>Выберите один из предложенных вариантов, отвечающий Вашей структуре/статусу. </strong>
			</p>
			<form id="regformferst" action="_scriptsphp/fish.php" method="get">
				<label for="radGroupregform1">
					<input id="company" name="radGroupregform1" type="radio" value="company" checked="checked" />Компания, состоящая из нескольких агентств.
				</label>
				<!--<br/>
				<label>
				<input id="agency" name="radGroupregform1" type="radio" value="agency" />Агентство, не имеющее подразделений.
				</label>
				<br/>
				<label>
				<input id="freeagent" name="radGroupregform1" type="radio" value="freeagent" />Свободный агент, работающий на себя.
				</label>
				<br/>
				<label>
				<input id="individual" name="radGroupregform1" type="radio" value="individual" />Частное лицо - не профессиональный риэлтор.
				</label>-->
				<p>
					<input id="next1" name="" type="button" value="Далее &gt;&gt;" />
				</p>
			</form>
		</div>
		<div id="regpage1" class="hide">
			<form id="selcompanystatus" action="_scriptsphp/fish.php" method="get">
				<label for="invite_company">
					Код приглашения:
				</label><br/>
				<input class="inform double" id="invite_company" name="invite_company" type="text" value="" />
				<br/>
				<input id="knownconpany" name="radGroupregform2" type="radio" value="knownconpany" checked="checked" />
				<label for="knownconpany">
					Зарегистрированная компания
				</label>
				<br/>
				<input id="newcompany" name="radGroupregform2" type="radio" value="newcompany" />
				<label for="newcompany">
					Новая компания
				</label>
				<p>
					<input id="back2" name="" type="button" value="&lt;&lt; Назад" /><input id="next2" name="" type="submit" value="Далее &gt;&gt;" />
				</p>
			</form>
		</div>
		<div id="regpage1-0" class="hide">
			<form id="regcompany" action="_scriptsphp/create_company.php" method="get">
				<fieldset>
					<legend>
						<strong>Регистрация новой компании</strong>
					</legend>
					<br/>
					<div>
						<label class="inform" for="n_companyname">
							Название компании:
						</label>
						<input class="inform" id="n_companyname" name="n_companyname" type="text"/>
						<br/>
						<label class="inform" for="inn">
							ИНН:
						</label>
						<input class="inform" name="inn" type="text"/>
						<br/>
						<p>
							<strong>Руководитель компании</strong>
						</p>
						<br/>
						<label class="inform" for="companyleaderferstname">
							Имя:
						</label>
						<input class="inform" name="companyleaderferstname" type="text" />
						<br/>
						<label class="inform" for="companyleadersecondname">
							Отчество:
						</label>
						<input class="inform" name="companyleadersecondname" type="text" />
						<br/>
						<label class="inform" for="companyleaderlastname">
							Фамилия:
						</label>
						<input class="inform" name="companyleaderlastname" type="text" />
						<br/>
						<label class="inform" for="companyleaderphon">
							Контактный телефон:
						</label>
						<input class="inform" name="companyleaderphon" type="text" />
						<br/>
						<label class="inform" for="companyleadermail">
							E-mail:
						</label>
						<input class="inform" name="companyleadermail" type="text" />
						<br/>
						<label class="inform" for="companyleaderlogin">
							Логин:
						</label>
						<input class="inform" name="companyleaderlogin" type="text" />
						<br/>
						<label class="inform" for="companyleaderpassword">
							Пароль:
						</label>
						<input class="inform" id="companyleaderpassword" name="companyleaderpassword" type="text" />
						<br/>
						<label class="inform" for="companyleaderconfpass">
							Подтверждение пароля:
						</label>
						<input class="inform" id="companyleaderconfpass" name="companyleaderconfpass" type="text" />
						<br/>
					</div>
				</fieldset>
				<br/>
				<br/>
				<input id="back3-0" name="" type="button" value="&lt;&lt; Назад" /><input id="next3-0" name="" type="submit" value="Далее &gt;&gt;" />
			</form>
		</div>
		<br/>
		<div id="regpage1-1" class="hide">
			<form id="regsubdivision" action="_scriptsphp/create_sub.php" method="get">
				<fieldset>
					<legend>
						<strong>Регистрация агентства (подразделения компании)</strong>
					</legend>
					<br/>
					<label class="inform" for="companyname">
						Название компании:
					</label>
					<label id="cell" class="hide">
					</label>
					<input id="h_companyname" name="h_companyname" type="hidden" value="" />
					<select id="companyname" class="hide" name="companyname"/>
					<br/>
					<label class="inform" for="subdname">
						Название агентства:
					</label>
					<input class="inform" name="subdname" type="text" />
					<br/>
					<label class="inform" for="subdphon">
						Телефоны агентства:
					</label>
					<input class="inform" name="subdphon" type="text" />
					<br/>
					<label class="inform" for="subemail">
						Эл.почта:
					</label>
					<input class="inform" id="subemail" name="subemail" type="text" />
					<br/>
				</fieldset>
				<br/>
				<fieldset>
					<legend>
						<strong>Регистрация руководителя агентства(подразделения компании)</strong>
					</legend>
					<br/>
					<label class="inform" for="subleaderferstname">
						Имя:
					</label>
					<input class="inform" name="subleaderferstname" type="text" />
					<br/>
					<label class="inform" for="subleadersecondname">
						Отчество:
					</label>
					<input class="inform" name="subleadersecondname" type="text" />
					<br/>
					<label class="inform" for="subleaderlastname">
						Фамилия:
					</label>
					<input class="inform" name="subleaderlastname" type="text" />
					<br/>
					<label class="inform" for="subleaderlogin">
						Логин:
					</label>
					<input class="inform" name="subleaderlogin" type="text" />
					<br/>
					<label class="inform" for="subleaderpassword">
						Пароль:
					</label>
					<input class="inform" id="subleaderpassword" name="subleaderpassword" type="text" />
					<br/>
					<label class="inform" for="subleaderconfpass">
						Подтверждение пароля:
					</label>
					<input class="inform" id="subleaderconfpass" name="subleaderconfpass" type="text" />
					<br/>
				</fieldset>
				<br/>
				<fieldset>
					<legend>
						<strong>Регистрация менеджера агентства (подразделения компании)</strong>
					</legend>
					<br/>
					<label class="inform" for="submenferstname">
						Имя:
					</label>
					<input class="inform" name="submenferstname" type="text" />
					<br/>
					<label class="inform" for="submensecondname">
						Отчество:
					</label>
					<input class="inform" name="submensecondname" type="text" />
					<br/>
					<label class="inform" for="submenlastname">
						Фамилия:
					</label>
					<input class="inform" name="submenlastname" type="text" />
					<br/>
					<label class="inform" for="submenlogin">
						Логин:
					</label>
					<input class="inform" name="submenlogin" type="text" />
					<br/>
					<label class="inform" for="submenpassword">
						Пароль:
					</label>
					<input class="inform" id="submenpassword" name="submenpassword" type="text" />
					<br/>
					<label class="inform" for="submenconfpass">
						Подтверждение пароля:
					</label>
					<input class="inform" id="submenconfpass" name="submenconfpass" type="text" />
					<br/>
				</fieldset>
				<br/>
				<input id="back3-1" name="" type="button" value="&lt;&lt; Назад" /><input id="next3-1" name="" type="submit" value="Далее &gt;&gt;" />
			</form>
		</div>
		<div id="regpage2" class="hide">
			<form id="regagency" action="_scriptsphp/fish.php" method="get">
				<label class="inform" for="invite_agency">
					Код приглашения:
				</label>
				<input class="inform" id="invite_agency" name="invite_agency" type="text" value="" />
				<br/>
				<label class="inform" for="agencyname">
					Название агентства:
				</label>
				<input class="inform" name="agencyname" type="text" />
				<br/>
				<label class="inform" for="agencyinn">
					ИНН:
				</label>
				<input class="inform" name="agencyinn" type="text"/>
				<br/>
				<label class="inform" for="agencyphon">
					Телефоны агентства:
				</label>
				<input class="inform" name="agencyphon" type="text" />
				<br/>
				<label class="inform" for="agencymail">
					E-mail:
				</label>
				<input class="inform" name="agencymail" type="text" />
				<br/>
				<br/>
				<fieldset>
					<legend>
						<strong>Регистрация руководителя агентства</strong>
					</legend>
					<br/>
					<label class="inform" for="agencyleaderferstname">
						Имя:
					</label>
					<input class="inform" name="agencyleaderferstname" type="text" />
					<br/>
					<label class="inform" for="agencyleadersecondname">
						Отчество:
					</label>
					<input class="inform" name="agencyleadersecondname" type="text" />
					<br/>
					<label class="inform" for="agencyleaderlastname">
						Фамилия:
					</label>
					<input class="inform" name="agencyleaderlastname" type="text" />
					<br/>
					<label class="inform" for="agencyleaderlogin">
						Логин:
					</label>
					<input class="inform" name="agencyleaderlogin" type="text" />
					<br/>
					<label class="inform" for="agencyleaderpassword">
						Пароль:
					</label>
					<input class="inform" name="agencyleaderpassword" type="text" />
					<br/>
					<label class="inform" for="agencyleaderconfpass">
						Подтверждение пароля:
					</label>
					<input class="inform" name="agencyleaderconfpass" type="text" />
					<br/>
				</fieldset>
				<br/>
				<fieldset>
					<legend>
						<strong>Регистрация менеджера агентства</strong>
					</legend>
					<br/>
					<label class="inform" for="agencymenferstname">
						Имя:
					</label>
					<input class="inform" name="agencymenferstname" type="text" />
					<br/>
					<label class="inform" for="agencymensecondname">
						Отчество:
					</label>
					<input class="inform" name="agencymensecondname" type="text" />
					<br/>
					<label class="inform" for="agencymenlastname">
						Фамилия:
					</label>
					<input class="inform" name="agencymenlastname" type="text" />
					<br/>
					<label class="inform" for="agencymenlogin">
						Логин:
					</label>
					<input class="inform" name="agencymenlogin" type="text" />
					<br/>
					<label class="inform" for="agencymenpassword">
						Пароль:
					</label>
					<input class="inform" name="agencymenpassword" type="text" />
					<br/>
					<label class="inform" for="agencymenconfpass">
						Подтверждение пароля:
					</label>
					<input class="inform" name="agencymenconfpass" type="text" />
					<br/>
					<input id="back4-1" name="" type="button" value="&lt;&lt; Назад" /><input id="next4-1" name="" type="button" value="Далее &gt;&gt;" />
				</fieldset>
			</form>
		</div>
		<div id="end-reg" class="hide">
			Регистрация завершена.
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				var econtainer = $('div.econtainer');
				////первый экран - Выбор типа участника - сейчас нет частников
				$("#next1").click(function(){
					$('#inv-message').addClass('hide');
					var rad_val = $(":radio[name=radGroupregform1]").filter(":checked").val();
					$('#regpage').removeClass('show').addClass('hide');
					switch (rad_val) {
						case 'company':
							$('#regpage1').removeClass('hide').addClass('show');
							break;
						case 'agency':
							$('#regpage2').removeClass('hide').addClass('show');
							$('#createpass').removeClass('hide').addClass('show');
							break;
						default:

					}
				});
				////второй экран - Выбор компании (зарегистрированная/новая)
				var valid_invcompany = $("#selcompanystatus").validate({
					rules: {
						invite_company: {
							required: true,
							remote: {
								url: "../_scriptsphp/check_invite.php",
								type: "post",
								data: {
									invite: function() {
										return $("#invite_company").val();
									}
								}
							}
						}
					},
					messages: {
						invite_company: {
							required: "Пожалуйста, введите Ваш \"Код приглашения\".",
							remote: "Код приглашения не прошел проверку, попробуйте снова."
						}
					},
					submitHandler: function(form){
						jQuery(form).ajaxSubmit({
							resetForm: true
						});
						rad_val = $(":radio[name=radGroupregform2]").filter(":checked").val();
						$('#regpage1').removeClass('show').addClass('hide');
						switch (rad_val) {
							case 'knownconpany':
								$.getJSON("_scriptsphp/getcompany.php", function(json){
									$('#companyname').fillSelect(json).attr('disabled', '').removeClass('hide').addClass('show inform');
								});
								$('#regpage1-1').removeClass('hide').addClass('show');
								break;
							case 'newcompany':
								$('#regpage1-0').removeClass('hide').addClass('show');
								break;
							default:

						}
						$('#createpass').removeClass('hide').addClass('show');
						return false;
					},
					errorContainer: econtainer,
					errorLabelContainer: $("ol", econtainer),
					wrapper: 'li',
					errorElement: "p",
					onkeyup: false,
					onfocusout: false,
					onclick: false

				});
				///////////
				//                $("#next2").click(function(){
				//
				//                    return false;
				//                });
				/// возвращение на 1 экран
				$("#back2").click(function(){
					$('#regpage1').removeClass('show').addClass('hide');
					$('#regpage').removeClass('hide').addClass('show');
					valid_invcompany.resetForm();
					return false;
				});
				//// возвращение из регистрации новой компании на экран выбора типа компании
				$("#back3-0").click(function(){
					$('#createpass').removeClass('show').addClass('hide');
					$('#regpage1-0').removeClass('show').addClass('hide');
					$('#regpage1').removeClass('hide').addClass('show');
					valid_company.resetForm();
					return false;
				});
				/////////
				// валидация регистрации новой компании
				var valid_company = $("#regcompany").validate({
					rules: {
						n_companyname: "required",
						inn: {
							required: true,
							minlength: 4
						},
						companyleaderferstname: "required",
						companyleadersecondname: "required",
						companyleaderlastname: "required",
						companyleaderphon: "required",
						companyleadermail: {
							required: true,
							email: true
						},
						companyleaderlogin: "required",
						companyleaderpassword: {
							required: true,
							minlength: 5
						},
						companyleaderconfpass: {
							required: true,
							minlength: 5,
							equalTo: "#companyleaderpassword"
						}
					},
					messages: {
						n_companyname: {
							required: "Пожалуйста, введите название Вашей компании."
						},
						inn: {
							required: "Пожалуйста, введите ИНН компании."
						},
						companyleaderferstname: {
							required: "Пожалуйста, введите имя руководителя компании."
						},
						companyleadersecondname: {
							required: "Пожалуйста, введите отчество руководителя компании."
						},
						companyleaderlastname: {
							required: "Пожалуйста, введите фамилию руководителя компании."
						},
						companyleaderphon: {
							required: "Пожалуйста, укажите телефон руководителя компании."
						},
						companyleadermail: {
							required: "Пожалуйста, укажите Ваш электронный адрес (e-mail).",
							email: "Пожалуйста, укажите правильный электронный адрес (e-mail)."
						},
						companyleaderlogin: {
							required: "Пожалуйста, создайте логин для входа в систему."
						},
						companyleaderpassword: {
							required: "Пожалуйста, создайте пароль для входа в систему."
						},
						companyleaderconfpass: {
							required: "Пожалуйста, повторите пароль."
						}
					},
					submitHandler: function(form){
						jQuery(form).ajaxSubmit();
						$('#regpage1-0').removeClass('show').addClass('hide');
						$('#regpage1-1').removeClass('hide').addClass('show');
						var str = $("input[name='n_companyname']").val();
						if (str == "") {
							$.getJSON("_scriptsphp/getcompany.php", function(json){
								$('#companyname').fillSelect(json).attr('disabled', '');
							});
							$('#companyname').removeClass('hide').addClass('show inform');
						}
						else {
							$('#cell').removeClass('hide').addClass('show inform').text(str);
							$("#h_companyname").val(str);
						}
						return false;
					},
					errorContainer: econtainer,
					errorLabelContainer: $("ol", econtainer),
					wrapper: 'li',
					errorElement: "p",
					onkeyup: false,
					onfocusout: false,
					onclick: false

				});
				//                $("#companyleaderpassword").blur(function(){
				//                    $("#companyleaderconfpass").valid();
				//                });
				///////////
				/////валидация регистрации подразделения компании
				var valid_subdivision = $("#regsubdivision").validate({
					rules: {
						subdname: {
							required: true,
							minlength: 5
						},
						subdphon: "required",
						subemail:{
							required: true,
							email: true
						},
						subleaderferstname: "required",
						subleadersecondname: "required",
						subleaderlastname: "required",
						subleaderlogin: "required",
						subleaderpassword: {
							required: true,
							minlength: 8
						},
						subleaderconfpass: {
							required: true,
							minlength: 8,
							equalTo: "#subleaderpassword"
						},
						submenferstname: "required",
						submensecondname: "required",
						submenlastname: "required",
						submenlogin: "required",
						submenpassword: {
							required: true,
							minlength: 8
						},
						submenconfpass: {
							required: true,
							minlength: 8,
							equalTo: "#submenpassword"
						}
					},
					messages: {
						subdname: {
							required: "Пожалуйста, введите название подразделения."
						},
						subdphon: {
							required: "Пожалуйста, введите телефоны."
						},
						subemail:{
							required: "Пожалуйста, укажите электронный адрес (e-mail) агентства.",
							email: "Пожалуйста, укажите правильный электронный адрес (e-mail)."
						},
						subleaderferstname: {
							required: "Пожалуйста, введите имя руководителя подразделения."
						},
						subleadersecondname: {
							required: "Пожалуйста, введите отчество руководителя подразделения"
						},
						subleaderlastname: {
							required: "Пожалуйста, введите фамилию руководителя подразделения"
						},
						subleaderlogin: {
							required: "Пожалуйста, создайте логин руководителя подразделения."
						},
						subleaderpassword: {
							required: "Пожалуйста, создайте пароль руководителя подразделения."
						},
						subleaderconfpass: {
							required: "Пожалуйста, подтвердите пароль руководителя подразделения."
						},
						submenferstname: {
							required: "Пожалуйста, введите имя менеджера подразделения."
						},
						submensecondname: {
							required: "Пожалуйста, введите отчество менеджера подразделения."
						},
						submenlastname: {
							required: "Пожалуйста, введите фамилию менеджера подразделения."
						},
						submenlogin: {
							required: "Пожалуйста, создайте логин менеджера подразделения."
						},
						submenpassword: {
							required: "Пожалуйста, создайте пароль менеджера подразделения."
						},
						submenconfpass: {
							required: "Пожалуйста, подтвердите пароль менеджера подразделения."
						}
					},
					submitHandler: function(form){
						$(form).ajaxSubmit();
						$('#regpage1-1').removeClass('show').addClass('hide');
						$('#createpass').removeClass('show').addClass('hide');
						$('#end-reg').removeClass('hide').addClass('show');
						return false;
					},
					errorContainer: econtainer,
					errorLabelContainer: $("ol", econtainer),
					wrapper: 'li',
					errorElement: "p",
					onkeyup: false,
					onfocusout: false,
					onclick: false
				});
				//                $("#subleaderpassword").blur(function(){
				//                    $("#subleaderconfpass").valid();
				//                });
				//                $("#submenpassword").blur(function(){
				//                    $("#submenconfpass").valid();
				//                });
				//////////////////////
				/*	$("#next3-1").click(function()
				{
				alert ($("#h_companyname").val());
				alert ($("#companyname option:selected").text());
				return false;
				});*/
				$("#back3-1").click(function(){
					$('#createpass').removeClass('show').addClass('hide');
					$('#cell').removeClass('show inform').addClass('hide');
					$('#companyname').removeClass('show inform').addClass('hide');
					$('#regpage1-1').removeClass('show').addClass('hide');
					$('#regpage1').removeClass('hide').addClass('show');
					valid_subdivision.resetForm();
					return false;
				});
				$("#back4-1").click(function(){
					$('#createpass').removeClass('show').addClass('hide');
					$('#regpage2').removeClass('show').addClass('hide');
					$('#regpage').removeClass('hide').addClass('show');
					return false;
				});
			});
		</script>
	</body>
</html>
