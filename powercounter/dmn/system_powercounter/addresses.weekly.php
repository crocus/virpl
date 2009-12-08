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

  // ������ ���������� ���������� �������� �������� � ���������.
  $title = '����������� �����'; 
  try
  {
    // �������� ��������� ��������
    require_once("../utils/topcounter.php");

    // ������������ ���������
    if(empty($_GET['page'])) $page = 1;
    else $page = $_GET['page'];

    // ��������� ���������� �������
    $query = "SELECT COUNT(DISTINCT putdate_begin) 
              FROM $tbl_arch_ip_week";
    $total = query_result($query);

    $page_link = 3;
    $first = ($page - 1)*$pnumber;
  
    // ������� ������ �� ������ ��������
    pager($page, 
          $total, 
          $pnumber, 
          $page_link,
          "");
    echo "<br><br>";

    // ��������� ������ ��� ������� ��������
    $query = "SELECT UNIX_TIMESTAMP(putdate_begin) as putdate_begin,
                     UNIX_TIMESTAMP(putdate_end) as putdate_end
              FROM $tbl_arch_ip_week
              GROUP BY putdate_begin
              ORDER BY putdate_begin DESC";
    $arh = mysql_query($query);
    if(!$arh)
    {
       throw new ExceptionMySQL(mysql_error(), 
                                $query,
                               "������ ���������� ��������� ����������");
    }
    if(mysql_num_rows($arh))
    {
      echo "<table class=table width=100% border=0 cellpadding=0 cellspacing=0>
              <tr class=header align=center>
                <td align=center width=50%>����</td>
                <td align=center width=50%>������</td>
              </tr>";
      while ($hits=mysql_fetch_array($arh))
      {
        // ��������� ����
        $date_table = date("d.m",$hits['putdate_begin'])." - ".date("d.m",$hits['putdate_end']);
        echo "<tr>
                <td align=center>$date_table</td>
                <td align=center><a href=$_SERVER[PHP_SELF]?date=$hits[putdate_begin]>��������</a></td>
              </tr>";
      }
      echo "</table><br><br>";
    }
  
    // ���� �������� $_GET['date'] �� ����, ����������� IP-������
    // �� ������
    if(!empty($_GET['date']))
    {
      $_GET['date'] = intval($_GET['date']);
      $query = "SELECT INET_NTOA(ip) AS ip, total 
                FROM $tbl_arch_ip_week 
                WHERE putdate_begin LIKE '".date("Y-m-d",$_GET['date'])."%'";
      $ipt = mysql_query($query);
      if(!$ipt)
      {
         throw new ExceptionMySQL(mysql_error(), 
                                  $query,
                                 "������ ���������� ��������� ����������");
      }
      if(mysql_num_rows($ipt))
      {
        echo "<table class=table width=100% border=0 cellpadding=0 cellspacing=0>
                <tr class=header align=center>
                  <td>IP-�����</td>
                  <td>����</td>
                  <td>����� ���������</td>
                </tr>";
        while($ip = mysql_fetch_array($ipt))
        {
          echo "<tr><td>$ip[ip]</td>";
          if(HOST_BY_ADDR) echo "<td align=center>".(@gethostbyaddr($ip['ip']))."</td>";
          else echo "<td align=center>-</td>";
          echo "<td align=center>$ip[total]</td></tr>";
        }
        echo "</table>";
      }
    }

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
