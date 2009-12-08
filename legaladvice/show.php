<?php
include('../_scriptsphp/r_conn.php');
include('../_scriptsphp/rdate/rdate.php');
require_once('../_scriptsphp/session.inc');
session_start();
$c=0;
$r=mysql_query ("SELECT * FROM gb ORDER BY dt DESC"); // выбор всех записей из БД, отсортированных так, что самая последняя отправленная запись будет всегда первой.
while ($row=mysql_fetch_array($r))  // для каждой записи организуем вывод.
{
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
					case 4:
					case 5:
					case 15:
						echo '<div style="width:10%;padding-top:5px;text-align:right;float:right;">
			<label style="display:none;">'.$row['id'].'</label>
			<a href="#" class="ladvice_redact" title="Ответить"><img src="../_images/balloon-left.png" alt="Ответить" /></a>
			<a href="#" class="ladvice_delete" title="Удалить"><img src="../_images/cross.png" alt="Удалить" /></a>
		</div>';
						break;
				}
			}?>

	</div><br />
		<?php if(!empty($row['response'])) {
			echo '<p class="ready-answer"><span>Ответ:</span>' . $row['response'] . '</p>';
		}?>
</div>    
	<?php
	$c++;
}
if ($c==0) // если ни одной записи не встретилось
	echo "Гостевая книга пуста!</br>";
?>