<?php
  ////////////////////////////////////////////////////////////
  // ������� ����� ������������ ����� - PowerCounter
  // 2003-2008 (C) IT-������ SoftTime (http://www.softtime.ru)
  // ���������: http://www.softtime.ru/forum/
  // �������� �.�. (simdyanov@softtime.ru)
  // �������� �.�. (kuznetsov@softtime.ru)
  // ����� �.� (loki_angel@mail.ru)
  // ������� �.�. (softtime@softtime.ru)
  ////////////////////////////////////////////////////////////
  // ���������� ������� ��������� ������ 
  // (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE); 
  // ������������� ���������� � ����� ������
  require_once("config.php");
  // ���������� SoftTime FrameWork
  require_once("../../config/class.config.dmn.php");
  // ���������� ���� �����������
  require_once("../utils/security_mod.php");
  // ���������� ���� ����������� ������ � ���� ��������
  require_once("../utils/utils.print_page.php");
  // ������������ WHERE-�������
  require_once("utils.where.php");
  // ���������� �������
  require_once("utils.query_result.php");

  if (!isset($_GET['begin'])) $begin = 1;
  else $begin = intval($_GET['begin']);
  if (!isset($_GET['end'])) $end = 0;
  else $end = intval($_GET['end']);

  // ��������� ��������
  $title = '����� ������'; 
  $pageinfo = '�� ���� �������� �� ������ ������ ���������� �� 
  ������� ����������� ������������ �� ����� ����� �� ��������� 
  ������� �������.';  

  try
  {
    // �������� ��������� ��������
    require_once("../utils/topcounter.php");

    ?>
      <table class="table" width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr class="header">
          <td width=<?= 100/5 ?>% align=center><a href='time.php?begin=1&end=0'>�������</a></td>
          <td width=<?= 100/5 ?>% align=center><a href='time.php?begin=2&end=1'>�����</a></td>
          <td width=<?= 100/5 ?>% align=center><a href='time.php?begin=7&end=0'>�� 7 ����</a></td>
          <td width=<?= 100/5 ?>% align=center><a href='time.php?begin=30&end=0'>�� 30 ����</a></td>
          <td width=<?= 100/5 ?>% align=center><a href='time.php?begin=0&end=0'>�� �� �����</a></td>
        </tr>
      </table><br><br>
      <table class="table" width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr class="header"><td><p>�����</td><td>�������������</td><td>�����������</td></tr>
    <?php
    // ������� ��������� ������� $tbl_thits
    $query = "TRUNCATE TABLE $tbl_thits";  
    if(!mysql_query($query))
    {
       throw new ExceptionMySQL(mysql_error(), 
                                $query,
                               "������ ������� ��������� �������");
    }
         
    // ��������� ��������� ��������
    for($i = $begin; $i > $end; $i--)
    {
      // ��������� WHERE-������� ��� ���������� ���������
      $where = where_interval($begin, $end);
      $query = "INSERT INTO $tbl_thits 
                SELECT ROUND((max(unix_timestamp(putdate))-min(unix_timestamp(putdate)))/60)*60+60 
                FROM $tbl_ip 
                $where AND systems != 'none' AND
                       systems != 'robot_yandex' AND
                       systems != 'robot_google' AND
                       systems != 'robot_rambler' AND
                       systems != 'robot_aport' AND
                       systems != 'robot_msn'
                GROUP BY ip";
      if(!mysql_query($query))
      {
         throw new ExceptionMySQL(mysql_error(), 
                                  $query,
                                 "������ ���������� ��������� �������");
      }
    }

    $query = "SELECT COUNT(hits) AS total 
              FROM $tbl_thits 
              GROUP BY hits 
              ORDER BY total DESC
              LIMIT 1";
    $total = query_result($query);

    $query = "SELECT hits, COUNT(hits) AS total 
              FROM $tbl_thits 
              GROUP BY hits 
              ORDER BY hits";
    $res = mysql_query($query); 
    if(!$res)
    {
       throw new ExceptionMySQL(mysql_error(), 
                                $query,
                               "������ ���������� ���������");
    }
    while($time = mysql_fetch_array($res))
    {
      echo "<tr>
             <td>".gmdate("H:i", $time['hits'])."</td>
             <td>$time[total]</td>
             <td><img src=images/parm.gif 
                      border=0 
                      width=".(400/$total*$time['total'])." 
                      height=6></td>
            </tr>";
      $host += $time['total'];
    }
    echo "<tr>
            <td>&nbsp;</td>
            <td>������: $host</td>
            <td>&nbsp;</td>
          </tr>";

    echo "</table>";
    // ���������� ��������
    require_once("../utils/bottomcounter.php");
  }
  catch(ExceptionObject $exc) 
  {
    require("../utils/exception_object.php"); 
  }
  catch(ExceptionMySQL $exc)
  {
    require("../utils/exception_mysql.php"); 
  }
  catch(ExceptionMember $exc)
  {
    require("../utils/exception_member.php"); 
  }
?>