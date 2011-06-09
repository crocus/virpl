<?php
	include('../_scriptsphp/r_conn.php');
	include('../_scriptsphp/rdate/rdate.php');
	require_once('../_scriptsphp/session.inc');
	session_start();
	$per_page = 10; 
	$page = (isset( $_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
	$start = ($page-1)*$per_page;

	$c=0;
	$s="SELECT * FROM vp_faq ORDER BY dt DESC"; // выбор всех записей из БД, отсортированных так, что самая последняя отправленная запись будет всегда первой.

	$query_limit_Recordset = sprintf("%s LIMIT %d, %d", $s, $start, $per_page);
	$r= mysql_query ($query_limit_Recordset) or die(mysql_error());
	$row=mysql_fetch_assoc($r);
	if (isset($_GET['totalRows_Recordset'])) {
		$totalRows_Recordset = $_GET['totalRows_Recordset'];
	} else {
		$all_Recordset = mysql_query($s);
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

	if($totalRows_Recordset>0) { 
		do { 
			if ($c%2)
				$col="#f9f9f9";	// цвет для четных записей
			else
				$col="#f0f0f0";	// цвет для нечетных записей
			if(empty($row['response'])) {
				$col = "#FDE6E9"; 
			}
		?>

		<h2 style="background-color:<?php echo $col; ?>"><span class="inlinetext" style="font-size:10pt;">Вопрос: <?php echo $row['msg']; ?></span></h2>
		<div>
			<div class="shap">
				<div style="width:85%;float:left;"><span>Автор:<span class="inlinetext"><?php echo $row['username']; ?></span></span><br />
					<span>Опубликован:<span class="inlinetext"><?php echo nicetime($row['dt'], false); ?></span></span>
				</div>
				<?php if(isset($_SESSION['user'])&& !empty($_SESSION['user']) ) {
						$role = $_SESSION['role'];
						switch ($role) {
							case 3:
							case 4:
							case 5:
							case 15:
								echo '<div style="width:10%;padding-top:5px;text-align:right;float:right;">
								<label style="display:none;">'.$row['id'].'</label>
								<a href="#" class="_redact" title="Ответить"><img src="../_images/balloon-left.png" alt="Ответить" /></a>
								<a href="#" class="_delete" title="Удалить"><img src="../_images/cross.png" alt="Удалить" /></a>
								</div>';
								break;
						}
				}?>

			</div><br />
			<?php if(!empty($row['response'])) {
					echo '<p class="ready-answer"><span>Ответ:</span>' . $row['response'] . '</p>';
			}?>
		</div>    
		<?php  $c++; } while ($row=mysql_fetch_assoc($r)); ?>
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
	} else { echo "";}?>