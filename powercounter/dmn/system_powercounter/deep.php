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
  $title = '������� ���������'; 
  $pageinfo = '�� ���� �������� �� ������ ������ ���������� 
  �� ���������� ������������� ������� ������������ �� ���� 
  �����.';  

  try
  {
    // �������� ��������� ��������
    require_once("../utils/topcounter.php");

    ?>
    <table border=0 width=100%>
      <tr valign=top>
        <td align=left>
    <table class="table" border="0" cellpadding="0" cellspacing="0">
      <tr class="header" align="center">
        <td>���������� �� �����</td>
        <td>�����������</td>
        <td>�����������</td></tr>
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
      for ($i = $begin; $i > $end; $i--)
      {
        // ��������� WHERE-������� ��� ���������� ���������
        $where = where_interval($begin, $end);
        // ��������� ������
        $query = "INSERT INTO $tbl_thits SELECT count(id_ip) AS hits FROM $tbl_ip 
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
    
      $query = "SELECT hits, 
                       COUNT(hits) AS total 
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
      if (mysql_num_rows($res))
      {
        while($deep = mysql_fetch_array($res))
        {
          echo "<tr>
                 <td>$deep[hits]</td>
                 <td>$deep[total]</td>
                 <td><img src=images/parm.gif 
                          border=0 
                          width=".(400/$total*$deep['total'])." 
                          height=6></td>";
          $host = $host+$deep['total'];
          $hits = $hits+($deep['hits']*$deep['total']);
        }
        echo "<tr>
                <td>�����: $hits</td>
                <td>������: $host</td>
                <td>&nbsp;</td>
              </tr>";
     }

    echo "</table>";
    echo "</td></tr></table>";

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