<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-������ SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // ���� ��������� DEBUG ����������, �������� ����������
  // �������, � ��������� ��������� ��������� ��������� ��
  // �������������� ���������, ��������� � MySQL � ���
  define("DEBUG", 1);
  // ������ ��������� ������ ��������� ������
  $dblocation = "localhost";
  // ��� ���� ������, �� �������� ��� ��������� ������
  $dbname = "foliantn_powercounter";
  $dbuser = "foliantn_iamcroc";
  $dbpasswd = "di13Bskj";

  // ��������
  $tbl_accounts         = 'system_accounts';
  // �������
  $tbl_news             = 'system_news';
  // ������ � �������
  $tbl_faq              = 'system_faq';
  // CMS
  $tbl_catalog          = 'system_menu_catalog';
  $tbl_position         = 'system_menu_position';
  $tbl_paragraph        = 'system_menu_paragraph';
  $tbl_paragraph_image  = 'system_menu_paragraph_image';
  // �������
  $tbl_cat_catalog      = 'system_catalog';
  $tbl_cat_position     = 'system_position';
  // ���� ��������
  $tbl_contactaddress   = 'system_contactaddress';
  // ���� �����������
  $tbl_poll             = 'system_poll';
  $tbl_poll_answer      = 'system_poll_answer';
  $tbl_poll_session     = 'system_poll_session';
  // �������� �����
  $tbl_guestbook        = 'system_guestbook';
  // ������������ �����
  $tbl_users            = 'system_users';
  // �����������
  $tbl_photo_catalog    = 'system_photo_catalog';
  $tbl_photo_position   = 'system_photo_position';
  $tbl_photo_settings   = 'system_photo_settings';

  // ������������� ���������� � ����� ������
  $dbcnx = mysql_connect($dblocation,$dbuser,$dbpasswd);
  if(!$dbcnx)
	exit("<P>� ��������� ������ ������ ���� ������ �� 
		  ��������, ������� ���������� ����������� 
		  �������� ����������.</P>" );
  // �������� ���� ������
  if(! @mysql_select_db($dbname,$dbcnx))
	exit("<P>� ��������� ������ ���� ������ �� ��������, 
		  ������� ���������� ����������� �������� 
		  ����������.</P>" );

  @mysql_query("SET NAMES 'cp1251'");
//  @mysql_query("SET time_zone = '+11:00'");
  if(!function_exists('get_magic_quotes_gpc'))
  {
	function get_magic_quotes_gpc()
	{
	  return false;
	}
  }
?>