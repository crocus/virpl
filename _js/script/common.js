var view = $.cookie("view");
$(document).ready(function(){
	show_ladvice_list();
	if($.cookie("_filedir")!=null){
		$.post("../_scriptsphp/trimming.php");
	}
//    $("#loading").ajaxStart(function(){
//        $(this).show();
//    });
//    $("#loading").ajaxStop(function(){
//        $(this).hide();
//    });
	$("#leftmenu").accordion({
		collapsible: true,
		autoHeight: true
	});
	$("#foo").carousel();
	/////////// тестовый аккардеон
	/*	$("#accordion").tabs("#accordion div.pane", {
	tabs: 'h2',  
	effect: 'slide' 
});*/
	/////////////
	$.getJSON("_scriptsphp/hot_advert.php", function(json){
/*		$("#anonce_total").text(json.sale.actual);
		$("#anonce_min").text(json.price.min);
		$("#anonce_max").text(json.price.max);
		$("#anonce_tleft").text(json.last.dated);*/
		});
	$.getJSON("_scriptsphp/anoncement.php", function(json){
		$("#anonce_total").text(json.sale.actual);
		$("#anonce_min").text(json.price.min);
		$("#anonce_max").text(json.price.max);
		$("#anonce_tleft").text(json.last.dated);
		});
	$('#logoslide').cycle({
		fx: 'scrollLeft',
		timeout: 6000,
		delay: -2000
	});
	getCount();
	$("#fl").click(function(){
		openLink(2);
		return false;
	});
	$("#pods").click(function(){
		openLink(5);
		return false;
	});
	$("#0_fl").click(function(){
		openLink(2, 0);
		return false;
	});
	$("#1_fl").click(function(){
		openLink(2, 1);
		return false;
	});
	$("#2_fl").click(function(){
		openLink(2, 2);
		return false;
	});
	$("#3_fl").click(function(){
		openLink(2, 3);
		return false;
	});
	$("#4_fl").click(function(){
		openLink(2, 4);
		return false;
	});
	$("#office").click(function(){
		openLink(4);
		return false;
	});
	$("#stroyeniya").click(function(){
		openLink(3);
		return false;
	});
	$("#proizvod").click(function(){
		openLink(6);
		return false;
	});
	$("#torgovlya").click(function(){
		openLink(7);
		return false;
	});
	$("#dom").click(function(){
		openLink(1);
		return false;
	});
	$("#kottedg").click(function(){
		openLink(8);
		return false;
	});
	$("#grounds").click(function(){
		openLink(9);
		return false;
	});
	$("#dachi").click(function(){
		openLink(10);
		return false;
	});
	$("#registr").click(function(){
		if ($("#form-registr").length === 0) {
			$("#tabs").tabs("add", '#form-registr', 'Регистрация пользователей');
			$("#form-registr").css({
				//            "position": "relative",
				"width": "auto",
				"height": "auto"
			});
			$("#form-registr").load('../../registration.php', function(){
				$("#form-registr").append('<p><a href="#" class="tabs-close-button" title="Закрыть вкладку"><img src="../_images/remove.png" width="32" height="32" alt="Закрыть вкладку" /></a></p>' + "<br />");
				$("#tabs").tabs('option', 'selected', '#form-registr');
			});
		}
		return false;
	});
	$("a.genpass").live('click', function(){
		var txtnew=PWD();
		var txtnew2=PWD();
		var txtnew3=PWD();
		$(".setpass").val(txtnew +'\n'+  txtnew2+'\n' + txtnew3).focus();
		return false;
	});  
	$("#add_advert").click(function(){
		if ($("#advertis").length == 0) {
			$("#tabs").tabs("add", '#advertis', 'Добавление объявления');
			$("#advertis").css({
				"position": "relative",
				"padding": "0",
				"height": "auto"
			});
			$("#advertis").load('add_advert.php', function(){
				$("#advertis").append('<p><a href="#" class="tabs-close-button" title="Закрыть вкладку"><img src="../_images/remove.png" width="32" height="32" alt="Закрыть вкладку" /></a></p>' + "<br />");
				$("#tabs").tabs('option', 'selected', '#advertis');
			});
		}
		return false;
	});
	$("#add_exchange").click(function(){
		if ($("#a_exchange").length === 0) {
			$("#tabs").tabs("add", '#a_exchange', 'Добавление обмена');
			$("#a_exchange").css({
				"position": "relative",
				"padding": "0",
				"height": "auto"
			});
			$("#a_exchange").load('../../add_exchanges.php', function(){
				$("#a_exchange").append('<p><a href="#" class="tabs-close-button" title="Закрыть вкладку"><img src="../_images/remove.png" width="32" height="32" alt="Закрыть вкладку" /></a></p>' + "<br />");
				$("#tabs").tabs('option', 'selected', '#a_exchange');
				$('#back_exchanges_all').live("click", function(){
					$("#del_a_exchange").trigger('click');
					$("#s_exchanges").trigger('click');
					$('#_exchanges').attr('src', 'exchanges.php');
					return false;
				});
			});
		}
		return false;
	});
	$('.tabs-close-button').live("click", function(){
		var selected = $('#tabs').tabs().tabs('option', 'selected');
		$("#tabs").tabs("remove", selected);
		$("#tabs").tabs('option', 'selected', '#objects');
		$(document).scrollTo(0);
		return false;
	});
	$('.tabs-back-button').live("click", function(){
		// $('.tabs-close-button').trigger('click');//непонятки
		var selected = $('#tabs').tabs().tabs('option', 'selected');
		$("#tabs").tabs("remove", selected);
		$("#tabs").tabs('option', 'selected', '#objects');
		$(document).scrollTo(0);
		return false;
	});
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
	$("#add_vacancy").click(function(){
		if ($("#vacancy").length === 0) {
			$("#tabs").tabs("add", '#vacancy', 'Вакансии');
			$("#vacancy").css({
				"position": "relative",
				"height": "auto"
			});
			$.get('../../vacy.html', {}, function(response){
				$("#vacancy").append(response).fadeIn('slow');
				$("#vacancy").append('<p><a href="#" id="back_2" title="назад" style =" float: right;">Назад</a></p>' + "<br />");
				$("#tabs").tabs('option', 'selected', '#vacancy');
			});
		}
		return false;
	});
	$(".tolawyer").live("click",function(){
		if ($("#lawyer").length === 0) {
			$("#tabs").tabs("add", '#lawyer', 'Юридическая консультация');
			$("a[href='#lawyer']").append('<img src="../_images/ajax-loader.gif" class="loader" style="padding-left:5px;vertical-align: middle;" width="16" height="16" alt="" />');
			$("#lawyer").css({
				"position": "relative",
				"padding": "0",
				"height": "auto"
			});
			$.get('../legaladvice/index.php', function(response){
				$("#lawyer").append(response).fadeIn('slow');
				$("#lawyer").append('<p><a href="#" class="tabs-close-button" title="Закрыть вкладку"><img src="../_images/remove.png" width="32" height="32" alt="Закрыть вкладку" /></a></p>' + "<br />");
				$("#tabs").tabs('option', 'selected', '#lawyer');
				$(".loader").remove();
			});
		}
		return false;
	});
	$("#proposal-buy").click(function(){
		if ($("#b_proposal").length === 0) {
			$("#tabs").tabs("add", '#b_proposal', 'Заявка на покупку');
			$("#b_proposal").css({
				"position": "relative",
				"padding": "0",
				"height": "auto"
			});
			$.get('../pfb.php', {}, function(response){
				$("#b_proposal").append(response).fadeIn('slow');
				$("#b_proposal").append('<p><a href="#" class="tabs-close-button" title="Закрыть вкладку"><img src="../_images/remove.png" width="32" height="32" alt="Закрыть вкладку" /></a></p>' + "<br />");
				$("#tabs").tabs('option', 'selected', '#b_proposal');
			});
		}
		return false;
	});
	$("#proposal-buy-a").click(function(){
		if ($("#b_proposal-lenta").length == 0) {
			$("#tabs").tabs("add", '#b_proposal-lenta', 'Куплю');
			$("#b_proposal-lenta").css({
				"position": "relative",
				"padding": "10px 0 0 0",
				"height": "auto"
			});
			$("#b_proposal-lenta").append('<iframe id="_b_proposal-lenta" src="spb.php" style="width:100%;height:1000px;overflow:hidden;" frameborder="0" scrolling="no"></iframe><p><a href="#" class="tabs-close-button" title="Закрыть вкладку"><img src="../_images/remove.png" width="32" height="32" alt="Закрыть вкладку" /></a></p>' + "<br />");
		}
		$("#tabs").tabs('option', 'selected', '#b_proposal-lenta');
		return false;
	});
	$("#s_exchanges").click(function(){
		if ($("#exchanges").length == 0) {
			$("#tabs").tabs("add", '#exchanges', 'Варианты обменов');
			$("#exchanges").css({
				"position": "relative",
				"padding": "10px 0 0 0",
				"height": "auto"
			});
			$("#exchanges").append('<iframe id="_exchanges" src="exchanges.php" style="width:100%;height:1050px;overflow:hidden;" frameborder="0" scrolling="no"></iframe><p><a href="#" class="tabs-close-button" title="Закрыть вкладку"><img src="../_images/remove.png" width="32" height="32" alt="Закрыть вкладку" /></a></p>' + "<br />");
		}
		$('#_exchanges').attr('src', 'exchanges.php');
		$("#tabs").tabs('option', 'selected', '#exchanges');
		return false;
	});	
	$("#link_ext_seach").click(function(){
		if ($("#extseach").length === 0) {
			$("#tabs").tabs("add", '#extseach', 'Расширенный поиск');
			$("#extseach").css({
				"position": "relative",
				"height": "auto"
			});
			$.get('../../left_search.php', {}, function(response){
				$("#extseach").append(response).fadeIn('slow');
				$("#extseach").append('<p><a href="#" class="tabs-close-button" title="Закрыть вкладку"><img src="../_images/remove.png" width="32" height="32" alt="Закрыть вкладку" /></a></p>' + "<br />");
			});
		}
		$("#tabs").tabs('option', 'selected', '#extseach');
		return false;
	});
	/*$.ajax({
	 type : "GET",
	 cache : false,
	 url : "../../base3.php",
	 success : function(response){
	 var rObject_t = JSON.parse(response);
	 // var  rObject_t = eval('(' + response + ')');
	 var myJSONText = JSON.stringify(rObject_t);
	 // 	alert  ( myJSONText);
	 }
	 }); */

	$("#autorization-dialog").dialog({
		title: 'Авторизация',
		bgiframe: true,
		autoOpen: false,
		width: 250,
		modal: true,
		buttons: {
			'Закрыть': function(){
				$(this).dialog('close');
			},
			'Войти': function(){
				$("#login").submit();
				$(this).dialog('close');
			}
		}
	});
		$('#enter_priv').click(function(){
		$('#autorization-dialog').dialog('open');
	});
	$("#tabs").tabs();
	$("#tabstest").tabs();
	$('#back_t').click(function(){
		$("#tabs").tabs('option', 'selected', '#objects');
		return false;
	});
	if (view == null) {
		view = "lenta";
		$.cookie("view", "lenta");
	}
	createView(view);
	function createView(view){
		switch (view) {
			case "lenta":
			default:
				$("#lenta").show();
				$("#table").hide();
				$('#v_lenta').attr('src', 'v_lenta.php');
				break;
			case "table":
				$("#lenta").hide();
				$("#table").show();
				$('#v_table').attr('src', 'v_table.php');
				break;
		}
	}
	$('#view_switch').click(function(){
		switch (view) {
			case "lenta":
				$.cookie("view", "table");
				createView("table");
				break;
			case "table":
				$.cookie("view", "lenta");
				createView("lenta");
				break;
			default:
				break;
		}
		view = $.cookie("view");
		return false;
	});
	///////////временно для манипуляции с агентами
	$("#agents_cur").click(function(){
		if ($("#temp_agents").length === 0) {
			$("#tabs").tabs("add", '#temp_agents', 'Манипуляции с агентами');
			$("#temp_agents").css({
				"position": "relative",
				"height": "auto"
			});
			$("#temp_agents").load('../../temporary_ag.php', function(){
				$("#temp_agents").append('<p><a href="#" class="tabs-close-button" title="Закрыть вкладку"><img src="../_images/remove.png" width="32" height="32" alt="Закрыть вкладку" /></a></p>' + "<br />");
				$("#tabs").tabs('option', 'selected', '#temp_agents');
			});
		}
		return false;
	});
	/////////////////////////
	///////////актуальные агенты
	$("#add_agent").click(function(){
		if ($("#p_agents").length === 0) {
			$("#tabs").tabs("add", '#p_agents', 'Сотрудники');
			$("#p_agents").css({
				"position": "relative",
				"padding": "0",
				"height": "auto"
			});
			$("#p_agents").load('../../participants.php', function(){
				$("#p_agents").append('<p><a href="#" class="tabs-close-button" title="Закрыть вкладку"><img src="../_images/remove.png" width="32" height="32" alt="Закрыть вкладку" /></a></p>' + "<br />");
				$("#tabs").tabs('option', 'selected', '#p_agents');
			});
		}
		return false;
	});
	 $(".agreement").live('click', function(){
		if ($("#tab_agreement").length === 0) {
			$("#tabs").tabs("add", '#tab_agreement', 'Пользовательское соглашение');
			$("#tab_agreement").css({
				"position": "relative",
				"padding": "0 20px",
				"font": " 1.2em helvetica, verdana, sans-serif",
				"height": "auto"
			});
			$("#tab_agreement").load('../../agreement.html', function(){
				$("#tab_agreement").append('<p><a href="#" class="tabs-close-button" title="Закрыть вкладку"><img src="../_images/remove.png" width="32" height="32" alt="Закрыть вкладку" /></a></p>' + "<br />");
				$("#tabs").tabs('option', 'selected', '#tab_agreement');
				$(window.document).scrollTo(0);
			});
		}
		return false;
	});
	////////////////////////////////
	////temporary
	$("#news2").click(function(){
		if ($("#news").length === 0) {
			$("#tabs").tabs("add", '#news', 'Новостная лента');
			$("#news").css({
				"position": "relative",
				"padding": "0 20px",
				"font": " 1.2em helvetica, verdana, sans-serif",
				"height": "auto"
			});
			$("#news").load('../../recomendation.html', function(){
				$("#news").append('<p><a href="#" class="tabs-close-button" title="Закрыть вкладку"><img src="../_images/remove.png" width="32" height="32" alt="Закрыть вкладку" /></a></p>' + "<br />");
				$("#tabs").tabs('option', 'selected', '#news');
			});
		}
		return false;
	});
});
function logOut(){
	$.post("../_scriptsphp/logout.php");
//	$.cookie("inquery", null);
	//window.location.reload();
	window.location.href = "/index.php";	
}
function openLink(type, room){
	$('#v_lenta').attr('src', 'v_lenta.php?type%5B%5D=' + type + '&room%5B%5D=' + room);
	$('#v_table').attr('src', 'v_table.php?type%5B%5D=' + type + '&room%5B%5D=' + room);
	$("#tabs").tabs('option', 'selected', '#objects');
};
function getCount(){
	$.getJSON("_scriptsphp/get_count.php", function(data){
		var room = -1;
		var count_dom = 0;
		var count_all_fl = 0;
		var count_str = 0;
		var count_office = 0;
		var count_pods = 0;
		var count_pr = 0;
		var count_torg = 0;
		var count_kot = 0;
		var count_gr = 0;
		var count_dach = 0;
		$.each(data, function(i, item){
			if (item.type_cod == 1) 
				count_dom += parseInt(item.count);
			if (item.type_cod == 2) {
				setCount(2, parseInt(item.room_cod), parseInt(item.count));
				count_all_fl += parseInt(item.count);
			}
			if (item.type_cod == 3) 
				count_str += parseInt(item.count);
			if (item.type_cod == 4) 
				count_office += parseInt(item.count);
			if (item.type_cod == 5) 
				count_pods += parseInt(item.count);
			if (item.type_cod == 6) 
				count_pr += parseInt(item.count);
			if (item.type_cod == 7) 
				count_torg += parseInt(item.count);
			if (item.type_cod == 8) 
				count_kot += parseInt(item.count);
			if (item.type_cod == 9) 
				count_gr += parseInt(item.count);
			if (item.type_cod == 10) 
				count_dach += parseInt(item.count);
		});
		setCount(1, room, count_dom);
		setCount(2, room, count_all_fl);
		setCount(3, room, count_str);
		setCount(4, room, count_office);
		setCount(5, room, count_pods);
		setCount(6, room, count_pr);
		setCount(7, room, count_torg);
		setCount(8, room, count_kot);
		setCount(9, room, count_gr);
		setCount(10, room, count_dach);
	});
};
function setCount(type, room, count){
	if (count != 0) {
		switch (type) {
			case 1:
				$('#count_dom').text(count);
				break;
			case 2:
				switch (room) {
					case 0:
						$('#count_0').text(count);
						break;
					case 1:
						$('#count_1').text(count);
						break;
					case 2:
						$('#count_2').text(count);
						break;
					case 3:
						$('#count_3').text(count);
						break;
					case 4:
						$('#count_4').text(count);
						break;
					default:
						$('#count_all_fl').text(count);
						break;
				}
				break;
			case 3:
				$('#count_str').text(count);
				break;
			case 4:
				$('#count_office').text(count);
				break;
			case 5:
				$('#count_pods').text(count);
				break;
			case 6:
				$('#count_pr').text(count);
				break;
			case 7:
				$('#count_torg').text(count);
				break;
			case 8:
				$('#count_kot').text(count);
				break;
			case 9:
				$('#count_gr').text(count);
				break;
			case 10:
				$('#count_dach').text(count);
				break;
			default:
				break;
		}
	}
}
function getCountPrivate(){
	$.getJSON("_scriptsphp/getCountPrivate.php", function(json){
		$("#count_sa").text(json.sale.actual[0]);
		$("#count_so").text(json.sale.outdated[0]);
		$("#count_exa").text(json.exchange.actual[0]);
		$("#count_exo").text(json.exchange.outdated[0]);
		});
}

function autoIframe(frameId){
	try {
		frame = document.getElementById(frameId);
		innerDoc = (frame.contentDocument) ? frame.contentDocument : frame.contentWindow.document;
		objToResize = (frame.style) ? frame.style : frame;
		objToResize.height = innerDoc.body.scrollHeight + 10;
	} 
	catch (err) {
		window.status = err.message;
	}
};
function removeMessageBox(){
	setTimeout(function () {
		$("#infomessage").fadeOut(10000).remove();
	}, 5000);
};
function removeMessageBoxforElement(element){
	setTimeout(function () {
	  $(element).fadeOut(10000).remove();
	}, 5000);
};
function closeTabOnTimeout(){
	setTimeout(function () {
		var selected = $('#tabs').tabs().tabs('option', 'selected');
		$("#tabs").tabs("remove", selected);
		$("#tabs").tabs("select", '#objects');
		$(document).scrollTo(0);
	}, 5000);
};
function show_ladvice_list()
			{
				$.ajax({
					url: "../legaladvice/onmainlist.php",
					cache: false,
					success: function(html){
						$("#advice").html(html);
								$('.advice_digest').mTruncate({
			length: 65,
			minTrail: 10,
			ellipsisText: "..."
		});
					}
				});			
			};
/*function pageload(hash) {
		// alert("pageload: " + hash);
		// hash doesn't contain the first # character.
		if(hash) {
			// restore ajax loaded state
			if($.browser.msie) {
				// jquery's $.load() function does't work when hash include special characters like åäö.
				hash = encodeURIComponent(hash);
			}
			//$("#load").load(hash + ".html");
		} else {
			// start page
			//$("#load").empty();
		}
	};*/
function PWD() {
	var m;
	var a;
	if(!a) { a = "8"}
	if(!m) {
		m = "1"
	}
	if(m == "0") { 
		var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_+=~`[]{}|\:;\"'<>,.?/ ";
	}
	if(m == "1") { 
		var chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234506789";
	}
	var pass = "";
	for (x=0; x < a; x++){
		rand  = Math.random() * chars.length;
		genn = Math.round(rand);
		while (genn<=0){
			genn++;
		}
		pass+=chars.charAt(genn);
	}
	return pass;
};	