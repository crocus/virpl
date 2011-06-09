<?php
ob_start("ob_gzhandler");
include('base2.php');
include('_scriptsphp/rdate/rdate.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Представление в виде таблицы</title>
		<!--<script type="text/javascript" src="_js/jquery/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="../_js/jquery/ui/jquery-ui-1.7.custom.js"></script>-->
		<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/jquery-ui.min.js"></script>-->
		<!--<script type="text/javascript" src="_js/plugins/jquery.carousel.pack.js"></script>-->
		<!--<script type="text/javascript" src="_js/plugins/lightbox/js/jquery.lightbox.min.js"></script>-->
		<script type='text/javascript' src="/min/?g=jsframe"></script>
		<!--<script type='text/javascript' src="/min/?g=jsl"></script>
		<link href="_style/iframe.min.css" rel="stylesheet" type="text/css" />-->
		<link href="/min/?g=cssframe" rel="stylesheet" type="text/css"/>
	</head>
	<body>
		<div id="objects" style="margin:0; padding:0;">
			<table id="o_table" class="table d_table" border="0">
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
				<tbody>
					<?php if($totalRows_Recordset1>0) {
						do { ?>
					<tr  id="m_tr"  onmouseover="this.style.background='#FCD9BA'" onmouseout="this.style.background=''"  onclick="showPopup(<?php echo $row_Recordset1['flats_cod']; ?>)">
						<td > <?php
									if (isset($row_Recordset1['flats_date'])) {
										echo nicetime($row_Recordset1['flats_date'], false);
									}
									?></td>
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
			</table><br />
			<table class="d_table">
				<tfoot>
					<tr>
						<td ><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
							<a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="_images/First.gif" alt="" /><br/>Первая</a>
								<?php } // Show if not first page ?>
						</td>
						<td ><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
							<a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="_images/Previous.gif" alt="" /><br/>Предыдущая</a>
								<?php } // Show if not first page ?>
						</td>
						<td ><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
							<a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="_images/Next.gif" alt="" /><br/>Следующая</a>
								<?php } // Show if not last page ?>
						</td>
						<td ><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
							<a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="_images/Last.gif" alt="" /><br/>Последняя</a>
								<?php } // Show if not last page ?>
						</td>
					</tr>
					<tr>
						<td  colspan="4" align="center" valign="center" >Объекты с <?php echo ($startRow_Recordset1 + 1) ?> по <?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> из <?php echo $totalRows_Recordset1 ?> найденных в базе данных
						<?php } else { echo "Отсутствуют объявления, удовлетворяющие условиям, Вашего запроса.";}?></td>
					</tr>
				</tfoot>
			</table>
		</div>
		<div id="card" style="display:none;padding:10px;"></div>
	</body>
</html>
<script type="text/javascript">
	var modeview = $.cookie("modeview");
	var obj_AvailableAgents="";
	$(document).ready(function(){
		if (modeview == null) {
			modeview = "review";
			$.cookie("modeview", "review");
		}
		createModeView(modeview);
				$.getJSON("../_scriptsphp/session_var.php", function(json){
					var use = json.use;
					if (use == 1) {
						if (parseInt(json.role) <= 1) {
							bind_id = json.id;
						}
						else {
							bind_id = json.group;
						}
					   if($.cookie("inquery") === bind_id) {
							agent_t = $.ajax({
							url: "../_scriptsphp/get_parameters.php",
							data: "parameter=agent",
							async: false
						}).responseText;
						obj_AvailableAgents = eval("(" + agent_t + ")");
					   } 
					}
				});
	});
</script>
<?php ob_end_flush();?> 
