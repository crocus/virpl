<?php 
  ////////////////////////////////////////////////////////////
  // ������ �����������������
  // 2006-2007 (C) IT-������ SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // ���� ������������ �� ������������� - ������������
  if(!isset($_SERVER['PHP_AUTH_USER']) || (!empty($_GET['logout']) && $_SERVER['PHP_AUTH_USER'] == $_GET['logout'])) 
  { 
    Header("WWW-Authenticate: Basic realm=\"Control Page\""); 
    Header("HTTP/1.0 401 Unauthorized"); 
    exit(); 
  } 
  else 
  { 
    // ������ ���������� $_SERVER['PHP_AUTH_USER'] � $_SERVER['PHP_AUTH_PW'],
    // ����� ���� �� ����������
    if (!get_magic_quotes_gpc())
    {
      $_SERVER['PHP_AUTH_USER'] = mysql_escape_string($_SERVER['PHP_AUTH_USER']);
      $_SERVER['PHP_AUTH_PW']   = mysql_escape_string($_SERVER['PHP_AUTH_PW']);
    }
    
    $query = "SELECT * FROM $tbl_accounts
              WHERE name = '".$_SERVER['PHP_AUTH_USER']."'";
    $lst = @mysql_query($query); 
    // ���� ������ � SQL-������� - ����� ����
    if(!$lst)
    {
      Header("WWW-Authenticate: Basic realm=\"Control Page\""); 
      Header("HTTP/1.0 401 Unauthorized"); 
      exit(); 
    }
    // ���� ������ ������������ ��� - ����� ����
    if(mysql_num_rows($lst) == 0)
    {
      Header("WWW-Authenticate: Basic realm=\"Control Page\""); 
      Header("HTTP/1.0 401 Unauthorized"); 
      exit(); 
    }
    // ���� ��� �������� ��������, ���������� ���� �������
    $account = @mysql_fetch_array($lst);
    if(md5($_SERVER['PHP_AUTH_PW']) != $account['pass'])
    {
      Header("WWW-Authenticate: Basic realm=\"Control Page\""); 
      Header("HTTP/1.0 401 Unauthorized"); 
      exit(); 
    }
  }
?>