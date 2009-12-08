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
  function archive_robots($tbl_ip, $tbl_arch_robots)
  {
    // ��������� ������ ����
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
    // ������ ��������� ������
    $begin_day = begin_day_arch($tbl_ip, $tbl_arch_robots);
    // ���������� ����, ���������� ���������
    $days = floor(($last_day - $begin_day)/24/60/60);
    // ���� ���������
    if($days)
    {
      for ($i = $days - 1; $i >= 0; $i--)
      {
        $begin = "SELECT COUNT(*) FROM $tbl_ip 
                  WHERE putdate LIKE '".date("Y-m-d", $last_day - $i*24*3600)."%' AND 
                        systems = ";
  
        // ������������ ���������� ��������� �� ����� 
        $systems_yandex    = query_result("$begin 'robot_yandex'");
        $systems_gogle     = query_result("$begin 'robot_google'");
        $systems_rambler   = query_result("$begin 'robot_rambler'");
        $systems_aport     = query_result("$begin 'robot_aport'");
        $systems_msn       = query_result("$begin 'robot_msnbot'");
        $systems_none      = query_result("$begin 'none'");
  
        // ��������� ������ ��� �������� �������
        $sql_robots[] = "(NULL,
                          '".date("Y-m-d", $last_day - $i*24*3600)."',
                          $systems_yandex,
                          $systems_rambler,
                          $systems_gogle,
                          $systems_aport,
                          $systems_msn,
                          $systems_none)";
      }
      if(!empty($sql_robots))
      {
        $query = "INSERT INTO $tbl_arch_robots VALUES".implode(",", $sql_robots);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ �������� ��������� - archive_robots()");
        }
      }
    }
  }
  
  // ������� ��������� ������� � ��������� �������
  function archive_robots_week($tbl_arch_robots, $tbl_arch_robots_week)
  {
    // ��������� ������ ����
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
    // ������ ��������� ������
    $begin_day = begin_day_arch($tbl_arch_robots, $tbl_arch_robots_week, 'putdate_begin');
    // ��������� ������� ������ ������ � ���� ��������� ���������
    $week = floor(($last_day - $begin_day)/24/60/60/7);
    // ���� ������ ������ ������ - ���������� ������
    if ($week > 0)
    {
      // $last_date - ���� ��������� ���������... - ������� ������ �� ��
      // ����� ������ (�����������). �������� �������� ������ � ������������ (1)
      // �� ����������� (0).
      $weekday = date('w', $begin_day);
  
      // �������� ������� ������������ ��������� �����
      $current_date = $begin_day;
      while(floor(($last_day - $current_date)/24/60/60/7))
      {
        $end = "FROM $tbl_arch_robots
                WHERE putdate > '".date("Y-m-d", $current_date)."' AND
                      putdate <= '".date("Y-m-d", $current_date + 24*3600*(7 - $weekday))."'";

        // ������������ ���������� ��������� �� ������
        $systems_yandex    = query_result("SELECT SUM(yandex) $end");
        $systems_gogle     = query_result("SELECT SUM(google) $end");
        $systems_rambler   = query_result("SELECT SUM(rambler) $end");
        $systems_aport     = query_result("SELECT SUM(aport) $end");
        $systems_msn       = query_result("SELECT SUM(msn) $end");
        $systems_none      = query_result("SELECT SUM(none) $end");
  
        $sql_robots[] = "(NULL,
                          '".date("Y-m-d", $current_date)."',
                          '".date("Y-m-d", $current_date + 24*3600*(7 - $weekday))."', 
                          $systems_yandex,
                          $systems_rambler,
                          $systems_gogle,
                          $systems_aport,
                          $systems_msn,
                          $systems_none)";
  
        // ����������� ������� ����� �� ��������� ������
        $current_date += (7 - $weekday)*24*3600;
        $weekday = 0; // ����� ���� ����� �� ����� ������
      }
      if(!empty($sql_robots))
      {
        $query = "INSERT INTO $tbl_arch_robots_week VALUES".implode(",", $sql_robots);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ ��������� ��������� - archive_robots_week()");
        }
      }
    }
  }
  
  // ������� ��������� ������� ��������� ������ � �������� �������
  function archive_robots_month($tbl_arch_robots, $tbl_arch_robots_month)
  {
    // ��������� ������ ����
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y")) + 2;
    // ������ ��������� ������
    $begin_day = begin_day_arch($tbl_arch_robots, $tbl_arch_robots_month);
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

        $end = "FROM $tbl_arch_robots
                WHERE YEAR(putdate) = $year AND
                      MONTH(putdate) = '".sprintf("%02d",$month)."'";

        // ������������ ���������� ��������� �� �����
        $systems_yandex    = query_result("SELECT SUM(yandex) $end");
        $systems_gogle     = query_result("SELECT SUM(google) $end");
        $systems_rambler   = query_result("SELECT SUM(rambler) $end");
        $systems_aport     = query_result("SELECT SUM(aport) $end");
        $systems_msn       = query_result("SELECT SUM(msn) $end");
        $systems_none      = query_result("SELECT SUM(none) $end");
  
        $sql_robots[] = "(NULL,
                         '$year-".sprintf("%02d",$month)."-01',
                          $systems_yandex,
                          $systems_rambler,
                          $systems_gogle,
                          $systems_aport,
                          $systems_msn,
                          $systems_none)";
      }
  
      if(!empty($sql_robots))
      {
        $query = "INSERT INTO $tbl_arch_robots_month VALUES".implode(",", $sql_robots);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ �������� ��������� - archive_robots_month()");
        }
      }
    }
  }
?>
