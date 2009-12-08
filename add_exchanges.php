<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require_once ('_scriptsphp/r_conn.php');
require_once ('_scriptsphp/services.php');
require_once ("_scriptsphp/getOutside.php");
?>
<?php
$prpt_id = $_COOKIE["inquery"];
if (isset ($prpt_id) && !empty ($prpt_id)) {
	$query_Agent = "SELECT n.UUID as Id, n.Name_Node as Name FROM node n WHERE n.participants_id = $prpt_id AND n.Status_Group in (11,12)\n"
		. "UNION SELECT fn.UUID, fn.Name_Node FROM node n \n"
		. "INNER JOIN node fn on fn.parents_id = n.participants_id WHERE fn.parents_id = $prpt_id AND fn.Status_Group in (11,12)\n"
		. "UNION SELECT ln.UUID, ln.Name_Node FROM (SELECT fn.participants_id, fn.Name_Node FROM node n \n"
		. "INNER JOIN node fn on fn.parents_id = n.participants_id WHERE fn.parents_id = $prpt_id ) AS g \n"
		. "INNER JOIN node ln on ln.parents_id = g.participants_id AND ln.Status_Group in (11,12)";
	$Agent = mysql_query($query_Agent, $realtorplus) or die(mysql_error());
	$row_Agent = mysql_fetch_assoc($Agent);
}
?>
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Владивостокский Информационный Риэлторский Портал - добавление варианта обмена</title>
<link rel="shortcut icon" href="http://foliant/realtorplus.ico" />-->
<body>
	<div id="add-exchange-request" style=" padding-left:10px;">
		<form  name="add_advert_form" id="add_advert_form" action="_scriptsphp/service_tb.php" method="post">
			<input type="hidden" name="MM_insert" value="add_advert_form" />
			<p> <span class="redline">Все поля формы, обязательны к заполнению.</span></p>
			<label class="label" style="font-size:medium;"><span class="red">*</span>Формула</label>
			<br />
			<input type="text" name="formula" id="formula"/>
			<label for="formula"></label>
			<br />
			<span class="red redline textondiv">Порядок написания формулы! В длинной части (&quot;1+г+допл&quot;), сначала указываем объект большей площади, затем меньшей, и в заключении, если необходимо, доплата.<br/>
				Например: <br/>
				если Вы разъезжаетесь - 4=1+г+допл <br/>
				или съезжаетесь - 2+1+допл=4<br/>
				Гостинки - г, дома - д, подселения - подс, доплата - допл.</span> <br />
			<label for="description" class="label" style="font-size:medium;"><span class="red">*</span>Описание</label>
			<br/>
			<textarea name="description"  style="width:410px; height:100px;" id="description"></textarea>
			<p>
				<label class="label" style="font-size:medium;"><strong>Фотографии</strong></label><br />
				<span class="delineation">Размер фотографии должен быть <span class="red">не более 2Мб.</span></span>
			</p><div id="example3" style="width:410px; clear:both">
				<div class="textondiv" style="border: 1px solid #8B8B8B;">
					<div class="tags" style="margin-top: 5px"> <label for="images_newlabel_">На фотографии:&nbsp;</label>
						<select name="tag" id="images_newlabel_" >
							<option value="" selected="selected" >Выберите...</option>
							<option value="Дом снаружи">Дом снаружи</option>
							<option value="Вид из окна">Вид из окна</option>
							<option value="Интерьер">Интерьер</option>
							<option value="План квартиры">План квартиры</option>
						</select>
					</div>
					<div style="margin-top: 5px">
						<input id="button1" name="button1"  type="button" value="Добавить фотографию" style="width:167; height:22"/>
						<input id="filepath_u" name="filepath_u" type="hidden" value="" />
					</div>
				</div>
				<br />
				<div class="upload-layer">
					<p style="padding-left:25px;">Загруженные фотографии:</p>
					<ul id="image_list" class="files">
					</ul>
				</div>
			</div>
			</p><br/>
			<div id="exchange-logged" class="hide">
				<label for="agent_cod">Агент:&nbsp;</label><select name="agent_cod">
					<?php
					do {
						?>
					<option value="<?php echo $row_Agent['Id'] ?>" <?php if (!(strcmp($row_Agent['Id'], $row_Agent['Id']))) {echo "SELECTED";}?>><?php echo $row_Agent['Name'] ?></option>
					<?php
					} while ($row_Agent = mysql_fetch_assoc($Agent));
					?>
				</select >
			</div>
			<div id="exchange-unlogged" >
				<?php
				echo $iscontact;
				?>
			</div><br/>
			<div id="iscapture" class="show">
				<?php
				echo $capture;
				?>
			</div>
			<div class="private-traider"><?php
				echo $confirm;
				?></div>
			<div class="econtainer">
				<h4>При размещении объявления были допущены ошибки, смотрите ниже для уточнения.</h4>
				<ol/>
			</div>
			<input id="button_add_advert" name="button_add_advert" type="submit" value="Добавить объявление"/>
			<input type="hidden" name="action" value="submitted" />
		</form>
		<?php
		//}
		?>
	</div>
	<br />
</body>
<script type="text/javascript">
	$(document).ready(function(){
		var econtainer = $('div.econtainer');
		reloadImage("#capture_image");
		$.getJSON("../_scriptsphp/session_var.php", function(json){
			var use = json.use;
			if(use == 1){
				//				$("").hide();
				$('#exchange-logged').removeClass("hide").addClass("show");
				$('#exchange-unlogged, #iscapture, div.private-traider').removeClass("show").addClass("hide");
			}
		});
		simple_tooltip("#capture_image","tooltip");
		$("#capture_image").click( function(){
			reloadImage("#capture_image");
			return false;
		});
		var options = {
			// beforeSubmit: showRequest, // функция, вызываемая перед передачей
			success: showAnswer, // функция, вызываемая при получении ответа
			resetForm: true,
			timeout: 3000 // тайм-аут
		};
		$("#add_advert_form").validate({
			ignore: ".ignore",
			rules: {
				formula: {
					required: true,
					minlength: 3
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
						data: {
							keystring: function(){
								return $("#keystring").val();
							}
						}
					}
				}
			},
			messages: {
				formula: {
					required: "Пожалуйста, введите формулу.",
					minlength: "Формула обмена не должна содержать менее 3 символов."
				},
				private_trader: {
					required: "К сожалению, если Вы не являетесь частным лицом или несогласны с <a href='#' class=\"agreement\">Пользовательским Соглашением</a>, Вы не можете добавлять объявления на Портале."
				},
				fio: {
					required: "Пожалуйста, укажите Ваши Фамилию Имя Отчество."
				},
				phon: {
					required: "Пожалуйста, укажите телефоны для связи с Вами."
				},
				keystring: {
					required: "Вы допустили ошибку в написании кода.",
					minlength: "Код не может содержать менее 4 символов."
				}
			},
			submitHandler: function(form) {
				jQuery(form).ajaxSubmit(options);
				return false;
			},
			success: function(label){
				label.remove();
			},
			errorContainer: econtainer,
			errorLabelContainer: $("ol", econtainer),
			wrapper: 'li',
			errorElement: "p",
			/* errorPlacement: function(error, element) {
				var er = element.attr("name");
		 error.appendTo( element.parent().find("label[for='" + er + "']"));
		 if (er == 'keystring' ){
		  reloadImage("#capture_image");
		 }
		 },*/
			onkeyup: false,
			onfocusout: false,
			onclick: false
		});
		<!---->
		createImageUploadE();
		<!---->
	});
	function createImageUploadE(){
		var upload_button = $('#button1'), interval;
		var filedir = hex_md5(Date()).substr(10, 8);
		var value = "";
		var filepath = './_tmp/' + filedir + '/';
		var i=0;
		new Ajax_upload(upload_button,{
			action: '_scriptsphp/image_upload.php',
			data: {
				MAX_FILE_SIZE : '2097152'
			},
			name: 'userfile',
			onSubmit : function(file , ext){
				if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
					alert('Вы можете прикреплять к объявлению только файлы изображений.');
					return false;
				}
				if( i > 5){
					alert('Вы можете прикреплять не более 6 (шести)  изображений.');
					return false;
				}
				if(	$("#images_newlabel_").val()==""){
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
				value =  $("#images_newlabel_").val();
				this.setData({'f_description': '' + value + '', 'filedir': '' + filedir + ''});
				$("#filepath_u").val(filepath);
			},
			onComplete : function(file, response){
				upload_button.attr("value","Добавить фотографию");
				window.clearInterval(interval);
				this.enable();
				var filename = filepath + response;
				if (filename.search(/(jpg|png|jpeg|gif)/) !=-1) {
					var image = '<li><div class="upload-container"><div class="elemondiv"><a href="'+ filename +'" rel="lightgallery" ><img src="'+ filename +'" /></a></div><div><span><strong>' + value + '</strong></span><br /><a id="rem_'+ response + '" class="remove_image mlink" href="#">Удалить</a><input class="filename" type="hidden" value="' + filename +'"/></div></div></li>';
					$('#example3 .files').append(image);
					++i;
					$('a[rel*=lightgallery]').lightBox();
				} else {
					alert("Ошибка при загрузке! Возможно размер файла более 2Мб.\nЕсли Вы уверены в корректности файла, Вы можете сообщить об этой ошибке администратору портала с помощью сервиса \"Оставить свой отзыв\".");
				}
			}
		});
	};
	function showAnswer(responseText, statusText)  {
		//$(document).scrollTo(0);
		var infohtml = '<div id="infomessage" class="i-message-big ui-corner-bottom"><div class="textondiv redline"></div></div>';
		if( $('#exchange-logged').hasClass("hide")){
			$(document).find("#a_exchange").prepend(infohtml);
			$('#add-exchange-request').removeClass('show').addClass('hide');
			closeTabOnTimeout();
		} else {
			$(document).find("#a_exchange").append(infohtml);
			$(document).find(".i-message-big").addClass("i-bottom");
			$("#capture_image").trigger('click');
			$('#image_list > li').remove();
			createImageUploadE();
			removeMessageBox();
			getCountPrivate();
		}
		$(document).find("#infomessage div:first-child").html(responseText).fadeIn("fast");
	};
</script>
</html>