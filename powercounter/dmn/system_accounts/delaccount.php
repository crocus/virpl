<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-������ SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // ���������� ������� ��������� ������ 
  // (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE); 

  // ������������� ���������� � ����� ������
  require_once("../../config/config.php");
  // ���������� ���� �����������
  require_once("../utils/security_mod.php");
  // ���������� SoftTime FrameWork
  require_once("../../config/class.config.dmn.php");

  // ��������� GET-��������, ������������ SQL-��������
  $_GET['id_account'] = intval($_GET['id_account']);

  try
  {
    // ��������� �� ��������� �� ��������� ������� -
    // ���� �� ����� ����� � ������� ������ ����� �����
    $query = "SELECT COUNT(*) FROM $tbl_accounts";
    $acc = mysql_query($query);
    if(!$acc)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��������
                               ������������");
    }
    if(mysql_result($acc, 0) > 1)
    {
      $query = "DELETE FROM $tbl_accounts 
                WHERE id_account=".$_GET['id_account'];
      if(mysql_query($query))
      {
        header("Location: index.php?page=".$_GET['page']);
      }
      else
      {
        throw new ExceptionMySQL(mysql_error(), 
                                 $query,
                                "������ ��������
                                 ������������");
      }
    }
    else
    {
      throw new Exception("������ ������� 
                           ������������ �������");
    }
  }
  catch(ExceptionMySQL $exc)
  {
    require("../utils/exception_mysql.php"); 
  }
  catch(Exception $exc)
  {
    require("../utils/exception.php"); 
  }
?>