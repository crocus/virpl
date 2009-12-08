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

  // ��������� ��������
  $title = '��������'; 
  $pageinfo = '�� ���� �������� �� ������ ������ ���������� 
  �� ���������� ���������, �.�. ��������� �� ��� ���� � 
  ������ ������.';  
  try
  {
    // �������� ��������� ��������
    require_once("../utils/topcounter.php");

    // ������� ������������ ���������
    if(empty($_GET['page'])) $page = 1;
    else $page = intval($_GET['page']);

    // ������� ������� � ����������
    refferer(1, 0, $page, $pnumber);
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
  function refferer($begin, $end, $page, $pnumber)
  {
    // ��������� ����� ������ �����������
    global $tbl_refferer, $tbl_pages;
    // ��������� WHERE-������� ��� ���������� ���������
    $where = where_interval($begin, $end);

    $page_link = 3;
    $start = ($page - 1)*$pnumber;
    // ����� ���������� �������
    $query = "SELECT COUNT(DISTINCT name) 
              FROM $tbl_refferer $where";
    $total = query_result($query);
    
    // ������� ������ �� ������ ��������
    pager($page, 
          $total, 
          $pnumber, 
          $page_link, 
          "");
    echo "<br><br>";
  
    // ��������� ������� ��� ������� ��������
    $query = "SELECT name, 
                     COUNT(name) AS hits,
                     id_page
              FROM $tbl_refferer
              $where 
              GROUP BY name
              ORDER BY hits DESC
              LIMIT $start, $pnumber";
    $ref = mysql_query($query);
    $i = $start + 1;
    if(!$ref)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ���������� �������");
    }
    if(mysql_num_rows($ref))
    {
      echo "<table class=table width=100% border=0 cellpadding=0 cellspacing=0>
              <tr class=header align=center>
                <td widht=50 align=center>�����</td>
                <td>�������</td>
                <td>����� ���������</td>
                <td>��������</td>
              </tr>";
      while($refferer = mysql_fetch_array($ref))
      {
        if(empty($refferer['name'])) continue;
        // ��������� �������� ��������
        $query = "SELECT * FROM $tbl_pages
                  WHERE id_page = $refferer[id_page]";
        $pag = mysql_query($query);
        if(!$pag)
        {
          throw new ExceptionMySQL(mysql_error(), 
                                   $query,
                                  "������ ��� ���������� �������");
        }
        if(mysql_num_rows($pag))
        {
          $page = mysql_fetch_array($pag);
          if(empty($page['title']))
          {
            $title = "http://{$_SERVER[SERVER_NAME]}{$page[name]}";
          }
          else $title = $page['title'];
        }
        echo "<tr>
              <td>$i</td>
              <td>".htmlspecialchars($refferer['name'])."</td>
              <td align=center>$refferer[hits]</td>
              <td><a href=http://{$_SERVER[SERVER_NAME]}{$page[name]}>$title</a></td>
              </tr>";
        $i++;
      }
      echo "</table>";
    } 
  }
?>