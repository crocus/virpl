<?php
  ///////////////////////////////////////////////////
  // Система учёта посещаемости сайта - PowerCounter
  // 2003-2006 (C) IT-студия SoftTime (http://www.softtime.ru)
  // Поддержка: http://www.softtime.ru/forum/
  // Симдянов И.В. (simdyanov@softtime.ru)
  // Кузнецов М.В. (kuznetsov@softtime.ru)
  // Голышев С.В. (softtime@softtime.ru)
  ///////////////////////////////////////////////////
  // Помещаем время окончания вычислений в переменную $end_time
  $part_time = explode(' ',microtime()); 
  $end_time = $part_time[1].substr($part_time[0],1); 
?>
<br><br></td><td width=10%>&nbsp;</td></tr>
<tr class=authors>
  <td colspan="3">
     Система статистики PowerCounter разработана и поддерживается IT-студией «SoftTime»
     <a href="http://www.softtime.ru">www.softtime.ru</a> Время генерации страницы <?= sprintf("%.2f",$end_time - $begin_time) ?> секунды</td></tr>
</table>
</body>
</html>
<script language='JavaScript1.1' type='text/javascript'>
<!--
  function delete_position(url, ask)
  {
    if(confirm(ask))
    {
      location.href=url;
    }
    return false;
  }
//-->
</script>