<?php
  ///////////////////////////////////////////////////
  // ������� ����� ������������ ����� - PowerCounter
  // 2003-2006 (C) IT-������ SoftTime (http://www.softtime.ru)
  // ���������: http://www.softtime.ru/forum/
  // �������� �.�. (simdyanov@softtime.ru)
  // �������� �.�. (kuznetsov@softtime.ru)
  // ������� �.�. (softtime@softtime.ru)
  ///////////////////////////////////////////////////
  // �������� ����� ��������� ���������� � ���������� $end_time
  $part_time = explode(' ',microtime()); 
  $end_time = $part_time[1].substr($part_time[0],1); 
?>
<br><br></td><td width=10%>&nbsp;</td></tr>
<tr class=authors>
  <td colspan="3">
     ������� ���������� PowerCounter ����������� � �������������� IT-������� �SoftTime�
     <a href="http://www.softtime.ru">www.softtime.ru</a> ����� ��������� �������� <?= sprintf("%.2f",$end_time - $begin_time) ?> �������</td></tr>
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