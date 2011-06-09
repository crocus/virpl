<?php
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	ob_start("ob_gzhandler");
	require_once ('_scriptsphp/session.inc');
	require_once ("_scriptsphp/getOutside.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	include('_scriptsphp/r_conn.php');
	$query_City = "SELECT city_cod, city_name FROM tbl_city";
	$City = mysql_query($query_City, $realtorplus) or die(mysql_error());
	$row_City = mysql_fetch_assoc($City);

	$query_Street = "SELECT * FROM tbl_street";
	$Street = mysql_query($query_Street, $realtorplus) or die(mysql_error());
	$row_Street = mysql_fetch_assoc($Street);
	$totalRows_Street = mysql_num_rows($Street);

	$query_Plan= "SELECT * FROM tbl_plan";
	$Plan = mysql_query($query_Plan, $realtorplus) or die(mysql_error());
	$row_Plan = mysql_fetch_assoc($Plan);
	$totalRows_Plan = mysql_num_rows($Plan);

	$query_Room= "SELECT * FROM tbl_room";
	$Room = mysql_query($query_Room, $realtorplus) or die(mysql_error());
	$row_Room = mysql_fetch_assoc($Room);
	$totalRows_Room = mysql_num_rows($Room);

	$query_Cond= "SELECT * FROM tbl_cond";
	$Cond = mysql_query($query_Cond, $realtorplus) or die(mysql_error());
	$row_Cond = mysql_fetch_assoc($Cond);
	$totalRows_Cond = mysql_num_rows($Cond);

	$query_Balc= "SELECT * FROM tbl_balcon";
	$Balc = mysql_query($query_Balc, $realtorplus) or die(mysql_error());
	$row_Balc = mysql_fetch_assoc($Balc);
	$totalRows_Balc = mysql_num_rows($Balc);

	$query_Mat= "SELECT * FROM tbl_material";
	$Mat = mysql_query($query_Mat, $realtorplus) or die(mysql_error());
	$row_Mat = mysql_fetch_assoc($Mat);
	$totalRows_Mat = mysql_num_rows($Mat);

	$query_WC= "SELECT * FROM tbl_wc";
	$WC = mysql_query($query_WC, $realtorplus) or die(mysql_error());
	$row_WC = mysql_fetch_assoc($WC);
	$totalRows_WC = mysql_num_rows($WC);

	$query_Sale= "SELECT * FROM tbl_sale";
	$Sale = mysql_query($query_Sale, $realtorplus) or die(mysql_error());
	$row_Sale = mysql_fetch_assoc($Sale);
	$totalRows_Sale = mysql_num_rows($Sale);

	$query_Project= "SELECT * FROM tbl_project";
	$Project = mysql_query($query_Project, $realtorplus) or die(mysql_error());
	$row_Project = mysql_fetch_assoc($Project);


	$query_Type= "SELECT * FROM tbl_type";
	$Type = mysql_query($query_Type, $realtorplus) or die(mysql_error());
	$row_Type = mysql_fetch_assoc($Type);
	$totalRows_Type = mysql_num_rows($Type);

	$query_Side= "SELECT * FROM tbl_side";
	$Side = mysql_query($query_Side, $realtorplus) or die(mysql_error());
	$row_Side = mysql_fetch_assoc($Side);
	$totalRows_Side = mysql_num_rows($Side);

	$prpt_id =  $_COOKIE["inquery"];
	if(isset($prpt_id) && !empty($prpt_id)) {
		// $query_param = "SELECT UUID as Id, Name_Node as Name FROM node WHERE Status_Group = 11";
		$query_Agent = "SELECT n.UUID as Id, n.Name_Node as Name FROM node n WHERE n.participants_id = $prpt_id AND n.Status_Group in (11,12)\n"
		. "UNION SELECT fn.UUID, fn.Name_Node FROM node n \n"
		. "INNER JOIN node fn on fn.parents_id = n.participants_id WHERE fn.parents_id = $prpt_id AND fn.Status_Group in (11,12)\n"
		. "UNION SELECT ln.UUID, ln.Name_Node FROM (SELECT fn.participants_id, fn.Name_Node FROM node n \n"
		. "INNER JOIN node fn on fn.parents_id = n.participants_id WHERE fn.parents_id = $prpt_id ) AS g \n"
		. "INNER JOIN node ln on ln.parents_id = g.participants_id AND ln.Status_Group in (11,12)";

		/*$query_Agent= "SELECT UUID AS agent_cod, Name_Node AS agent_name
		FROM node
		WHERE Status_Group
		IN ( 11 )";*/
		$Agent = mysql_query($query_Agent, $realtorplus) or die(mysql_error());
		$row_Agent = mysql_fetch_assoc($Agent);
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>virpl.ru</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<div id="output"></div>
		<div id="aa-request" class="dintab">
			<form id="add_ro_form" action="_scriptsphp/service_tb.php" method="post">
				<table id="t_advert" style="width:410px;">
					<tr>
						<td align="right" style="white-space:nowrap;">Населенный пункт:</td>
						<td style="width:70%;"><select id="city" name="city_cod" class="in-td">
								<?php
									do {
									?>
									<option value="<?php echo $row_City['city_cod']?>" ><?php echo $row_City['city_name']?></option>
									<?php
									} while ($row_City = mysql_fetch_assoc($City));
								?>
							</select></td>
					</tr>
					<!--                    <tr  valign="baseline">
					<td align="right" >Улица:</td>
					<td style="width:70%;"><select id="street" name="street_cod"  disabled="disabled" class="in-td"/>
					</td>
					</tr>-->
					<tr  valign="baseline">
						<td align="right"> Улица:</td>
						<td><input type="text" id="streetAuto" name="streetauto" class="in-td" style="width:89%;"/>
						&nbsp;<img id="faq" src="../_images/question-frame.png" width="16" height="16" alt="" style="vertical-align:middle;" title="Отсутствует улица или не появляется 'список'?<br/>Кликни по значку!"/>
							<input type="hidden" id="streetId" name="street_cod" />
							<span style="font-size:smaller;">(выбирается <span class="red">только</span> из списка, список появляется при наборе двух и более букв)</span></td>
					</tr>
					<tr valign="baseline">
						<td align="right" >Номер дома:</td>
						<td><input type="text" id="building_id" name="building_id" style="width:30%;" value=""/></td>
					</tr>
					<tr valign="baseline">
						<td align="right" >Тип объекта:</td>
						<td><select id="type_cod" name="type_cod" class="in-td">
								<?php
									do {
									?>
									<option value="<?php echo $row_Type['type_cod']?>"><?php echo $row_Type['type_s']?></option>
									<?php
									} while ($row_Type = mysql_fetch_assoc($Type));
								?>
							</select></td>
					</tr>
					<tr valign="baseline">
						<td align="right" >Вид продажи:</td>
						<td style="width:70%;"><select class="in-td" id="sale_cod" name="sale_cod">
								<?php
									do {
									?>
									<option value="<?php echo $row_Sale['sale_cod']?>" ><?php echo $row_Sale['sale_name']?></option>
									<?php
									} while ($row_Sale = mysql_fetch_assoc($Sale));
								?>
							</select></td>
					</tr>
					<tr valign="baseline">
						<td align="right">Количество комнат:</td>
						<td style="width:70%;"><select id="room_cod" name="room_cod" class="in-td">
								<?php
									do {
									?>
									<option value="<?php echo $row_Room['room_cod']?>"><?php echo $row_Room['room_short']?></option>
									<?php
									} while ($row_Room = mysql_fetch_assoc($Room));
								?>
							</select></td>
					</tr>
					<tr>
						<td align="right" >Проект здания:</td>
						<td style="width:70%;">
							<select class="in-td" id="project_cod" name="project_cod">
								<?php
									do {
									?>
									<option value="<?php echo $row_Project['project_cod']?>" ><?php echo $row_Project['project_name']?></option>
									<?php
									} while ($row_Project = mysql_fetch_assoc($Project));
								?>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<td align="right" >Площади,(So/Sж/Sk):</td>
						<td style="width:30%;"><div>
								<input  style="width:30%;"  type="text" id="so" name="so" value="" size="5" />
								<input style="width:30%;" type="text" id="sz" name="sz" value="" size="3" />
								<input style="width:30%;"  type="text" id="sk" name="sk" value="" size="2" />
							</div></td>
					</tr>
					<tr valign="baseline">
						<td align="right" style="white-space:nowrap;">Этаж/Этажность:</td>
						<td style="white-space:nowrap;width:30%;"><input style="width:47%;" type="text" id="flats_floor" name="flats_floor" value="" />
							<input style="width:47%;" type="text" id="flats_floorest" name="flats_floorest" value="" /></td>
					</tr>
					<tr valign="baseline">
						<td align="right" style="white-space:nowrap;">Материал постройки:</td>
						<td style="width:70%;"><select id="material_cod" name="material_cod" class="in-td">
								<?php
									do {
									?>
									<option value="<?php echo $row_Mat['material_cod']?>" ><?php echo $row_Mat['material_name']?></option>
									<?php
									} while ($row_Mat = mysql_fetch_assoc($Mat));
								?>
							</select></td>
					</tr>
					<tr valign="baseline">
						<td align="right" >Планировка:</td>
						<td ><select id="plan_cod" name="plan_cod" class="in-td">
								<?php
									do {
									?>
									<option value="<?php echo $row_Plan['plan_cod']?>"><?php echo $row_Plan['plan_name']?></option>
									<?php
									} while ($row_Plan = mysql_fetch_assoc($Plan));
								?>
							</select></td>
					</tr>
					<tr>
						<td align="right">Санузел:</td>
						<td style="width:70%;"><select id="wc_cod" name="wc_cod" class="in-td">
								<?php
									do {
									?>
									<option value="<?php echo $row_WC['wc_cod']?>"><?php echo $row_WC['wc_name']?></option>
									<?php
									} while ($row_WC = mysql_fetch_assoc($WC));
								?>
							</select></td>
					</tr>
					<tr>
						<td align="right">Балкон/лоджия:</td>
						<td style="width:70%;"><select id="balcon_cod" name="balcon_cod" class="in-td">
								<?php
									do {
									?>
									<option value="<?php echo $row_Balc['balcon_cod']?>" ><?php echo $row_Balc['balcon_name']?></option>
									<?php
									} while ($row_Balc = mysql_fetch_assoc($Balc));
								?>
							</select></td>
					</tr>
					<tr>
						<td align="right">Состояние:</td>
						<td style="width:70%;"><select id="cond_cod" name="cond_cod" class="in-td">
								<?php
									do {
									?>
									<option value="<?php echo $row_Cond['cond_cod']?>"><?php echo $row_Cond['cond_name']?></option>
									<?php
									} while ($row_Cond = mysql_fetch_assoc($Cond));
								?>
							</select></td>
					</tr>
					<tr>
						<td align="right">Сторона света:</td>
						<td style="width:70%;"><select id="side_cod" name="side_cod" class="in-td">
								<?php
									do {
									?>
									<option value="<?php echo $row_Side['side_cod']?>"><?php echo $row_Side['side_name']?></option>
									<?php
									} while ($row_Side = mysql_fetch_assoc($Side));
								?>
							</select></td>
					</tr>
					<tr>
						<td align="right" style="white-space:nowrap;">Ипотека:</td>
						<td><input  type="checkbox" id="mortgage-chance" name="mortgage-chance" value="" /></td>
					</tr>
					<tr>
						<td align="right" style="white-space:nowrap;"></td>
						<td><input  type="checkbox" id="kind-flats-price" name="kind-flats-price" value="" />за квадратный метр</td>
					</tr>
					<tr>
						<td align="right" style="white-space:nowrap;">Цена объекта:</td>
						<td><input class="in-td" style="width:75%;" type="text" name="flats_price" value="" />
							<select name="currency" id="currency" size="1">
								<option value="0">руб.</option>
								<option value="1">$</option>
								<option value="2">euro</option>
							</select>    
						</td>
					</tr>
					<tr>
						<td align="right" style="white-space:nowrap;">Телефон:</td>
						<td><input  type="checkbox" id="flats_tel" name="flats_tel" value="" /></td>
					</tr>	
					<tr id="logged" class="logged hide">
						<td align="right" valign="top" style="white-space:nowrap;">Агент:</td>
						<td colspan="2" valign="top"><select name="agent_cod">
								<?php
									if(isset($prpt_id) && !empty($prpt_id)) {
										do {
										?>
										<option value="<?php echo $row_Agent['Id']?>" <?php if (!(strcmp($row_Agent['Id'], $row_Agent['Id']))) {echo "SELECTED";} ?>><?php echo $row_Agent['Name']?></option>
										<?php
										} while ($row_Agent = mysql_fetch_assoc($Agent));
									}
								?>
							</select ></td>
					</tr>
					<tr class="logged hide">
						<td align="right" valign="top" style="white-space:nowrap;">Телефон агента:</td>
						<td colspan="2" valign="top" ><input type="text" id="agent_phon" name="agent_phon" style="width:100%;"/></td>
					</tr>
					<tr>
						<td align="right" style="white-space:nowrap;">Примечание:</td>
						<td></td>
					</tr>
					<tr valign="baseline">
						<td colspan="2" valign="top" ><textarea name="flats_comments" cols="47" rows="5" style="width: 100%;"></textarea></td>
					</tr>
					<tr valign="baseline">
						<td colspan="2"><div>
								<p>
									<label class="label" style="font-size:medium;"><strong>Фотографии</strong></label>
									<br />
									<span class="delineation">Размер фотографии должен быть <span class="red">не более 2Мб.</span></span>
								</p>
								<div id="upload_advert" style="width:410px; clear:both">
									<div class="textondiv" style="border: 1px solid #8B8B8B;">
										<div class="tags" style="margin-top: 5px">
											<label for="images_label_advert">На фотографии:&nbsp;</label>
											<select name="tag" id="images_label_advert" >
												<option value="" selected="selected" >Выберите...</option>
												<option value="Дом снаружи">Дом снаружи</option>
												<option value="Вид из окна">Вид из окна</option>
												<option value="Интерьер">Интерьер</option>
												<option value="План квартиры">План квартиры</option>
											</select>
										</div>
										<div style="margin-top: 5px">
											<input id="u_but_advert" name="u_but_advert"  type="button" value="Добавить фотографию" style="width:167; height:22"/>
											<input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
											<input id="filepath_a" name="filepath_a" type="hidden" value="" />
										</div>
									</div>
									<br />
									<div class="upload-layer">
										<p style="padding-left:25px;">Загруженные фотографии:</p>
										<ul id="image_list_advert" class="files"/>
									</div>
								</div>
								<p></p>
							</div></td>
					</tr>
					<tr id="unlogged" class="show">
						<td  colspan="2">
							<?php
								echo $iscontact;
							?>

							<!--<div><label class="label" style="font-size:medium;"><strong>Контактная информация</strong></label><br />
							<label for="aa_fio" class="label"><span class="red">*</span>ФИО:</label>
							<br/>
							<input id="aa_fio" name="aa_fio" type="text" class="inform private-traider"/>
							<br/>
							<label for="aa_phon" class="label"><span class="red">*</span>Телефон:</label>
							<br/>
							<input id="aa_phon" name="aa_phon" type="text" class="inform private-traider"/>
							<br />
							<label for="aa_e_mail" class="label">E-mail:</label>
							<br/>
							<input id="aa_e_mail" name="aa_e_mail" type="text" class="inform"/></div>--></td>
					</tr>
					<tr id="iscapture" class="show" >
						<td colspan="2"><?php
								echo $capture;
						?></td>
					</tr>
					<tr class="private-traider"><td colspan="2"><?php
								echo $confirm;
						?></td></tr>
					<tr valign="baseline">
						<td colspan="2"><div class="econtainer">
								<h4>При заполнении формы были допущены ошибки.</h4>
								<ol/>
							</div></td></tr>
					<tr valign="baseline">
						<td colspan="2"><input type="hidden" name="MM_insert" value="linsert" />
							<input id="add_button" type="submit" value="Добавить объект" />
							<input type="hidden" name="action_a" value="submitted" />
							<input type="hidden" id="isprivate_field" name="isprivate_field" value="<?php echo $_SESSION['id'];?>" /></td>
					</tr>
				</table>

			</form>
		</div>
		<div id="faq_exchange" style="display: none">
			<div id="faq-body" class="textondiv">Если Вы не нашли улицу:
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
	</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){
		var options = {
			//     target: "#infomessage",
			beforeSubmit: showRequest, // функция, вызываемая перед передачей
			success: showResponse, // функция, вызываемая при получении ответа
			resetForm: true,
			timeout: 3000 // тайм-аут
		};
		var econtainer = $('div.econtainer');
		$("#add_ro_form").validate({
			ignore: ".ignore",
			event: "submit",
			rules: {
				street_cod: {
					required: function(element) {
						return ($(element).parent().css('display') != 'none');
					}
				},
				so: {
					required: true,
					maxlength: 5,
					range: [5, 10000]
				},
				flats_floor: {
					required: true
				},
				flats_floorest: {
					required: true
				},
				flats_price: {
					required: true
				},
				private_trader: {
					required: function(element) {
						return ($(element).parent().css('display') != 'none');
					}
				},
				fio: {
					required: function(element) {
						return ($(element).parent().css('display') != 'none');
					}
				},
				phon: {
					required: function(element) {
						return ($(element).parent().css('display') != 'none');
					}
				},
				keystring: {
					required: function(element) {
						return ($(element).parent().css('display') != 'none');
					},
					minlength: 4,
					cache: false,
					remote: {
						url: "./_scriptsphp/process.php",
						type: "post",
						cache: false,
						data: {
							keystring: function(){
								return $("#keystring").val();
							}
						}
					}
				}
			},
			messages: {
				so: {
					required: "Пожалуйста, введите общую площадь объекта.",
					maxlength: "Вы с площадью не ошиблись? Ваш объект не вмещается в рамки нашего портала."
				},
				street_cod:{
					required: "Пожалуйста, укажите улицу ('Улицы' выбираются только из списка, свои не добавляются)."
				},
				flats_floor: {
					required: "Пожалуйста, укажите этаж."
				},
				flats_floorest: {
					required: "Пожалуйста, укажите количество этажей."
				},
				flats_price: {
					required: "Пожалуйста, укажите цену объекта."
				},
				private_trader: {
					required: "К сожалению, если Вы не являетесь частным лицом или несогласны с <a href='#' class=\"agreement\">Пользовательским Соглашением</a>, Вы не можете добавлять объявления на Портале."
				},
				fio: {
					required: "Пожалуйста, укажите Ваши Фамилию Имя Отчество."
				},
				phon: {
					required: "Пожалуйста, укажите телефон(ы) для связи с Вами."
				},
				keystring: {
					required: "Введите код!!!",
					minlength: "Код не может содержать менее 4 символов."
				}
			},
			submitHandler: function(form) {
				jQuery(form).ajaxSubmit(options);
				return false;
			},
			success: function(label){
				//label.parent("div.error").css({'height':'0px'});
				//label.parent("div.error").removeClass("e-border").css({'height':'0px'});
				label.parent().remove();
				// label.parents().find("div.error").append("<span>maza</span>");
				//label.text("Ok");
			},
			errorContainer: econtainer,
			errorLabelContainer: $("ol", econtainer),
			wrapper: 'li',
			errorElement: "p",
			onkeyup: false,
			onfocusout: false,
			onclick: false
		});
		$('#city').change(function(){
			adjustStreet("city", "street");
			var id = $(this).attr("id");
			var name = $("#city option:selected").val();
			$("#streetAuto").removeAttr("value");
			$("#streetId").removeAttr("value");
			ac(id, name);
		}).change();
		function ac(id, name) {
			var random = hex_md5(Date()).substr(10, 8);
			// собственно autocomplete
			// обратите внимание, как я передаю ему id элемента
			$("#streetAuto").autocomplete("../_scriptsphp/street_autocomplit.php", {
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
			$("#streetAuto").result(function(event, data, formatted) {
				if (data){
					$(this).parent().find("#streetId").val(data[1]);
					//$(this).css("background-color","green");
				} 
			});
		}
		if($("#isprivate_field").val()!=""){
			$("tr.private-traider").addClass("hide");
		}
		reloadImage("#capture_image");
		$("#type_cod option:eq(1)").attr('selected', 'selected');
		$.getJSON("../_scriptsphp/session_var.php", function(json){
			var use = json.use;
			if(use == 1){
				$('.logged').removeClass("hide").addClass("show");
				$('#unlogged, #iscapture').removeClass("show").addClass("hide");
				//                $('#iscapture').removeClass("show").addClass("hide");
			}
		});
		$("#type_cod").change(function () {
			var str = "";
			var parameterArray = new Array();
			parameterArray.length = 0;
			parameterArray[0]= "sale_cod";
			parameterArray[1]= "room_cod";
			parameterArray[2]= "so";
			parameterArray[3]= "sk";
			parameterArray[4]= "sz";
			parameterArray[5]= "flats_floor";
			parameterArray[6]= "flats_floorest";
			parameterArray[7]= "material_cod";
			parameterArray[8]= "plan_cod";
			parameterArray[9]= "wc_cod";
			parameterArray[10]= "balcon_cod";
			parameterArray[11]= "cond_cod";
			parameterArray[12]= "side_cod";
			parameterArray[13]= "flats_tel";
			parameterArray[14]= "project_cod";
			parameterArray[15]= "building_id";
			parameterArray[16]= "mortgage-chance";

			/*   var parameterArray = ["sale_cod","room_cod","so","sk","sz","flats_floor","flats_floorest","material_cod","plan_cod","wc_cod","balcon_cod","cond_cod","side_cod","flats_tel"];*/
			$("#t_advert").find(".ignore").removeAttr("disabled").removeClass("ignore");
			$("#type_cod option:selected").each(function () {
				str = $(this).text();
				switch (str) {
					case 'дом':
						parameterArray.length = 0;
						break;
					case 'квартира':
						parameterArray.length = 0;
						break;
					case 'подселение':
						parameterArray.length = 0;
						break;
					case 'офис':
						delete parameterArray[1];
						delete parameterArray[2];
						delete parameterArray[5];
						delete parameterArray[6];
						delete parameterArray[7];
						delete parameterArray[11];
						delete parameterArray[13];
						delete parameterArray[14];
						delete parameterArray[15];
						break;
					case 'строение':
						delete parameterArray[1];
						delete parameterArray[2];
						delete parameterArray[5];
						delete parameterArray[6];
						delete parameterArray[7];
						delete parameterArray[13];
						delete parameterArray[14];
						delete parameterArray[15];
						break;
					case 'производство':
						delete parameterArray[1];
						delete parameterArray[2];
						delete parameterArray[5];
						delete parameterArray[6];
						delete parameterArray[7];
						delete parameterArray[13];
						delete parameterArray[14];
						delete parameterArray[15];
						break;
					case 'торговля':
						delete parameterArray[1];
						delete parameterArray[2];
						delete parameterArray[5];
						delete parameterArray[6];
						delete parameterArray[7];
						delete parameterArray[13];
						delete parameterArray[14];
						delete parameterArray[15];
						break;
					case 'коттедж':
						delete parameterArray[0];
						delete parameterArray[1];
						delete parameterArray[2];
						delete parameterArray[3];
						delete parameterArray[4];
						delete parameterArray[5];
						delete parameterArray[6];
						delete parameterArray[7];
						delete parameterArray[9];
						delete parameterArray[10];
						delete parameterArray[11];
						delete parameterArray[13];
						delete parameterArray[14];
						delete parameterArray[15];
						break;
					case 'под застройку':
						delete parameterArray[2];
						delete parameterArray[15];					
						break;
					case 'дача':
						delete parameterArray[0];
						delete parameterArray[1];
						delete parameterArray[2];
						delete parameterArray[5];
						delete parameterArray[6];
						delete parameterArray[7];
						delete parameterArray[9];
						delete parameterArray[10];
						delete parameterArray[11];
						delete parameterArray[13];
						delete parameterArray[14];
						delete parameterArray[15];
						break;
					default:
						parameterArray.length = 0;
						break;
				}
				$.each(parameterArray, function() {
					if(this!='[object Window]'){
						$("#" + this).addClass("ignore").attr("disabled","disabled");
					}
				});
			});
		}).change();
		simple_tooltip("#capture_image, #faq","tooltip");
		$("#capture_image").live("click", function(){
			reloadImage("#capture_image");
			return false;
		});
		<!---->
		createImageUpload();
		<!---->
		$("#faq").click(function () {
			$("#faq_exchange").toggle();
			var s = $("#faq");
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
			$('#faq_exchange').css(cssObj);
			$('#faq-body').css("background-color", "#FFFFCC");
		});
		var timoutHandler = function () {
			$("#faq_exchange").fadeOut("slow");
		};
		var timeoutId = null;
		$("#faq_exchange").mouseout(function(){
			timeoutId = setTimeout(timoutHandler, 2000);
		}).mouseover(function(){
			clearTimeout(timeoutId);
		});
	});
	function createImageUpload(){
		var upload_button = $('#u_but_advert'), interval;
		var filedir = hex_md5(Date()).substr(10, 8);
		var value = "";
		var filepath = './_tmp/' + filedir + '/';
		var i=0;
		new Ajax_upload(upload_button,{
			action: '_scriptsphp/image_upload.php',
			name: 'userfile',
			//responseType: "json",
			onSubmit : function(file , ext){
				if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
					// extension is not allowed
					alert('Вы можете прикреплять к объявлению только файлы изображений.');
					// cancel upload
					return false;
				}

				if( i > 11){
					alert('Вы можете прикреплять не более 12 изображений.');
					return false;
				}
				if(	$("#images_label_advert").val()==""){
					if (confirm("Вы действительно хотите добавить фотографию без подписи?")) {
					} else {
						return false;
					}
				}
				upload_button.attr("value","Загрузка");
				// If you want to allow uploading only 1 file at time,
				// you can disable upload button
				//this.disable();
				interval = window.setInterval(function(){
					var text = upload_button.val();
					if (text.length < 13){
						upload_button.attr("value", text + '.')
					} else {
						upload_button.attr("value","Загрузка");
					}
				}, 200);
				value =  $("#images_label_advert").val();
				this.setData({'f_description': '' + value + '', 'filedir': '' + filedir + ''});
				$("#filepath_a").val(filepath);
			},
			onComplete : function(file, response){
				upload_button.attr("value","Добавить фотографию");
				window.clearInterval(interval);
				this.enable();
				var filename = filepath + response;
				if (filename.search(/(jpg|png|jpeg|gif)/) !=-1) {
					var image = '<li><div class="upload-container"><div class="elemondiv"><a href="'+ filename +'" rel="lightgallery" ><img src="'+ filename +'" /></a></div><div ><span><strong>' + value + '</strong></span><br /><a id="rem_'+ response + '" class="remove_image mlink" href="#">Удалить</a><input class="filename" type="hidden" value="' + filename +'"/></div></div></li>';
					$('#upload_advert .files').append(image);

					++i;
					$('a[rel*=lightgallery]').lightBox();
				} else {
					alert("Ошибка при загрузке! Возможно размер файла более 2Мб.\nЕсли Вы уверены в корректности файла, Вы можете сообщить об этой ошибке администратору портала с помощью сервиса \"Оставить свой отзыв\".");
				}
			}
		});
	};

	function showRequest(formData, jqForm, options) {
		var queryString = $.param(formData);
//				 alert('Вот что мы передаем: \n\n' + queryString);
		// здесь можно вернуть false чтобы запретить отправку формы;
		// любое отличное от fals значение разрешит отправку формы.
		return true;
	}
	function showResponse(responseText, statusText)  {
		var infohtml = '<div id="infomessage" class="i-message-big ui-corner-bottom"><div class="textondiv redline"></div></div>';
		if( $('.logged').hasClass("hide")){
			$(document).find("#advertis").prepend(infohtml);
			$('#aa-request').removeClass('show').addClass('hide');
			$("#a_capture_image").trigger('click');
			closeTabOnTimeout();
		} else{
			$(document).find("#advertis").append(infohtml);
			$(document).find(".i-message-big").addClass("i-bottom");
			$('#image_list_advert > li').remove();
			createImageUpload();
			removeMessageBox();
			getCountPrivate();
		}
		$(document).find("#infomessage div:first-child").html(responseText).fadeIn("fast");
		$("#type_cod option:eq(1)").attr('selected', 'selected');
		$("#type_cod").change();
		getCount();
	}
</script>
<?php ob_end_flush();?>