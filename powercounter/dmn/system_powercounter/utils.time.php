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
  function archive_time($tbl_ip, $tbl_arch_time, $tbl_arch_time_temp)
  {
    // ��������� ������ ����
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
    // ������ ��������� ������
    $begin_day = begin_day_arch($tbl_ip, $tbl_arch_time);
    // ���������� ����, ���������� ���������
    $days = floor(($last_day - $begin_day)/24/60/60);
    // ���� ���������
    if($days)
    {
      for ($i = $days - 1; $i >= 0; $i--)
      {
        $query = "DELETE FROM $tbl_arch_time_temp";
        @mysql_query($query);
  
        // ��������� ��������� ������� tbl_arch_time_temp
        // ��������� ��������� ��������� �����������
        $query = "INSERT INTO $tbl_arch_time_temp 
                  SELECT ROUND((MAX(unix_timestamp(putdate))-min(unix_timestamp(putdate)))/60)*60+60, 
                         '".date("Y-m-d H:i:s",$last_day)."' - INTERVAL $i DAY
                  FROM $tbl_ip
                  WHERE putdate LIKE '".date("Y-m-d", $last_day - $i*24*3600)."%' AND
                        systems  != 'none' AND
                        browsers != 'none'
                  GROUP BY ip";
        if(!mysql_query($query)) exit(mysql_error());
  
        // ����� ���������: 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 �����
        for($j = 60; $j < 11*60; $j = $j + 60)
        {
          $query_visit[] = "SELECT COUNT(time_min) AS total
                      FROM $tbl_arch_time_temp
                      WHERE putdate LIKE '".date("Y-m-d", $last_day - $i*24*3600)."%' AND
                            time_min >= $j AND time_min < ".($j + 60);
        }
  
        // ����� ���������: 11-20, 21-30, ..., 50-60 �����
        for($j = 600; $j < 3600; $j = $j + 600)
        {
          $query_visit[] = "SELECT COUNT(time_min) AS total
                      FROM $tbl_arch_time_temp
                      WHERE putdate LIKE '".date("Y-m-d", $last_day - $i*24*3600)."%' AND
                            time_min >= $j AND time_min < ".($j + 60);
        }
        // ������� ���������: 2, 3, 4, ... 24 ����
        for($j = 3600; $j < 3600*24; $j = $j + 3600)
        {
          $query_visit[] = "SELECT COUNT(time_min) AS total
                      FROM $tbl_arch_time_temp
                      WHERE putdate LIKE '".date("Y-m-d", $last_day - $i*24*3600)."%' AND
                            time_min >= $j AND time_min < ".($j + 60);
        }
        foreach($query_visit as $quer) $total[] = intval(query_result($quer));
  
        // ��������� ������ ��� �������� IP-������� � ������� $tbl_arch_deep
        $sql_ip[] = "(NULL,
                     '".date("Y-m-d", $last_day - $i*24*3600)."',
                     ".implode(",",$total).")";
        unset($query_visit, $total);
      }
  
      if(!empty($sql_ip))
      {
        $query = "INSERT INTO $tbl_arch_time VALUES ".implode(",", $sql_ip);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ �������� ��������� - archive_time()");
        }
      }
    }
  }
  
  
  // ������� ��������� ���������
  function archive_time_week($tbl_arch_time, $tbl_arch_time_week)
  {
    // ��������� ������ ����
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
    // ������ ��������� ������
    $begin_day = begin_day_arch($tbl_arch_time, $tbl_arch_time_week, 'putdate_begin');
    // ��������� ������� ������ ������ � ���� ��������� ���������
    $week = floor(($last_day - $begin_day)/24/60/60/7);
    // ���� ������ ������ ������ - ���������� ������
    if($week > 0)
    {
      // $last_date - ���� ��������� ���������... - ������� ������ �� ��
      // ����� ������ (�����������). �������� �������� ������ � ������������ (1)
      // �� ����������� (0).
      $weekday = date('w', $begin_day);
  
      // �������� ������� ������������ ��������� �����
      $current_date = $begin_day;
      while(floor(($last_day - $current_date)/24/60/60/7))
      {
        $where = "WHERE putdate >= '".date("Y-m-d", $current_date)."' AND
                        putdate < '" .date("Y-m-d", $current_date + 24*3600*(7 - $weekday))."'";
  
        $query = "SELECT SUM(visit1) AS visit1,
                         SUM(visit2) AS visit2,
                         SUM(visit3) AS visit3,
                         SUM(visit4) AS visit4,
                         SUM(visit5) AS visit5,
                         SUM(visit6) AS visit6,
                         SUM(visit7) AS visit7,
                         SUM(visit8) AS visit8,
                         SUM(visit9) AS visit9,
                         SUM(visit10) AS visit10,
                         SUM(visit20) AS visit20,
                         SUM(visit30) AS visit30,
                         SUM(visit40) AS visit40,
                         SUM(visit50) AS visit50,
                         SUM(visit60) AS visit60,
                         SUM(visit2h) AS visit2h,
                         SUM(visit3h) AS visit3h,
                         SUM(visit4h) AS visit4h,
                         SUM(visit5h) AS visit5h,
                         SUM(visit6h) AS visit6h,
                         SUM(visit7h) AS visit7h,
                         SUM(visit8h) AS visit8h,
                         SUM(visit9h) AS visit9h,
                         SUM(visit10h) AS visit10h,
                         SUM(visit11h) AS visit11h,
                         SUM(visit12h) AS visit12h,
                         SUM(visit13h) AS visit13h,
                         SUM(visit14h) AS visit14h,
                         SUM(visit15h) AS visit15h,
                         SUM(visit16h) AS visit16h,
                         SUM(visit17h) AS visit17h,
                         SUM(visit18h) AS visit18h,
                         SUM(visit19h) AS visit19h,
                         SUM(visit20h) AS visit20h,
                         SUM(visit21h) AS visit21h,
                         SUM(visit22h) AS visit22h,
                         SUM(visit23h) AS visit23h,
                         SUM(visit24h) AS visit24h
                  FROM $tbl_arch_time $where";
  
        $ses = mysql_query($query);
        if(!$ses)
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ ��������� ��������� - archive_time_week()");
        }
        if(mysql_num_rows($ses))
        {
          $total = mysql_fetch_array($ses);
  
          $sql_ip[] = "(NULL,
                     '".date("Y-m-d", $current_date)."',
                     '".date("Y-m-d", $current_date + 24*3600*(7 - $weekday))."',
                      $total[visit1], 
                      $total[visit2], 
                      $total[visit3], 
                      $total[visit4], 
                      $total[visit5], 
                      $total[visit6], 
                      $total[visit7], 
                      $total[visit8], 
                      $total[visit9], 
                      $total[visit10], 
                      $total[visit20], 
                      $total[visit30], 
                      $total[visit40], 
                      $total[visit50], 
                      $total[visit60], 
                      $total[visit2h], 
                      $total[visit3h], 
                      $total[visit4h], 
                      $total[visit5h], 
                      $total[visit6h], 
                      $total[visit7h], 
                      $total[visit8h], 
                      $total[visit9h], 
                      $total[visit10h], 
                      $total[visit11h], 
                      $total[visit12h], 
                      $total[visit13h], 
                      $total[visit14h], 
                      $total[visit15h], 
                      $total[visit16h], 
                      $total[visit17h], 
                      $total[visit18h], 
                      $total[visit19h], 
                      $total[visit20h], 
                      $total[visit21h], 
                      $total[visit22h], 
                      $total[visit23h], 
                      $total[visit24h])";
        }
  
        // ����������� ������� ����� �� ��������� ������
        $current_date += (7 - $weekday)*24*3600;
        $weekday = 0; // ����� ���� ����� �� ����� ������
      }
      if(!empty($sql_ip))
      {
        $query = "INSERT INTO $tbl_arch_time_week VALUES ".implode(",", $sql_ip);
        if(!mysql_query($query))
        {
         throw new ExceptionMySQL(mysql_error(), 
                                  $query,
                                  "������ ��������� ��������� - archive_time_week()");
        }
      }
    }
  }
  
  // ������� �������� ���������
  function archive_time_month($tbl_arch_time, $tbl_arch_time_month)
  {
    // ��������� ������ ����
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y")) + 2;
    // ������ ��������� ������
    $begin_day = begin_day_arch($tbl_arch_time, $tbl_arch_time_month);
    // ��������� ������� ������ ������ � ���� ��������� ���������
    $month = (floor(date("Y",$last_day) - date("Y",$begin_day)))*12 + 
             floor(date("m",$last_day) - date("m",$begin_day)); 
    // ���� ������ ������ ������ - ���������� ������
    if($month > 0)
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

        $where = "WHERE YEAR(putdate) = $year AND
                        MONTH(putdate) = '".sprintf("%02d",$month)."'";
  
        $query = "SELECT SUM(visit1) AS visit1,
                         SUM(visit2) AS visit2,
                         SUM(visit3) AS visit3,
                         SUM(visit4) AS visit4,
                         SUM(visit5) AS visit5,
                         SUM(visit6) AS visit6,
                         SUM(visit7) AS visit7,
                         SUM(visit8) AS visit8,
                         SUM(visit9) AS visit9,
                         SUM(visit10) AS visit10,
                         SUM(visit20) AS visit20,
                         SUM(visit30) AS visit30,
                         SUM(visit40) AS visit40,
                         SUM(visit50) AS visit50,
                         SUM(visit60) AS visit60,
                         SUM(visit2h) AS visit2h,
                         SUM(visit3h) AS visit3h,
                         SUM(visit4h) AS visit4h,
                         SUM(visit5h) AS visit5h,
                         SUM(visit6h) AS visit6h,
                         SUM(visit7h) AS visit7h,
                         SUM(visit8h) AS visit8h,
                         SUM(visit9h) AS visit9h,
                         SUM(visit10h) AS visit10h,
                         SUM(visit11h) AS visit11h,
                         SUM(visit12h) AS visit12h,
                         SUM(visit13h) AS visit13h,
                         SUM(visit14h) AS visit14h,
                         SUM(visit15h) AS visit15h,
                         SUM(visit16h) AS visit16h,
                         SUM(visit17h) AS visit17h,
                         SUM(visit18h) AS visit18h,
                         SUM(visit19h) AS visit19h,
                         SUM(visit20h) AS visit20h,
                         SUM(visit21h) AS visit21h,
                         SUM(visit22h) AS visit22h,
                         SUM(visit23h) AS visit23h,
                         SUM(visit24h) AS visit24h
                  FROM $tbl_arch_time $where";

        $tim = mysql_query($query);
        if(!$tim)
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ �������� ��������� - archive_time_month()");
        }
  
        if(mysql_num_rows($tim))
        {
          $total = mysql_fetch_array($tim);
          $sql_time[] = "(NULL,
                      '$year-".sprintf("%02d",$month)."-01',
                      $total[visit1], 
                      $total[visit2], 
                      $total[visit3], 
                      $total[visit4], 
                      $total[visit5], 
                      $total[visit6], 
                      $total[visit7], 
                      $total[visit8], 
                      $total[visit9], 
                      $total[visit10], 
                      $total[visit20], 
                      $total[visit30], 
                      $total[visit40], 
                      $total[visit50], 
                      $total[visit60], 
                      $total[visit2h], 
                      $total[visit3h], 
                      $total[visit4h], 
                      $total[visit5h], 
                      $total[visit6h], 
                      $total[visit7h], 
                      $total[visit8h], 
                      $total[visit9h], 
                      $total[visit10h], 
                      $total[visit11h], 
                      $total[visit12h], 
                      $total[visit13h], 
                      $total[visit14h], 
                      $total[visit15h], 
                      $total[visit16h], 
                      $total[visit17h], 
                      $total[visit18h], 
                      $total[visit19h], 
                      $total[visit20h], 
                      $total[visit21h], 
                      $total[visit22h], 
                      $total[visit23h], 
                      $total[visit24h])";
        }
      }
      // ��������� ������������� ������� � ��������� ��
      if(!empty($sql_time))
      {
        $query = "INSERT INTO $tbl_arch_time_month VALUES ".implode(",", $sql_time);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ �������� ��������� - archive_time_month()");
        }
      }
    }
  }
?>