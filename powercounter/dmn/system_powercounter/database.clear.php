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

  try
  {
    if($_GET['part'] == actual)
    {
      $array = array($tbl_ip, 
                     $tbl_pages, 
                     $tbl_thits,
                     $tbl_refferer, 
                     $tbl_searchquerys);
      foreach($array as $table)
      {
        // ������� ������ �� �������
        $query = "TRUNCATE $table";
        if(!mysql_query($query))
        {
          throw new ExceptionMySQL(mysql_error(), 
                                   $query,
                                  "������ ��� �������
                                   �������");
        }
      }
    }
    if($_GET['part'] == archive)
    {
      $array = array($tbl_arch_hits,
                     $tbl_arch_ip, 
                     $tbl_arch_clients, 
                     $tbl_arch_robots,
                     $tbl_arch_refferer, 
                     $tbl_arch_searchquery,
                     $tbl_arch_num_searchquery, 
                     $tbl_arch_enterpoint,
                     $tbl_arch_deep, 
                     $tbl_arch_time, 
                     $tbl_arch_time_temp,
                     $tbl_arch_hits_week, 
                     $tbl_arch_robots_week,
                     $tbl_arch_ip_week, 
                     $tbl_arch_clients_week,
                     $tbl_arch_refferer_week, 
                     $tbl_arch_searchquery_week,
                     $tbl_arch_num_searchquery_week, 
                     $tbl_arch_enterpoint_week,
                     $tbl_arch_deep_week, 
                     $tbl_arch_time_week,
                     $tbl_arch_hits_month, 
                     $tbl_arch_robots_month,
                     $tbl_arch_ip_month, 
                     $tbl_arch_clients_month,
                     $tbl_arch_refferer_month, 
                     $tbl_arch_searchquery_month,
                     $tbl_arch_num_searchquery_month, 
                     $tbl_arch_enterpoint_month,
                     $tbl_arch_deep_month, 
                     $tbl_arch_time_month);
      foreach($array as $table)
      {
        // ������� ������ �� �������
        $query = "TRUNCATE $table";
        if(!mysql_query($query))
        {
          throw new ExceptionMySQL(mysql_error(), 
                                   $query,
                                  "������ ��� �������
                                   �������");
        }
      }
    }
    header("Location: database.php");
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