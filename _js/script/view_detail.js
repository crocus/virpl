$(".remove_image").live("click", function(){
	that = $(this);
	remove_file = that.next().val();
	if (confirm("Вы действительно хотите удалить фотографию?")) {
		$.getJSON("_scriptsphp/image_delete.php", {
			filename: remove_file,
			action: "del"
		}, function(result){
			if (result.result == 1) {
				that.parents("li").remove();
			}
			else {
				alert("Ошибка при удалении файла! Вы можете сообщить об этой ошибке администратору портала с помощью сервиса \"Оставить свой отзыв\".");
				that.parents("li").remove();
			}
		});
	}

	return false;
});

function showPopup(flat_id){
	$.ajax({
		type: "GET",
		cache: false,
		url: "../../detail_dialog.php",
		data: "id=" + flat_id,
		success: function(response){
			obj = eval("(" + response + ")");
			var hits = $.ajax({
				url: "_scriptsphp/hits.php",
				data: "UUID=" + obj.UUID,
				async: false
			}).responseText;
			hit = eval("(" + hits + ")");
			//	alert(response);
			// var rObject = JSON.parse(response);
			var readyTreat = false;
			if (obj.Source == 0 && obj.Treated == 0) {
				readyTreat = true;
			}
			var back_block ='<div style="clear:both; width:100%; margin: 5px 0; padding: 1px 0;"><img height="16" width="16" class="icon back_to_list_advert" alt="" title="вернуться к списку объектов" src="_images/arrow-curve-180.png"/><a href="#" class="back_to_list_advert mlink" title="назад">вернуться к списку объектов</a></div>';		
			var result = '<div id="_mode-view" class="hide" style="padding: 0 0 5px 5px">Режим:<a href="#mode-view" id="mode-view-switch" title="Режим доступа" style ="padding-left:5px;">Просмотр/Редактирование</a></div>';
			result += back_block;
			result += '<div id="d_container" style="float: left;width: 100%;">';
			result += '<div class="contact"><div class="textondiv"><span style="font-weight:500;">Код объявления:&nbsp;' + obj.UUID.substr(0, 8) + '</span><br />' +
			'<div style="margin: 3px 0 3px;white-space:nowrap; font-size:0.8em;">Добавлено&nbsp;' +
			customDateString(obj.flats_date) +
			'</div><div style="margin: 3px 0 3px; white-space:nowrap; font-size:0.8em;">Просмотров: ' + hit.day +'/'+ hit.all + ' (уникальных: ' + hit.unique + ')</div><span style="color:#222;border-bottom: 1px dotted">Контактная информация</span><br />' +
			'<div style="margin-top: 5px">';
			if (readyTreat) {
				result += obj.Contact +
				'<div style="margin-top: 5px" ><span class="red letter">Получено с сайта.</span><br/><label class="asblock">Вы можете закрепить это объявление за агентом:</label><br/>' +
				'<select id="treat-agent-buy" name="treat-agent" style="width:220px;margin-top: 3px"></select><br/>' +
				'<input id="treat-buy" type="submit" value="Закрепить за агентом" style="margin-top: 3px" /></div>';
			}
			else {
				result += obj.agency_name +
				'<br />E-mail&nbsp;<a href="mailto:' +
				obj.agency_mail +
				'">' +
				obj.agency_mail +
				'</a><br />Телефоны&nbsp;<strong>' +
				obj.phon +
				'</strong>';
			}
			result += '</div></div></div>';
			var count_r = obj.room_cod;
			object_type = "";
			switch (obj.type_s) {
				case 'дом':
				//				object_type = '<span class="mark-field">Вид объекта: </span>';
				if (count_r != 0) {
					object_type += 'Дом, ' + count_r + ' комн.';
				}
				else {
					object_type += 'Дом';
				}
				break;
				case 'квартира':
				//				object_type = '<span class="mark-field">Вид квартиры: </span>';
				//				object_type = "";
				if (count_r != 0) {
					object_type += count_r + '-комнатная';
				}
				else {
					object_type += 'Гостинка';
				}
				break;
				case 'подселение':
				//				object_type = '<span class="mark-field">Вид квартиры: </span>';
				if (count_r != 0) {
					object_type += 'Подселение, ' + count_r + ' комн.';
				}
				else {
					object_type += 'Подселение';
				}
				break;
				case 'офис':
				//				object_type = '<span class="mark-field">Вид помещения: </span>';
				if (count_r != 0) {
					object_type += 'Офис, ' + count_r + ' каб.';
				}
				else {
					object_type += 'Офис';
				}
				break;
				case 'строение':
					//					object_type = '<span class="mark-field">Вид объекта: </span>';
					object_type += 'Отдельностоящее строение';
					break;
				case 'производство':
					//					object_type = '<span class="mark-field">Вид объекта: </span>';
					object_type += 'Производственно-складское помещение';
					break;
				case 'торговля':
					//					object_type = '<span class="mark-field">Вид объекта: </span>';
					object_type += 'Торговое помещение, ';
					break;
				case 'коттедж':
					//					object_type = '<span class="mark-field">Вид объекта: </span>';
					object_type += 'Коттедж, ';
					break;
				case 'под застройку':
					//					object_type = '<span class="mark-field">Вид объекта: </span>';
					object_type += 'Земли поселений (под застройку)';
					break;
				case 'дача':
					//					object_type = '<span class="mark-field">Вид объекта: </span>';
					object_type += 'Садоводческий участок (дача)';
					break;
				default:
					//					object_type = '<span class="mark-field">Вид объекта: </span>';
					object_type += count_r + '-комнатная';
					break;
			}
			onplace = ((obj.region_name == obj.city_name) ? "" : "р-н ") + obj.region_name + ', ' + obj.street_name;
			/*object_place =  '<span class="mark-field">Расположение: </span>' + ((obj.region_name == obj.city_name) ? "" : "р-н ") + obj.region_name + ', ' + obj.street_name + '<br />';
			*/
			object_place =  ' по ул. ' + obj.street_name + ', ' + ((obj.region_name == obj.city_name) ? "" : "р-н ") + obj.region_name;
			object_sale = '<span class="mark-field">Вид продажи: </span>' + obj.sale_name + '<br />';
			(obj.project_name!= '-') ? object_project = '<span class="mark-field">Проект здания: </span>' + obj.project_name + '<br />': object_project="";
			object_square = '<span class="mark-field">Площадь, (кв.м.): </span>' + obj.So;
			(obj.Sz != 0) ? object_square += ' / ' + obj.Sz : object_square += '';
			(obj.Sk != 0) ? object_square += ' / ' + obj.Sk : object_square += '';
			if (obj.flats_floor == 0) {
				obj.flats_floor = 'цоколь';
			}
			object_floor = '<span class="mark-field">Этаж, этажность, материал: </span>' + obj.flats_floor + ' / ' +
			obj.flats_floorest +
			'&nbsp;' +
			obj.material_name.toLowerCase() +
			'<br />';
			(obj.plan_name != 'Не определено') ? object_plan = '<span class="mark-field">Планировка: </span>' + obj.plan_name + '<br />' : object_plan = '';
			(obj.wc_name != 'Не определено') ? object_wc = '<span class="mark-field">Сан. узел: </span>' + obj.wc_name + '<br />' : object_wc = '';
			(obj.balcon_name != 'Не определено') ? object_bulk = '<span class="mark-field">Балкон/лоджия: </span>' + obj.balcon_name + '<br />' : object_bulk = '';
			(obj.cond_name != 'Не определено') ? object_cond = '<span class="mark-field">Состояние: </span>' + obj.cond_name + '<br />' : object_cond = '';
			(obj.side_name != '-') ? object_side = '<span class="mark-field">Сторона света: </span>' + obj.side_name + '<br />' : object_side = '';
			object_price = '<div style="color:#5D2E35;font:bold 1.2em Arial,Verdana,Tahoma; padding: 5px 10px 0;">Цена ' + number_format(obj.flats_price, 0, '.', ' ') + ' руб. (' +
			((obj.kind_calc == 1 || obj.kind_calc == 2) ? '<span style="background-color:#99FF99;">~ ' + obj.flats_price_usd + ' $</span>' :'~ ' + obj.flats_price_usd +' $' ) +
			')</div>';
			result += '<div style="border-bottom: thin solid #2B4558;margin:0 270px 5px 0;padding:0;color:#2B4558"><span style="font: bold 1.3em Arial,Verdana,Tahoma;margin:0;padding:0;">'+object_type + object_place+'</span><br />'+
			object_price + '</div><div style="margin-right:250px;">' +
			//object_type +
			//object_place +
			object_sale +
			object_project +
			object_square +
			'<br />' +
			object_floor +
			object_plan +
			object_wc +
			object_bulk +
			object_cond +
			object_side ;
			//			object_price;
			var commentEmpty = false;
			var object_comments = obj.flats_comments;
			if (object_comments == '' || object_comments == null) {
				object_comments = '';
				commentEmpty = true;
			}
			if (obj.flats_tel == 1) {
				if (!commentEmpty) {
					object_comments += ',&nbsp;';
				}
				object_comments += 'есть телефонная точка.';
			}
			result += '<p><div class="textondiv">' + object_comments + '</div></p></div>';
			if (obj.foto > 0) {
				result += '<div id="gallery" class="gallery"><ul id="gallery_din">';
				//<div style="border-bottom: thin solid #2B4558;margin:0 0 10px;padding:0;color:#2B4558"><h3 style="margin:0;padding:0;">Фотографии</h3></div>
				for (var i = 0; i < obj.foto; i++) {
					result += '<li><a href="./base5.php?id_image=' + flat_id + '&category=0&image=' + i + '" rel="gallery" title="' + onplace + '" ><img src="./base5.php?id_image=' + flat_id + '&category=0&image=' +
					i +
					'&min=1" alt=""/></a></li>';
				}
				result += '</ul></div><br />';
			}
			result += '</div><div id="_redact" class="hide" style="margin-top:10px;">'+
			'<form id="redact-form" name="redact-form" action="http://">' +
			'<label for="r_city" class="inform">Населенный пункт:</label><select id="r_city" name="r_city" class="inform" size="1"/><br />' +
			'<label for="r_street" class="inform">Улица:</label><select id="r_street" name="r_street" class="inform" size="1"/><br />' +
			'<label for="r_type" class="inform">Вид объекта:</label><select id="r_type" name="r_type" class="inform" size="1"/><br />' +
			'<label for="r_room" class="inform">Количество комнат:</label><select id="r_room" name="r_room" class="inform" size="1"/><br />' +
			'<label for="r_sale" class="inform">Вид продажи:</label><select id="r_sale" name="r_sale" class="inform" size="1"/><br />' +
			'<label for="r_project" class="inform">Проект здания:</label><select id="r_project" name="r_project" class="inform" size="1"/><br />' +
			'<label for="r_so" class="inform">Площадь, (кв.м.):</label><input type="text" id="r_so" name="r_so" class="inform trinity"/>' +
			'<input type="text" id="r_sz" name="r_sz" class="inform trinity"/><input type="text" id="r_sk" name="r_sk" class="inform trinity"/><br />' +
			'<label for="r_floor" class="inform">Этаж/Этажей:</label><input type="text" id="r_floor" name="r_floor" class="inform double"/>' +
			'<input type="text" id="r_floorest" name="r_floorest" class="inform double"/><br />' +
			'<label for="r_material" class="inform">Материал постройки:</label><select id="r_material" name="r_material" class="inform" size="1"/><br />' +
			'<label for="r_plan" class="inform">Планировка:</label><select id="r_plan" name="r_plan" class="inform" size="1"/><br />' +
			'<label for="r_cond" class="inform">Состояние:</label><select id="r_cond" name="r_cond" class="inform" size="1"/><br />' +
			'<label for="r_side" class="inform">Сторона света:</label><select id="r_side" name="r_side" class="inform" size="1"/><br />' +
			'<label for="r_phon" class="inform">Телефонная точка:</label><input type="checkbox" id="r_phon" name="r_phon"/><br />' +
			'<label for="r_price" class="inform">Цена:</label><input type="text" id="r_price" name="r_price" class="inform"/><br />' +
			'<label for="r_agent" class="inform">Агент:</label><select id="r_agent" name="r_agent" class="inform" size="1"/><br />' +
			'<label for="r_comments" class="inform">Примечание:</label><br /><textarea style="display:block; margin-bottom:5px;width:400px; height:120px;" id="r_comments" name="r_comments" rows="2" cols="20"></textarea><br />' +
			//////////тест форма добавления фотографий
			'<div class="d-link"><img height="48" width="48" alt="" src="_images/digikam.png"/><br /><a class="mlink" id="r_photo" href="#">Редактирование фотографий</a></div>' +
			'<div id="photoredactor" style="display: none"><div class="textondiv"><label class="label" style="font-size:medium;"><strong>Фотографии</strong></label><br />' +
			'<span class="delineation">Размер фотографии должен быть <span class="red">не более 2Мб</span>.</span>' +
			'<div id="upload_advert" style="width:410px; clear:both">' +
			'<div class="textondiv" style="border: 1px solid #8B8B8B;">' +
			'<div class="tags" style="margin-top: 5px">' +
			'<label for="images_label_advert">На фотографии:&nbsp;</label>' +
			'<select name="tag" id="r_images_label" >' +
			'<option value="" selected="selected" >Выберите...</option>' +
			'<option value="Дом снаружи">Дом снаружи</option>' +
			'<option value="Вид из окна">Вид из окна</option>' +
			'<option value="Интерьер">Интерьер</option>' +
			'<option value="План квартиры">План квартиры</option></select></div>' +
			'<div style="margin-top: 5px">' +
			'<input id="r_image_button" name="image_but_redact" type="button" value="Добавить фотографию" style="width:167; height:22"/>' +
			'<input type="hidden" name="MAX_FILE_SIZE" value="2097152" />' +
			'<input id="filepath_a" name="filepath_a" type="hidden" value="" /></div></div><br />' +
			'<div><ul id="r_image_list" class="files"></ul>' +
			'</div></div></div></div>' +
			/* конец формы добавления фотографий */
			'<a href="#" id="r_saled" class="inform">Отметить объект проданным по цене:</a><br /><input type="text" id="r_price_sale" name="r_price_sale" class="inform" disabled="disabled"/><br />' +
			'<div style="clear:both; margin-top: 10px;"><input type="button" id="r_update" name="r_update" value="Применить изменения" />' +
			'<input type="button" id="r_delete" name="r_delete" value="Удалить" /></form></div></div>';
			result += back_block;
			$("#card").html(result);
			$(window.parent.document).scrollTo(0);
			$("#gallery_din").css({
				"margin": "0px",
				"padding": "1px",
				"list-style": "none",
				"list-style-position": "inside"
			});
			$("#gallery_din li").css({
				"display": "inline",
				"margin": "0 0.4em 0.4em 0",
				"vertical-align": "baseline"
			});
			$("#gallery_din img").css({
				"background-color": "#ECECEC",
				"padding": "5px 5px 10px",
				"border": "1px solid #333333"
			});
			$("#gallery_din img").live("mouseover", function(){
				$(this).css({
					"background-color": "#FFF"
				});
			});
			$("#gallery_din img").live("mouseout", function(){
				$(this).css({
					"background-color": "#ECECEC"
				});
			});
			$("#photoredactor").draggable();
			$(".d-link").draggable();

			if (jQuery("#card").css("display") == "none") {
				jQuery("#objects").hide();
				jQuery("#card").show();
			}
			$('.back_to_list_advert').click(function(){
				if ($.cookie("_filedir") != null) {
					$.post("../_scriptsphp/trimming.php");
				}
				jQuery("#objects").show();
				jQuery("#card").hide();
				return false;
			});
			// $("#photocar").carousel( { dispItems : 3, autoSlide : true } );
			$('a[rel*=gallery]').lightBox();


			if (readyTreat) {
				$('#treat-agent-buy').fillSelect(obj_AvailableAgents).attr('disabled', '');
			}
			if (obj_AvailableAgents != 'undefined') {
				$.each(obj_AvailableAgents, function(i, val){
					if (val.Name === obj.agent_name) {
						$('#_mode-view').removeClass("hide").addClass("show");
					}
				});
			}
			$("#treat-buy").bind("click", function(){
				var user_id = $("#treat-agent-buy option:selected").val();
				$.get("../_scriptsphp/treat.php", {
					section: "buy",
					id: user_id,
					uuid: obj.UUID
				}, function(data){
					sendMessageAndRedirect("update", data);
				});
			});
			$(".d-link").click(function(){
				$("#photoredactor").toggle();
				var cssObj = {
					'position': 'absolute',
					'zoom':'1',
					'top': '40px',
					'left': '10px',
					'background-color': '#EFEFEF',
					'border': '2px solid #dedede',
					'width': '420px',
					'font-size': 'small'
				}
				$('#photoredactor').css(cssObj);
				forCreateRedactImage("#r_image_button", "#r_images_label", "#r_image_list", "r_gallery");
				// $('#photoredactor').css("background-color", "#FFFFCC");
			});
			$('#mode-view-switch').bind("click", function(){
				switch (modeview) {
					case "review":
					if ($.cookie("_filedir") != null) {
						alert ("Директория для создания фотографий существует.\nВыйдите из режима редактировния в других разделах.");
						return;
					} else {
						$.cookie("modeview", "redact");
						createModeView("redact");
						inAutorized(obj);
					}
					break;
					case "redact":
					$.cookie("modeview", "review");
					createModeView("review");
					if ($.cookie("_filedir") != null) {
						$.post("../_scriptsphp/trimming.php");
						$('#r_image_list > li').remove();
					}
					break;
					default:
						break;
				}
				modeview = $.cookie("modeview");
				return false;
			});
		}
	});
}
function inAutorized(obj){
	if (obj != "undefined") {

		var parameters = {
			room: obj.room_cod,
			sale: obj.sale_name,
			type: obj.type_s,
			project: obj.project_name,
			material: obj.material_name,
			plan: obj.plan_name,
			cond: obj.cond_name,
			side: obj.side_name,
			agent: obj.agent_name
		};
		if (obj.foto > 0) {
			if ($.cookie("_filedir") != null) {
				alert ("Директория для создания фотографий существует.\nВыйдите из режима редактировния в других разделах.");
				return;
			} else {
				var filedir = hex_md5(Date()).substr(10, 8);
				$.cookie("_filedir", filedir);
			}
			for (var i = 0; i < obj.foto; i++) {
				$.get("./iredact.php",
				{
					id_image: obj.flats_cod,
					category: 0,
					image: i
				}, function(data){
					var file = data.substr(data.lastIndexOf("/") + 1);
					var image = '<li><div class="upload-container"><div class="min-elemondiv"><a href="' + data + '" rel="r_gallery"><img src="' + data + '" alt=""/></a></div><div class="upload-image-control"><br /><a id="rem_' + file + '" class="remove_image mlink" href="#">Удалить</a><input class="filename" type="hidden" value="' + data + '"/></div></div></li>';
					$('#r_image_list').append(image);
					$('a[rel*="r_gallery"]').lightBox();
				});
			}
		}
		$.each(parameters, function(i, parameter){
			$.getJSON("../_scriptsphp/get_parameters.php", {
				parameter: i
			}, function(json){
				$('#r_' + i + '').fillSelect(json).attr('disabled', '');
				$("#r_" + i + " option:contains('" + parameter + "')").attr("selected", "selected");
			});
		});
		$.getJSON("../_scriptsphp/get_parameters.php", {
			parameter: "city"
		}, function(json){
			$('#r_city').fillSelect(json).attr('disabled', '');
			$("#r_city option:contains('" + obj.city_name + "')").attr("selected", "selected");
			var id_city = $("#r_city option:selected").val();
			$.getJSON("../_scriptsphp/get_parameters.php", {
				parameter: "street",
				id: id_city
			}, function(json){
				$('#r_street').fillSelect(json).attr('disabled', '');
				$("#r_street option:contains('" + obj.street_name + "')").each(function (index) {
					if ($(this).text() === obj.street_name) {
						$(this).attr("selected", "selected");
					}
				});

			});
		});
		$('#r_city').bind("change", function(){
			adjustStreet("r_city", "r_street");
		});
		$("#r_so").val(obj.So);
		$("#r_sz").val(obj.Sz);
		$("#r_sk").val(obj.Sk);
		$("#r_floor").val(obj.flats_floor);
		$("#r_floorest").val(obj.flats_floorest);
		if (obj.flats_tel == 1)
			$("#r_phon").attr("checked", "checked");
		$("#r_price").val(obj.flats_price);
		$("#r_comments").html(obj.flats_comments);
		//
		$("#r_saled").live("click", function(){
			var $this = $('#r_price_sale');
			if ($this.attr("disabled") == "")
				$this.attr('disabled', 'disabled').val("");
			else
				$this.attr('disabled', '').val("");
			/*      $("#r_price_sale").toggle(
			function () {
			$(this).attr('disabled', '').val("");
			});*/
			//  $("#r_price_sale").attr('disabled', '');
		});
		$("#r_delete").bind("click", function(){
			if($("#r_price_sale").val()!=""){
				updateSaleAdvertisement();
			} else {
				$.post("../_scriptsphp/refinement.php", {
					action: "delete",
					uuid: obj.UUID
				}, function(data){
					if ($.cookie("_filedir") != null) {
						$.post("../_scriptsphp/trimming.php");
					}
					sendMessageAndRedirect("delete", data);
				});
			}		
		});
		$("#r_update").bind("click", function(){
			updateSaleAdvertisement();
		});
	}
};
function updateSaleAdvertisement(){
	var obj_update = {
		"street_cod": $("#r_street option:selected").val(),
		"room_cod": $("#r_room option:selected").val(),
		"type_cod": $("#r_type option:selected").val(),
		"sale_cod": $("#r_sale option:selected").val(),
		"project_cod": $("#r_project option:selected").val(),
		"So": $("#r_so").val(),
		"Sz": $("#r_sz").val(),
		"Sk": $("#r_sk").val(),
		"flats_floor": $("#r_floor").val(),
		"flats_floorest": $("#r_floorest").val(),
		"material_cod": $("#r_material option:selected").val(),
		"plan_cod": $("#r_plan option:selected").val(),
		"cond_cod": $("#r_cond option:selected").val(),
		"side_cod": $("#r_side option:selected").val(),
		"agent_cod": $("#r_agent option:selected").val(),
		"flats_tel": ($("#r_phon").attr("checked")) ? 1 : 0,
		"flats_price": $("#r_price").val(),
		"price_sale": $("#r_price_sale").val(),
		"flats_comments": $("#r_comments").val()
	};
	$.post("../_scriptsphp/refinement.php", {
		action: "update",
		uuid: obj.UUID,
		json_obj: $.toJSON(obj_update)
	}, function(data){
		sendMessageAndRedirect("update", data);
	});
}
function sendMessageAndRedirect(action, data){
	var infohtml = '<div id="infomessage" class="i-message ui-corner-bottom"><div class="textondiv redline"></div></div>';
	window.parent.getCount();
	$(window.parent.document).find("#objects").prepend(infohtml);
	$(window.parent.document).find("#objects").append(infohtml);
	$(window.parent.document).find(".i-message").each(function() {
		$(this).find("div:first-child").text(data).fadeIn("fast");
	});
	var url = window.location.href;
	var croped_url = (url.indexOf("?")!=-1)?url.substr(url.indexOf("?") + 1):"";
	var simple_url = (url.indexOf("?")!=-1)?url.substr(0, url.indexOf("?") + 1): url;
	if (action == "delete") {
		if (croped_url.match("totalRows_Recordset1")) {
			var returnVal;
			var aQuery = croped_url.split("&");
			for (var i = 0; i < aQuery.length; i++) {
				if (escape(unescape(aQuery[i].split("=")[0])) == "totalRows_Recordset1") {
					returnVal = aQuery[i].split("=")[1];
				}
			}
			croped_url = croped_url.replace("totalRows_Recordset1=" + returnVal, "totalRows_Recordset1=" + (parseInt(returnVal) - 1));
		}
	}
	// ((croped_url.indexOf("search") ==-1)? "search=_" + random : "")
	// $('#back_2').trigger('click');
	//    if ($.cookie("view") == "table") {
	//        window.location.href = simple_url + croped_url;
	//    }
	//    else {
	//        window.location.href = simple_url + croped_url;
	//       // window.location.href = "v_lenta.php?" + croped_url;
	//    }
	window.location.href = simple_url + croped_url;
	if (action != "delete") {
		window.location.reload();
	}
	//    window.parent.removeMessageBoxAsClass();
	$(window.parent.document).scrollTo(0);
	window.parent.getCountPrivate();
	window.parent.removeMessageBoxforElement(".i-message");
}
function prepareUrl(url){
	var tmp = new Array(); // два вспомагательных
	var tmp2 = new Array(); // массива
	var param = new Array();

	var get = url;
	if (get != '') {
		tmp = (get.substr(1)).split('&'); // разделяем переменные
		for (var i = 0; i < tmp.length; i++) {
			tmp2 = tmp[i].split('='); // массив param будет содержать
			param[tmp2[0]] = tmp2[1]; // пары ключ(имя переменной)->значение
		}
		var obj = document.getElementById('greq'); // вывод на экран
		for (var key in param) {
			alert(key + '=' + param[key]);
		}
	}
};
function createModeView(modeview){
	switch (modeview) {
		case "review":
		default:
			$("#d_container").show();
			$("#_redact").hide();
			break;
		case "redact":
			$("#d_container").hide();
			$("#_redact").show();
			break;
	}
};
function showPopupEx(exchange_id){
	$.ajax({
		type: "GET",
		cache: false,
		url: "../../detail_exchange.php",
		data: "id=" + exchange_id,
		success: function(response){
			var obj = eval("(" + response + ")");
			var readyTreat = false;
			if (obj.Source == 0 && obj.Treated == 0) {
				readyTreat = true;
			}
			var result = '<div id="_mode-view" class="hide" style="padding: 0 0 5px 5px">Режим:<a href="#mode-view" id="mode-view-switch" title="Режим доступа" style ="padding-left:5px;">Просмотр/Редактирование</a></div>';
			var back_block ='<div style="clear:both; width:100%; margin: 5px 0; padding: 1px 0;"><img height="16" width="16" class="icon back_to_list_advert" alt="" title="вернуться к списку объектов" src="_images/arrow-curve-180.png"/><a href="#" class="back_to_list_advert mlink" title="назад">вернуться к списку объектов</a></div>';		
			result += back_block;
			result += '<div id="exd_container" style="float: left;width: 100%;">';
			result += '<div class="contact"><div class="textondiv"><span>Код объявления:&nbsp;</span>' + obj.UUID.substr(0, 8) + '<br />' +
			'Добавлено&nbsp;' +
			customDateString(obj.Date) +
			'<br /><div style="margin-top: 5px"><span class="letter">Контактная информация</span></div>' +
			'<div style="margin-top: 5px"> Разместил&nbsp;';
			if (readyTreat) {
				result += obj.Contact +
				'<div style="margin-top: 5px" ><span class="red letter">Получено с сайта.</span><br/>Вы можете закрепить это объявление за агентом:<br/>' +
				'<select id="treat-agent" name="treat-agent" style="width:220px;margin-top: 3px"></select><br/>' +
				'<input id="treat-exchange" type="submit" value="Закрепить за агентом" style="margin-top: 3px" /></div>';
			}
			else {
				result += obj.agency_name +
				'<br />E-mail&nbsp;<a href="mailto:' +
				obj.agency_mail +
				'">' +
				obj.agency_mail +
				'</a><br />Телефоны&nbsp;<strong>' +
				obj.phon +
				'</strong>';
			}
			result += '</div></div></div>';
			/* end right */
			var typeExchange;
			var Type_Exchange = obj.Type_Exchange;
			switch (Type_Exchange) {
				case "0":
					typeExchange = "Съезд:";
					break;
				case "1":
					typeExchange = "Разъезд:";
					break;
				default:
					typeExchange = "Обмениваю:";
					break;
			}
			(Type_Exchange === "0") ? Formula = obj.Formula + '=' + obj.Result : Formula = obj.Result + '=' + obj.Formula;
			result += '<div style="border-bottom: thin solid #2B4558;margin:0 270px 5px 0;padding:0;color:#2B4558"><span style="font: bold 1.3em Arial,Verdana,Tahoma;margin:0;padding:0;">' + typeExchange + '&nbsp;' + Formula +'</span></div>';
			result += '<div style="margin-right:250px;"><div class="textondiv">' +	obj.Description +'</div>';
			if (obj.foto > 0) {
				result += '<div class="image-layer gallery"><ul id="gallery_din">';
				for (var i = 0; i < obj.foto; i++) {
					result += '<li><div class="image-container"><div class="elemondiv"><a href="./base5.php?id_image=' + exchange_id + '&category=1&image=' + i + '" rel="gallery" ><img src="./base5.php?id_image=' + exchange_id + '&category=1&image=' +
					i +
					'&min=1" alt=""/></a></div></div></li>';
				}
				result += '</ul></div><br />';
			}
			result += '</div></div><div id="rex_redact" class="hide" style="margin-top:10px;">'+
			'<form id="rex-form" name="rex-form" action="http://">' +
			'<label for="rex_formula" class="inform">Формула:</label><input type="text" id="rex_formula" name="rex_formula" class="inform double"/><br />' +
			'<label for="rex_agent" class="inform">Агент:</label><select id="rex_agent" name="rex_agent" class="inform" size="1"/><br />' +
			'<label for="rex_comments" class="inform">Описание:</label><br /><textarea style="display:block; margin-bottom:5px;width:410px; height:120px;" id="rex_comments" name="rex_comments" rows="2" cols="20"></textarea>' +
			//////////тест форма добавления фотографий
			'<div class="d-link"><img height="48" width="48" alt="" src="_images/digikam.png"/><a class="mlink" id="rex_photo" href="#">Редактирование фотографий</a></div>' +
			'<div id="rex_photoredactor" style="display: none"><div class="textondiv"><label class="label" style="font-size:medium;"><strong>Фотографии</strong></label><br />' +
			'<span class="delineation">Размер фотографии должен быть <span class="red">не более 2Мб</span>.</span>' +
			'<div id="rex_iupload" style="width:410px; clear:both">' +
			'<div class="textondiv" style="border: 1px solid #8B8B8B;">' +
			'<div class="tags" style="margin-top: 5px">' +
			'<label for="images_label_exchange">На фотографии:&nbsp;</label>' +
			'<select name="tag" id="images_label_exchange" >' +
			'<option value="" selected="selected" >Выберите...</option>' +
			'<option value="Дом снаружи">Дом снаружи</option>' +
			'<option value="Вид из окна">Вид из окна</option>' +
			'<option value="Интерьер">Интерьер</option>' +
			'<option value="План квартиры">План квартиры</option></select></div>' +
			'<div style="margin-top: 5px">' +
			'<input id="rex_image_but" name="rex_image_but" type="button" value="Добавить фотографию" style="width:167; height:22"/>' +
			'<input type="hidden" name="MAX_FILE_SIZE" value="2097152" />' +
			'<input id="filepath_a" name="filepath_a" type="hidden" value="" /></div></div><br />' +
			'<div><ul id="rex_image_list" class="files"></ul>' +
			'</div></div></div></div>' +
			/* конец формы добавления фотографий */
			'<div style="clear:both; margin-top: 10px;"><input type="button" id="rex_update" name="rex_update" value="Применить изменения" />' +
			'<input type="button" id="rex_delete" name="rex_delete" value="Удалить" /></form></div></div>';
			result += back_block;
			$("#card-e").html(result);
			$("#rex_photoredactor").draggable();
			$(window.parent.document).scrollTo(0);
			$("#gallery_din").css({
				"width": "100%",
				"margin": "0px",
				"padding": "0px"
			});
			$("#gallery_din li").css({
				"list-style": "none",
				"display": "inline"
			});
			$(".elemondiv").live("mouseover", function(){
				$(this).css({
					"background-color": "#FFF"
				});
			});
			$(".elemondiv").live("mouseout", function(){
				$(this).css({
					"background-color": "#ECECEC"
				});
			});
			if (jQuery("#card-e").css("display") == "none") {
				jQuery("#objects").hide();
				jQuery("#card-e").show();
			}
			$('.back_to_list_advert').click(function(){
				if ($.cookie("_filedir") != null) {
					$.post("../_scriptsphp/trimming.php");
				}
				jQuery("#objects").show();
				jQuery("#card-e").hide();
				return false;
			});
			$('a[rel*=gallery]').lightBox();
			//не обрабатывается логгед юзеры просто для теста
			/* $.getJSON("../_scriptsphp/get_parameters.php", {
			parameter: "agent",
			time: "2pm"
			}, function(json){
			$('#treat-agent').fillSelect(json).attr('disabled', '');
			});*/
			if (readyTreat) {
				$('#treat-agent').fillSelect(obj_AvailableAgents).attr('disabled', '');
			}

			$("#treat-exchange").live("click", function(){
				var user_id = $("#treat-agent option:selected").val();
				$.get("../_scriptsphp/treat.php", {
					section: "exchange",
					id: user_id,
					uuid: obj.UUID
				}, function(data){
					sendMessageAndRedirect("update", data);
				});
			});
			if (obj_AvailableAgents != "undefined") {
				$.each(obj_AvailableAgents, function(i, val){
					if (val.Name === obj.agent_name) {
						$('#_mode-view').removeClass("hide").addClass("show");
					}
				});
			}
			$(".d-link").click(function(){
				$("#rex_photoredactor").toggle();
				var cssObj = {
					'position': 'absolute',
					//'z-index':'999',
					'top': '310px',
					'left': '10px',
					'background-color': '#EFEFEF',
					'border': '2px solid #dedede',
					'width': '420px',
					'font-size': 'small'
				}
				$('#rex_photoredactor').css(cssObj);
				forCreateRedactImage("#rex_image_but", "#images_label_exchange", "#rex_image_list", "rex_gallery");
			});
			$('#mode-view-switch').bind("click", function(){
				switch (modeview) {
					case "review":
					if ($.cookie("_filedir") != null) {
						alert ("Директория для создания фотографий существует.\nВыйдите из режима редактировния в других разделах.");
						return;
					} else {
						$.cookie("modeview", "redact");
						createModeViewEx("redact");
						inAutorizedEx(obj);
					}
					break;
					case "redact":
						$.cookie("modeview", "review");
						createModeViewEx("review");
						break;
					default:
						break;
				}
				modeview = $.cookie("modeview");
				return false;
			});
		}
	});
}
function createModeViewEx(modeview){
	switch (modeview) {
		case "review":
		default:
			$("#exd_container").show();
			$("#rex_redact").hide();
			break;
		case "redact":
			$("#exd_container").hide();
			$("#rex_redact").show();
			break;
	}
}
function inAutorizedEx(obj){
	if (obj != "undefined") {
		var parameters = {
			agent: obj.agent_name
		};
		if (obj.foto > 0) {
			var filedir = hex_md5(Date()).substr(10, 8);
			$.cookie("_filedir", filedir);
			for (var i = 0; i < obj.foto; i++) {
				$.get("./iredact.php",
				{
					id_image: obj.Id,
					category: 1,
					image: i
				}, function(data){
					var file = data.substr(data.lastIndexOf("/") + 1);
					var image = '<li><div class="upload-container"><div class="min-elemondiv"><a href="' + data + '" rel="rex_gallery"><img src="' + data + '" alt=""/></a></div><div class="upload-image-control"><br /><a id="rem_' + file + '" class="remove_image mlink" href="#">Удалить</a><input class="filename" type="hidden" value="' + data + '"/></div></div></li>';
					$('#rex_image_list').append(image);
					$('a[rel*="rex_gallery"]').lightBox();
				});
			}
		}
		$.each(parameters, function(i, parameter){
			$.getJSON("../_scriptsphp/get_parameters.php", {
				parameter: i
			}, function(json){
				$('#rex_' + i + '').fillSelect(json).attr('disabled', '');
				$("#rex_" + i + " option:contains('" + parameter + "')").attr("selected", "selected");
			});
		});
		(obj.Type_Exchange === "0") ? Formula = obj.Formula + '=' + obj.Result : Formula = obj.Result + '=' + obj.Formula;
		$("#rex_formula").val(Formula);
		$("#rex_comments").html(obj.Description);

		$("#rex_delete").bind("click", function(){
			$.post("../_scriptsphp/refinement_ex.php", {
				action: "delete",
				uuid: obj.UUID
			}, function(data){
				if ($.cookie("_filedir") != null) {
					$.post("../_scriptsphp/trimming.php");
				}
				sendMessageAndRedirect("delete", data);
			});
		});
		$("#rex_update").bind("click", function(){
			var obj_update = {
				"formula": $("#rex_formula").val(),
				"agent_cod": $("#rex_agent option:selected").val(),
				"Description": $("#rex_comments").val()
			};
			$.post("../_scriptsphp/refinement_ex.php", {
				action: "update",
				uuid: obj.UUID,
				json_obj: $.toJSON(obj_update)
			}, function(data){
				sendMessageAndRedirect("update", data);
			});
		});
	}
};
function forCreateRedactImage(button, label, ilist, gallery){
	var upload_button = $(button), interval;
	var filedir = $.cookie("_filedir");
	if (filedir == null) {
		filedir = hex_md5(Date()).substr(10, 8);
		$.cookie("_filedir", filedir);
	}
	var filepath = './_tmp/' + filedir + '/';
	var value = "";
	new Ajax_upload(upload_button, {
		action: '_scriptsphp/image_upload.php',
		name: 'userfile',
		onSubmit: function(file, ext){
			if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))) {
				alert('Вы можете прикреплять к объявлению только файлы изображений.');
				return false;
			}
			if ($(label).val() == "") {
				if (confirm("Вы действительно хотите добавить фотографию без подписи?")) {
				}
				else {
					return false;
				}
			}
			upload_button.attr("value", "Загрузка");
			interval = window.setInterval(function(){
				var text = upload_button.val();
				if (text.length < 13) {
					upload_button.attr("value", text + '.')
				}
				else {
					upload_button.attr("value", "Загрузка");
				}
			}, 200);
			value = $(label).val();
			this.setData({
				'f_description': '' + value + '',
				'filedir': '' + filedir + ''
			});
			$("#filepath_a").val(filepath);
		},
		onComplete: function(file, response){
			upload_button.attr("value", "Добавить фотографию");
			window.clearInterval(interval);
			this.enable();
			var filename = filepath + response;
			if (filename.search(/(jpg|png|jpeg|gif)/) != -1) {
				var n_image = '<li><div class="upload-container"><div class="min-elemondiv"><a href="' + filename + '" rel="'+ gallery +'"><img src="' + filename + '" /></a></div><div class="upload-image-control"><strong>' + value + '</strong><br /><a id="rem_' + response + '" class="remove_image mlink" href="#">Удалить</a><input class="filename" type="hidden" value="' + filename + '"/></div></div></li>';
				$(ilist).append(n_image);
				$('a[rel*="' + gallery + '"]').lightBox();
			}
			else {
				alert("Ошибка при загрузке! Возможно размер файла более 2Мб.\nЕсли Вы уверены в корректности файла, Вы можете сообщить об этой ошибке администратору портала с помощью сервиса \"Оставить свой отзыв\".");
			}
		}
	});
}
function PopupProposalBuy(id){
	$.ajax({
		type: "GET",
		cache: false,
		url: "../../detail_proposal_buy.php",
		data: "id=" + id,
		success: function(response){
			var obj = eval("(" + response + ")");
			var back_block ='<div style="clear:both; width:100%; margin: 5px 0; padding: 1px 0;"><img height="16" width="16" class="icon back_to_list_advert" alt="" title="вернуться к списку объектов" src="_images/arrow-curve-180.png"/><a href="#" class="back_to_list_advert mlink" title="назад">вернуться к списку объектов</a></div>';		
			var result= '<div id="d_container" style="float: left;width: 100%;"><div class="contact"><div class="textondiv"><span>Код объявления:&nbsp;</span>' + obj.UUID.substr(0, 8) + '<br />' +
			'Добавлено&nbsp;' +
			customDateString(obj.Date) +
			'<br /><div style="margin-top: 5px"><span class="letter">Контактная информация</span></div>' +
			'<div style="margin-top: 5px"> Разместил&nbsp;' +
			obj.Contact +
			'</div></div></div>';
			/* end right */
			result += '<div style="border-bottom: thin solid #2B4558;margin:0 270px 5px 0;padding:0;color:#2B4558"><span style="font: bold 1.3em Arial,Verdana,Tahoma;margin:0;padding:0;">' + obj.Header +'</span></div>';
			result += '<div style="margin-right:250px;"><span class="mark-field">Тип объекта: </span>' +
			obj.type_name +
			'<br /><span class="mark-field">Расположение: </span>' +
			obj.regions +
			'<br /><span class="mark-field">Цена не более: </span>' +
			number_format(obj.price_fb, 0, '.', ' ') +
			' руб.<br /><p><span class="advertbody">' +
			obj.comm_fb +
			'</span></p>';
			result += back_block;
			$("#card-e").html(result);
			$(window.parent.document).scrollTo(0);
			if (jQuery("#card-e").css("display") == "none") {
				jQuery("#objects").hide();
				jQuery("#card-e").show();
			}
			$('.back_to_list_advert').click(function(){
				jQuery("#objects").show();
				jQuery("#card-e").hide();
				return false;
			});
		}
	});
};
function MakeArray(n){
	this.length = n;
	return this;
};

monthNames = new MakeArray(12);
monthNames[1] = "января"
monthNames[2] = "февраля"
monthNames[3] = "марта"
monthNames[4] = "апреля"
monthNames[5] = "мая"
monthNames[6] = "июня"
monthNames[7] = "июля"
monthNames[8] = "августа"
monthNames[9] = "сентября"
monthNames[10] = "октября"
monthNames[11] = "ноября"
monthNames[12] = "декабря"
dayNames = new MakeArray(7);
dayNames[1] = "воскресенье"
dayNames[2] = "понедельник"
dayNames[3] = "вторник"
dayNames[4] = "среда"
dayNames[5] = "четверг"
dayNames[6] = "пятница"
dayNames[7] = "суббота"

function customDateString(customDate){
	currentDate = new Date(customDate);
	var theDay = dayNames[currentDate.getDay() + 1]
	var theMonth = monthNames[currentDate.getMonth() + 1]
	msie4 = ((navigator.appName == "Microsoft Internet Explorer") && (parseInt(navigator.appVersion) >= 4));
	op = (navigator.appName == "Opera");
	if (msie4 || op) {
		var theYear = currentDate.getYear()
	}
	else {
		var theYear = currentDate.getYear() + 1900
	}
	var Minutes = currentDate.getMinutes();
	return "<span class='thetimes'>" + currentDate.getHours() + ((Minutes < 10) ? ":0" : ":") + Minutes + "</span>, <span class='thedate'>" + currentDate.getDate() + "</span>&nbsp;<span class='themonth'>" + theMonth +
	"</span>&nbsp;<span class='theyear'>" +
	theYear +
	"</span>";
};
function number_format(number, decimals, dec_point, thousands_sep){
	// http : // kevin.vanzonneveld.net
	// %        note 1 : For 1000.55 result with precision 1 in FF / Opera is 1, 000.5, but in IE is 1, 000.6
	// *     example 1 : number_format(1234.56);
	// *     returns 1 : '1,235'
	// *     example 2 : number_format(1234.56, 2, ',', ' ');
	// *     returns 2 : '1 234,56'
	// *     example 3 : number_format(1234.5678, 2, '.', '');
	// *     returns 3 : '1234.57'
	// *     example 4 : number_format(67, 2, ',', '.');
	// *     returns 4 : '67,00'
	// *     example 5 : number_format(1000);
	// *     returns 5 : '1,000'
	// *     example 6 : number_format(67.311, 2);
	// *     returns 6 : '67.31'
	var n = number, prec = decimals;
	n = !isFinite(+n) ? 0 : +n;
	prec = !isFinite(+prec) ? 0 : Math.abs(prec);
	var sep = (typeof thousands_sep == "undefined") ? ',' : thousands_sep;
	var dec = (typeof dec_point == "undefined") ? '.' : dec_point;

	var s = (prec > 0) ? n.toFixed(prec) : Math.round(n).toFixed(prec);
	// fix for IE parseFloat(0.55).toFixed(0) = 0;

	var abs = Math.abs(n).toFixed(prec);
	var _, i;

	if (abs >= 1000) {
		_ = abs.split(/\D/);
		i = _[0].length % 3 || 3;

		_[0] = s.slice(0, i + (n < 0)) +
		_[0].slice(i).replace(/(\d{3})/g, sep + '$1');

		s = _.join(dec);
	}
	else {
		s = s.replace('.', dec);
	}

	return s;
};
