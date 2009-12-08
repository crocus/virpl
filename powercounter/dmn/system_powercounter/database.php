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

  $title = '����������&nbsp;�����&nbsp;������';
  $pageinfo = '�� ���� �������� �� ������ ��������� ������� ���� ������. ������� �� ���� ����� ������� ����������, ��� ��� ����-������ (��������� ������) ����� �������� ����������� ����� �� ������ �����.';
  try
  {
    // �������� ��������� ��������
    require_once("../utils/topcounter.php");
  
    $array[] = array("name" => $tbl_ip,
                     "description" => "���������� ���� ��������� ",
                     "value" => get_value_table($tbl_ip));
    $array[] = array("name" => $tbl_pages,
                     "description" => "��������, ����������� � ����������",
                     "value" => get_value_table($tbl_pages));
    $array[] = array("name" => $tbl_thits,
                     "description" => "��������� �������, ��� ���������� ��������",
                     "value" => get_value_table($tbl_thits));
    $array[] = array("name" => $tbl_refferer,
                     "description" => "�������� - ������ ������� ��������� ������, � ������� ��� ���������� ������� �� ��� ����",
                     "value" => get_value_table($tbl_refferer));
    $array[] = array("name" => $tbl_searchquerys,
                     "description" => "�������� �����, �� ������� ��� ���� ��� ��������� � ��������� ��������",
                     "value" => get_value_table($tbl_searchquerys));
    $array[] = array("name" => $tbl_cities,
                     "description" => "������ (��� ����������� �������������� �� IP-������)",
                     "value" => get_value_table($tbl_city));
    $array[] = array("name" => $tbl_ip_compact,
                     "description" => "������������ IP-������� ������� (��� ����������� �������������� �� IP-������)",
                     "value" => get_value_table($tbl_ip_compact));
    $array[] = array("name" => $tbl_regions,
                     "description" => "������ (��� ����������� �������������� �� IP-������)",
                     "value" => get_value_table($tbl_regions));
    $array[] = array("name" => $tbl_arch_hits,
                     "description" => "�������� �������� ������� ��� ����� � ������",
                     "value" => get_value_table($tbl_arch_hits));
    $array[] = array("name" => $tbl_arch_ip,
                     "description" => "�������� �������� ������� ��� IP-�������",
                     "value" => get_value_table($tbl_arch_ip));
    $array[] = array("name" => $tbl_arch_clients,
                     "description" => "�������� �������� ������� ��� ��������� � ������������ ������",
                     "value" => get_value_table($tbl_arch_clients));
    $array[] = array("name" => $tbl_arch_robots,
                     "description" => "�������� �������� ������� ��� ������� ��������� ������",
                     "value" => get_value_table($tbl_arch_robots));
    $array[] = array("name" => $tbl_arch_refferer,
                     "description" => "�������� �������� ������� ��� ��������� - ������� ������� ��������� ������, � ������� ��� ���������� ������� �� ��� ����",
                     "value" => get_value_table($tbl_arch_refferer));
    $array[] = array("name" => $tbl_arch_searchquery,
                     "description" => "�������� �������� ������� ��� ��������� ��������",
                     "value" => get_value_table($tbl_arch_searchquery));
    $array[] = array("name" => $tbl_arch_num_searchquery,
                     "description" => "�������� �������� ������� ��� ���������� ��������� ��������",
                     "value" => get_value_table($tbl_arch_num_searchquery));
    $array[] = array("name" => $tbl_arch_enterpoint,
                     "description" => "�������� �������� ������� ��� ����� �����",
                     "value" => get_value_table($tbl_arch_enterpoint));
    $array[] = array("name" => $tbl_arch_deep,
                     "description" => "�������� �������� ������� ��� ������� ���������",
                     "value" => get_value_table($tbl_arch_deep));
    $array[] = array("name" => $tbl_arch_time,
                     "description" => "�������� �������� ������� ��� ������� ������",
                     "value" => get_value_table($tbl_arch_time));
    $array[] = array("name" => $tbl_arch_time_temp,
                     "description" => "��������� ������� ��� ��������� ������� ������",
                     "value" => get_value_table($tbl_arch_time_temp));
    $array[] = array("name" => $tbl_arch_hits_week,
                     "description" => "��������� �������� ������� ��� ����� � ������",
                     "value" => get_value_table($tbl_arch_hits_week));
    $array[] = array("name" => $tbl_arch_ip_week,
                     "description" => "��������� �������� ������� ��� IP-�������",
                     "value" => get_value_table($tbl_arch_ip_week));
    $array[] = array("name" => $tbl_arch_clients_week,
                     "description" => "��������� �������� ������� ��� ��������� � ������������ ������",
                     "value" => get_value_table($tbl_arch_clients_week));
    $array[] = array("name" => $tbl_arch_robots_week,
                     "description" => "��������� �������� ������� ��� ������� ��������� ������",
                     "value" => get_value_table($tbl_arch_robots_week));
    $array[] = array("name" => $tbl_arch_refferer_week,
                     "description" => "��������� �������� ������� ��� ��������� - ������� ������� ��������� ������, � ������� ��� ���������� ������� �� ��� ����",
                     "value" => get_value_table($tbl_arch_refferer_week));
    $array[] = array("name" => $tbl_arch_searchquery_week,
                     "description" => "��������� �������� ������� ��� ��������� ��������",
                     "value" => get_value_table($tbl_arch_searchquery_week));
    $array[] = array("name" => $tbl_arch_num_searchquery_week,
                     "description" => "��������� �������� ������� ��� ���������� ��������� ��������",
                     "value" => get_value_table($tbl_arch_num_searchquery_week));
    $array[] = array("name" => $tbl_arch_enterpoint_week,
                     "description" => "��������� �������� ������� ��� ����� �����",
                     "value" => get_value_table($tbl_arch_enterpoint_week));
    $array[] = array("name" => $tbl_arch_deep_week,
                     "description" => "��������� �������� ������� ��� ������� ���������",
                     "value" => get_value_table($tbl_arch_deep_week));
    $array[] = array("name" => $tbl_arch_time_week,
                     "description" => "��������� �������� ������� ��� ������� ������",
                     "value" => get_value_table($tbl_arch_time_week));
    $array[] = array("name" => $tbl_arch_hits_month,
                     "description" => "�������� �������� ������� ��� ����� � ������",
                     "value" => get_value_table($tbl_arch_hits_month));
    $array[] = array("name" => $tbl_arch_ip_month,
                     "description" => "�������� �������� ������� ��� IP-�������",
                     "value" => get_value_table($tbl_arch_ip_month));
    $array[] = array("name" => $tbl_arch_clients_month,
                     "description" => "�������� �������� ������� ��� ��������� � ������������ ������",
                     "value" => get_value_table($tbl_arch_clients_month));
    $array[] = array("name" => $tbl_arch_robots_month,
                     "description" => "�������� �������� ������� ��� �������",
                     "value" => get_value_table($tbl_arch_robots_month));
    $array[] = array("name" => $tbl_arch_refferer_month,
                     "description" => "�������� �������� ������� ��� ��������� - ������� ������� ��������� ������, � ������� ��� ��������� ������� �� ��� ����",
                     "value" => get_value_table($tbl_arch_refferer_month));
    $array[] = array("name" => $tbl_arch_searchquery_month,
                     "description" => "�������� �������� ������� ��� ��������� ��������",
                     "value" => get_value_table($tbl_arch_searchquery_month));
    $array[] = array("name" => $tbl_arch_num_searchquery_month,
                     "description" => "�������� �������� ������� ��� ���������� ��������� ��������",
                     "value" => get_value_table($tbl_arch_num_searchquery_month));
    $array[] = array("name" => $tbl_arch_enterpoint_month,
                     "description" => "�������� �������� ������� ��� ����� �����",
                     "value" => get_value_table($tbl_arch_enterpoint_month));
    $array[] = array("name" => $tbl_arch_deep_month,
                     "description" => "�������� �������� ������� ��� ������� ���������",
                     "value" => get_value_table($tbl_arch_deep_month));
    $array[] = array("name" => $tbl_arch_time_month,
                     "description" => "�������� �������� ������� ��� ������� ������",
                     "value" => get_value_table($tbl_arch_time_month));
  ?>
  <p class=help>���������� ������� (<a href=database.clear.php?part=actual>��������</a>)</p>
  <table class="table" 
         width="100%" 
         border="0" 
         cellpadding="0" 
         cellspacing="0">
  <tr class="header" align="center">
    <td>���� ������</td>
    <td>��������</td>
    <td>�����</td>
  </tr>
  <?php
    for($i = 0; $i < 5; $i++)
    {
      $position = $array[$i];
      echo "<tr>";
        echo "<td><p>$position[name]</p></td>";
        echo "<td><p>$position[description]</p></td>";
        echo "<td align=center><p>".valuesize($position['value'])."</p></td>";
      echo "</tr>";
    }
    echo "</table>";
  ?>
  <p class=help>��������������� �������</p>
  <table class="table" 
         width="100%" 
         border="0" 
         cellpadding="0" 
         cellspacing="0">
  <tr class="header" align="center">
    <td>���� ������</td>
    <td>��������</td>
    <td>�����</td>
  </tr>
  <?php
    for($i = 5; $i < 8; $i++)
    {
      $position = $array[$i];
      echo "<tr>";
        echo "<td><p>$position[name]</p></td>";
        echo "<td><p>$position[description]</p></td>";
        echo "<td align=center><p>".valuesize($position['value'])."</p></td>";
      echo "</tr>";
    }
    echo "</table>";
  ?>
  <p class=help>�������� ������� (<a href=database.clear.php?part=archive>��������</a>)</p>
  <table class="table" 
         width="100%" 
         border="0" 
         cellpadding="0" 
         cellspacing="0">
  <tr class="header" align="center">
    <td>���� ������</td>
    <td>��������</td>
    <td>�����</td>
  </tr>
  <?php
    for($i = 8; $i < count($array); $i++)
    {
      $position = $array[$i];
      echo "<tr>";
        echo "<td><p>$position[name]</p></td>";
        echo "<td><p>$position[description]</p></td>";
        echo "<td align=center><p>".valuesize($position['value'])."</p></td>";
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
?>
