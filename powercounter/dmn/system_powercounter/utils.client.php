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

  // ������� ��������� �������� � �������� �������
  function archive_client($tbl_ip, $tbl_arch_clients)
  {
    // ��������� ������ ����
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
    // ������ ��������� ������
    $begin_day = begin_day_arch($tbl_ip, $tbl_arch_clients);
    // ���������� ����, ���������� ���������
    $days = floor(($last_day - $begin_day)/24/60/60);
    // ���� ���������
    if($days)
    {
      for ($i = $days - 1; $i >= 0; $i--)
      {
        $begin = "SELECT COUNT(DISTINCT ip) 
                  FROM $tbl_ip 
                  WHERE systems NOT LIKE 'robot_%' AND 
                        putdate LIKE '".date("Y-m-d", $last_day - $i*24*3600)."%' AND 
                        browsers = ";
        // ������������ ���������� ��������� �� ����� 
        $browsers_msie     = query_result("$begin 'msie'");
        $browsers_opera    = query_result("$begin 'opera'");
        $browsers_netscape = query_result("$begin 'netscape'");
        $browsers_firefox  = query_result("$begin 'firefox'");
        $browsers_myie     = query_result("$begin 'myie'");
        $browsers_mozilla  = query_result("$begin 'mozilla'");
        $browsers_none     = query_result("$begin 'none'");
  
        $systems_windows   = query_result("$begin 'windows'");
        $systems_unix      = query_result("$begin 'unix'");
        $systems_macintosh = query_result("$begin 'macintosh'");
        $systems_none      = query_result("$begin 'none'");
  
        // ��������� ������ ��� �������� �������
        $sql_clients[] = "(NULL,
                          '".date("Y-m-d", $last_day - $i*24*3600)."',
                          $browsers_msie,
                          $browsers_opera,
                          $browsers_netscape,
                          $browsers_firefox,
                          $browsers_myie,
                          $browsers_mozilla,
                          $browsers_none,
                          $systems_windows,
                          $systems_unix,
                          $systems_macintosh,
                          $systems_none)";
      }
      if(!empty($sql_clients))
      {
        $query = "INSERT INTO $tbl_arch_clients VALUES ".implode(",", $sql_clients);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ �������� ��������� - archive_client()");
        }
      }
    }
  }
  
  
  // ������� ��������� ��������� � ������������ ������ � ��������� �������
  function archive_client_week($tbl_arch_clients, $tbl_arch_clients_week)
  {
    // ��������� ������ ����
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
    // ������ ��������� ������
    $begin_day = begin_day_arch($tbl_arch_clients, $tbl_arch_clients_week, 'putdate_begin');
    // ��������� ������� ������ ������ � ���� ��������� ���������
    $week = floor(($last_day - $begin_day)/24/60/60/7);
    // ���� ������ ������ ������ - ���������� ������
    if ($week > 0)
    {
      // $begin_day - ���� ��������� ���������... - ������� ������ �� ��
      // ����� ������ (�����������). �������� �������� ������ � ������������ (1)
      // �� ����������� (0).
      $weekday = date('w', $begin_day);
  
      // �������� ������� ������������ ��������� �����
      $current_date = $begin_day;
      while(floor(($last_day - $current_date)/24/60/60/7))
      {
        $end = "FROM $tbl_arch_clients
                WHERE putdate > '".date("Y-m-d", $current_date)."' AND
                      putdate <= '".date("Y-m-d", $current_date + 24*3600*(7 - $weekday))."'";

        // ������������ ���������� ��������� �� ������
        $browsers_msie     = query_result("SELECT SUM(browsers_msie) $end");
        $browsers_opera    = query_result("SELECT SUM(browsers_opera) $end");
        $browsers_netscape = query_result("SELECT SUM(browsers_netscape) $end");
        $browsers_firefox  = query_result("SELECT SUM(browsers_firefox) $end");
        $browsers_myie     = query_result("SELECT SUM(browsers_myie) $end");
        $browsers_mozilla  = query_result("SELECT SUM(browsers_mozilla) $end");
        $browsers_none     = query_result("SELECT SUM(browsers_none) $end");
        $systems_windows   = query_result("SELECT SUM(systems_windows) $end");
        $systems_unix      = query_result("SELECT SUM(systems_unix) $end");
        $systems_macintosh = query_result("SELECT SUM(systems_macintosh) $end");
        $systems_none      = query_result("SELECT SUM(systems_none) $end");

        // ��������� ������ ��� �������� �������
        $sql_clients[] = "(NULL,
                          '".date("Y-m-d", $current_date)."',
                          '".date("Y-m-d", $current_date + 24*3600*(7 - $weekday))."', 
                          $browsers_msie,
                          $browsers_opera,
                          $browsers_netscape,
                          $browsers_firefox,
                          $browsers_myie,
                          $browsers_mozilla,
                          $browsers_none,
                          $systems_windows,
                          $systems_unix,
                          $systems_macintosh,
                          $systems_none)";
        // ����������� ������� ����� �� ��������� ������
        $current_date += (7 - $weekday)*24*3600;
        $weekday = 0; // ����� ���� ����� �� ����� ������
      }
      if(!empty($sql_clients))
      {
        $query = "INSERT INTO $tbl_arch_clients_week VALUES".implode(",", $sql_clients);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ ��������� ��������� - archive_client_week()");
        }
      }
    }
  }
  
  // ������� ��������� ��������� � ������������ ������ � �������� �������
  function archive_clients_month($tbl_arch_clients, $tbl_arch_clients_month)
  {
    // ��������� ������ ����
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y")) + 2;
    // ������ ��������� ������
    $begin_day = begin_day_arch($tbl_arch_clients, $tbl_arch_clients_month);
    // ��������� ������� ������ ������ � ���� ��������� ���������
    $month = (floor(date("Y",$last_day) - date("Y",$begin_day)))*12 + 
             floor(date("m",$last_day) - date("m",$begin_day)); 
    // ���� ������ ������ ������ - ���������� ������
    if ($month > 0)
    {
      // ���������� ������ �� ���� �������, �� ������� ���������
      // �� �����������
      for($i = date("Y",$begin_day)*12 + date("m",$begin_day); $i < date("Y",$last_day)*12 + date("m",$last_day); $i++)
      {
        $year = (int)($i/12);
        $month = ($i%12);
        if($month == 0)
        {
          $year--;
          $month = 12;
        }

        $end = "FROM $tbl_arch_clients
                WHERE YEAR(putdate) = $year AND
                      MONTH(putdate) = '".sprintf("%02d",$month)."'";
  
        // ������������ ���������� ��������� �� �����
        $browsers_msie     = query_result("SELECT SUM(browsers_msie) $end");
        $browsers_opera    = query_result("SELECT SUM(browsers_opera) $end");
        $browsers_netscape = query_result("SELECT SUM(browsers_netscape) $end");
        $browsers_firefox  = query_result("SELECT SUM(browsers_firefox) $end");
        $browsers_myie     = query_result("SELECT SUM(browsers_myie) $end");
        $browsers_mozilla  = query_result("SELECT SUM(browsers_mozilla) $end");
        $browsers_none     = query_result("SELECT SUM(browsers_none) $end");
        $systems_windows   = query_result("SELECT SUM(systems_windows) $end");
        $systems_unix      = query_result("SELECT SUM(systems_unix) $end");
        $systems_macintosh = query_result("SELECT SUM(systems_macintosh) $end");
        $systems_none      = query_result("SELECT SUM(systems_none) $end");

        // ��������� ������ ��� �������� �������
        $sql_clients[] = "(NULL,
                         '$year-".sprintf("%02d",$month)."-01',
                          $browsers_msie,
                          $browsers_opera,
                          $browsers_netscape,
                          $browsers_firefox,
                          $browsers_myie,
                          $browsers_mozilla,
                          $browsers_none,
                          $systems_windows,
                          $systems_unix,
                          $systems_macintosh,
                          $systems_none)";
      }
  
      if(!empty($sql_clients))
      {
        $query = "INSERT INTO $tbl_arch_clients_month VALUES".implode(",", $sql_clients);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ �������� ��������� - archive_clients_month()");
        }
      }
    }
  }
?>
