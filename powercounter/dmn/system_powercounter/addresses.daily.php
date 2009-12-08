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
  $title = '���������� �����'; 

  try
  {
    // �������� ��������� ��������
    require_once("../utils/topcounter.php");

    // $min_date - ��� ����� ������ ����, �� �������
    // ����� �������� �������� ����������, �� ����� ������
    // ������ ��� �������� �����������
    $query = "SELECT UNIX_TIMESTAMP(MIN(putdate)) as putdate 
              FROM $tbl_arch_ip";
    $min_date = query_result($query);
    if(empty($min_date)) $min_date = time();
  
    // ������� ��������� �� ������� �����
    calendar(time(), $min_date);
    echo "<br><br>";
    // ������� ��������� �� ��������� �����
    calendar(time() - 3600*24*date('j'), $min_date);
    echo "<br><br>";
  
    // ���� �������� $_GET['date'] �� ����, ����������� IP-������
    // �� ���� ����
    if(!empty($_GET['date']))
    {
      $_GET['date'] = intval($_GET['date']);
      $query = "SELECT INET_NTOA(ip) AS ip, total 
                FROM $tbl_arch_ip 
                WHERE putdate LIKE '".date("Y-m-d",$_GET['date'])."%'";
      $ipt = mysql_query($query);
      if(!$ipt)
      {
         throw new ExceptionMySQL(mysql_error(), 
                                  $query,
                                 "������ ���������� �������� ����������");
      }
      if(mysql_num_rows($ipt))
      {
        echo "<table class=table width=100% border=0 cellpadding=0 cellspacing=0>
                <tr class=header align=center>
                  <td>IP-�����</td>
                  <td>����</td>
                  <td>���������� ���������</td>
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
  // ������ ��������� ���������, � �������� ��������� ��������� �����
  // � ���� ����� ������, ��������� � �������� 1 ������ 1970 ����. �������
  // ��������� ��� ������ ����
  function calendar($date, $min_date)
  {
    $eng = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
    $rus = array("��","��","��","��","��","��","��");
  
    // ��������� ����� ���� � ������� ������
    $dayofmonth = date('t',$date);
    // ������� ��� ���� ������
    $day_count = 1;
  
    // ������ ������
    $num = 0;
    for($i = 0; $i < 7; $i++)
    {
      // ��������� ����� ��� ������ ��� �����
      $dayofweek = date('w',mktime(0, 0, 0, date('m',$date), $day_count, date('Y',$date)));
      // �������� � ����� � ������� 1 - �����������, ..., 6 - �������
      $dayofweek = $dayofweek - 1;
      if($dayofweek == -1) $dayofweek = 6;
  
      if($dayofweek == $i)
      {
        // ���� ��� ������ ���������,
        // ��������� ������ $week
        // ������� ������
        $week[$num][$i] = $day_count;
        $day_count++;
      }
      else
      {
        $week[$num][$i] = "";
      }
    }
  
    // ����������� ������ ������
    while(true)
    {
      $num++;
      for($i = 0; $i < 7; $i++)
      {
        $week[$num][$i] = $day_count;
        $day_count++;
        // ���� �������� ����� ������ - �������
        // �� �����
        if($day_count > $dayofmonth) break;
      }
      // ���� �������� ����� ������ - �������
      // �� �����
      if($day_count > $dayofmonth) break;
    }
  
    // ������� ���������� ������� $week
    // � ���� ���������
    // ������� �������
    echo "<table class=table width=100% border=0 cellpadding=0 cellspacing=0>
            <tr class=header align=center><td align=center colspan=".(count($week) + 1).">�������� ��������������� IP-������ �� ".date("Y.m", $date)."</td></tr>";
    for($j = 0; $j < 7; $j++)
    {
      if($j == 5 || $j == 6)
      {
        echo "<tr class=red>";
      }
      else
      {
        echo "<tr>";
      }
      echo "<td width=".(100/(count($week) + 1))."%>".$rus[$j]."</td>";
      for($i = 0; $i < count($week); $i++)
      {
        if(!empty($week[$i][$j]))
        {
          $dayofweek = mktime(0, 0, 0, date('m',$date), $week[$i][$j], date('Y',$date));
          if($dayofweek > $min_date && $dayofweek < time() - 3600*24)
          {
            echo "<td width=".(100/(count($week) + 1))."% align=center>
                    <a href=$_SERVER[PHP_SELF]?date=$dayofweek>".$week[$i][$j]."</a>
                  </td>";
          }
          else
          {
            echo "<td width=".(100/(count($week) + 1))."%  align=center>".$week[$i][$j]."</td>";
          }
        }
        else echo "<td>&nbsp;</td>";
      }
      echo "</tr>";
    } 
    echo "</table>";
  }
?>