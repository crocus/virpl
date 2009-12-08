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

  $title = '���������� ��������� ��������'; 
  $pageinfo = '�� ���� �������� �� ������ ������ ���������� 
  �� ���������� ��������� �������� �� ��������� ������� 
  �������. �� ��������� ��������� ������ 20 �������� 
  ��������������� ��������, ����� �������� ��� ��������� �� 
  ������ <a href=quers.php?limit=full>������ �����</a>';  

  try
  {
    // �������� ��������� ��������
    require_once("../utils/topcounter.php");
  
    if(empty($_GET['limit'])) $limit = "LIMIT 20";
    else $limit = "";

    // ��� ���������� ���������� �������������� �� ������ � ����������
    // �������� ��� �� ����� �����.
    $_GET['id_page'] = intval($_GET['id_page']);
    if(empty($_GET['id_page'])) $tmp = "";
    else $tmp = " AND id_page = $_GET[id_page]";

    // ��������� WHERE-������� ��� ���������� ���������
    $where = where_interval();

    // ������ ���������� ��������� ����
    $query = "SELECT query, COUNT(query) AS hits 
              FROM $tbl_searchquerys 
              $where $tmp
              GROUP BY query 
              ORDER BY hits DESC
              $limit";
    $sch = mysql_query($query);
    if(!$sch)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ��������� � 
                               �������� �� ��������� ������");
    }
    echo '<table class="table" width="60%" border="0" cellpadding="0" cellspacing="0">';
    echo '<tr class="header"><td>������</td><td>�-�� ���������</td></tr>';
    // ���� ������� ���� ���� ������ - ������� �������
    if (mysql_num_rows($sch)>0)
    {
      $sum=0;
      while ($search = mysql_fetch_array($sch))
      {
        if(trim($search['query']) == "") continue;
        echo "<tr>
           <td><p>".htmlspecialchars($search['query'])."</p></td>
           <td><p>".$search['hits']."</p></td></tr>";
        $sum += $search['hits'];
      }
    }
    echo "<tr>
            <td><b>����� ���������</b></td>
            <td><b>$sum</b></td>
          </tr></table>";

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
