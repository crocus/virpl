<?php
ob_start("ob_gzhandler");
include('../_scriptsphp/r_conn.php');
include('../_scriptsphp/rdate/rdate.php');
require_once('../_scriptsphp/session.inc');
session_start();
$c=0;
$r=mysql_query ("SELECT msg FROM gb WHERE response IS NOT NULL ORDER BY dt DESC LIMIT 3;"); // выбор всех записей из БД, отсортированных так, что самая последняя отправленная запись будет всегда первой.
while ($row=mysql_fetch_array($r))  // для каждой записи организуем вывод.
{
	?>
<li style="border-bottom: #CCC groove 1px; margin-bottom: 5px;"><span class="advice_digest" style="font-size:10pt;"><?php echo $row['msg']; ?></span></li>
	<?php
	$c++;
}
ob_end_flush();
?>