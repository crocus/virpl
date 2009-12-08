<?php
  ////////////////////////////////////////////////////////////
  // ������� ����� ������������ ����� - PowerCounter
  // 2003-2008 (C) IT-������ SoftTime (http://www.softtime.ru)
  // ���������: http://www.softtime.ru/forum/
  // �������� �.�. (simdyanov@softtime.ru)
  // ����� �.�. (loki_angel@mail.ru)
  // �������� �.�. (kuznetsov@softtime.ru)
  // ������� �.�. (softtime@softtime.ru)
  ////////////////////////////////////////////////////////////
  // ���������� ������� ��������� ������ 
  // (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE); 
  // ������������� ���������� � ����� ������
  include "../../config/config.php";
  // ���������� ������� �� ����� ��������
  $pnumber = 20;

  $tbl_ip                        = 'powercounter_ip';          
  $tbl_pages                     = 'powercounter_pages';       
  $tbl_links                     = 'powercounter_links';       
  $tbl_thits                     = 'powercounter_thits';       
  $tbl_refferer                  = 'powercounter_refferer';    
  $tbl_searchquerys              = 'powercounter_searchquerys';

  $tbl_cities                    = 'powercounter_cities';
  $tbl_ip_compact                = 'powercounter_ip_compact';
  $tbl_regions                   = 'powercounter_regions';

  $tbl_arch_hits                 = 'powercounter_arch_hits';
  $tbl_arch_ip                   = 'powercounter_arch_ip';
  $tbl_arch_clients              = 'powercounter_arch_clients';
  $tbl_arch_robots               = 'powercounter_arch_robots';
  $tbl_arch_refferer             = 'powercounter_arch_refferer';
  $tbl_arch_searchquery          = 'powercounter_arch_searchquery';
  $tbl_arch_num_searchquery      = 'powercounter_arch_num_searchquery';
  $tbl_arch_enterpoint           = 'powercounter_arch_enterpoint';
  $tbl_arch_deep                 = 'powercounter_arch_deep';
  $tbl_arch_time                 = 'powercounter_arch_time';
  $tbl_arch_time_temp            = 'powercounter_arch_time_temp';

  $tbl_arch_hits_week            = 'powercounter_arch_hits_week';
  $tbl_arch_robots_week          = 'powercounter_arch_robots_week';
  $tbl_arch_ip_week              = 'powercounter_arch_ip_week';
  $tbl_arch_clients_week         = 'powercounter_arch_clients_week';
  $tbl_arch_refferer_week        = 'powercounter_arch_refferer_week';
  $tbl_arch_searchquery_week     = 'powercounter_arch_searchquery_week';
  $tbl_arch_num_searchquery_week = 'powercounter_arch_num_searchquery_week';
  $tbl_arch_enterpoint_week      = 'powercounter_arch_enterpoint_week';
  $tbl_arch_deep_week            = 'powercounter_arch_deep_week';
  $tbl_arch_time_week            = 'powercounter_arch_time_week';

  $tbl_arch_hits_month           = 'powercounter_arch_hits_month';
  $tbl_arch_robots_month         = 'powercounter_arch_robots_month';
  $tbl_arch_ip_month             = 'powercounter_arch_ip_month';
  $tbl_arch_clients_month        = 'powercounter_arch_clients_month';
  $tbl_arch_refferer_month       = 'powercounter_arch_refferer_month';
  $tbl_arch_searchquery_month    = 'powercounter_arch_searchquery_month';
  $tbl_arch_num_searchquery_month= 'powercounter_arch_num_searchquery_month';
  $tbl_arch_enterpoint_month     = 'powercounter_arch_enterpoint_month';
  $tbl_arch_deep_month           = 'powercounter_arch_deep_month';
  $tbl_arch_time_month           = 'powercounter_arch_time_month';

  // ����� ����� �������� IP-�������, ������� ������������
  // � ��������, ��������� � �������� �������
  define("IP_NUMBER", 20);
  // ����� ����� �������� ����� �����, ������� ������������
  // � ��������, ��������� � �������� �������
  define("ENTERPOINT_NUMBER", 20);
  // ����� ����� ��������������� ���������, ������� ������������
  // � ��������, ��������� � �������� �������
  define("REFFERER_NUMBER", 20);
  // ����� ����� ��������������� �������� � Yandex, ������� ������������
  // � ��������, ��������� � �������� �������
  define("YANDEX_NUMBER", 20);
  // ����� ����� ��������������� �������� � Rambler, �������
  // ������������ � ��������, ��������� � �������� �������
  define("RAMBLER_NUMBER", 20);
  // ����� ����� ��������������� �������� � Google, ������� ������������
  // � ��������, ��������� � �������� �������
  define("GOOGLE_NUMBER", 20);
  // ����� ����� ��������������� �������� � Google, ������� ������������
  // � ��������, ��������� � �������� �������
  define("APORT_NUMBER", 20);
  // ����� ����� ��������������� �������� � MSN, ������� ������������
  // � ��������, ��������� � �������� �������
  define("MSN_NUMBER", 20);
  // ���� ��������� ��������� �������� 0 �� ������������ ������� ��������
  // ���� ��� IP-������, ���� ��������� ��������� �������� 1 - �����
  // �������������. �������� 0 ����������� ��� ��������� ��������� ������
  // IP-������, �����  ����� ������� �� ��������� ������������ �������� 
  // ����� IP-������� ����������
  // ������
  define("HOST_BY_ADDR", 0);
  // E-mail �� ������� ������������ �������� �����
  define("EMAIL_ADDRESS", "someone@somewhere.ru")
?>