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

  $title = '�������� ��������� ������';  
  $pageinfo = '�� ���� �������� ����� ��������� �������� ����� 
  �� �����, ������ � �����. E-mail �������� ����� �������� � 
  ���������������� ����� config.php ������� ����������������� 
  (��������� EMAIL_ADDRESS)';

  try
  {
    // �������� ��������� ��������
    require_once("../utils/topcounter.php");

    echo "<table class=table width=100% border=0 cellpadding=0 cellspacing=0>
            <tr>
              <td><a href=send_manage.php?freq=1>��������</a> ���������� ����� �� ".EMAIL_ADDRESS."</td>
            </tr>
            <tr>
              <td><a href=send_manage.php?freq=7>��������</a> ��������������� ����� �� ".EMAIL_ADDRESS."</td>
            </tr>
            <tr>
              <td><a href=send_manage.php?freq=30>��������</a> ����������� ����� �� ".EMAIL_ADDRESS."</td>
            </tr>
         </table>";
  
    // ���������� �������
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
  }?>