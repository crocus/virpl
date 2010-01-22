<?php
include('_scriptsphp/fb.php');
include('_scriptsphp/rdate/rdate.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<!--<script type="text/javascript" src="_js/jquery/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../_js/jquery/ui/jquery-ui-1.7.custom.js"></script>-->
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/jquery-ui.min.js"></script>-->
<script type='text/javascript' src="/min/?g=jsframe"></script>
<link href="/min/?g=cssframe" rel="stylesheet" type="text/css"/>
</head>
<body>
<div id="card-e" style="display:none;padding:10px;"></div>
<div id="objects">
  <table id="pfb-table" class="lenta d_table">
	<tbody>
	  <?php if($totalRows_Recordset1>0){	
	  do { ?>
		<tr  onclick="PopupProposalBuy(<?php echo $row_Recordset1['Id']; ?>)" >
		  <td class="align_l"><?php $count_r = $row_Recordset1['room_cod']; $rooms = explode(",", $count_r);
		  $text = '<span class="lentheader">'. $row_Recordset1['Header'].'</span>';
echo $text;?></td>
		  <td class="align_r" style=" width:100px;"><?php echo '<span class="lentprice">' . number_format($row_Recordset1['price_fb'], 0, '.', ' ').' руб.</span>'; ?></td><td class="align_r" style=" width:100px;"><span style="font-size:0.8em;white-space:nowrap;">
			<?php
	 if (isset($row_Recordset1['Date'])) {
		//echo rdate(" H:i, j m ", strtotime($row_Recordset1['Date']) );
		echo nicetime($row_Recordset1['Date'], true);
}
	?>
			</span></td>
		</tr>
		<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
	</tbody>
  </table>
  <table class="d_table">
	<tfoot>
	  <tr>
		<td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
			<a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="_images/First.gif" alt="" /></a>
			<?php } // Show if not first page ?>
		</td>
		<td ><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
			<a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="_images/Previous.gif" alt="" /></a>
			<?php } // Show if not first page ?>
		</td>
		<td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
			<a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="_images/Next.gif" alt="" /></a>
			<?php } // Show if not last page ?>
		</td>
		<td ><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
			<a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="_images/Last.gif" alt="" /></a>
			<?php } // Show if not last page ?>
		</td>
	  </tr>
	  <tr>
		<td colspan="4"  valign="center" >Объекты с <?php echo ($startRow_Recordset1 + 1) ?> по <?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> из <?php echo $totalRows_Recordset1 ?> найденных в базе данных
		 <?php } else { echo "Отсутствуют объявления, удовлетворяющие условиям, Вашего запроса.";}?></td>
	  </tr>
	</tfoot>
  </table>
 </div> 
</body>
</html>