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
    $query = "SELECT COUNT(*) FROM $tbl_arch_clients_month";
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
    $query = "SELECT DATE_FORMAT(putdate, '%Y.%m') as putdate, 
                     browsers_msie,
                     browsers_opera,
                     browsers_netscape,
                     browsers_firefox,
                     browsers_myie,
                     browsers_mozilla,
                     browsers_none,
                     systems_windows,
                     systems_unix,
                     systems_macintosh,
                     systems_none
              FROM $tbl_arch_clients_month
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
                <td align=center width=".(100/12)."%>����</td>
                <td align=center width=".(100/12)."%>IE</td>
                <td align=center width=".(100/12)."%>Opera</td>
                <td align=center width=".(100/12)."%>Netscape</td>
                <td align=center width=".(100/12)."%>Firefox</td>
                <td align=center width=".(100/12)."%>MyIE</td>
                <td align=center width=".(100/12)."%>Mozilla</td>
                <td align=center width=".(100/12)."%>�������.</td>
                <td align=center width=".(100/12)."%>Windows</td>
                <td align=center width=".(100/12)."%>UNIX</td>
                <td align=center width=".(100/12)."%>Macintosh</td>
                <td align=center width=".(100/12)."%>�������.</td>
              </tr>";
      while ($hits=mysql_fetch_array($arh))
      {
        echo "<tr>
                <td align=center>$hits[putdate]</td>
                <td align=center>$hits[browsers_msie]</td>
                <td align=center>$hits[browsers_opera]</td>
                <td align=center>$hits[browsers_netscape]</td>
                <td align=center>$hits[browsers_firefox]</td>
                <td align=center>$hits[browsers_myie]</td>
                <td align=center>$hits[browsers_mozilla]</td>
                <td align=center>$hits[browsers_none]</td>
                <td align=center>$hits[systems_windows]</td>
                <td align=center>$hits[systems_unix]</td>
                <td align=center>$hits[systems_macintosh]</td>
                <td align=center>$hits[systems_none]</td>
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