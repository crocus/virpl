<?php
	ob_start("ob_gzhandler");
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
	header('Cache-Control: no-store, no-cache, must-revalidate'); 
	header('Cache-Control: post-check=0, pre-check=0', FALSE); 
	header('Pragma: no-cache');
	include('base2.php');
	include('_scriptsphp/rdate/rdate.php');
	$_SESSION['userhash'] = md5( time() . $_SERVER['REMOTE_ADDR'] . 'Обломись, падла!! Ня!' );  
	setcookie("_userhash", $_SESSION['userhash'], 0, "/");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Представление в виде ленты</title>
		<script type='text/javascript' src="/min/?g=jsframe"></script>
		<link href="/min/?g=cssframe" rel="stylesheet" type="text/css"/>
	</head>
	<body>
		<div id="objects">
			<table id="o_lent" class="lenta d_table">
				<?php if($totalRows_Recordset1>0) {
						do { ?>
						<tr value="<?php echo $row_Recordset1['flats_cod']; ?>">
							<td class="check" style="vertical-align:middle; width:30px;">
								<input class="ocheck" name="mcheck[]" type="checkbox"/>
							</td>
							<td class="align_c show-popup" style=" width:90px;">
								<?php if( $row_Recordset1['foto'] != 0) echo '<div class="photo"><img src="base5.php?id_image='. $row_Recordset1['flats_cod'] .'&amp;category=0&amp;image=0&amp;min=1&amp;percent=0.12" alt="" /></div>'?>
							</td>
							<td class="align_l show-popup">
								<?php $count_r = $row_Recordset1['room_cod'];
									$text = '<a href="#" class="lentheader">';
									switch ( $row_Recordset1['type_s']) {
										case 'дом':
											if ($row_Recordset1['room_cod']!=0) {
												$text .= 'Дом, '.$count_r. ' комн., ';
											} else {
												$text .= 'Дом, ';
											}
											break;
										case 'квартира':
											if ($row_Recordset1['room_cod']!=0) {
												$text .= $count_r. '-комнатная, ';
											} else {
												$text .= 'Гостинка, ';
											}
											break;
										case 'подселение':
											if ($row_Recordset1['room_cod']!=0) {
												$text .= 'Подселение, '.$count_r. ' комн., ';
											} else {
												$text .= 'Подселение, ';
											}
											break;
										case 'офис':
											if ($row_Recordset1['room_cod']!=0) {
												$text .= 'Офис, '.$count_r. ' каб., ';
											} else {
												$text .= 'Офис, ';
											}
											break;
										case 'строение':
											$text .= 'Отдельностоящее строение, ';
											break;
										case 'производство':
											$text .= 'Производственно-складское помещение, ';
											break;
										case 'торговля':
											$text .= 'Торговое помещение, ';
											break;
										case 'коттедж':
											$text .= 'Коттедж, ';
											break;
										case 'под застройку':
											$text .= 'Земли поселений (под застройку), ';
											break;
										case 'земельный участок':
											$text .= 'Земельный участок, ';
											break;
										case 'дача':
											$text .= 'Садоводческий участок (дача), ';
											break;
										default :
											$text .= $count_r. '-комнатная, ';
											break;
									}
									$text .= $row_Recordset1['street_name'].(!empty($row_Recordset1['building_id']) ? ', дом '. $row_Recordset1['building_id'] :'').'</a><br/><span class="lentbody">'. $row_Recordset1['So']. ' кв.м., '
									. $row_Recordset1['flats_floor'].'/'.$row_Recordset1['flats_floorest'].' '. $row_Recordset1['material_short']
									. ', '. (($row_Recordset1['region_name']==$row_Recordset1['city_name']) ? $row_Recordset1['city_name']: 'р-н '. $row_Recordset1['region_name'])
									.'<span style="display:block;font-style: italic; font-size:0.8em;color:#73000B">'. (!empty($row_Recordset1['ipo_ch']) ?'Доступно по ипотеке' :'').'</span></span>';
									echo $text;
									echo '<div class="lentpricec" title="За сегодня/всего">Просмотров:' . (!empty($row_Recordset1['hitd']) ? $row_Recordset1['hitd'] :'0').'/'. (!empty($row_Recordset1['hita']) ? $row_Recordset1['hita'] :'0').'</div>'; ?>
							</td>
							<td class="align_r" style=" width:100px;">
								<?php echo '<span class="lentprice">' . number_format($row_Recordset1['flats_price'], 0, '.', ' ').' руб.</span><br />';
									echo (($row_Recordset1['kind_calc']==1 || $row_Recordset1['kind_calc'] == 2)? '<span class="lentpricec" style="background-color:#99FF99;">':'<span class="lentpricec">'). number_format(round($row_Recordset1['flats_price']/((isset($_SESSION['usd']))? $_SESSION['usd']:31)), 0, '.', ' ') .' $</span><br />';
									if($row_Recordset1['marga']!=0)echo ($row_Recordset1['marga']>0)?'<span style="font-size:small;color:green;">+'.$row_Recordset1['marga'].'</span>':'<span style="font-size:small;color:red;">-'.$row_Recordset1['marga'].'</span>';?>
							</td>
							<td class="trs-exchanges hide" valign="top" style="width:120px;">
								<div style="text-align:left; font-size:10px; color:#4A4A4A; padding-left:5px;">
									<?php
										if($row_Recordset1['Source']=='0' && $row_Recordset1['Treated']=='0') {
											echo 'Получено с сайта.<br/><span class="red">Необработано.</span>';
										} elseif($row_Recordset1['Source']=='0' && $row_Recordset1['Treated']=='1') {
											echo $row_Recordset1['agency_name'] . '<br/>Получено с сайта.<br/>Обработал(а):<br/>'. $row_Recordset1['agent_name'];
										} else {
											echo  $row_Recordset1['agency_name'] . '<br/>'. $row_Recordset1['agent_name'];
										};
										echo ' <br/><span style="border-bottom: 1px dashed red;">' . timeLeft($row_Recordset1['last_update']).'</span>';
									?>
								</div>
							</td>
						</tr>

						<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
				</table>

				<table>
					<tr>
						<td colspan="5" class="align_l" style="white-space: nowrap; font-size: 10pt;">
							<div style="display:inline;"><a href="#" id="check-all" style="color:navy;">Выделить все</a> / <a href="#" id="uncheck-all" style="color:navy;">Снять выделение</a>
								<em>С выделенными:</em>
								<span class="trs-exchanges hide"><img id="up-checked" class="with-checked" src="_images/arrow-return-090-left.png" height="16" width="16" title="Поднять объявления" alt="" style="cursor:pointer;margin:0 5px 0;vertical-align:middle;"/></span>
								<img id="delete-checked" class="with-checked" src="_images/cross-circle.png" height="16" width="16" title="Исключить из просмотра" alt="" style="cursor:pointer;margin-left:5px;vertical-align:middle;"/>
								<span class="trs-exchanges hide"><input id="marga" name="marga" type="text" value="" style="margin-left:10px;"/><img id="edit-checked" class="with-checked" src="_images/tick-circle.png" height="16" width="16" title="Применить комиссионные" alt="" style="cursor:pointer;margin-left:5px;vertical-align:middle;"/></span>
								<img id="print-check" class="with-checked" src="_images/printer-tick.png" height="16" width="16" title="Выделенные в печать" alt="" style="cursor:pointer;margin:0 5px 0;vertical-align:middle;"/>
								<img id="reload-uncheck" class="with-checked" src="_images/reload_16x16.png" height="16" width="16" title="Сбросить все отметки" alt="" style="cursor:pointer;margin:0 5px 0;vertical-align:middle;"/>
							</div>
						</td>
					</tr>
					<tr><td><fieldset><legend>Использование результатов запроса</legend>
								<div style="margin: 0 0 5px;" class="trs-exchanges hide"><input type="radio" name="report"  title="для клиента" checked="checked" value="0"/><label> для клиента</label>
									<input type="radio" name="report" title="для агента" value="1"/><label> для агента</label>
								</div>
								<span><a target="_blank" href="#" id="link-report"><img height="16" width="16" class="icon" alt="Версия для печати" title="Версия для печати" src="_images/printer.png" /> Версия для печати</a>
									<input id="s-page" type="hidden" value="<?php printf("%s?pageNum_Recordset1=%d%s", "print_view.php", $pageNum_Recordset1, $queryString_Recordset1); ?>"/>
									<input id="sel-page" type="hidden" value="<?php printf("%s?selected=%d%s", "print_view.php", 1000, $queryString_Recordset1); ?>"/>
									<input id="a-page" type="hidden" value="<?php printf("%s?maxRows_Recordset1=%d%s", "print_view.php", 1000, $queryString_Recordset1); ?>"/>
									<select id="type_report" name="type_report" size="1">
										<option value="0" selected="selected">страница</option>
										<option value="1">выделенные</option>
										<option value="2">полностью</option>
								</select> </span>
							</fieldset></td></tr>
				</table>
				<br/>
				<table class="d_table">
					<tfoot>
						<tr>
							<td>
								<?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
									<a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="_images/First.gif" alt="" /></a>
									<?php } // Show if not first page ?>
							</td>
							<td>
								<?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
									<a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage,  max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="_images/Previous.gif" alt="" /></a>
									<?php } // Show if not first page ?>
							</td>
							<td>
								<?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
									<a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage,  min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="_images/Next.gif" alt="" /></a>
									<?php } // Show if not last page ?>
							</td>
							<td>
								<?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
									<a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="_images/Last.gif" alt="" /></a>
									<?php } // Show if not last page ?>
							</td>
						</tr>
						<tr>
							<td colspan="4" valign="center">
								Объекты с 
								<?php echo ($startRow_Recordset1 + 1) ?>
								по 
								<?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?>
								из 
								<?php echo $totalRows_Recordset1 ?>
								найденных в базе данных
								<?php } else { echo "Отсутствуют объявления, удовлетворяющие условиям, Вашего запроса, либо объявление недоступно к просмотру.";}?>
						</td>
					</tr>
				</tfoot>
			</table>
			<!--	start paginator		-->
			<div id="loading" ></div>
			<div id="sstable" ></div>
			<ul id="pagination">
				<?php
					//Pagination Numbers
					/*for($i=1; $i<=10; $i++)
					{
					echo '<li id="'.$i.'">'.$i.'</li>';
					}*/
				?>
			</ul>
			<!--end paginator -->
		</div>

		<div id="card">
		</div>
		<script type='text/javascript' src="/min/?g=jstape"></script>
	</body>
</html>
<?php
	ob_end_flush();
?>
