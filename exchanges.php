<?php
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
	header('Cache-Control: no-store, no-cache, must-revalidate'); 
	header('Cache-Control: post-check=0, pre-check=0', FALSE); 
	header('Pragma: no-cache');
	require_once('_scriptsphp/r_conn.php');
	include('_scriptsphp/rdate/rdate.php');
	include('_scriptsphp/services.php');
	require_once('_scriptsphp/session.inc');
	session_start();
?>
<?php
	$currentPage = $_SERVER["PHP_SELF"];
	$maxRows_Recordset1 = 10;
	$pageNum_Recordset1 = 0;
	if (isset($_GET['pageNum_Recordset1'])) {
		$pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
	}
	$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;
	global $_GET;
	mysql_select_db($database_realtorplus, $realtorplus);
	$type = (isset($_GET['type_exchange']) && !is_null($_GET['type_exchange'])) ? $_GET['type_exchange'] : null;
	$formula = (isset($_GET['formula']) && strval($_GET['formula'] && !empty($_GET['formula']))) ? htmlspecialchars(trim(rtrim($_GET['formula']))) : null;
	//парсинг формулы /////////////////////
	if (!is_null($formula)) {
		$formula_array = formulaParser($formula, $type);
		$formula = $formula_array[0];
		$result = $formula_array[1];
		$type = $formula_array[2];
	}
	if (isset($_GET['s_prpt']) && strval($_GET['s_prpt'] && !empty($_GET['s_prpt']))) {
		$participants = searchFromParticipants($_GET['s_prpt']);
	} else {
		$participants = null;
	}
	$AgeQuery = (isset($participants) && !empty($participants)) ? " And e.agent_cod in ($participants)" : null;
	$age = (isset($_GET['pussy']) && strval($_GET['pussy'] && !empty($_GET['pussy']))) ? ' >= '  . trim(rtrim($_GET['pussy'])) : ' < 14 ';
	$GenerQuery = "SELECT e.Id, e.foto, e.UUID, e.Date, e.Type_Exchange, e.Formula, e.Result, e.Description, e.Contact, e.Source, e.Treated, n.value_property as agent_name FROM tbl_exchange e 
	LEFT JOIN tbl_participants pc ON pc.UUID = e.agent_cod 
	LEFT JOIN tbl_participants_catalog n ON pc.Participants_id = n.Participants_id And n.Participants_property_id=1 ";
	/*LEFT JOIN node n ON e.agent_cod = n.UUID 
	LEFT JOIN node na ON na.participants_id = n.parents_id 
	LEFT JOIN tbl_telag t ON t.agency_name = na.Name_Node */
	if(isset($_SESSION['user'])&& !empty($_SESSION['user'])) {
		$GenerQuery.= "WHERE DATEDIFF(NOW(), e.last_update) $age";
	} else {
		$GenerQuery.= "WHERE DATEDIFF(NOW(), e.last_update) $age And e.Treated = 1";
	}
	//WHERE e.Treated in (0,1)"e.Treated = 1;
	$connector = " And";
	$groupment = " group by e.Id";
	$order =  " ORDER BY e.Date DESC";
	switch ( $type ) {
		case NULL:
			$Type_Exchange = (" e.Type_Exchange IS NOT NULL");
			break;
		case "  ":
			$Type_Exchange = (" e.Type_Exchange IS NOT NULL");
			break;
		default :
			$Type_Exchange  = (" e.Type_Exchange = {$type}");
			break;
	}

	switch ( $formula  ) {
		case NULL:
			$formula_pq = (" e.Formula IS NOT NULL");
			break;
		case "  ":
			$formula_pq = (" e.Formula IS NOT NULL");
			break;
		default :
			$formula_pq  = " e.Formula = '{$formula}'";
			break;
	}
	switch ( $result ) {
		case NULL:
			$result_pq = (" e.Result IS NOT NULL");
			break;
		case "  ":
			$result_pq = (" e.Result IS NOT NULL");
			break;
		default :
			$result_pq  = " e.Result = '{$result}'";
			break;
	}
	switch ( $ord ) {
		case NULL:
			$ordQuery = (" ORDER BY f.flats_price");
			break;
		case "  ":
			$ordQuery = (" ORDER BY r.room_cod");
			break;
		case "type":
			$ordQuery = (" ORDER BY  t.type_s");
			break;
		case "date":
			$ordQuery = (" ORDER BY f.flats_date DESC");
			break;
		case "room":
			$ordQuery = (" ORDER BY r.room_cod");
			break;
		case "price":
			$ordQuery = (" ORDER BY f.flats_price DESC");
			break;
		default :
			$ordQuery  = " ORDER BY {$ord }";
			break;
	}
	$Exchange = $GenerQuery . $AgeQuery. $connector . $Type_Exchange . $connector . $formula_pq . $connector . $result_pq . $groupment . $order;
	$query_Recordset1 = $Exchange;
	$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
	$Recordset1 = mysql_query($query_limit_Recordset1, $realtorplus) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
	if (isset($_GET['totalRows_Recordset1'])) {
		$totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
	} else {
		$all_Recordset1 = mysql_query($query_Recordset1);
		$totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
	}
	$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

	$queryString_Recordset1 = "";
	if (!empty($_SERVER['QUERY_STRING'])) {
		$params = explode("&", $_SERVER['QUERY_STRING']);
		$newParams = array();
		foreach ($params as $param) {
			if (stristr($param, "pageNum_Recordset1") == false &&
			stristr($param, "totalRows_Recordset1") == false) {
				array_push($newParams, $param);
			}
		}
		if (count($newParams) != 0) {
			$queryString_Recordset1 = "&" . implode("&", $newParams);
		}
	}
	$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
?>
<?php
	function getTypeExchange($t_ex) {
		switch ( $t_ex) {
			case "0":
				echo "Съезд:";
				break;
			case "1":
				echo "Разъезд:";
				break;
			default:
				echo "Обмениваю:";
				break;
		}
	} 
	function getFFormula($t_ex, $rez, $form) {
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Владивостокский Информационный Риэлторский Портал: обмены</title>
		<script type='text/javascript' src="/min/?g=jsframe"></script>
		<link href="/min/?g=cssframe" rel="stylesheet" type="text/css"/>
	</head>
	<body>
		<div id="card-e" style="display:none;padding:10px;"></div>
		<div id="objects">
			<fieldset>
				<legend>Обмены</legend>
				<?php
					if (isset($_GET['action']) && $_GET['action'] == 'submitted') {
						if(strpos($_GET['formula'], '=') != strripos($_GET['formula'], '=')) {
							echo 'Вероятно Вы допустили ошибку при написании формулы.' . '<br/>';
						} else {
							echo 'Вы ищете в разделе ';
							getTypeExchange($type);
							echo  '&nbsp;';
							if($_GET['formula'] == NULL) {
								print "все предложения.";
							} elseif
							($type == "0") {
								print $formula."=". $result; }
							else {
								print $result."=". $formula; }
							echo '<br/>';
						}
						echo '<a href="'. $_SERVER['PHP_SELF'] .'">Изменить условия поиска</a>';
					} else {
					?>
					<form  id="search" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" style="margin-bottom:0px;" >
						<label for="formula">Формула:</label>
						<br />
						<input type="text" name="formula" id="textfield2"/>
						<div id="faq" class="slink"><span>Как пользоваться этой формой?</span></div>
						<span class="red redline note">Порядок написания формулы! В длинной части (&quot;1+г+допл&quot;), сначала указываем объект большей площади, затем меньшей, и в заключении, если необходимо, доплата.<br />
							Например:<br />
							если Вы разъезжаетесь - 4=1+г+допл<br />
							или съезжаетесь - 2+1+допл=4<br />
							Гостинки - г, дома - д, подселения - подс, доплата - допл.</span><br />
						<input type="radio" name="type_exchange" id="2" value="1" />
						<label for="type_exchange"> Разъезд</label>
						<br />
						<input type="radio" name="type_exchange"  id="1" value="0" />
						<label for="type_exchange">Съезд</label>
						<br />
						<br />
						<input name="button" type="submit" class="btn_onpix" id="button" value="Поиск" align="center"  />
						<input type="hidden" name="action" value="submitted" />
					</form>
					<?php
					}
				?>
			</fieldset>
			<table  id="e_lent" class="lenta d_table">
				<tbody>
					<?php
						if($totalRows_Recordset1>0) {
							do { ?>
							<tr onclick="showPopupEx(<?php echo $row_Recordset1['Id']; ?>)">
								<td class="align_c" style="width:90px; vertical-align:middle;"><?php if( $row_Recordset1['foto'] != 0) echo '<img src="base5.php?id_image='. $row_Recordset1['Id'] .'&amp;category=1&amp;image=0&amp;min=1&amp;percent=0.12" alt="" />'?></td>
								<td class="align_l"><?php echo '<span class="lentheader">';
										getTypeExchange($row_Recordset1['Type_Exchange']);
										($row_Recordset1['Type_Exchange'] == "0")?  print '&nbsp;' . $row_Recordset1['Formula']."=". $row_Recordset1['Result'] : print '&nbsp;' . $row_Recordset1['Result']."=". $row_Recordset1['Formula'];
									echo '</span><br /><span class="lentbody">' . $row_Recordset1['Description'] . '</span>'; ?></td>
								<td class="align_r"><span style="font-size:0.9em;white-space:nowrap;">
										<?php
											if (isset($row_Recordset1['Date'])) {
												//echo rdate(" H:i, j m ", strtotime($row_Recordset1['Date'], date() ) );
												echo nicetime($row_Recordset1['Date'], true);
											}
										?>
									</span></td>
								<td class="trs-exchanges hide" valign="top" width="15%"><div style=" text-align:left; font-size:10px; color:#4A4A4A; padding-left:5px;"><?php
											if($row_Recordset1['Source']=='0' && $row_Recordset1['Treated']=='0') {
												echo 'Получено с сайта.<br/><span class="red">Необработано.</span>';
											} elseif($row_Recordset1['Source']=='0' && $row_Recordset1['Treated']=='1') {
												echo 'Получено с сайта.<br/>Обработал(а):<br/>'. $row_Recordset1['agent_name'];
											} else {
												echo 'Разместил(а):<br/>'. $row_Recordset1['agent_name'];
											};
									?></div></td>
							</tr>
							<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
					</tbody>
				</table>
				<table class="d_table">
					<tfoot>
						<tr>
							<td ><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
									<a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="_images/First.gif" alt="" /><br/>
										Первая</a>
								<?php } // Show if not first page ?></td>
							<td ><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
									<a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="_images/Previous.gif" alt="" /><br/>
										Предыдущая</a>
								<?php } // Show if not first page ?></td>
							<td ><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
									<a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="_images/Next.gif" alt="" /><br/>
										Следующая</a>
								<?php } // Show if not last page ?></td>
							<td ><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
									<a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="_images/Last.gif" alt="" /><br/>
										Последняя</a>
								<?php } // Show if not last page ?></td>
						</tr>
						<tr>
							<td  colspan="4" align="center" valign="center" >Объекты с <?php echo ($startRow_Recordset1 + 1) ?> по <?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> из <?php echo $totalRows_Recordset1 ?> найденных в базе данных
							<?php } else { echo "Отсутствуют объявления, удовлетворяющие условиям, Вашего запроса.";}?></td>
					</tr>
				</tfoot>
			</table>
		</div>
		<div id="faq_exchange" style="display: none">
			<div id="faq-body" class="textondiv">Этот раздел может быть полезен:
				<p>– Тем, кто так и не дождался «своего» покупателя, а вопрос в РАЗЪЕЗДЕ или СЪЕЗДЕ актуален и по сей день.</p>
				<p>– Тем, кто «затрудняется» в выплате ИПОТЕКИ по причине наступивших экономических «перемен». Подобрав меньший вариант через ОБМЕН, Вы сможете полученной доплатой погасить долг перед банком, в конечном итоге, оставшись с крышей над головой.</p>
				<p>– Тем, кто вложил денежные средства в недвижимость как в инвестиционный проект и не может их «выдернуть» для решения текущих вопросов своего бизнеса. Предложив свою недвижимость к обмену на меньшее, Вы можете частично вернуть вложенные средства. Причем процесс может быть многоступенчатым. Не секрет, что в конечном итоге продать квартиру небольшой площади, намного легче.</p>
				<p>Основные принципы, заложенные в поисковую систему, просты: РАЗЪЕЗД – это обмен большего варианта на несколько меньших вариантов т. е. большее = меньшее + меньшее (знак = в левой части). СЪЕЗД – это обмен нескольких меньших вариантов на больший т. е. меньшее + меньшее = большее (знак = в правой части).</p><p>Пример: РАЗЪЕЗД <br />
					Вы меняете 3-х комнатную квартиру на 1 – комнатную и доплату:</p>
				<ol>
					<li>Формулу 3=1+допл записываете в поисковое окно.</li>
					<li>Ставите отметку на разделе СЪЕЗД т. к. будете производить поиск в альтернативных т. е. встречных вариантах.</li>
					<li>Нажимаете «ПОИСК».</li>
				</ol>
				<p>В результате поиска Вы получаете ряд встречных предложений из раздела СЪЕЗД из которых Вам остается найти «Ваш» и позвонить по указанному телефону.</p>
			</div>
		</div>
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
		createModeViewEx(modeview);
		$('.lentbody').mTruncate({
			length: 65,
			minTrail: 10,
			moreText: "[читать дальше]",
			lessText: "[спрятать]",
			ellipsisText: "...",
			moreAni: "fast",
			lessAni: "fast"
		});
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
					$('td.trs-exchanges').removeClass("hide").addClass("show");
					agent_t = $.ajax({
						url: "../_scriptsphp/get_parameters.php",
						data: "parameter=agent",
						async: false
					}).responseText;
					obj_AvailableAgents = eval("(" + agent_t + ")");
				} 
			}
		});
		$("#faq").click(function () {
			$("#faq_exchange").toggle();
			var s = $("#faq");
			var position = s.position();
			var s_w = s.width();
			var s_h = s.height();
			var top = position.top + s_h + 5;
			var left = position.left + s_w -405;
			var cssObj = {
				'position':'absolute',
				'z-index':'999',
				'left': left,
				'top' : top,
				'border':'3px solid #dedede',
				'width':'400px',
				'font-size':'small'
			}
			$('#faq_exchange').css(cssObj);
			$('#faq-body').css("background-color", "#FFFFCC");
		});
		var timoutHandler = function () {
			$("#faq_exchange").fadeOut("slow");
		};
		var timeoutId = null;
		$("#faq_exchange").mouseout(function(){
			timeoutId = setTimeout(timoutHandler, 2000);
		}).mouseover(function(){
			clearTimeout(timeoutId);
		});
	});
</script>