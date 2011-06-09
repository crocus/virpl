<?php require_once('_scriptsphp/r_conn.php');
	require_once ('_scriptsphp/session.inc');
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Расширенный поиск</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<style type="text/css">
			<!--
			.divinform {
				display:block;
				float:left;
				width:200px;
				margin: 0 5px 10px 0;
				font-family: Verdana, Arial, Helvetica, sans-serif;
				font-size: 10pt;
			}
			-->
		</style>
	</head>
	<body>
		<form id="seachform" name="seachform" action="_scriptsphp/fish.php" method="get">
			<div class="divinform private_seach" style="display:none;">
				<fieldset><legend>Ищем в:</legend><input type="radio" name="pussy" id="age" checked="checked" value=""><label>- актуальных</label><br />
					<input type="radio" name="pussy" id="age" value="14"><label>- устаревших</label>
				</fieldset>
			</div>
			<br />
			<div  class="divinform">
				<label class="strong" for="byid"> По коду объявления:</label>
				<br />
				<input type="text" class="full_width" name="byid" />
			</div>
			<br  style="clear:both"/>
			<div class="divinform">
				<label class="strong" for="type[]" >Тип объекта:</label>
				<br />
				<select class="full_width multiple" name="type[]" multiple="multiple" size="6">
					<?php
						mysql_select_db($database_realtorplus, $realtorplus);
						$query_Recordset1= "SELECT * FROM tbl_type";
						$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
						$row_Recordset1 = mysql_fetch_assoc($Recordset1);
					?>
					<?php do { ?>
						<option value ="<?php echo $row_Recordset1['type_cod'] ; ?>"><?php echo $row_Recordset1['type_s']; ?></option>
						<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
				</select>
			</div>
			<div class="divinform">
				<label class="strong" for="room[]">Количество комнат:</label>
				<br />
				<select class="full_width multiple" name="room[]" multiple="multiple" size="6">
					<?php
						$query_Recordset1= "SELECT * FROM tbl_room";
						$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
						$row_Recordset1 = mysql_fetch_assoc($Recordset1);
					?>
					<?php do { ?>
						<option value ="<?php echo $row_Recordset1['room_cod'] ; ?>"><?php echo $row_Recordset1['room_short']; ?></option>
						<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
				</select>
			</div>
			<div class="divinform">
				<label class="strong" for="region[]">Район: </label>
				<br />
				<select class="full_width" id="region" name="region[]" multiple="multiple" size="6">
					<?php
						$query_Recordset1= "SELECT* FROM tbl_region";
						$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
						$row_Recordset1 = mysql_fetch_assoc($Recordset1);
					?>
					<?php do { ?>
						<option value ="<?php echo $row_Recordset1['region_cod'] ; ?>"><?php echo $row_Recordset1['region_name']; ?></option>
						<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
				</select>
			</div>
			<div class="divinform" style="margin-bottom: 0px;">
				<label class="strong" for="street[]">Улица: </label>
				<br />
				<select class="full_width" id="ls-street" name="street[]" multiple="multiple" size="6"/>
			</div>
			<!--<br style="clear:both"/>-->
			<div class="divinform">
				<label class="strong" for="sale[]">Вид продажи:</label>
				<br />
				<select class="full_width multiple" name="sale[]" multiple="multiple" size="6" >
					<?php
						$query_Recordset1= "SELECT * FROM tbl_sale";
						$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
						$row_Recordset1 = mysql_fetch_assoc($Recordset1);
					?>
					<?php do { ?>
						<option value ="<?php echo $row_Recordset1['sale_cod'] ; ?>"><?php echo $row_Recordset1['sale_name']; ?></option>
						<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
				</select>
			</div>
			<div class="divinform">
				<label class="strong" for="project[]">Проект здания:</label>
				<br />
				<select class="full_width multiple" name="project[]" multiple="multiple" size="6" >
					<?php
						$query_Recordset1= "SELECT * FROM tbl_project";
						$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
						$row_Recordset1 = mysql_fetch_assoc($Recordset1);
					?>
					<?php do { ?>
						<option value ="<?php echo $row_Recordset1['project_cod'] ; ?>"><?php echo $row_Recordset1['project_name']; ?></option>
						<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
				</select>
			</div>
			<div class="divinform">
				<label class="strong" for="wc[]">Санитарный узел:</label>
				<br />
				<select class="full_width multiple" name="wc[]" multiple="multiple" size="6" >
					<?php
						$query_Recordset1= "SELECT * FROM tbl_wc";
						$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
						$row_Recordset1 = mysql_fetch_assoc($Recordset1);
					?>
					<?php do { ?>
						<option value ="<?php echo $row_Recordset1['wc_cod'] ; ?>"><?php echo $row_Recordset1['wc_name']; ?></option>
						<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
				</select>
			</div>
			<div class="divinform">
				<label class="strong" for="plan[]">Планировка:</label>
				<br />
				<select class="full_width multiple" name="plan[]" multiple="multiple" size="6" >
					<?php
						$query_Recordset1= "SELECT * FROM tbl_plan";
						$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
						$row_Recordset1 = mysql_fetch_assoc($Recordset1);
					?>
					<?php do { ?>
						<option value ="<?php echo $row_Recordset1['plan_cod'] ; ?>"><?php echo $row_Recordset1['plan_name']; ?></option>
						<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
				</select>
			</div>
			<div class="divinform">
				<label class="strong" for="balcon[]">Балконы/лоджии:</label>
				<br />
				<select class="full_width multiple" name="balcon[]" multiple="multiple" size="6" >
					<?php
						$query_Recordset1= "SELECT * FROM tbl_balcon";
						$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
						$row_Recordset1 = mysql_fetch_assoc($Recordset1);
					?>
					<?php do { ?>
						<option value ="<?php echo $row_Recordset1['balcon_cod'] ; ?>"><?php echo $row_Recordset1['balcon_name']; ?></option>
						<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
				</select>
			</div>
			<div class="divinform">
				<label class="strong" for="floor">Этажи:</label>
				<br />
				<select name="floor" class="full_width">
					<option selected="selected"> значение не задано </option>
					<option value="noferst">не первый</option>
					<option value="nolast">не последний</option>
					<option value="middle">средний</option>
					<option value="first">первый или цоколь</option>
				</select>
				<div style="margin-top:10px;">
					<label class="strong" for="mortgage" style="margin-right:15px;">Возможность ипотеки</label><input type="checkbox" name="mortgage"/>
				</div>
				<div style="margin-top:10px;">
					<label class="strong" for="order">Сортировать по:</label>
					<br />
					<select name="order" class="full_width">
						<option value="nothing" selected="selected"> значение не задано </option>
						<option value="date">Дате публикации</option>
						<option value="room">Количеству комнат</option>
						<option value="foto">С фотографиями</option>
						<option value="type">Типу объекта</option>
						<option value="pricedesk">Цене (по убыванию)</option>
						<option value="priceasc">Цене (по возрастанию)</option>
						<option class="private_seach" style="display:none;" value="issource">Получены с сайта</option>			
					</select>
				</div>
			</div>
			<br />
			<div class="divinform private_seach" style="display:none;">
				<label class="strong" for="participants">По пользователям:</label>
				<br />
				<div style="padding:0 5px; border:thin groove #666"><ul id="participants">
					</ul></div>
			</div>
			<br  style="clear:both"/>
			<div  class="divinform">
				<fieldset><legend class="strong">По площадям:</legend>
					<span style="white-space:nowrap;">
						<label class="strong"> - общая:</label><br />
						от:&nbsp;
						<input type="text" style="width:45px;" name="minso" />
						&nbsp;до:&nbsp;
						<input type="text" style="width:45px;" name="maxso" />
					</span><br />
					<span style="white-space:nowrap;">
						<label class="strong"> - кухни:</label><br />
						от:&nbsp;
						<input type="text" style="width:45px;" name="minsk" />
						&nbsp;до:&nbsp;
						<input type="text" style="width:45px;" name="maxsk" />
					</span>
				</fieldset>
				<p>
					<label class="strong" for="price"> По цене:</label>
					<br />
					<span style="white-space:nowrap;"> от:&nbsp;
						<input type="text" style="width:75px;" name="minprice" />
						&nbsp;до:&nbsp;
						<input type="text" style="width:75px;" name="maxprice" />
					</span></p></div>
			<br style="clear:both"/>
			<div class="divinform">
				<input name="Submit" type="submit" style="width:75px;" value="Поиск" />
				<input id="search-reset-form" name="search-reset-form" type="reset"  style="width:75px;" value="Сброс" />
			</div>
			<br style="clear: both;">
			<input id="s_prpt" name="s_prpt" type="hidden" value="" />
			<input id="isshow_field" name="isshow_field" type="hidden" value="<?php echo $_SESSION['id'];?>" />
		</form>
		<script type="text/javascript">
			$(document).ready(function(){
				$("select.multiple").simpleMultiSelect();	
				$('#region').change(function(){
					var multipleValues = $('#region').val() || [];
					$.getJSON("../_scriptsphp/street_complit.php", { 
						'id[]': multipleValues
					},
					function(data){
						// очищаем select
						$('#ls-street').clearSelect();
						// заполняем select
						$('#ls-street').fillSelect(data);
						//alert("Data Loaded: " + data);
					});
				}).change();

				if($("#isshow_field").val()!=""){
					$(".private_seach").show();
				}
				$("#participants").treeview({
					url: "_scriptsphp/source.php",
					collapsed: true
				});
				$("#participants").find('span').live('click', function(){
					$(this).toggleClass('treeitem');
					var prpt_selected;
					if ($(this).is('.treeitem')){
						// $(this).parent('li').prepend('<input name="prpt[]" class="p_check" type="checkbox" value="" checked />');
						$(this).parent('li').prepend('<img class="p_check" src="_images/Check_16x16.png" alt="" width="16" height="16" />');
					} else {
						$(this).parent('li').find('span').removeClass('treeitem');
						$(this).parent('li').find('img[class="p_check"]').remove();
						//$(this).parent('li').find('input[type="checkbox"]').remove();
					}
					var prpt = new Array();
					$(this).parents('li').find("span.treeitem").each(function(){
						prpt.push($($(this).parent('li')).attr("id"));
					});
					prpt_selected = prpt.join(",");
					$('#s_prpt').val(prpt_selected);
					return false;
				});

				$("#participants").find('span').live('mouseover', function() {
					$(this).css({'cursor' : 'pointer', 'text-decoration' : 'underline'}).addClass('red');
				}).live('mouseout', function() {
					$(this).css({'cursor' : 'none', 'text-decoration' : 'none'}).removeClass('red');
				});
				var options = {
					beforeSubmit: showRequest,
					timeout: 3000 // тайм-аут
				};
				$('#seachform').submit(function() {
					$(this).ajaxSubmit(options);
					return false;
				});
				$('#search-reset-form').click(function() {
					$('select.multiple').smsNone();
					$("#seachform").resetForm();
					$("#participants").find("span.treeitem").each(function(){
						$(this).removeClass('treeitem');
					});
					$("#participants").find('img[class="p_check"]').each(function(){
						$(this).remove();
					});
					$('#s_prpt').val('');
					return false;
				});
			});

			// вызов перед передачей данных
			function showRequest(formData, jqForm, options) {
				queryString = $.param(formData);
				//				alert('Вот что мы передаем: \n\n' + queryString);
				$('#v_lenta').attr('src','v_lenta.php?' + queryString);
				$('#v_table').attr('src','v_table.php?' + queryString);
				$("#tabs").tabs('option', 'selected', '#objects');
				return true;
			}
		</script>
	</body>
</html>
<?php
	mysql_free_result($Recordset1);
?>