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

  $title = '���������&nbsp;������';   
  $pageinfo = '�� ���� �������� �� ������ ������ ���������� 
  �� ��������� ����� �������� ��������� ������. ��� ���������� 
  ������ ��������, ����������� ������� �� ���, ��������� 
  ������� �������� ���������� ����� ���������� ���������. ';

  try
  {
    // �������� ��������� ��������
    require_once("../utils/topcounter.php");
  
    // �������� ������ ��������� ����������
    require_once("time_interval.php");
  
    // ��������� ������ � ���������� ��������� �������
    $rob['search']['ram'] = "robot_rambler";
    $rob['search']['gog'] = "robot_google";
    $rob['search']['ynd'] = "robot_yandex";
    $rob['search']['apt'] = "robot_aport";
    $rob['search']['msn'] = "robot_msnbot";
    $rob['search']['oth'] = "none";
    $rob['search']['tot'] = "total";
    $rob['name']['ram'] = "Rambler";
    $rob['name']['gog'] = "Google";
    $rob['name']['ynd'] = "Yandex";
    $rob['name']['apt'] = "Aport";
    $rob['name']['msn'] = "MSN";
    $rob['name']['oth'] = "������";
    $rob['name']['tot'] = "�����";

    // ������ �� SQL-��������
    $id_page = intval($_GET['id_page']);

    // ����������� ������ �� ���� ��������� ����������
    // ����������� � ����� time_interval.php   
    for($i = 0; $i < 5; $i++)
    {
      list($hit['ram'][$i],
           $hit['gog'][$i], 
           $hit['ynd'][$i], 
           $hit['apt'][$i], 
           $hit['msn'][$i], 
           $hit['oth'][$i], 
           $hit['tot'][$i]) = robots($time[$i]['begin'], 
                                     $time[$i]['end'],
                                     $id_page);
    }                                              
    ?>
    <table width=100% class="table" border="0" cellpadding="0" cellspacing="0">   
    <tr class="header" align="center">
      <td>�������� ������</td>
      <td>�������</td>
      <td>�����</td>
      <td>�� 7 ����</td>
      <td>�� 30 ����</td>
      <td>�� �� �����</td>
    </tr>
    <?php
    // ��������� �������
    foreach($rob['search'] as $key => $name)
    {
      echo "<tr align=right>";
      echo "<td class=field >{$rob[name][$key]}</td>";
      for($i = 0; $i<5; $i++)
      {
        $number = sprintf("%d (%01.1f%s)",
                        $hit[$key][$i],
                        $hit[$key][$i]/$hit['tot'][$i]*100,
                        '%');
        if($i != 4)
        {
          echo "<td><a href=pages.php?begin=".$time[$i]['begin']."&end=".$time[$i]['end']."&ip=$name>$number</a></td>"; 
        }
        else echo "<td>".sprintf("%d (%01.1f%s)",$hit["$key"][4],$hit["$key"][4]/$hit['tot'][4]*100,'%')."</td>";
      }
      echo "</tr>";
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

  // ������� ���������� ������ �� ����� ����������:
  // ����� ������� Rambler
  // ����� ������� Google
  // ����� ������� Yandex
  // ����� ������� Aport
  // ������ ������
  // ����� ����� ���������
  // $begin - ����� ����, ������� ���������� ������� �� ������� ����,
  // ��� ���� ����� �������� ��������� ����� ���������� ���������
  // $end - ����� ����, ������� ���������� ������� �� ������� ����,
  // ��� ���� ����� �������� �������� ����� ���������� ���������
  // $id_page - ��������� ���� ������ ������� pages, ��������������� �������� �����
  function robots($begin = 1, $end = 0, $id_page = "")
  {
    // ��������� ����� ������ �����������
    global $tbl_arch_robots, $tbl_arch_robots_month, $tbl_ip;
    // �������� ���� � �����
    $hits = array();
  
    /////////////////////////////////////////////////////////////////
    // ������� �� ������� ������������
    //            begin end
    // �������      1    0  - ��� ��������� �� $tbl_ip
    // �����        2    1  - ��� ��������� �� $tbl_arch_robots
    // ������       7    0  - ��� ��������� �� $tbl_arch_robots
    // �����       30    0  - ��� ��������� �� $tbl_arch_robots
    // �� �����    0    0  - ��� ��������� �� $tbl_arch_robots_month
    /////////////////////////////////////////////////////////////////
  
    // ��� ���������� ���������� �������������� �� ������ � ����������
    // �������� ��� �� ����� �����.
    if($id_page == "") $tmp = "";
    else $tmp = " AND id_page=$id_page";

	// �������
    if($begin == 1 && $end == 0)
    {
      // ��������� WHERE-������� ��� ���������� ���������
      $where = where_interval($begin, $end);

      // ��������� SQL-�������
      $begin = "SELECT COUNT(*) FROM $tbl_ip $where $tmp AND systems = ";
      $query['ynd'] = "$begin 'robot_yandex'";
      $query['ram'] = "$begin 'robot_rambler'";
      $query['gog'] = "$begin 'robot_google'";
      $query['apt'] = "$begin 'robot_aport'";
      $query['msn'] = "$begin 'robot_msnbot'";
      $query['oth'] = "$begin 'none'";
  
      // ��������� SQL-�������
      foreach($query as $robot => $value)
      {
        $hits[$robot] = query_result($value);
      }
      $total = array_sum($hits);
      // �� ��������� ������� �� 0 ��������� 
      // �������� ������ ����� ����� $total
      if($total == 0) $total = 1;
      return array($hits['ram'], $hits['gog'], $hits['ynd'], 
                   $hits['apt'], $hits['msn'], $hits['oth'], $total);
    }

    // ��������� WHERE-������� ��� ���������� ���������
    $where = where_interval($begin, $end);

    // �� �����
    if($begin == 0 && $end == 0)
    {
      // ��������� SQL-�������
      $end = " FROM $tbl_arch_robots $where $tmp";
      $query['ynd'] = "SELECT SUM(yandex)  $end";
      $query['ram'] = "SELECT SUM(rambler) $end";
      $query['gog'] = "SELECT SUM(google)  $end";
      $query['apt'] = "SELECT SUM(aport)   $end";
      $query['msn'] = "SELECT SUM(msn)     $end";
      $query['oth'] = "SELECT SUM(none)    $end";
  
      // ��������� SQL-�������
      foreach($query as $robot => $value)
      {
        $hits[$robot] = query_result($value);
      }
  
      // �������� ����� ������ ����� �� ������� $tbl_arch_robots,
      // ��, ��� ����� ���� �� ������� $tbl_arch_robots_month
      $query = "SELECT UNIX_TIMESTAMP(MIN(putdate)) AS data FROM $tbl_arch_robots";
      $last_day = query_result($query);
      if($last_day)
      {
        // ��������� WHERE-�������
        $where = "WHERE putdate < '".date("Y-m-01", $last_date)."'";
        // ��������� SQL-�������
        unset($query);
        $end = " FROM $tbl_arch_robots_month $where $tmp";
        $query['ynd'] = "SELECT SUM(yandex)  $end";
        $query['ram'] = "SELECT SUM(rambler) $end";
        $query['gog'] = "SELECT SUM(google)  $end";
        $query['apt'] = "SELECT SUM(aport)   $end";
        $query['msn'] = "SELECT SUM(msn)     $end";
        $query['oth'] = "SELECT SUM(none)    $end";

        // ��������� SQL-�������
        foreach($query as $robot => $value)
        {
          $hits[$robot] += query_result($value);
        }
      }
    }
    // ����� ������
    else
    {
      // ��������� SQL-�������
      $end = " FROM $tbl_arch_robots $where $tmp";
      $query['ynd'] = "SELECT SUM(yandex)  $end";
      $query['ram'] = "SELECT SUM(rambler) $end";
      $query['gog'] = "SELECT SUM(google)  $end";
      $query['apt'] = "SELECT SUM(aport)   $end";
      $query['msn'] = "SELECT SUM(msn)     $end";
      $query['oth'] = "SELECT SUM(none)    $end";
  
      // ��������� SQL-�������
      foreach($query as $robot => $value)
      {
        $hits[$robot] += query_result($value);
      }
    }
    $total = array_sum($hits);
    // �� ��������� ������� �� 0 ��������� 
    // �������� ������ ����� ����� $total
    if($total == 0) $total = 1;   
    return array($hits['ram'], $hits['gog'], 
                 $hits['ynd'], $hits['apt'], 
                 $hits['msn'], $hits['oth'], $total);
  }
?>
