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

    // ������������ ���������
    if(empty($_GET['page'])) $page = 1;
    else $page = $_GET['page'];

    // ��������� ���������� �������
    $query = "SELECT COUNT(DISTINCT putdate) 
              FROM $tbl_arch_time_month";
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
    $query = "SELECT UNIX_TIMESTAMP(putdate) as putdate
              FROM $tbl_arch_time_month
              GROUP BY putdate
              ORDER BY putdate DESC
              LIMIT $first, $pnumber";
    $arh = mysql_query($query);
    if(!$arh)
    {
       throw new ExceptionMySQL(mysql_error(), 
                                $query,
                               "������ ���������� �������� ����������");
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
        $date_table = date("Y.m",$hits['putdate']);
        // ������ ���������� �������� ���� ������ �� �������
        echo "<tr>
                <td align=center>$date_table</td>
                <td align=center><a href=$_SERVER[PHP_SELF]?date=$hits[putdate]>��������</a></td>
              </tr>";
      }
      echo "</table><br><br>";
    }
  
    // ���� �������� $_GET['date'] �� ����, ����������� IP-������
    // �� ���� ����
    if(!empty($_GET['date']))
    {
      $_GET['date'] = intval($_GET['date']);
      $query = "SELECT * FROM $tbl_arch_time_month 
                WHERE putdate LIKE '".date("Y-m",$_GET['date'])."%'";
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
                  <td width=150>�����</td>
                  <td width=150>����� ���������</td>
                  <td>�����������</td>
                </tr>";
        $arch_time = mysql_fetch_array($ipt);
        unset($arch_time['id_time'], $arch_time['putdate']);
        $total = array_sum($arch_time);
        echo "<tr>
                <td>1 ������</td>
                <td>".$arch_time['visit1']."</td>
                <td><img src=images/parm.gif border=0 width=".(100*$arch_time['visit1']/$total)."% height=6></td>
              </tr>\r\n";
        echo "<tr>
                <td>2 ������</td>
                <td>".$arch_time['visit2']."</td>
                <td><img src=images/parm.gif border=0 width=".(100*$arch_time['visit2']/$total)."% height=6></td>
              </tr>\r\n";
        echo "<tr>
                <td>3 ������</td>
                <td>".$arch_time['visit3']."</td>
                <td><img src=images/parm.gif border=0 width=".(100*$arch_time['visit3']/$total)."% height=6></td>
              </tr>\r\n";
        echo "<tr>
                <td>4 ������</td>
                <td>".$arch_time['visit4']."</td>
                <td><img src=images/parm.gif border=0 width=".(100*$arch_time['visit4']/$total)."% height=6></td>
              </tr>\r\n";
        for($i = 5; $i < 11; $i++)
        {
          echo "<tr>
                  <td>$i �����</td>
                  <td>".$arch_time['visit'.$i]."</td>
                  <td><img src=images/parm.gif border=0 width=".(100*$arch_time['visit'.$i]/$total)."% height=6></td>
                </tr>\r\n";
        }
        for($i = 10; $i < 60; $i = $i + 10)
        {
          echo "<tr>
                  <td>�� ".$i." �� ".($i+10)." �����</td>
                  <td>".$arch_time['visit'.($i+10)]."</td>
                  <td><img src=images/parm.gif border=0 width=".(100*$arch_time['visit'.($i+10)]/$total)."% height=6></td>
                </tr>\r\n";
        }
        for($i = 1; $i < 24; $i++)
        {
          echo "<tr>
                  <td>�� ".$i." �� ".($i+1)." �����</td>
                  <td>".$arch_time['visit'.($i+1).'h']."</td>
                  <td><img src=images/parm.gif border=0 width=".(100*$arch_time['visit'.($i+1).'h']/$total)."% height=6></td>
                </tr>\r\n";
        }
      }
      echo "</table>";
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