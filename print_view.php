<?php
	ob_start("ob_gzhandler");
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
	header('Cache-Control: no-store, no-cache, must-revalidate'); 
	header('Cache-Control: post-check=0, pre-check=0', FALSE); 
	header('Pragma: no-cache');
	include('print.php');
	include('_scriptsphp/rdate/rdate.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Версия для печати (объявления) c www.virpl.ru</title>
		<script type='text/javascript' src="/min/?g=jsframe"></script>
		<link href="/min/?g=cssframe" rel="stylesheet" type="text/css"/>
		<link rel="icon" href="/favicon.ico" type="image/x-icon"/>
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
	</head>
	<body style="margin: 20px 20px;width:1024px;">	
		<?php
			if (isset($_COOKIE['report']) && $_COOKIE['report'] == 0) {
				echo "<h2>Коммерческое предложение</h2>";
				//$contact = "Контакт: ";
				$contact = '<div style="text-align:left; font-size:10pt; color:#4A4A4A; padding-left:5px; margin-top:5px;">'
				. $row_Recordset1['logged_user'] .'</div>';	
				echo $contact;
			} elseif(isset($_COOKIE['report']) && $_COOKIE['report'] == 1) {
				echo "<h2>Отчет для агента</h2>";
			} else {
				echo "<h2>Выбранные предложения от компаний</h2>";
			}
		?>
		<div id="objects" style="padding: 20px 20px;">
			<table id="o_lent" class="lenta d_table">
				<?php if($totalRows_Recordset1>0) {
						do { ?>
						<tr value="<?php echo $row_Recordset1['flats_cod']; ?>">
							<td class="align_l show-popup">
								<?php $count_r = $row_Recordset1['room_cod'];
									$text = '<span class="lentheader">';
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
										case 'дача':
											$text .= 'Садоводческий участок (дача), ';
											break;
										default :
											$text .= $count_r. '-комнатная, ';
											break;
									}
									$text .= $row_Recordset1['street_name']. ', '.(($row_Recordset1['region_name']==$row_Recordset1['city_name']) ? $row_Recordset1['city_name']: 'р-н '
									. $row_Recordset1['region_name']). '</span><br/><span style="font: 10pt Arial;">Код объекта: ' 
									. substr($row_Recordset1['UUID'], 0, 8) . '</span>';
									if (isset($_COOKIE['report']) && $_COOKIE['report'] == 1) {
										$text .= '<div style="font-size:10px; color:#4A4A4A; margin-bottom:5px;"><span style="border-bottom: 1px dashed red;">' . timeLeft($row_Recordset1['last_update']).'</span></div>';
									}
									$text .= '<div><span class="lentbody"> Площади: '. $row_Recordset1['So']
									. ((!empty($row_Recordset1['Sz'])) ? '/'. $row_Recordset1['Sz']:  null)
									. ((!empty($row_Recordset1['Sk'])) ? '/'.$row_Recordset1['Sk']: null). ' кв.м., '
									. $row_Recordset1['flats_floor'].'/'.$row_Recordset1['flats_floorest'].' '. $row_Recordset1['material_short']. ', ' 
									. 'Санузел: '. $row_Recordset1['wc_name'] . ', '
									. (($row_Recordset1['balcon_short'] !="НЕТ") ? $row_Recordset1['balcon_short'] : null )
									. ((!empty($row_Recordset1['flats_comments'])) ? '<br/>'. $row_Recordset1['flats_comments']:  null)
									. '<div style="text-align:left; font-size:10pt; color:#4A4A4A; padding-left:5px; margin-top:5px;">';
									if (!isset($_COOKIE['report']) || $_COOKIE['report'] == 1) {
										if($row_Recordset1['Source']=='0' && $row_Recordset1['Treated']=='0') {
											$text .= 'Получено с сайта.<br/><span class="red">Необработано.</span>';
										} elseif($row_Recordset1['Source']=='0' && $row_Recordset1['Treated']=='1') {
											$text .= 'Получено с сайта.<br/>Обработал(а):<br/>'. $row_Recordset1['agent_name'];
										} else {
											$text .= 'Агент: '. $row_Recordset1['agent_name'];
										}
										$text .= '<br/>Агентство: '. $row_Recordset1['agency_name']
										.'<br/>'. $row_Recordset1['phon'];
									} 
									$text .= '</div></span></div>';
									echo $text;?>
							</td>
							<td class="align_r" style=" width:100px;">
								<?php echo '<span class="lentprice">' . number_format($row_Recordset1['flats_price'], 0, '.', ' ').' руб.</span><br />';
									echo (($row_Recordset1['kind_calc']==1 || $row_Recordset1['kind_calc'] == 2)? '<span class="lentpricec" style="background-color:#99FF99;">':'<span class="lentpricec">'). number_format(round($row_Recordset1['flats_price']/((isset($_SESSION['usd']))? $_SESSION['usd']:31)), 0, '.', ' ') .' $</span><br />';
									if (isset($_COOKIE['report']) && $_COOKIE['report'] == 1) {
										if($row_Recordset1['marga']!=0)echo ($row_Recordset1['marga']>0)?'<span style="font-size:small;color:green;">+'.$row_Recordset1['marga'].'</span>':'<span style="font-size:small;color:red;">-'.$row_Recordset1['marga'].'</span>';
								}?>

							</td>
						</tr>

						<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
					<?php }?>
			</table>
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
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
							$('.trs-exchanges').removeClass("hide").addClass("show");
						}
					}
				});
			});
		</script>
	</body>
</html>
<?php
	ob_end_flush();
?>
