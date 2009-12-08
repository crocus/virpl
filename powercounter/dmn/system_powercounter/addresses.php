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
  // ������������ ���������
  require_once("../utils/utils.pager.php");
  // ������������ WHERE-�������
  require_once("utils.where.php");
  // ���������� �������
  require_once("utils.query_result.php");

  $title = 'IP&nbsp;������';
  $pageinfo = '�� ���� �������� �� ������ ������ IP-������
  �����������, ��������������� ���� ������� �������� �����
  ������, ���������� ��������� � ������� IP-������, �������
  ��������� � ����� IP-������ �� ������ ���������� ���������
  � ��������� ����� ��������� � ����� IP-������. ����� ��
  ������������ IP-����� ����� �������� ���������� � ���,
  �� ���� �� ���������������. ';  

  try
  {
    // �������� ��������� ��������
    require_once("../utils/topcounter.php");
  
    // ����������� ���������� ip-������ �� ���� ������
    // ���������������� �� �������
    if(empty($_GET['page'])) $page = 1;
    else $page = $_GET['page'];
    // ��������� ������ ������
    $begin = ($page - 1)*$pnumber;

    $tmp = "";
    if(!empty($_GET['id_page']))
      $tmp = " AND id_page=$_GET[id_page]";
  
    $page_link = 3;
    // ���������� ����� ����������� � ����������� IP-��������
    // �� ��������� �����
    $query = "SELECT COUNT(distinct ip) FROM $tbl_ip 
              WHERE systems != 'none' AND
              systems != 'robot_yandex' AND 
              systems != 'robot_google' AND
              systems != 'robot_rambler' AND
              systems != 'robot_aport' AND
              systems != 'robot_msnbot' AND
              putdate LIKE CONCAT(DATE_FORMAT(NOW(),'%Y-%m-%d'), '%') $tmp";
    $total = query_result($query);
  
    // ������� ������ �� ������ ��������
    pager($page, 
          $total, 
          $pnumber, 
          $page_link, 
          "&id_page=$_GET[id_page]");
    echo "<br>";

    // ������� ���� ip-������
    ?>
      <br><br><table class="table" border="0" cellpadding="0" cellspacing="0">   
         <tr class="header" align="center">
           <td>�</td>
           <td>IP-�����</td>
           <td>����</td>
           <td>������</td>
           <td>�����</td>
           <td>����� ���������</td>
           <td>���������&nbsp;���������</td>
         </tr>
    <?
    // ��������� � ��������� SQL-������, ����������� 
    $query = "SELECT INET_NTOA(ip) AS ip,
                     max(putdate) AS putdate,
                     count(id_ip) AS hits FROM $tbl_ip
              WHERE
              systems != 'none' AND
              systems != 'robot_yandex' AND 
              systems != 'robot_google' AND
              systems != 'robot_rambler' AND
              systems != 'robot_aport' AND
              systems != 'robot_msnbot' AND
              putdate LIKE CONCAT(DATE_FORMAT(NOW(),'%Y-%m-%d'), '%') $tmp
              GROUP BY ip
              ORDER BY putdate DESC
              LIMIT $begin, $pnumber";
    $ips = mysql_query($query);
    if(!$ips)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ��������� 
                               � ������� IP-�������");
    }
    if(mysql_num_rows($ips) > 0)
    {
      $i=1;
      while($ip = mysql_fetch_array($ips))
      {
        $query = "SELECT city_name, region_name 
                  FROM $tbl_ip_compact, $tbl_cities, $tbl_regions
                  WHERE INET_ATON('$ip[ip]') BETWEEN init_ip AND end_ip AND 
                        $tbl_cities.city_id = $tbl_ip_compact.city_id AND
                        $tbl_cities.region_id = $tbl_regions.region_id";
        $reg = mysql_query($query);
        if(!$reg)
        {
          throw new ExceptionMySQL(mysql_error(), 
                                   $query,
                                  "������ ��� ����������� 
                                   �������������� IP-������");
        }
        $region = mysql_fetch_array($reg);
        echo "<tr>
              <td>$i</td>
              <td><a href='pages.php?nav=1&ip=$ip[ip]'>$ip[ip]</a></td>";
        if(HOST_BY_ADDR) echo "<td>".(@gethostbyaddr($ip['ip']))."</td>";
        else echo "<td align=center>-</td>";
        if ($region['city_name']) 
          echo "<td>$region[city_name]</td>"; 
        else echo "<td>��� ������</td>";
        if ($region['region_name']) 
          echo "<td>$region[region_name]</td>"; 
        else echo "<td>��� ������</td>";
        echo "<td>$ip[hits]</td><td>$ip[putdate]</td>";
        $i++;
      }
    }
    echo "</table>";
    // �������� ���������� ��������
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