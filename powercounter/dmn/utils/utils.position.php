<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-������ SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // ���������� ������� ��������� ������ 
  // (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE); 
  // ���������� SoftTime FrameWork
  require_once("../../config/class.config.dmn.php");

  // ����������� �������
  function show($id_position, $tbl_name, $where = "", $fld_name = "id_position")
  {
    // ��������� GET-��������, ������������ SQL-��������
    $id_position = intval($id_position);

    // ���������� �������
    $query = "UPDATE $tbl_name SET hide='show' 
              WHERE $fld_name=$id_position $where";
    if(!mysql_query($query))
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ����������� 
                               �������");
    }
  }

  // �������� �������
  function hide($id_position, $tbl_name, $where = "", $fld_name = "id_position")
  {
    // ��������� GET-��������, ������������ SQL-��������
    $id_position = intval($id_position);

    // �������� �������
    $query = "UPDATE $tbl_name SET hide='hide' 
              WHERE $fld_name=$id_position $where";
    if(!mysql_query($query))
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ��������
                               �������");
    }
  }

  // ������ ����� �� ���� ������� �����
  function up($id_position, $tbl_name, $where = "", $fld_name = "id_position")
  {
    // ��������� ������� �������
    $query = "SELECT pos FROM $tbl_name
              WHERE $fld_name = $id_position
              LIMIT 1";
    $pos = mysql_query($query);
    if(!$pos)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ���������� 
                               ������� �������");
    }
    if(mysql_num_rows($pos))
    {
      $pos_current = mysql_result($pos, 0);
    }
    // ��������� �������� �������
    $query = "SELECT pos FROM $tbl_name
              WHERE pos < $pos_current $where
              ORDER BY pos DESC
              LIMIT 1";
    $pos = mysql_query($query);
    if(!$pos)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ���������� 
                               ���������� �������");
    }
    if(mysql_num_rows($pos))
    {
      $pos_preview = mysql_result($pos, 0);
  
      // ������ ������� ������� � ���������� �������
      $query = "UPDATE $tbl_name
                SET pos = $pos_current + $pos_preview - pos
                WHERE pos IN ($pos_current, $pos_preview) $where";
      if(!mysql_query($query))
      {
        throw new ExceptionMySQL(mysql_error(), 
                                 $query,
                                "������ ���������
                                 �������");
      }
    }
  }

  // ��������� ����� �� ���� ������� ����
  function down($id_position, $tbl_name, $where = "", $fld_name = "id_position")
  {
    // ��������� ������� �������
    $query = "SELECT pos FROM $tbl_name
              WHERE $fld_name = $id_position
              LIMIT 1";
    $pos = mysql_query($query);
    if(!$pos)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ���������� 
                               ������� �������");
    }
    if(mysql_num_rows($pos))
    {
      $pos_current = mysql_result($pos, 0);
    }
    // ��������� ��������� �������
    $query = "SELECT pos FROM $tbl_name
              WHERE pos > $pos_current $where
              ORDER BY pos
              LIMIT 1";
    $pos = mysql_query($query);
    if(!$pos)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ���������� 
                               ��������� �������");
    }
    if(mysql_num_rows($pos))
    {
      $pos_next = mysql_result($pos, 0);
  
      // ������ ������� ������� � ��������� �������
      $query = "UPDATE $tbl_name
                SET pos = $pos_next + $pos_current - pos
                WHERE pos IN ($pos_next, $pos_current) $where";
      if(!mysql_query($query))
      {
        throw new ExceptionMySQL(mysql_error(), 
                                 $query,
                                "������ ���������
                                 �������");
      }
    }
  }
?>