<?php
include('base2.php');
include"_scriptsphp/main.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RealtorPlus</title>
<script type="text/javascript" src="_js/jquery/jquery-1.3.2.js"></script>
<script type="text/javascript" src="_js/jquery/ui/ui.core.js"></script>
<script type="text/javascript" src="_js/jquery/external/bgiframe/jquery.bgiframe.js"></script>
<script type="text/javascript" src="_js/jquery/ui/jquery-ui-1.7.custom.js"></script>
<script type="text/javascript" src="_js/plugins/ext_libs/json/json2.js"></script>
<!---->
<!--<script src="js/jquery.ui.all.js" type="text/javascript"></script>-->
<!--<script src="js/jquery.jqGrid.js" type="text/javascript"></script>
<script src="js/jquery.tablednd.js" type="text/javascript"></script>
<script src="js/jqModal.js" type="text/javascript"></script>
<script src="js/jqDnR.js" type="text/javascript"></script>-->
<!---->
<script type="text/javascript" src="_js/plugins/tablesorter/js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="_js/plugins/lightbox/js/jquery.lightbox.js"></script>
<script type="text/javascript" src="_js/plugins/thickbox/js/thickbox.js"></script>
<script type="text/javascript" src="_js/plugins/jqueryslidemenu/js/jqueryslidemenu.js"></script>
<script type="text/javascript" src="_js/plugins/tabslide/js/jquery.tabSlide.js"></script>
<script type="text/javascript" src="_js/plugins/tabslide/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="_js/plugins/jquery.form.js"></script>

<style type="text/css">
@import url("_style/test.css");
@import url("_style/top_menu_a.css");
@import url("_js/plugins/tablesorter/css/tablesorter.css");
@import url("_js/plugins/jqueryslidemenu/css/jqueryslidemenu.css");
@import url("_js/plugins/thickbox/css/thickbox.css");
@import url("_js/plugins/tabslide/css/tabslide.css");
</style>
<!--[if IE 6]>
<style type="text/css">
body { width: expression((document.documentElement.clientWidth < 1010) ? '1000px' : '100%'); }
*html > body {
  height: 100%;
}
.h_menu {
  width: 68%;
}

.d_table tbody td{
font-size: small;
}
#tabs-4 {
  font-size:  65%;
}
#content { 	width: 62%;}
.big_content { 
 width: 94%; 
  height: 500px;
  overflow: auto;
}
.active{ left: 0%; }
</style>
<script type="text/javascript">
$("#leftmenu").bind("accordionchange", function(event, ui) {
  ui.options (autoHeight: true)
});
</script>
<![endif]-->
<script type="text/javascript">
var gridimgpath = 'themes/lightness/images';
jQuery(document).ready(function(){
			
/*	$.jgrid.defaults = $.extend($.jgrid.defaults,{loadui:"enable"});*/
/* $('#switcher').themeswitcher();*/
	//$.jgrid.defaults = $.extend($.jgrid.defaults,{loadui:"block"});
  /*  var imgarr = {basic: 'themes/basic/images',coffee: 'themes/coffee/images',green: 'themes/green/images',sand: 'themes/sand/images',steel: 'themes/steel/images'};
// end splitter
    $("#styleswitch").change(function(){
		switchStylestyle($(this).val());
        gridimgpath = imgarr[$(this).val()];
		return false;
    }); 
	var c = readCookie('style');
    if (c) {
        switchStylestyle(c);
        $("option","#styleswitch").each(function(){
            if ($(this).val()==c) {
                this.selected = true;
                gridimgpath = imgarr[c];
            }
            else this.selected=false;
        }); 
		}   */
});
</script>
<!--<script type="text/javascript"
  src="http://ui.jquery.com/themeroller/themeswitchertool/">
</script>-->
<link href="_js/jquery/themes/smoothness/ui.all.css" rel="stylesheet" type="text/css" />
</head>
<script type="text/javascript">
$(document).ready(function()
 {
  $("#add_advert").click(function()
   { 
  	if( $("#advertis").length == 0){
   	$("#tabs").tabs("add", '#advertis', 'Добавление объявления');
	$("#advertis").css({"position":"relative",'background-color' : '#CCCCCC',"height":"auto"});
/*	$("#advertis").load('../../example_jqs/form/form.html', function () {*/
	$("#advertis").load('add_advert.php', function () {
	$("#advertis").append('<p><a href="javascript:void(0)" id="back_2" title="Закрыть" style =" float: right;">Закрыть</a></p>' + "<br />"); 
	 $("#tabs").tabs('option', 'selected', '#advertis');
});
	} 
   return false;
   });  	 
});
</script>
<script type="text/javascript">
$(document).ready(function()
 {
  $("#add_exchange").click(function()
   { 
  	if( $("#a_exchange").length == 0){
   	$("#tabs").tabs("add", '#a_exchange', 'Добавление обмена');
	$("#a_exchange").css({"position":"relative",'background-color' : '#999999',"height":"auto"});
	$("#a_exchange").load('../../add_exchanges.php', function () {
	 $("#tabs").tabs('option', 'selected', '#a_exchange');
	$("#a_exchange").append('<p><a href="#" id="del_a_exchange" title="Закрыть" style =" float: right;">Закрыть</a></p>' + "<br />");
$('#del_a_exchange').click(function() { 
	var selected = $('#tabs').tabs().tabs('option', 'selected');
	alert(selected);
    $("#tabs").tabs('option', 'selected', '#objects');
    $("#tabs").tabs("remove", selected);
    return false;
});
});
	} 
   return false;
   });
    $("#add_vacancy").click(function()
   { 
  	if( $("#vacancy").length == 0){
   	$("#tabs").tabs("add", '#vacancy', 'Вакансии');
	$("#vacancy").css({"position":"relative","height":"auto"});
		$.get('../../vacy.html',{},
		function(response){
		$("#vacancy").append(response).fadeIn('slow');
		$("#vacancy").append('<p><a href="javascript:void(0)" id="back_2" title="Назад" style =" float: right;">Назад</a></p>' + "<br />");
		$("#tabs").tabs('option', 'selected', '#vacancy');
});
	} 
   return false;
   });
   $("#s_exchanges").click(function()
   { 
  	if( $("#exchanges").length == 0){
   	$("#tabs").tabs("add", '#exchanges', 'Варианты обменов');
	$("#exchanges").css({"position":"relative","height":"auto"});
		$.get('../../exchanges.php',{},
		function(response){
		$("#exchanges").append(response).fadeIn('slow');
		$("#exchanges").append('<p><a href="javascript:void(0)" id="back_2" title="Назад" style =" float: right;">Назад</a></p>' + "<br />");
		$("#tabs").tabs('option', 'selected', '#exchanges');
});
	} 
   return false;
   });
});
</script>
<script type="text/javascript">
$(document).ready(function()
 {
  $("#b_table").click(function()
   { 
  	if( $("#objects").length == 1){
   	//$("#tabs").tabs("add", '#objects', 'Продажа квартир');
	$("#objects:hidden").show("fast");
	//$("#tabs-6").load('../../add_advert.php ');
	$.get('../../base2.php',{},
								function(response){
									$("#loading_animation").hide();
									$("#objects").append(response).fadeIn('slow');
								});
	$("#tabs").tabs('option', 'selected', '#objects'); 
   return false;
   }
   });
});
</script>
<script type="text/javascript">
$(document).ready(function(){
$("#leftmenu").accordion({
			collapsible: true,
			autoHeight: false
		}); 
$('#companyslide').slideNews({
/*				btNext:'a.next',
				btPrev:'a.prev',*/
				tabsNews:'ul.tabset a',
				holderList: 'div.tab-holder',
				scrollElParent: 'ul',
				scrollEl: 'li',
				autoSlide:3000
			});	
});
</script>
<script type="text/javascript">
$(document).ready(function(){
	$(".btn-slide").click(function(){
		$("#panel1").slideToggle("fast");
		$(this).toggleClass("active");
		$(".slide").toggleClass("active");
		$(".btn-slide").toggleClass("active");
		return false;
	}); 
	
});
</script>
<script type="text/javascript">
$(document).ready(function(){
// ---- tablesorter -----
$("#example").tablesorter({
	sortList:[[1,0]],
	widgets: ['zebra']
});
});
</script>
<script type="text/javascript">
/*$(document).ready(function(){
$.ajax({
   type: "GET",
   cache: false,
   url: "../../base3.php",
   success: function(response){
	var rObject_t = JSON.parse(response);
 	//var  rObject_t = eval('(' + response + ')');
	var myJSONText = JSON.stringify(rObject_t);
 //	alert  ( myJSONText); 
			}
});
});*/
</script>
<script type="text/javascript">
$(document).ready(function(){
  $('#enter_priv').click(function() {
			$('#autorization-dialog').dialog('open');
});
  $("#autorization-dialog").dialog({
  	title: 'Авторизация',
			bgiframe: true,
			autoOpen: false,
			width: 250,
			modal: true,
  	buttons: {  
     		'Закрыть': function() { $(this).dialog('close'); },  
       		'Войти': function() { 
			$("#login").submit();
			$(this).dialog('close');
 }  
    }  
  });

});
</script>
<script type="text/javascript">
	$(document).ready(function(){
	$("#tabs").tabs();
	    $("#tabstest").tabs();
	$('#back_t').click(function() { 
    $("#tabs").tabs('option', 'selected', '#objects');
    return false;
});
});
</script>
<script type="text/javascript">
function showPopup(flat_id)
{
<!--alert (flat_id);-->
$.ajax({
   type: "GET",
   cache: false,
   url: "../../detail_dialog.php",
   data: "id=" + flat_id,
   success: function(response){
   var obj = eval("(" + response + ")");
 // var rObject = JSON.parse(response);
   alert(response); 
 
  var result = 	"Код объявления:" + obj.flats_cod + "<br />" +
  				"Дата постановки:" + obj.flats_date + "<br />" +
				"Примечание:" + obj.flats_comments+ "<br />"; 
var phon;				
(obj.flats_tel == 1) ? phon = "есть" :  phon = "отсутствует";
result = result + "Телефонная точка:" + phon + "<br />"  + "<br />" +
   '<div class="section"><ul id="gallery_din">';
   for( var i=0; i< obj.foto; i++){
    result = result +  '<li><a href="../../base5.php?image=' + i + '"><img src="../../base5.php?image=' + i + '&min=1" alt="" /></a></li>';
}
    result = result + '</ul></div>' + "<br />" + 
	'<p><a href="#" id="back_2" title="Назад" style =" float: right;">Назад</a></p>' + "<br />";

	//document.getElementById("popupDetail").innerHTML = "Код объявления:" + rObject.flats_cod;
	//document.getElementById("popupDetail").innerHTML = "Дата постановки:" + obj.flats_date;
	//document.getElementById("popupDetail").innerHTML = "Примечание:" + rObject.flats_comments;
 

	//$("#card_o").prepend(result);
	$("#card_o").html(result);
	 	$("#gallery_din").css({"list-style":"none"});
	$("#gallery_din li").css({"display":"inline", "margin":"5px"});
	$("#gallery_din img").css({"background-color":"#ECECEC", "padding": "5px 5px 10px", "border":"1px solid #333333"});
	$("#gallery_din img").live("mouseover", function(){$(this).css({"background-color":"#FFF"});});
	//$("#gallery_din img").live("mouseover", function(){$(this).css("opacity", 0.8);});
	$("#gallery_din img").live("mouseout", function(){$(this).css({"background-color":"#ECECEC"});});
	//document.getElementById("resizable").innerHTML = result;

	if(jQuery("#card_o").css("display")=="none") {
			jQuery("#objects").hide();
			jQuery("#card_o").show();
		}
	//$("#tabs").tabs('option', 'selected', '#card_o');
	$('#back_2').click(function() { 
   // $("#tabs").tabs('option', 'selected', '#objects');
   jQuery("#objects").show();
			jQuery("#card_o").hide();
    return false;
});
	 $("#gallery_din a").lightbox();
}
  });
  }
</script>
<body>
<div id="header">
  <!--  <div class="panel" id="panel1">
    <ul>
      <li><a href="/" title="Главная"><img src="../../forum.gif" alt="foliant" width="25%" height="25%" longdesc="http://foliant"/><br />
        Главная</a></li>
    </ul>
    <ul>
      <li><a href="#" title="Элемент 1">Элемент 1</a></li>
      <li><a href="#" title="Элемент 2">Элемент 2</a></li>
      <li><a href="#" title="Элемент 3">Элемент 3</a></li>
    </ul>
    <ul>
      <li><a href="#" title="Элемент 1">Элемент 1</a></li>
      <li><a href="#" title="Элемент 2">Элемент 2</a></li>
      <li><a href="#" title="Элемент 3">Элемент 3</a></li>
    </ul>
    <ul>
      <li><a href="#" title="Элемент 1">Элемент 1</a></li>
      <li><a href="#" title="Элемент 2">Элемент 2</a></li>
      <li><a href="#" title="Элемент 3">Элемент 3</a></li>
    </ul>
    <ul>
      <li><a href="#" title="Элемент 1">Элемент 1</a></li>
      <li><a href="#" title="Элемент 2">Элемент 2</a></li>
      <li><a href="#" title="Элемент 3">Элемент 3</a></li>
    </ul>
  </div>
  <p class="slide"><a href="#" class="btn-slide">Компании в проекте</a></p>-->
  <div id="companyslide">
    <!--		<ul class="tabset">
			<li><a href="#" class="active">Таб 1</a></li>
			<li><a href="#">Таб 2</a></li>
			<li><a href="#">Таб 3</a></li>
			<li><a href="#">Таб 4</a></li>
		</ul>-->
    <a href="#" class="prev">Prev</a> <a href="#" class="next">Next</a>
    <div class="tab-holder">
      <ul>
        <li><a href="/"> <img src="_images/fol_logo_m.jpg" alt="" />
          <p>г.Владивосток, ул. Адм. Юмашева д.4 к.22, <br/>
            т.44-44-50</p>
          </a></li>
        <li>
          <p>
          <h1>РК "Альянс"</h1>
          </p>
        </li>
        <li> <img src="_images/avega_logo.gif" alt="" />
          <p></p>
        </li>
        <li><img src="_images/omega_logo.jpg" alt="" /> </li>
      </ul>
    </div>
  </div>
  <div id="site_name"><h1>Информационный ресурс о недвижимости</h1></div>
  <div id="accsess"><a href="#" id="enter_priv" style="white-space:nowrap;"><h3 align="justify">Вход в личный кабинет</h3></a>
 <a href="#" id="registr">Регистрация</a><a href="#" id="remember" style="padding-left: 40px; white-space:nowrap;">Забыли пароль?</a></div>
  <div id="autorization-dialog" title="Авторизация">
	<form id="login" method="post" action="">
	<fieldset>
		<label for="name" class="label">Логин:</label>
		<input type="text" name="user_name" id="name" class="input_a_form"/><br/>
		<label for="password" class="label">Пароль:</label>
		<input type="password" name="user_pass" id="password" class="input_a_form" value=""/>
	</fieldset>
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
      <h3><a href="#">Жилая недвижимость</a></h3>   
     <div>
      <ul class="h_menu">
        <li><a href="#" id="b_table">Продажа квартир</a></li>
        <li><a href="#" id="s_exchanges">Обмены</a></li>
        <li><a href="#">Расширенный поиск</a></li>
      </ul>
      </div>
      <h3><a href="#">Коммерческая недвижимость</a></h3>
      <div>
      <ul class="h_menu">
        <li><a href="#" id="b_table_com">Продажа квартир</a></li>
        <li><a href="#" id="s_exchanges_com">Обмены</a></li>
        <li><a href="#">Расширенный поиск</a></li>
      </ul>
      </div>
      <h3><a href="#">Дома, участки и дачи</a></h3>
      <div>
        <p>Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis.</p>
      <ul class="h_menu">
        <li><a href="#" id="b_table_gr">Продажа квартир</a></li>
        <li><a href="#" id="s_exchanges_gr">Обмены</a></li>
        <li><a href="#">Расширенный поиск</a></li>
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
    <div id="fragment-1">
    </div>
    <div id="fragment-2">
        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
    </div>
    <div id="fragment-3">
        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
    </div>
</div>
    <!--    <ul id="gallery">
     class="thickbox"
      <li><a href="../../base5.php?image=0" title="Фасад"   rel="lightbox-myGroup"><img src="../../base5.php?image=0" alt="Plant 1" /></a></li>
      <li><a href="../../_images/star.jpg" title="Интерьер" rel="lightbox-myGroup"><img src="../../_images/star.jpg" alt="Plant 2" /></a></li>
    </ul>-->
  </div>
  <div id="content">
    <div id="tabs">
      <ul>
        <li><a href="#objects">Квартиры продажа</a></li>
        <li><a href="#ext_seach">Поиск</a></li>
       <!-- <li><a href="#card_o">Карточка</a></li>-->
        <li><a href="#tabs-4">JSON</a></li>
        <li><a href="pi.html">AjaxText</a></li>
        <!--     <li><a href="#tabs-6">Добавление объявления</a></li>-->
      </ul>
      <div id="objects">
        <table id="example" class="d_table" border="0">
          <thead>
            <tr>
              <th>Дата постановки</th>
              <th>Тип</th>
              <th>Комнат</th>
              <th>Расположение</th>
              <th >Площади, <span style="white-space: nowrap;">(Sо/Sж/Sк)</span></th>
              <th>С/У</th>
              <th>Б/Л</th>
              <th>Цена</th>
              <th>Этаж</th>
            </tr>
          </thead>
          <tbody id="d_tr">
            <?php do { ?>
              <tr  id="m_tr"  onmouseover="this.style.background='#FFCC33'" onmouseout="this.style.background=''"  onclick="showPopup(<?php echo $row_Recordset1['flats_cod']; ?>)">
                <td ><?php echo $row_Recordset1['flats_date']; ?></td>
                <td><?php echo $row_Recordset1['type_s']; ?></td>
                <td><?php echo $row_Recordset1['room_cod']; ?></td>
                <td align="left"><?php echo $row_Recordset1['region_name']; ?><?php echo ", "; ?><?php echo $row_Recordset1['street_name']; ?></td>
                <td ><?php echo $row_Recordset1['So']; ?><?php echo "/"; ?><?php echo $row_Recordset1['Sz']; ?><?php echo "/"; ?><?php echo $row_Recordset1['Sk']; ?></td>
                <td><?php echo $row_Recordset1['wc_short']; ?></td>
                <td><?php echo $row_Recordset1['balcon_short']; ?></td>
                <td><?php echo $row_Recordset1['flats_price']; ?></td>
                <td align="center" style="white-space:nowrap;"><?php echo $row_Recordset1['flats_floor']; ?><?php echo "/"; ?><?php echo $row_Recordset1['flats_floorest']; ?> <?php echo $row_Recordset1['material_short']; ?></td>
              </tr>
              <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
          </tbody>
        </table>
        <table class="d_table">
          <tfoot align="center">
            <tr>
              <td  align="center">
                <?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="_images/First.gif" alt=""></a>
                  <?php } // Show if not first page ?>                </td>
              <td  align="center">
                <?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="_images/Previous.gif" alt=""></a>
                  <?php } // Show if not first page ?>                </td>
              <td align="center">
                <?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="_images/Next.gif" alt=""></a>
                  <?php } // Show if not last page ?>                </td>
              <td align="center">
                <?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="_images/Last.gif" alt=""></a>
                  <?php } // Show if not last page ?>                </td>
            </tr>
            <tr>
              <td  colspan="4" align="center"valign="center" >Объекты с <?php echo ($startRow_Recordset1 + 1) ?> по <?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> из <?php echo $totalRows_Recordset1 ?> найденных в базе данных</td>
            </tr>
          </tfoot>
        </table>
      </div>
     <div id="card_o"><b>Response:</b> <span id="resp"></span><a href="#" id="back_t" title="Назад" style =" float: right;">Назад</a> </div>
      <div id="ext_seach">
        <table  id="example2" class="d_table" border="0">
          <thead>
            <tr>
              <th>Дата постановки</th>
              <th>Тип</th>
              <th>Комнат</th>
              <th>Расположение</th>
              <th >Площади, (Sо/Sж/Sк)</th>
              <th>С/У</th>
              <th>Б/Л</th>
              <th>Цена</th>
              <th>Этаж</th>
            </tr>
          </thead>
          <tbody>
            <?php do { ?>
              <tr  onmouseover="this.style.background='#FFCC33'" onmouseout="this.style.background=''"  onclick="showPopup(<?php echo $row_Recordset3['flats_cod']; ?>)">
                <td ><?php echo $row_Recordset3['flats_date']; ?></td>
                <td><?php echo $row_Recordset3['type_s']; ?></td>
                <td><?php echo $row_Recordset3['room_cod']; ?></td>
                <td align="left"><?php echo $row_Recordset3['region_name']; ?><?php echo ","; ?><?php echo $row_Recordset3['street_name']; ?></td>
                <td ><?php echo $row_Recordset3['So']; ?><?php echo "/"; ?><?php echo $row_Recordset3['Sz']; ?><?php echo "/"; ?><?php echo $row_Recordset3['Sk']; ?></td>
                <td><?php echo $row_Recordset3['wc_short']; ?></td>
                <td><?php echo $row_Recordset3['balcon_short']; ?></td>
                <td><?php echo $row_Recordset3['flats_price']; ?></td>
                <td align="center" style="white-space:nowrap;"><?php echo $row_Recordset3['flats_floor']; ?><?php echo "/"; ?><?php echo $row_Recordset3['flats_floorest']; ?> <?php echo $row_Recordset3['material_short']; ?></td>
              </tr>
              <?php } while ($row_Recordset3 = mysql_fetch_assoc($Recordset3)); ?>
          </tbody>
        </table>
      </div>
     <!-- <div id="card_o"><b>Response:</b> <span id="resp"></span><a href="#" id="back_t" title="Назад" style =" float: right;">Назад</a> </div>-->
      <div id="tabs-4"><a href="javascript:void(0)" id="vcol">Скрыть/Показать столбцы</a><br/>
        <br />
        <table id="list2" cellpadding="0" cellspacing="0">
        </table>
        <div id="pager2"  class="ui-jqgrid" style="text-align:center;"></div>
        <!--        <script  type="text/javascript" src="jsonmap.js"></script>  -->
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
<div id="loading_animation" style="display: none; color: red; font-size: 36px;">
  <!-- Невидимы див, который будет появляться только при загрузке страницы page2.html-->
  Loading... Wait... </div>
</body>
</html>
