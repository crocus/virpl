<?php
	include('../_scriptsphp/r_conn.php');
	include('../_scriptsphp/rdate/rdate.php');
	require_once('../_scriptsphp/session.inc');
	session_start();
	$per_page = 10; 
	$page = (isset( $_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
	$start = ($page-1)*$per_page;

	$q_street = (isset( $_REQUEST['street']) && $_REQUEST['street']!= 'undefined' && !empty($_REQUEST['street']))? " WHERE rf.Street={$_REQUEST['street']}" : null;
	$q_house = (isset( $_REQUEST['house']) && $_REQUEST['house']!= 'undefined' && !empty($_REQUEST['house']))? " AND rf.House='{$_REQUEST['house']}'" : null;
	$q_flat = (isset( $_REQUEST['flat']) && $_REQUEST['flat']!= 'undefined' && !empty($_REQUEST['flat']))? " AND rf.Flat='{$_REQUEST['flat']}'" : null;
	
	$doubtful_q= "SELECT rf.Timestamp, ci.city_name, s.street_name,rf.House, rf.Flat, rf.Reason, rf.Published FROM tbl_refuse rf
	LEFT JOIN tbl_street s ON rf.Street = s.street_cod   
	LEFT JOIN tbl_city ci ON s.city_cod = ci.city_cod" . $q_street . $q_house. $q_flat . " ORDER BY rf.Timestamp DESC ";
	$query_limit_Recordset = sprintf("%s LIMIT %d, %d", $doubtful_q, $start, $per_page);
	$r= mysql_query ($query_limit_Recordset) or die(mysql_error());
	$row=mysql_fetch_assoc($r);

	if (isset($_GET['totalRows_Recordset'])) {
		$totalRows_Recordset = $_GET['totalRows_Recordset'];
	} else {
		$all_Recordset = mysql_query($doubtful_q);
		$totalRows_Recordset = mysql_num_rows($all_Recordset);
	}
	$queryString_Recordset = "";
	if (!empty($_SERVER['QUERY_STRING'])) {
		$params = explode("&", $_SERVER['QUERY_STRING']);
		$newParams = array();
		foreach ($params as $param) {
			if (stristr($param, "page") == false &&
			stristr($param, "totalRows_Recordset") == false) {
				array_push($newParams, $param);
			}
		}
		if (count($newParams) != 0) {
			$queryString_Recordset = "&" . implode("&", $newParams);
		}
	}
	$queryString_Recordset = sprintf("&totalRows_Recordset=%d%s", $totalRows_Recordset, $queryString_Recordset);
?>
<?php if($totalRows_Recordset>0) { ?>
	<table class="lenta d_table">
		<?php do { ?>
			<tr>
				<td class="align_l">
					<div class="shap">
						<div><span class="inlinetext"><?php echo nicetime($row['Timestamp'], false); ?></span><br />
							<span class="lentheader"><?php echo $row['city_name'] .', '. $row['street_name'] .' д. '.$row['House'].' кв. '.$row['Flat'] ; ?></span><br />
							<span class="lentbody"><?php echo $row['Reason']; ?></span><br />
							<span>Контакт:<span class="inlinetext"><?php echo $row['Published']; ?></span></span><br/>
							<!--<span class="inlinetext"><?php $queryString_Recordset; ?></span>-->
						</div>
					</div>
				</td>
			</tr>  
			<?php } while ($row=mysql_fetch_assoc($r)); ?>
	</table>
	<!--	<ul id="pagination">
	<?php
		//Pagination Numbers
		/*for($i=1; $i<=$total_pages; $i++)
		{
		echo '<li id="'.$i.'">'.$i.'<span style="display: none;">'.$queryString_Recordset.'</span></li>';
		}*/
	?>
	</ul>-->
	<div class="pagination">
		<?php
			//----------------------------------
			// Pages
			//----------------------------------
			if ($per_page){
				//$total_pages = @ceil($count_all / $number);
				$total_pages = @ceil($totalRows_Recordset/$per_page);
				$current_page = ($start/$per_page) + 1;
				$pages  = '';

				//Advanced pagination
				if ($total_pages > 10){
					//Left block
					$pages_start = 1;
					$pages_max = $current_page >= 5 ? 3 : 5;
					for($j = $pages_start; $j <= $pages_max; $j++){
						if($j == $current_page){
							$pages  .= '<b>'.$j.' </b>';
						} else {
							$pages .= '<a href="?page='.$j. $queryString_Recordset.'">'.$j.' </a> ';
						}
					}
					$pages  .= '... ';

					//Middle block
					if($current_page > 4 && $current_page < ($total_pages - 3)){
						$pages_start = $current_page - 1;
						$pages_max = $current_page + 1;
						for($j = $pages_start; $j <= $pages_max; $j++){
							if($j == $current_page){
								$pages  .= '<b>'.$j.' </b>';
							} else {
								$pages .= '<a href="?page='.$j. $queryString_Recordset.'">'.$j.' </a> ';
							}
						}
						$pages  .= '... ';
					}

					//Right block
					$pages_start = $current_page <= $total_pages - 4 ? $total_pages - 2 : $total_pages - 4;
					$pages_max = $total_pages;
					for($j = $pages_start; $j <= $pages_max; $j++){
						if($j == $current_page){
							$pages  .= '<b>'.$j.' </b>';
						}
						else{
							$pages .= '<a href="?page='.$j. $queryString_Recordset.'">'.$j.' </a> ';
						}
					}
				}

				//Normal pagination
				else {
					for ($j = 1; $j <= $total_pages; $j++){
						if ((($j - 1) * $per_page) != $start){
							$pages .= '<a href="?page='.$j. $queryString_Recordset.'">'.$j.' </a> ';
						} else {
							$pages .= ' <b>'.$j.'</b> ';
						}
					}
				}
				echo $pages;
			}
		?>
	</div>
	<?php 
	} else { echo "Отсутствуют объявления, удовлетворяющие условиям, Вашего запроса.";}?>