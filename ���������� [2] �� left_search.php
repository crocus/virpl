<?php require_once('_scriptsphp/r_conn.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Расширенный поиск</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<form id="seachform"  action="_scriptsphp/fish.php" method="get">
  <table  class="b_table" width="100%" cellpadding="1" cellspacing="2">
    <tr>
      <td><label class="strong" for="type[]" >Тип объекта :</label>
        <br />
        <select class="full_width" name="type[]" multiple="multiple" size="7">
          <?php
	 mysql_select_db($database_realtorplus, $realtorplus);
	$query_Recordset1= "SELECT * FROM tbl_type";
  	$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
   ?>
          <?php do { ?>
          <option value ="<?php echo $row_Recordset1['type_cod'] ; ?>"><?php echo $row_Recordset1['type_s']; ?></option>
          <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        </select></td>
      <td><label class="strong" for="room[]">Количество комнат :</label>
        <br />
        <select class="full_width" name="room[]" multiple="multiple" size="7">
          <?php
	$query_Recordset1= "SELECT * FROM tbl_room";
  	$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
   ?>
          <?php do { ?>
          <option value ="<?php echo $row_Recordset1['room_cod'] ; ?>"><?php echo $row_Recordset1['room_short']; ?></option>
          <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        </select></td>
              <td><label class="strong" for="region[]">Район : </label>
        <br />
        <select class="full_width" name="region[]" multiple="multiple" size="7">
          <?php
	$query_Recordset1= "SELECT* FROM tbl_region";
  	$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
   ?>
          <?php do { ?>
          <option value ="<?php echo $row_Recordset1['region_cod'] ; ?>"><?php echo $row_Recordset1['region_name']; ?></option>
          <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        </select></td>
    </tr>
    <tr>
       <td><label class="strong" for="wc[]">Санитарный узел :</label>
        <br />
        <select class="full_width" name="wc[]" multiple="multiple" size="7" >
          <?php
	$query_Recordset1= "SELECT * FROM tbl_wc";
  	$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
   ?>
          <?php do { ?>
          <option value ="<?php echo $row_Recordset1['wc_cod'] ; ?>"><?php echo $row_Recordset1['wc_name']; ?></option>
          <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        </select></td>
         <td><label class="strong" for="plan[]">Планировка :</label>
        <br />
        <select class="full_width" name="plan[]" multiple="multiple" size="7" >
          <?php
	$query_Recordset1= "SELECT * FROM tbl_plan";
  	$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
   ?>
          <?php do { ?>
          <option value ="<?php echo $row_Recordset1['plan_cod'] ; ?>"><?php echo $row_Recordset1['plan_name']; ?></option>
          <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        </select></td>
          <td><label class="strong" for="balcon[]">Балконы/лоджии :</label>
        <br />
        <select class="full_width" name="balcon[]" multiple="multiple" size="7" >
          <?php
	$query_Recordset1= "SELECT * FROM tbl_balcon";
  	$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
   ?>
          <?php do { ?>
          <option value ="<?php echo $row_Recordset1['balcon_cod'] ; ?>"><?php echo $row_Recordset1['balcon_name']; ?></option>
          <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        </select></td>
    </tr>
    <tr><td><label class="strong" for="floor">Этажи :</label>
        <br />
        <select name="floor" class="full_width">
          <option selected="selected"> значение не задано </option>
          <option value="noferst">не первый</option>
          <option value="nolast">не последний</option>
          <option value="middle">средний</option>
        </select></td>
         <td></td>
         <td></td>
         </tr>
           <tr>
      <td><label class="strong" for="order">Сортировать по :</label>
        <br />
        <select name="order" class="full_width">
          <option value="nothing" selected="selected"> значение не задано </option>
          <option value="date">Дате публикации</option>
          <option value="room">Количеству комнат</option>
          <option value="type">Типу</option>
          <option value="price">Цене</option>
        </select></td> 
        <td></td>
         <td></td>
    </tr>
      <tr>
      <td><label class="strong" for="price">Цена :</label>
        <br />
        от:&nbsp;<input type="text" name="minprice" />&nbsp;до:&nbsp;<input type="text" name="miaxprice" /></td> 
        <td></td>
         <td></td>
    </tr>
    <tr>
      <td><input name="Submit" type="submit" class="denyhalf" value="   Поиск   " />
        <input name="Reset"type="reset" class="denyhalf" value="   Сброс   " /></td>
        <td></td>
    </tr>
  </table>
</form>
<script type="text/javascript">
$(document).ready(function(){
  var options = { 
    beforeSubmit: showRequest,
    timeout: 3000 // тайм-аут
  };
  $('#seachform').submit(function() { 
    $(this).ajaxSubmit(options); 
    return false;
  }); 
});

// вызов перед передачей данных
function showRequest(formData, jqForm, options) { 
    // formData - массив; здесь используется $.param чтобы преобразовать его в строку для вывода в alert(),
    // (только в демонстрационных целях), но в самом плагине jQuery Form это совершается автоматически.
    queryString = $.param(formData); 
     alert('Вот что мы передаем: \n\n' + queryString);
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