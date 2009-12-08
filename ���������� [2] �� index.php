<?php
ob_start("ob_gzhandler"); 
include("_scriptsphp/main.inc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="pragma" content="no-cache" />
<title>Владивостокский Информационный Риэлторский Портал</title>
<noscript>
</noscript>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

<script type='text/javascript' src="/min/?g=js"></script>
<!--<script type="text/javascript" src="../_js/jquery/ui/jquery-ui-1.7.custom.js"></script>-->
<!--<script type="text/javascript" src="_js/plugins/jquery.blockUI.js"></script>-->
<!--<script type="text/javascript" src="_js/jquery/external/bgiframe/jquery.bgiframe.min.js"></script>-->
<!--<script type="text/javascript" src="../_js/jquery/external/cookie/jquery.cookie.min.js"></script>-->
<!--<script type="text/javascript" src="_js/plugins/jqueryslidemenu/js/jqueryslidemenu.js"></script>-->
<!--<script type="text/javascript" src="_js/plugins/jquery.form.js"></script>-->
<!--<script type="text/javascript" src="_js/plugins/jquery.cycle.all.min.js"></script>-->
<!--<script type="text/javascript" src="_js/plugins/jquery.validate.min.js"></script>-->
<!--<script type="text/javascript" src="_js/plugins/messages_ru.js"></script>-->
<!--[if IE 6]>
<style type="text/css">
body { width: expression((document.documentElement.clientWidth < 1010) ? '1000px' : '100%'); }
*html > body {
  height: 100%;
}
.d_table tbody td{
font-size: small;
}
#content {width: 63.8%;}
.big_content {
 width: 94%;
  height: 500px;
  overflow: auto;
}
</style>
<![endif]-->
<script type="text/javascript">
$(document).ready(function(){
  $("#leftmenu").accordion({
    collapsible : true,
    autoHeight : true
  }
  );
  $('#logoslide').cycle({
    fx:     'scrollLeft',
    timeout: 6000,
    delay:  -2000
});
}
);
</script>
<script type="text/javascript">
var gridimgpath = 'themes/lightness/images';
jQuery(document).ready(function(){

  /* 	$.jgrid.defaults = $.extend($.jgrid.defaults, {loadui : "enable"}); */
  /* $('#switcher').themeswitcher(); */
  // $.jgrid.defaults = $.extend($.jgrid.defaults, {loadui : "block"});
  /*  var imgarr = {basic : 'themes/basic/images', coffee : 'themes/coffee/images', green : 'themes/green/images', sand : 'themes/sand/images', steel : 'themes/steel/images'};
  // end splitter
  $("#styleswitch").change(function(){
  switchStylestyle($(this).val());
  gridimgpath = imgarr[$(this).val()];
  return false;
  });
  var c = readCookie('style');
  if (c) {
  switchStylestyle(c);
  $("option", "#styleswitch").each(function(){
  if ($(this).val() == c) {
  this.selected = true;
  gridimgpath = imgarr[c];
  }
  else this.selected = false;
  });
  }   */
}
);
</script>
<!--<script type="text/javascript"
  src="http://ui.jquery.com/themeroller/themeswitchertool/">
</script>-->
<!--<link href="_js/jquery/themes/smoothness/ui.all.css" rel="stylesheet" type="text/css" />-->
<link href="/min/?g=css" rel="stylesheet" type="text/css" />
</head><script type="text/javascript">
function openLink(type, room)
{
	$('#v_lenta').attr('src','v_lenta.php?type%5B%5D=' + type +'&room%5B%5D=' + room);
	$('#v_table').attr('src','v_table.php?type%5B%5D=' + type +'&room%5B%5D=' + room);
	$("#tabs").tabs('option', 'selected', '#objects');
}
function setCount(type, room, count)
{
	if(count !=0){
	switch (type){
		case 1:
		$('#count_dom').text(count);
		break;
		case 2:
		switch (room){
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
$(document).ready(function()
{
	$.getJSON("_scriptsphp/get_count.php",
        function(data){
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
          $.each(data, function(i,item){
			if(	item.type_cod == 1)	
			count_dom += parseInt(item.count);
			if(	item.type_cod == 2){
			setCount(2, parseInt(item.room_cod), parseInt(item.count));
			count_all_fl += parseInt(item.count);
			}
			if(	item.type_cod == 3)	
			count_str += parseInt(item.count);
			if(	item.type_cod == 4)	
			count_office += parseInt(item.count);
			if(	item.type_cod == 5)	
			count_pods += parseInt(item.count);
			if(	item.type_cod == 6)	
			count_pr += parseInt(item.count);
			if(	item.type_cod == 7)	
			count_torg += parseInt(item.count);
			if(	item.type_cod == 8)	
			count_kot += parseInt(item.count);
			if(	item.type_cod == 9)	
			count_gr += parseInt(item.count);
			if(	item.type_cod == 10)	
			count_dach += parseInt(item.count);
          });
		  setCount(1, room, count_dom);
		  setCount(2, room, count_all_fl);
		  setCount(3, room, count_str);
		  setCount(4, room, count_str);
		  setCount(5, room, count_pods);
		  setCount(6, room, count_pr);
		  setCount(7, room, count_torg);
		  setCount(8, room, count_kot);
		  setCount(9, room, count_gr);
		  setCount(10, room, count_dach);
        });

/*
$.get("base2.php", { type: "10", show:"1" },
   function(data){
	   if(data!=0){
    $('#count_dach').text(data);
	   } else {
	$("#dachi").removeClass('show').addClass('hide'); 
	//$("#dachi").toggle();
	   }
   });*/
$("#fl").click(function()
  {
		openLink(2);
		return false;
  });
$("#pods").click(function()
  {
		openLink(5);
		return false;
  });
$("#0_fl").click(function()
  {
		openLink('2','0');
		return false;
  });
$("#1_fl").click(function()
  {
		openLink(2,1);
		return false;
  });
$("#2_fl").click(function()
  {
		openLink(2,2);
		return false;
  });
$("#3_fl").click(function()
  {
		openLink(2,3);
		return false;
  });
$("#4_fl").click(function()
  {
		openLink(2,4);
		return false;
  });
$("#office").click(function()
  {
		openLink(4);
		return false;
  });
$("#stroyeniya").click(function()
  {
		openLink(3);
		return false;
  });
$("#proizvod").click(function()
  {
		openLink(6);
		return false;
  });
$("#torgovlya").click(function()
  {
		openLink(7);
		return false;
  });
$("#dom").click(function()
  {
		openLink(1);
		return false;
  });
$("#kottedg").click(function()
  {
		openLink(8);
		return false;
  });
$("#grounds").click(function()
  {
		openLink(9);
		return false;
  });
$("#dachi").click(function()
  {
		openLink(10);
		return false;
  });
  $("#registr").click(function()
  {
    if( $("#form-registr").length === 0){
      $("#tabs").tabs("add", '#form-registr', 'Регистрация пользователей');
      $("#form-registr").css({
        "position" : "relative", "height" : "auto"
      }
      );
      /* 	$("#advertis").load('../../example_jqs/form/form.html', function () { */
      $("#form-registr").load('../../registration.php', function () {
        $("#form-registr").append('<p><a href="#" id="close_form_reg" title="Закрыть" style ="float: right;">Закрыть</a></p>' + "<br />");
        $("#tabs").tabs('option', 'selected', '#form-registr');
		$("#next1").click(function()
  {
   var rad_val = $(":radio[name=radGroupregform1]").filter(":checked").val();
   $('#regpage').removeClass('show').addClass('hide');
      switch (rad_val)
   {
       case 'company' :
   			$('#regpage1').removeClass('hide').addClass('show');
           break;
       case 'agency' :
   			$('#regpage2').removeClass('hide').addClass('show');
			$('#createpass').removeClass('hide').addClass('show');
           break;
       default:
   
   }
   });
   $("#next2").click(function()
  {
   rad_val = $(":radio[name=radGroupregform2]").filter(":checked").val();
   $('#regpage1').removeClass('show').addClass('hide');
      switch (rad_val)
   {
       case 'knownconpany' :
	   $.getJSON("_scriptsphp/getcompany.php", function(json){
   					$('#companyname').fillSelect(json).attr('disabled','').removeClass('hide').addClass('show');
 					});
   			$('#regpage1-1').removeClass('hide').addClass('show');
           break;
       case 'newcompany' :
   			$('#regpage1-0').removeClass('hide').addClass('show');
           break;
       default:
   
   }
   $('#createpass').removeClass('hide').addClass('show');
   return false;
   });
   $("#back2").click(function()
  {
    $('#regpage1').removeClass('show').addClass('hide');
    $('#regpage').removeClass('hide').addClass('show');
	return false;   
   });
   $("#back3-0").click(function()
  {
  $('#createpass').removeClass('show').addClass('hide');
    $('#regpage1-0').removeClass('show').addClass('hide');
    $('#regpage1').removeClass('hide').addClass('show'); 
	return false;  
   });
     
  $("#regcompany").validate({
		rules: {
			n_companyname: "required",
			inn: {
				required: true,
				minlength: 4
			},
			compayleaderferstname: "required",
			compayleadersecondname: "required",
			compayleaderlastname: "required",
			compayleaderpassword: {
				required: true,
				minlength: 5
			},
			compayleaderconfpass: {
				required: true,
				minlength: 5,
				equalTo: "#compayleaderpassword"
			}
		},
		submitHandler: function(form) {
				jQuery(form).ajaxSubmit();
					$('#regpage1-0').removeClass('show').addClass('hide');
    				$('#regpage1-1').removeClass('hide').addClass('show');
					var str = $("input[name='n_companyname']").val();			
					if(str == ""){
					$.getJSON("_scriptsphp/getcompany.php", function(json){
   					$('#companyname').fillSelect(json).attr('disabled','');
 					});
					$('#companyname').removeClass('hide').addClass('show');
					} else {
					$('#cell').removeClass('hide').addClass('show').text(str);
					$("#h_companyname").val(str);
					}
					return false;
				}
				
	});
  $("#compayleaderpassword").blur(function() {
		$("#compayleaderconfpass").valid();
	});
    $("#regsubdivision").validate({
		rules: {
			subdname: {
				required: true,
				minlength: 5
				//event: "blur"
			},
			subdphon: "required",
			subleaderferstname: "required",
			subleadersecondname: "required",
			subleaderlastname: "required",
			subleaderlogin: "required",
			subleaderpassword: {
				required: true,
				minlength: 5
			},
			subleaderconfpass: {
				required: true,
				minlength: 5,
				equalTo: "#subleaderpassword"
			}
		},
		submitHandler: function(form) {
				jQuery(form).ajaxSubmit();
					$('#regpage1-1').removeClass('show').addClass('hide');
					$('#createpass').removeClass('show').addClass('hide');
    				$('#end-reg').removeClass('hide').addClass('show');
					return false;
				}			
	});
  $("#subleaderpassword").blur(function() {
		$("#subleaderconfpass").valid();
	});
  
/*	$("#next3-1").click(function() 
  {
	  alert ($("#h_companyname").val());
	  alert ($("#companyname option:selected").text());
	return false;   
   });*/
   $("#back3-1").click(function()
  {
  $('#createpass').removeClass('show').addClass('hide');
  $('#cell').removeClass('show').addClass('hide');
  $('#companyname').removeClass('show').addClass('hide');
    $('#regpage1-1').removeClass('show').addClass('hide');
    $('#regpage1').removeClass('hide').addClass('show');
	return false;   
   });
   $("#back4-1").click(function()
  {
  $('#createpass').removeClass('show').addClass('hide');
    $('#regpage2').removeClass('show').addClass('hide');
    $('#regpage').removeClass('hide').addClass('show');
	return false;   
   });
      }
      );
    }
    return false;
  }
  );
}
);
</script>
<script type="text/javascript">
(function($){
  // очищаем select
  $.fn.clearSelect = function() {
    return this.each(function(){
      if(this.tagName=='SELECT') {
        this.options.length = 0;
        $(this).attr('disabled','disabled');
      }
    });
  }
  // заполняем select
$.fn.fillSelect = function(dataArray) {
    return this.clearSelect().each(function(){
      if(this.tagName=='SELECT') {
        var currentSelect = this;
        $.each(dataArray,function(index,data){
          var option = new Option(data.Name,data.Id);
          if($.support.cssFloat) {
            currentSelect.add(option,null);
         } else {
            currentSelect.add(option);
          }
        });
      }
    });
  }
})(jQuery);
  </script>
<script type="text/javascript">
$(document).ready(function()
{
  $("#add_advert").click(function()
  {
    if( $("#advertis").length == 0){
      $("#tabs").tabs("add", '#advertis', 'Добавление объявления');
      $("#advertis").css({
        "position" : "relative", 'background-color' : '#CCCCCC', "height" : "auto"
      }
      );
      /* 	$("#advertis").load('../../example_jqs/form/form.html', function () { */
      $("#advertis").load('add_advert.php', function () {
      $("#advertis").append('<p><a href="#" id="back_2" title="Закрыть" style =" float: right;">Закрыть</a></p>' + "<br />");
        $("#tabs").tabs('option', 'selected', '#advertis');
      }
      );
    }
    return false;
  }
  );
  $("#add_exchange").click(function()
  {
    if( $("#a_exchange").length === 0){
      $("#tabs").tabs("add", '#a_exchange', 'Добавление обмена');
      $("#a_exchange").css({
        "position" : "relative", 'background-color' : '#999999', "height" : "auto"
      }
      );
      $("#a_exchange").load('../../add_exchanges.php', function () {
        $("#tabs").tabs('option', 'selected', '#a_exchange');
        $("#a_exchange").append('<p><a href="#" id="del_a_exchange" title="Закрыть" style =" float: right;">Закрыть</a></p>' + "<br />");
        $('#del_a_exchange').click(function() {
          var selected = $('#tabs').tabs().tabs('option', 'selected');
          alert(selected);
          $("#tabs").tabs('option', 'selected', '#objects');
          $("#tabs").tabs("remove", selected);
          return false;
        }
        );
      }
      );
    }
    return false;
  }
  );
  $("#add_vacancy").click(function()
  {
    if( $("#vacancy").length === 0){
      $("#tabs").tabs("add", '#vacancy', 'Вакансии');
      $("#vacancy").css({
        "position" : "relative", "height" : "auto"
      }
      );
      $.get('../../vacy.html', {
      }
      ,
      function(response){
        $("#vacancy").append(response).fadeIn('slow');
        $("#vacancy").append('<p><a href="#" id="back_2" title="Назад" style =" float: right;">Назад</a></p>' + "<br />");
        $("#tabs").tabs('option', 'selected', '#vacancy');
      }
      );
    }
    return false;
  }
  );
  $("#s_exchanges").click(function()
  {
    if( $("#exchanges").length === 0){
      $("#tabs").tabs("add", '#exchanges', 'Варианты обменов');
      $("#exchanges").css({
        "position" : "relative", "padding" : "10px 0 0 0", "height" : "auto"
      }
      );
	  $("#exchanges").append('<iframe id="_exchanges" src="exchanges.php" style="width:100%;height:1000px;overflow:hidden;" frameborder="0" scrolling="no"></iframe><p><a href="#" id="close_exchanges" class="tabs-close-button" title="Закрыть">Закрыть</a></p>' + "<br />");      
    }
	 $("#tabs").tabs('option', 'selected', '#exchanges');
    return false;
  }
  );

  $("#link_ext_seach").click(function()
  {
    if( $("#extseach").length === 0){
      $("#tabs").tabs("add", '#extseach', 'Расширенный поиск');
      $("#extseach").css({
        "position" : "relative", "height" : "auto"
      }
      );
      $.get('../../left_search.php', {
      }
      ,
      function(response){
        $("#extseach").append(response).fadeIn('slow');
        $("#extseach").append('<p><a href="#" id="close_ext_seach" title="Закрыть" style =" float: right;">Закрыть</a></p>' + "<br />");
        $('#close_ext_seach').click(function() {
          var selected = $('#tabs').tabs().tabs('option', 'selected');
          $("#tabs").tabs('option', 'selected', '#objects');
          $("#tabs").tabs("remove", selected);
          return false;
        }
        );
      }
      );
    } 
	$("#tabs").tabs('option', 'selected', '#extseach');
    return false;
  }
  );

}
);
</script>
<script type="text/javascript">
$(document).ready(function()
{
  $("#b_table").click(function()
  {
    if( $("#objects").length === 1){
      // $("#tabs").tabs("add", '#objects', 'Продажа квартир');
      // $("#tabs-6").load('../../add_advert.php ');
      /* 	$.get('../../base.php', {},
      function(response){
      $("#objects").append(response).fadeIn('slow');
      // $("#table").append(response).fadeIn('slow');
      }); */
      $("#tabs").tabs('option', 'selected', '#objects');
      return false;
    }
  }
  );
}
);
</script>
<!--<script type="text/javascript">
/* $(document).ready(function(){
$.ajax({
type : "GET",
cache : false,
url : "../../base3.php",
success : function(response){
var rObject_t = JSON.parse(response);
// var  rObject_t = eval('(' + response + ')');
var myJSONText = JSON.stringify(rObject_t);
// 	alert  ( myJSONText);
}
});
}); */
</script>-->
<script type="text/javascript">
var view = $.cookie("view");
$(document).ready(function(){
  $('#enter_priv').click(function() {
    $('#autorization-dialog').dialog('open');
  }
  );
  $("#autorization-dialog").dialog({
    title : 'Авторизация',
    bgiframe : true,
    autoOpen : false,
    width : 250,
    modal : true,
    buttons : {
      'Закрыть' : function() {
        $(this).dialog('close');
      }
      ,
      'Войти' : function() {
        $("#login").submit();
        $(this).dialog('close');
      }
    }
  }
  );

  $("#tabs").tabs();
  $("#tabstest").tabs();
  $('#back_t').click(function() {
    $("#tabs").tabs('option', 'selected', '#objects');
    return false;
  }
  );
  if(view == null){
    view = "lenta";
    $.cookie("view", "lenta");
  }
  createView(view);
  function createView( view )
  {
    switch(view)
    {
      case "lenta" :
      default :
        $("#lenta").show();
        $("#table").hide();
        break;
      case "table" :
        $("#lenta").hide();
        $("#table").show();
        break;
    }
  }
  $('#view_switch').click(function() {
    switch(view)
    {
      case "lenta" :
      $.cookie("view", "table");
      createView("table");
      break;
      case "table" :
      $.cookie("view", "lenta");
      createView("lenta");
      break;
      default :
      break;
    }
    view = $.cookie("view");
    return false;
  }
  );
}
);
</script>
<body>
<script type="text/javascript" src="../_js/script/preloader.js"></script>
<div id="header">
  <div id="logoslide">
    <div> <a href="/"> <img src="_images/fol_logo_m.jpg" alt="" /> <br/>
      г.Владивосток, ул. Адм. Юмашева д.4 к.22, <br/>
      т.44-44-50 </a></div>
    <div>
      <h1>РК &quot;Альянс&quot;</h1>
    </div>
    <div> <img src="_images/avega_logo.gif" alt="" /> </div>
    <div><img src="_images/omega_logo.jpg" alt="" /> </div>
  </div>
  <div id="site_name">Владивостокский<br />
    Информационный<br />
    <span style="white-space:nowrap">Риэлторский ПортаЛ</span> </div> 
  <div id="accsess"><a href="#" id="enter_priv" style="white-space:nowrap;"> <span style="font-size:large">Вход в личный кабинет</span></a><br />
    <a href="#" id="registr">Регистрация</a><a href="#" id="remember" style="padding-left: 45px; white-space:nowrap;">Забыли пароль?</a> </div>
  <div id="autorization-dialog" title="Авторизация">
    <form id="login" method="post" action="">
      <label for="name" class="label">Логин:</label>
      <input type="text" name="user_name" id="name" class="input_a_form"/>
      <br/>
      <label for="password" class="label">Пароль:</label>
      <input type="password" name="user_pass" id="password" class="input_a_form" value=""/>
    </form>
  </div>
  <div id="myslidemenu" class="jqueryslidemenu">
    <ul>
      <li><a href="http://www.dynamicdrive.com">Item 1</a></li>
      <li><a href="#">Item 2</a></li>
      <li><a href="#">Folder 1</a>
        <ul>
          <li><a href="#">Sub Item 1.1</a></li>
          <li><a href="#">Sub Item 1.2</a></li>
          <li><a href="#">Sub Item 1.3</a></li>
          <li><a href="#">Sub Item 1.4</a></li>
        </ul>
      </li>
      <li><a href="#" id="add_vacancy">Вакансии</a></li>
      <li><a href="#">Частным лицам</a>
        <ul>
          <li><a href="#">Оставить заявку</a>
            <ul>
              <li><a href="#">На продажу</a></li>
              <li><a href="#">На покупку</a></li>
              <li><a href="#">Ваш обмен</a>
                <ul>
                  <li><a href="#">Sub Item 3.1.1.1</a></li>
                  <li><a href="#">Sub Item 3.1.1.2</a></li>
                  <li><a href="#">Sub Item 3.1.1.3</a></li>
                  <li><a href="#">Sub Item 3.1.1.4</a></li>
                  <li><a href="#">Sub Item 3.1.1.5</a></li>
                </ul>
              </li>
              <li><a href="#">Sub Item 2.1.4</a></li>
            </ul>
          </li>
        </ul>
      </li>
      <li><a href="#">Добавить объявление</a>
        <ul>
          <li><a href="#" id="add_advert">Продажа квартиры</a></li>
          <li><a href="#" id="add_exchange">Обмен</a></li>
        </ul>
      </li>
    </ul>
    <br style="clear:left;" />
  </div>
  <!---->
</div>
<div id="container">
  <div id="left">
    <div id="leftmenu">
      <h2><a href="#" id="inhabitad">Жилая недвижимость</a></h2>
      <div style="margin:0; padding:10px;">
        <ul>
          <!--   <ul class="h_menu">-->
          <li><a href="#" id="fl" class="mlink">Все квартиры</a><span id="count_all_fl" class="count"></span></li>
          <li><a href="#" id="pods" class="mlink">Подселения</a><span id="count_pods" class="count"></span></li>
          <li><a href="#" id="0_fl" class="mlink">Гостинки</a><span id="count_0" class="count"></span></li>
          <li><a href="#" id="1_fl" class="mlink">1-комнатные</a><span id="count_1" class="count"></span></li>
          <li><a href="#" id="2_fl" class="mlink">2-комнатные</a><span id="count_2" class="count"></span></li>
          <li><a href="#" id="3_fl" class="mlink">3-комнатные</a><span id="count_3" class="count"></span></li>
          <li><a href="#" id="4_fl" class="mlink" >4-комнатные</a><span id="count_4" class="count"></span></li>
          <!--          <li><a href="#" id="b_table">Продажа квартир</a></li>-->
          <li><a href="#" id="s_exchanges" class="mlink">Обмены</a></li>
          <li><a href="#" id="link_ext_seach" class="mlink">Расширенный поиск</a></li>
        </ul>
      </div>
      <h2><a href="#">Коммерческая недвижимость</a></h2>
      <div style="margin:0; padding:10px;">
        <ul>
          <li><a href="#" id="office" class="mlink">Офисы</a><span id="count_office" class="count"></span></li>
          <li><a href="#" id="stroyeniya" class="mlink">Отдельностоящие строения</a><span id="count_str" class="count"></span></li>
          <li><a href="#" id="proizvod" class="mlink">Производственно-складские помещения</a><span id="count_pr" class="count"></span></li>
          <li><a href="#" id="torgovlya" class="mlink">Торговые помещения</a><span id="count_torg" class="count"></span></li>
        </ul>
      </div>
      <h2><a href="#">Дома, участки и дачи</a></h2>
      <div style="margin:0; padding:10px;">
        <ul>
          <li><a href="#" id="dom" class="mlink">Дома</a><span id="count_dom" class="count"></span></li>
          <li><a href="#" id="kottedg" class="mlink">Коттеджи</a><span id="count_kot" class="count"></span></li>
          <li><a href="#" id="grounds" class="mlink">Земельные участки</a><span id="count_gr" class="count"></span></li>
          <li><a href="#" id="dachi" class="mlink">Дачи</a><span id="count_dach" class="count"></span></li>
        </ul>
      </div>
    </div>
  </div>
  <div id="right">
    <div id="tabstest">
      <ul>
        <li><a href="#fragment-1"><span>One</span></a></li>
        <li><a href="#fragment-2"><span>Two</span></a></li>
        <li><a href="#fragment-3"><span>Three</span></a></li>
      </ul>
      <div id="fragment-1"> </div>
      <div id="fragment-2"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </div>
      <div id="fragment-3"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </div>
    </div>
  </div>
  <div id="content">
    <div id="tabs">
      <ul>
        <li><a href="#objects">Продажа</a></li>
        <li><a href="pi.html">AjaxText</a></li>
        <!--     <li><a href="#tabs-6">Добавление объявления</a></li>-->
      </ul>
      <div id="objects"> <span style="padding-left:10px">В виде:<a href="#" id="view_switch" title="Представление" style =" padding-left: 10px;">Таблицы/Ленты</a></span> <br />
        <br />
        <div id="lenta" class="hide">
          <iframe id="v_lenta" src="v_lenta.php" style="width:100%;height:800px;overflow:hidden;" frameborder="0" scrolling="no"> </iframe>
        </div>
        <div id="table" class="show">
          <iframe id="v_table" src="v_table.php" style="width:100%;height:800px;overflow:hidden;" frameborder="0" scrolling="no"> </iframe>
        </div>
      </div>
    </div>
  </div>
  <div id="footer">
    <div class="bg"></div>
    <div class="inner">
      <p> <span class="first">Sponsored by: </span><a class="block liferay" href="http://www.liferay.com/"><span>Liferay</span></a> <a class="block filamentgroup" href="http://www.filamentgroup.com/"><span>Filamentgroup</span></a> <span class="first" style="float: right; padding-right: 12px;">&copy; 2009 Crocus <a href="http://jqueryui.com/about">jQuery UI Team</a>.</span> </p>
    </div>
  </div>
</div>
</body>
</html>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/jquery-ui.min.js"></script>
<?php ob_end_flush();?> 