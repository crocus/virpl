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

  $title = '���������&nbsp;�������';  
  $pageinfo = '�� ���� �������� �� ������ ������ �� ����� 
  �������� � ��������� ������ �������� ���������� �� ��� ����';

  try
  {
    // �������� ��������� ��������
    require_once("../utils/topcounter.php");
  
    // �������� ������ ��������� ����������
    require_once("time_interval.php");

    // ��������� ������ � ���������� ��������� ������
    $sch['rambler'] = "Rambler";
    $sch['google'] = "Google";
    $sch['yandex'] = "Yandex";
    $sch['aport'] = "Aport";
    $sch['msn'] = "MSN";
    $sch['mail'] = "Mail.ru";
    $sch['total'] = "���";

    for($i = 0; $i < 5; $i++)
    {
      list($hit['rambler'][$i],
           $hit['yandex'][$i], 
           $hit['aport'][$i],
           $hit['google'][$i],
           $hit['msn'][$i],
           $hit['mail'][$i],
           $hit['total'][$i]) = search($time[$i]['begin'], 
                                       $time[$i]['end'], 
                                       $id_page);
    }
    ?>
    <table width=100% class="table" border="0" cellpadding="0" cellspacing="0" >    
    <tr class="header" align="center">
      <td>���������&nbsp;�������</td>
      <td width=<?= 100/5 ?>% >�������</td>
      <td width=<?= 100/5 ?>% >�����</td>
      <td width=<?= 100/5 ?>% >�� 7 ����</td>
      <td width=<?= 100/5 ?>% >�� 30 ����</td>
      <td width=<?= 100/5 ?>% >�� �� �����</td>
    </tr>
    <?php
    // ��������� ������� � ������ ��������� � ������������ ������
    foreach($sch as $key => $name)
    {
      echo "<tr align=right>";
      echo "<td class=field>$name</td>";
      for($i = 0; $i < 4; $i++)
      {
        echo "<td><a href=searchquery.php?".
             "begin={$time[$i][begin]}&".
             "end={$time[$i][end]}&".
             "srch=$key&".
             "id_page=$id_page>{$hit[$key][$i]}</a></td>";
      }
      echo "<td>".$hit[$key][4]."</td>";
      echo "</tr>";
    }
    echo "</table><br>";
  
    if(empty($_GET['begin']) ||
       !isset($_GET['end']) ||
       empty($_GET['srch']))
    {
      $_GET['begin'] = 1;
      $_GET['end']   = 0;
      $_GET['srch']  = "total";
    }
  
    // ������� ������������ ���������
    if(empty($_GET['page'])) $page = 1;
    else $page = intval($_GET['page']);
  
    searchquery($_GET['begin'], $_GET['end'], $_GET['srch'], $page, $pnumber);

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

  function searchquery($begin, $end, $srch, $page, $pnumber)
  {
    // ��������� ����� ������ �����������
    global $tbl_searchquerys, $tbl_pages;
    // ��������� WHERE-������� ��� ���������� ���������
    $where = where_interval($begin, $end);

    // ������������ ���������
    $page_link = 3;
    $start = ($page - 1)*$pnumber;
    // ����� ���������� �������
    if($srch != "total")
    {
      // �������� ����� ��� ���������� ��������� �������
      $query = "SELECT COUNT(*)
                FROM $tbl_searchquerys, $tbl_pages 
                $where AND $tbl_searchquerys.id_page = $tbl_pages.id_page AND 
                $tbl_searchquerys.searches = '$srch'";
    }
    else
    {
      // ��� ��������� �������
      $query = "SELECT COUNT(*)
                FROM $tbl_searchquerys, $tbl_pages
                $where AND $tbl_searchquerys.id_page = $tbl_pages.id_page";
    }  
    $total = query_result($query);
    
    // ������� ������ �� ������ ��������
    pager($page, 
          $total, 
          $pnumber, 
          $page_link, 
          "&begin=$begin&end=$end&srch=$srch&order=$order");
    echo "<br>";
  
    // ��������� ������ ��� ������� ��������
    if($srch != "total")
    {
      // �������� ����� ��� ���������� ��������� �������
      $query = "SELECT $tbl_pages.title AS title,
                       $tbl_pages.name AS url,
                       $tbl_searchquerys.query AS name,
                        putdate,
                        INET_NTOA(ip) AS ip,
                        searches
                FROM $tbl_searchquerys, $tbl_pages 
                $where AND $tbl_searchquerys.id_page = $tbl_pages.id_page AND 
                $tbl_searchquerys.searches = '$srch' 
                ORDER BY putdate DESC
                LIMIT $start, $pnumber";
    }
    else
    {
      // ��� ��������� �������
      $query = "SELECT $tbl_pages.title AS title, 
                       $tbl_pages.name AS url,
                       $tbl_searchquerys.query AS name,
                       putdate,
                       INET_NTOA(ip) AS ip,
                       searches
                FROM $tbl_searchquerys, $tbl_pages
                $where AND $tbl_searchquerys.id_page = $tbl_pages.id_page
                ORDER BY putdate DESC
                LIMIT $start, $pnumber";
    }		 
    $qwr = mysql_query($query);
    $i = $start + 1;
    if(!$qwr)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ���������� �������");
    }
    if(mysql_num_rows($qwr))
    {
      echo "<br><table width=100% class=\"table\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
      while($ip = mysql_fetch_array($qwr))
      {
        if(empty($ip['name'])) continue;
        echo "<tr>
              <td>$i</td>
              <td>".htmlspecialchars($ip['name'])."</td>
              <td>$ip[searches]</td>
              <td>$ip[putdate]</td>
              <td><a href=pages.php?ip=$ip[ip]&begin=$begin&end=$end>$ip[ip]</a></td>
              <td><a href=http://{$_SERVER[SERVER_NAME]}{$ip[url]}>
                  $ip[title]</a></td></tr>";
        $i++;
      }
      echo "</table>";
    } 
  }
  function search($begin, $end, $id_page)
  {
    // ��������� ����� ������ �����������
    global $tbl_arch_num_searchquery, $tbl_arch_num_searchquery_month, $tbl_searchquerys;
    // ��� ���������� ���������� �������������� �� ������ � ����������
    // �������� ��� �� ����� �����.
    if($id_page == "") $tmp = "";
    else $tmp = " AND id_page = $id_page";
    // �������� ���� � �����
    $hits = array();

    /////////////////////////////////////////////////////////////////////////////
    // ������� �� ������� ������������
    //            begin end
    // �������      1    0  - ��� ��������� �� $tbl_searchquerys
    // �����        2    1  - ��� ��������� �� $tbl_arch_num_searchquery
    // ������       7    0  - ��� ��������� �� $tbl_arch_num_searchquery
    // �����       30    0  - ��� ��������� �� $tbl_arch_num_searchquery
    // �� �����    0    0  - ��� ��������� �� $tbl_arch_num_searchquery_month
    /////////////////////////////////////////////////////////////////////////////

    // �������
    if($begin == 1 && $end == 0)
    {
      // ��������� WHERE-������� ��� ���������� ���������
      $where = where_interval($begin, $end);
      // ��������� SQL-�������
      $begin = "SELECT COUNT(*) FROM $tbl_searchquerys $where $tmp AND searches =";
      $query['ynd'] = "$begin 'yandex'";
      $query['ram'] = "$begin 'rambler'";
      $query['gog'] = "$begin 'google'";
      $query['apt'] = "$begin 'aport'";
      $query['msn'] = "$begin 'msn'";
      $query['mil'] = "$begin 'mail'";
  
      // ��������� SQL-�������
      foreach($query as $search => $value)
      {
        $hits[$search] = query_result($value);
      }	
      $total = array_sum($hits);
      return array($hits['ram'], $hits['ynd'], 
                   $hits['apt'], $hits['gog'], 
                   $hits['msn'], $hits['mil'], $total);
    }

    // ��������� WHERE-������� ��� ���������� ���������
    $where = where_interval($begin, $end);

    // �� �����
    if($begin == 0 && $end == 0)
    {
      // ��������� SQL-�������
      $end = "FROM $tbl_arch_num_searchquery $where";
      $query['ynd'] = "SELECT SUM(number_yandex)  $end";
      $query['ram'] = "SELECT SUM(number_rambler) $end";
      $query['gog'] = "SELECT SUM(number_google)  $end";
      $query['apt'] = "SELECT SUM(number_aport)   $end";
      $query['msn'] = "SELECT SUM(number_msn)     $end";
      $query['mil'] = "SELECT SUM(number_mail)    $end";
      // ��������� SQL-�������
      foreach($query as $search => $value)
      {
        $hits[$search] += query_result($value);
      }
  
      // ��������� SQL-�������
      $query = "SELECT UNIX_TIMESTAMP(MIN(putdate)) AS data FROM $tbl_arch_num_searchquery";
      $last_day = query_result($query);
      if($last_day)
      {
        $end = "FROM $tbl_arch_num_searchquery_month WHERE putdate < '".date("Y-m-01", $last_date)."'";
        unset($query);
        $query['ynd'] = "SELECT SUM(number_yandex)  $end";
        $query['ram'] = "SELECT SUM(number_rambler) $end";
        $query['gog'] = "SELECT SUM(number_google)  $end";
        $query['apt'] = "SELECT SUM(number_aport)   $end";
        $query['msn'] = "SELECT SUM(number_msn)     $end";
        $query['mil'] = "SELECT SUM(number_mail)    $end";
        // ��������� SQL-�������
        foreach($query as $search => $value)
        {
          $hits[$search] += query_result($value);
        }
      }
    }
    // ����� ������
    else
    {
      // ��������� SQL-�������
      $end = "FROM $tbl_arch_num_searchquery $where";
      $query['ynd'] = "SELECT SUM(number_yandex)  $end";
      $query['ram'] = "SELECT SUM(number_rambler) $end";
      $query['gog'] = "SELECT SUM(number_google)  $end";
      $query['apt'] = "SELECT SUM(number_aport)   $end";
      $query['msn'] = "SELECT SUM(number_msn)     $end";
      $query['mil'] = "SELECT SUM(number_mail)    $end";
  
      // ��������� SQL-�������
      foreach($query as $search => $value)
      {
        $hits[$search] += query_result($value);
      }
    }

    $total = array_sum($hits);
    // �� ��������� ������� �� 0 ��������� �������� ������ $total
    if($total == 0) $total = 1;
    return array($hits['ram'], $hits['ynd'], 
                 $hits['apt'], $hits['gog'], 
                 $hits['msn'], $hits['mil'], $total);
  }
?>