<?php
	include('../_scriptsphp/r_conn.php');
	include('../_scriptsphp/rdate/rdate.php');
	require_once('../_scriptsphp/session.inc');
	session_start();
	$UUID=$_REQUEST['UUID'];
	$c=0;
	$r=mysql_query ("SELECT * FROM tbl_claim WHERE Flag =0 And UUID = '$UUID' ORDER BY Timestamp DESC"); // выбор всех записей из БД, отсортированных так, что самая последняя отправленная запись будет всегда первой.
?>
<h3 style="margin: 10px 0;color:#2E6E9E;">Заявки на осмотр объекта</h3>
<div style="width: 590px; margin:5px 0; padding: 5px;" class="form-container">
	<?php
		while ($row=mysql_fetch_array($r))  // для каждой записи организуем вывод.
		{
			if ($c%2)
				$col="#f9f9f9";	// цвет для четных записей
			else
				$col="#f0f0f0";	// цвет для нечетных записей
		?>

		<div class="shap" style="padding-bottom: 3px; border-bottom: 1px solid navy;">
			<div style="width:85%; display: inline-block;">
				<span style="display: block; margin: 3px 0; border-bottom: 1px dotted #000;">Заявка отправлена: <?php echo nicetime($row['Timestamp'], false); ?></span>
				<span>Имя: <?php echo $row['Author']; ?></span><br />		
				<span>Контактные данные:<span class="inlinetext"><?php echo $row['Contact']; ?></span></span><br />	
				<?php
					if(!empty($row['Description']))
						echo '<span>Дополнительные пожелания:</span><br /><span class="inlinetext">' . $row['Description'].'</span>';
				?>
			</div>
			<?php if(isset($_SESSION['user'])&& !empty($_SESSION['user']) ) {
					$role = $_SESSION['role'];
					switch ($role) {
						case 2:
						case 4:
						case 5:
						case 15:
							echo '<div style=" display: inline-block; width:13%;padding-top:5px;text-align:right; vertical-align: top;">
							<label style="display:none;">'.$row['Claim_id'].'</label>
							<a href="#" class="claim_delete" title="Удалить"><img src="../_images/cross.png" alt="Удалить" /></a>
							</div>';
							break;
					}
			}?>
		</div>  
		<?php
			$c++;
		}
		if ($c==0) // если ни одной записи не встретилось
			echo "<span id='empty_claim'>По этому объекту нет заявок.</span></br>";
	?>
	</div>