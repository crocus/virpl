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

  // ������� �������� ���������
  function archive_num_searchquery($tbl_searchquerys, $tbl_arch_num_searchquery)
  {
    // ��������� ������ ����
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
    // ������ ��������� ������
    $begin_day = begin_day_arch($tbl_searchquerys, $tbl_arch_num_searchquery);
    // ���������� ����, ���������� ���������
    $days = floor(($last_day - $begin_day)/24/60/60);
    // ���� ���������
    if($days)
    {
      for ($i = $days - 1; $i >= 0; $i--)
      {
        $begin = "SELECT COUNT(*) 
                  FROM $tbl_searchquerys
                  WHERE putdate LIKE '".date("Y-m-d", $last_day - $i*24*3600)."%' AND
                         searches = ";
  
        // ������������ ���������� ��������� �� ����� 
        $number_yandex     = query_result("$begin 'yandex'");
        $number_google     = query_result("$begin 'google'");
        $number_rambler    = query_result("$begin 'rambler'");
        $number_aport      = query_result("$begin 'aport'");
        $number_msn        = query_result("$begin 'msn'");
        $number_mail       = query_result("$begin 'mail'");
  
        $sql_num_queries[] = "(NULL,
                          '".date("Y-m-d", $last_day - $i*24*3600)."',
                          $number_yandex,
                          $number_google,
                          $number_rambler,
                          $number_aport,
                          $number_msn,
                          $number_mail)";
      }
      if(!empty($sql_num_queries))
      {
        $query = "INSERT INTO $tbl_arch_num_searchquery VALUES ".implode(",", $sql_num_queries);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ �������� ��������� - archive_num_searchquery()");
        }
      }
    }
  }
  
  // ������� ��������� ��������� � ������������ ������ � ��������� �������
  function archive_num_searchquery_week($tbl_arch_num_searchquery, $tbl_arch_num_searchquery_week)
  {
    // ��������� ������ ����
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
    // ������ ��������� ������
    $begin_day = begin_day_arch($tbl_arch_num_searchquery, $tbl_arch_num_searchquery_week, 'putdate_begin');
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
        $end = "FROM $tbl_arch_num_searchquery
                WHERE putdate > '".date("Y-m-d", $current_date)."' AND
                      putdate <= '".date("Y-m-d", $current_date + 24*3600*(7 - $weekday))."'";
  
        // ������������ ���������� ��������� �� ������
        $number_yandex  = query_result("SELECT SUM(number_yandex) $end");
        $number_google  = query_result("SELECT SUM(number_google) $end");
        $number_rambler = query_result("SELECT SUM(number_rambler) $end");
        $number_aport   = query_result("SELECT SUM(number_aport) $end");
        $number_msn     = query_result("SELECT SUM(number_msn) $end");
        $number_mail    = query_result("SELECT SUM(number_mail) $end");
                                        
        // ��������� ������ ��� �������� �������
        $sql_num_queries[] = "(NULL,
                              '".date("Y-m-d", $current_date)."',
                              '".date("Y-m-d", $current_date + 24*3600*(7 - $weekday))."', 
                              $number_yandex,
                              $number_google,
                              $number_rambler,
                              $number_aport,
                              $number_msn,
                              $number_mail)";
  
        // ����������� ������� ����� �� ��������� ������
        $current_date += (7 - $weekday)*24*3600;
        $weekday = 0; // ����� ���� ����� �� ����� ������
      }
  
      // ��������� ������������� ������ � ��������� ���
      if(!empty($sql_num_queries))
      {
        $query = "INSERT INTO $tbl_arch_num_searchquery_week VALUES".implode(",", $sql_num_queries);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ ��������� ��������� - archive_num_searchquery_week()");
        }
      }
    }
  }
  
  // ������� ��������� ��������� � ������������ ������ � �������� �������
  function archive_num_searchquery_month($tbl_arch_num_searchquery, $tbl_arch_num_searchquery_month)
  {
    // ��������� ������ ����
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y")) + 2;
    // ������ ��������� ������
    $begin_day = begin_day_arch($tbl_arch_num_searchquery, $tbl_arch_num_searchquery_month);
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

        $end = "FROM $tbl_arch_num_searchquery
                WHERE YEAR(putdate) = $year AND
                      MONTH(putdate) = '".sprintf("%02d",$month)."'";
  
        // ������������ ���������� ��������� �� �����
        $number_yandex  = query_result("SELECT SUM(number_yandex) $end");
        $number_google  = query_result("SELECT SUM(number_google) $end");
        $number_rambler = query_result("SELECT SUM(number_rambler) $end");
        $number_aport   = query_result("SELECT SUM(number_aport) $end");
        $number_msn     = query_result("SELECT SUM(number_msn) $end");
        $number_mail    = query_result("SELECT SUM(number_mail) $end");
                                        
        // ��������� ������ ��� �������� �������
        $sql_num_queries[] = "(NULL,
                             '$year-".sprintf("%02d",$month)."-01',
                              $number_yandex,
                              $number_google,
                              $number_rambler,
                              $number_aport,
                              $number_msn,
                              $number_mail)";
      }
  
      // ��������� ������������� ������ � ��������� ���
      if(!empty($sql_num_queries))
      {
        $query = "INSERT INTO $tbl_arch_num_searchquery_month VALUES".implode(",", $sql_num_queries);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ �������� ��������� - archive_num_searchquery_month()");
        }
      }
    }
  }
?>
