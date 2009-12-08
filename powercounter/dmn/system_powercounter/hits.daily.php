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
    $query = "SELECT COUNT(*) FROM $tbl_arch_hits";
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
    $query = "SELECT UNIX_TIMESTAMP(putdate) as putdate, 
                     hosts_total, 
                     host, 
                     hits_total, 
                     hits 
              FROM $tbl_arch_hits 
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
              <td align=center width=20%>����</td>
              <td align=center width=20%>����������� �����</td>
              <td align=center width=20%>�����</td>
              <td align=center width=20%>����������� ����</td>
              <td align=center width=20%>����</td>
            </tr>";
      $eng = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
      $rus = array("��","��","��","��","��","��","��");
      while ($hits=mysql_fetch_array($arh))
      {
        // ��������� ����
        if(date("w",$hits['putdate']) == 0 || date("w",$hits['putdate']) == 6)
        {
          // ������� � �����������
          $date_table = "<div style='color:red'>".date("d.m D",$hits['putdate'])."</div>";
        }
        else
        {
          // �����
          $date_table = date("d.m D",$hits['putdate']);
        }
        // ������ ���������� �������� ���� ������ �� �������
        $date_table = str_replace($eng,$rus,$date_table);
        echo "<tr>
                <td align=center>$date_table</td>
                <td align=center>$hits[host]</td>
                <td align=center>$hits[hosts_total]</td>
                <td align=center>$hits[hits]</td>
                <td align=center>$hits[hits_total]</td>
              </tr>";
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