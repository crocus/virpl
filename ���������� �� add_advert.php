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

$query_Type= "SELECT * FROM tbl_type";
$Type = mysql_query($query_Type, $realtorplus) or die(mysql_error());
$row_Type = mysql_fetch_assoc($Type);
$totalRows_Type = mysql_num_rows($Type);

$query_Side= "SELECT * FROM tbl_side";
$Side = mysql_query($query_Side, $realtorplus) or die(mysql_error());
$row_Side = mysql_fetch_assoc($Side);
$totalRows_Side = mysql_num_rows($Side);

$query_Agent= "SELECT * FROM tbl_agent";
$Agent = mysql_query($query_Agent, $realtorplus) or die(mysql_error());
$row_Agent = mysql_fetch_assoc($Agent);
$totalRows_Agent = mysql_num_rows($Agent);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
<head>
<title>Построение пользовательских интерфейсов на основе библиотеки jQuery</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">
$(document).ready(function(){
  function adjustStreet(){
  	var cityValue = $('#city').val();
  	var tmpSelect = $('#street');
  	if(cityValue.length == 0) {
  		tmpSelect.attr('disabled','disabled');
  		tmpSelect.clearSelect();
  	} else {
  		$.getJSON('./_scriptsphp/cascadSelectStreet.php',{city:cityValue},function(data) { tmpSelect.fillSelect(data).attr('disabled','');	
		});		
  	}
  };	
  $('#city').change(function(){
  	adjustStreet();
  }).change();
});
</script>
</head>
<body>
<div id="output">AJAX-ответ от сервера заменит этот текст.</div>
<div>
  <form id="myForm" action="_scriptsphp/service_tb.php" method="post">
    <table id="t_advert" width="auto">
      <!--DWLayoutTable-->
      <tr>
        <td align="right" style="white-space:nowrap;">Населенный пункт:</td>
        <td style="width:30%;"><select id="city" name="city_cod" class="in-td">
            <?php 
do {  
?>
            <option value="<?php echo $row_City['city_cod']?>" ><?php echo $row_City['city_name']?></option>
            <?php
} while ($row_City = mysql_fetch_assoc($City));
?>
          </select></td>
        <td align="right"></td>
        <td></td>
      </tr>
      <tr  valign="baseline">
        <td align="right" >Улица:</td>
        <td style="width:30%;"><select id="street" name="street_cod"  disabled="disabled" class="in-td">
          </select></td>
        <td align="right" >Планировка:</td>
        <td ><select name="plan_cod" class="in-td">
            <?php 
do {  
?>
            <option value="<?php echo $row_Plan['plan_cod']?>"><?php echo $row_Plan['plan_name']?></option>
            <?php
} while ($row_Plan = mysql_fetch_assoc($Plan));
?>
          </select></td>
      </tr>
      <tr valign="baseline">
        <td align="right" >Вид продажи:</td>
        <td style="width:30%;"><select class="in-td" name="sale_cod">
            <?php 
do {  
?>
            <option value="<?php echo $row_Sale['sale_cod']?>" ><?php echo $row_Sale['sale_name']?></option>
            <?php
} while ($row_Sale = mysql_fetch_assoc($Sale));
?>
          </select></td>
        <td align="right">Санузел:</td>
        <td style="width:30%;"><select name="wc_cod" class="in-td">
            <?php 
do {  
?>
            <option value="<?php echo $row_WC['wc_cod']?>"><?php echo $row_WC['wc_name']?></option>
            <?php
} while ($row_WC = mysql_fetch_assoc($WC));
?>
          </select></td>
      </tr>
      <tr valign="baseline">
        <td align="right" >Тип объекта:</td>
        <td><select name="type_cod" class="in-td">
            <?php 
do {  
?>
            <option value="<?php echo $row_Type['type_cod']?>"><?php echo $row_Type['type_s']?></option>
            <?php
} while ($row_Type = mysql_fetch_assoc($Type));
?>
          </select></td>
        <td align="right">Балкон/лоджия:</td>
        <td style="width:30%;"><select  name="balcon_cod" class="in-td">
            <?php 
do {  
?>
            <option value="<?php echo $row_Balc['balcon_cod']?>" ><?php echo $row_Balc['balcon_name']?></option>
            <?php
} while ($row_Balc = mysql_fetch_assoc($Balc));
?>
          </select></td>
      </tr>
      <tr valign="baseline">
        <td align="right">Количество комнат:</td>
        <td style="width:30%;"><select  name="room_cod" class="in-td">
            <?php 
do {  
?>
            <option value="<?php echo $row_Room['room_cod']?>"><?php echo $row_Room['room_short']?></option>
            <?php
} while ($row_Room = mysql_fetch_assoc($Room));
?>
          </select></td>
        <td align="right">Состояние:</td>
        <td style="width:30%;"><select  name="cond_cod" class="in-td">
            <?php 
do {  
?>
            <option value="<?php echo $row_Cond['cond_cod']?>"><?php echo $row_Cond['cond_name']?></option>
            <?php
} while ($row_Cond = mysql_fetch_assoc($Cond));
?>
          </select></td>
      </tr>
      <tr valign="baseline">
        <td align="right" >Площади,(So/Sж/Sk):</td>
        <td style="white-space:nowrap;width:30%;"><input  style="width:30%;"  type="text" name="So" value="" size="4">
          <input style="width:30%;" type="text" name="Sz" value="" size="4">
          <input style="width:30%;"  type="text" name="Sk" value="" size="4"></td>
        <td align="right">Сторона света:</td>
        <td style="width:30%;"><select  name="side_cod" class="in-td">
            <?php 
do {  
?>
            <option value="<?php echo $row_Side['side_cod']?>"><?php echo $row_Side['side_name']?></option>
            <?php
} while ($row_Side = mysql_fetch_assoc($Side));
?>
          </select></td>
      </tr>
      <tr valign="baseline">
        <td align="right" style="white-space:nowrap;">Этаж/Этажность:</td>
        <td style="white-space:nowrap;width:30%;"><input style="width:47%;" type="text" name="flats_floor" value="" >
          <input style="width:47%;" type="text" name="flats_floorest" value="" ></td>
        <td align="right" style="white-space:nowrap;">Цена объекта:</td>
        <td style="width:30%;"><input class="in-td"  type="text" name="flats_price" value="" ></td>
      </tr>
      <tr valign="baseline">
        <td align="right" style="white-space:nowrap;">Материал постройки:</td>
        <td style="width:30%;"><select  name="material_cod" class="in-td">
            <?php 
do {  
?>
            <option value="<?php echo $row_Mat['material_cod']?>" ><?php echo $row_Mat['material_name']?></option>
            <?php
} while ($row_Mat = mysql_fetch_assoc($Mat));
?>
          </select></td>
        <td align="right" style="white-space:nowrap;">Телефон:</td>
        <td><input  type="checkbox" name="flats_tel" value="" ></td>
      </tr>
      <tr valign="baseline">
        <td align="right" style="white-space:nowrap;"></td>
        <td></td>
        <td align="right" valign="top" style="white-space:nowrap;">Агент:</td>
        <td colspan="2" valign="top"><select    name="agent_cod">
            <?php 
do {  
?>
            <option value="<?php echo $row_Agent['agent_cod']?>" <?php if (!(strcmp($row_Agent['agent_cod'], $row_Agent['agent_cod']))) {echo "SELECTED";} ?>><?php echo $row_Agent['agent_name']?></option>
            <?php
} while ($row_Agent = mysql_fetch_assoc($Agent));
?>
          </select ></td>
      </tr>
      <tr valign="baseline">
        <td align="right" style="white-space:nowrap;">Примечание:</td>
        <td colspan="3" valign="top" ><textarea name="flats_comments" cols="47" rows="5" style="width: 100%;"></textarea></td>
      </tr>
      <tr valign="baseline">
        <td colspan="4">
          <p>
            <label class="label" style="font-size:medium;"><strong>Фотографии</strong></label>
            <br />
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
                <input id="filepath_advert" name="filepath_advert" type="hidden" value="" />
              </div>
            </div>
            <br />
            <div class="upload-layer">
              <p style="padding-left:25px;">Загруженные фотографии:</p>
              <ul id="image_list_advert" class="files">
              </ul>
            </div>
          </div>
          </p></td>
      </tr>
      <tr valign="baseline">
        <td colspan="4" align="center" ><input type="hidden" name="MM_insert" value="linsert">
        <input id="add_button" type="submit" value="Добавить объект"></td>
      </tr>
    </table>
  </form>
</div>
<script type="text/javascript">
$(document).ready(function(){
// ---- Форма -----
  var options = { 
    // элемент, который будет обновлен по ответу сервера 
  	target: "#output",
    beforeSubmit: showRequest, // функция, вызываемая перед передачей 
    success: showResponse, // функция, вызываемая при получении ответа
    timeout: 3000 // тайм-аут
  };
  
  // привязываем событие submit к форме
  $('#myForm').submit(function() { 
    $(this).ajaxSubmit(options); 
    // !!! Важно !!! 
    // всегда возвращаем false, чтобы предупредить стандартные
    // действия браузера (переход на страницу form.php) 
    return false;
  }); 
// ---- Форма -----
});

// вызов перед передачей данных
function showRequest(formData, jqForm, options) { 
    // formData - массив; здесь используется $.param чтобы преобразовать его в строку для вывода в alert(),
    // (только в демонстрационных целях), но в самом плагине jQuery Form это совершается автоматически.
    var queryString = $.param(formData); 
    // jqForm это jQuery объект, содержащий элементы формы.
    // Для доступа к элементам формы используйте 
    // var formElement = jqForm[0]; 
    alert('Вот что мы передаем: \n\n' + queryString); 
    // здесь можно вернуть false чтобы запретить отправку формы; 
    // любое отличное от fals значение разрешит отправку формы.
    return true; 
} 
 
// вызов после получения ответа 
function showResponse(responseText, statusText)  { 
    // для обычного html ответа, первый аргумент - свойство responseText
    // объекта XMLHttpRequest
 
    // если применяется метод ajaxSubmit (или ajaxForm) с использованием опции dataType 
    // установленной в 'xml', первый аргумент - свойство responseXML
    // объекта XMLHttpRequest
 
    // если применяется метод ajaxSubmit (или ajaxForm) с использованием опции dataType
    // установленной в 'json', первый аргумент - объек json, возвращенный сервером.
 	getCount();
    alert('Статус ответа сервера: ' + statusText + '\n\nТекст ответа сервера: \n' + responseText + 
        '\n\nЦелевой элемент div обновиться этим текстом.'); 
}
</script>
</body>
</html>
<?php
mysql_free_result($Type);
mysql_free_result($Sale);
mysql_free_result($Plan);
mysql_free_result($Room);
mysql_free_result($Side);
mysql_free_result($Cond);
mysql_free_result($Balc);
mysql_free_result($Mat);
mysql_free_result($WC);
mysql_free_result($Agent);
mysql_free_result($Street);
mysql_free_result($City);
?>