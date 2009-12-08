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
  function archive_deep($tbl_ip, $tbl_arch_deep)
  {
    // ��������� ������ ����
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
    // ������ ��������� ������
    $begin_day = begin_day_arch($tbl_ip, $tbl_arch_deep);
    // ���������� ����, ���������� ���������
    $days = floor(($last_day - $begin_day)/24/60/60);
    // ���� ���������
    if($days)
    {
      for ($i = $days - 1; $i >= 0; $i--)
      {
        $where = "WHERE putdate LIKE '".date("Y-m-d", $last_day - $i*24*3600)."%' AND
                        systems != 'none' AND browsers  != 'none'";
  
        // ������� ���������: 1, 2, 3, 4, 5, 6, 7, 8, 9, 10
        for($j = 1; $j < 11; $j++)
        {
          $query_visit[] = "SELECT COUNT(id_ip) AS total
                      FROM $tbl_ip 
                      $where
                      GROUP BY ip
                      HAVING COUNT(id_ip) = $j";
        }
        // ������� ���������: 11-20, 21-30, ..., 91-100
        for($j = 10; $j < 100; $j = $j + 10)
        {
          $query_visit[] = "SELECT COUNT(id_ip) AS total
                      FROM $tbl_ip 
                      $where
                      GROUP BY ip
                      HAVING COUNT(id_ip) > $j AND
                             COUNT(id_ip) <= ".($j + 10);
        }
        // ������� ���������: > 100
        $query_visit[] = "SELECT COUNT(id_ip) AS total
                    FROM $tbl_ip 
                    $where
                    GROUP BY ip
                    HAVING COUNT(id_ip) > 100";
        // ������������ ������� � ���� ������
        foreach($query_visit as $query)
        {
          $ses = mysql_query($query);
          if(!$ses)
          {
             throw new ExceptionMySQL(mysql_error(), 
                                      $query,
                                     "������ �������� ��������� - archive_deep()");
          }
          $total[] = mysql_num_rows($ses);
        }
  
        // ��������� ������ ��� �������� IP-������� � ������� $tbl_arch_deep
        $sql_ip[] = "(NULL,'".date("Y-m-d", $last_day - $i*24*3600)."', ".implode(",",$total).")";
        unset($query_visit, $total);
      }
      if(!empty($sql_ip))
      {
        $query = "INSERT INTO $tbl_arch_deep VALUES".implode(",", $sql_ip);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                    "������ �������� ��������� - archive_deep()");
        }
      }
    }
  }
  
  // ������� ��������� ���������
  function archive_deep_week($tbl_arch_deep, $tbl_arch_deep_week)
  {
    // ��������� ������ ����
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
    // ������ ��������� ������
    $begin_day = begin_day_arch($tbl_arch_deep, $tbl_arch_deep_week, 'putdate_begin');
    // ��������� ������� ������ ������ � ���� ��������� ���������
    $week = floor(($last_day - $begin_day)/24/60/60/7);
    // ���� ������ ������ ������ - ���������� ������
    if($week > 0)
    {
      // $last_date - ���� ��������� ���������... - ������� ������ �� ��
      // ����� ������ (�����������). �������� �������� ������ � ������������ (1)
      // �� ����������� (0).
      $weekday = date('w',$last_date);
  
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
                         SUM(visit70) AS visit70,
                         SUM(visit80) AS visit80,
                         SUM(visit90) AS visit90,
                         SUM(visit100) AS visit100,
                         SUM(visitmore) AS visitmore
                  FROM $tbl_arch_deep $where ";
  
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
                      $total[visit70], 
                      $total[visit80], 
                      $total[visit90], 
                      $total[visit100],
                      $total[visitmore])";
        }
        // ����������� ������� ����� �� ��������� ������
        $current_date += (7 - $weekday)*24*3600;
        $weekday = 0; // ����� ���� ����� �� ����� ������
      }
      if(!empty($sql_ip))
      {
        $query = "INSERT INTO $tbl_arch_deep_week VALUES".implode(",", $sql_ip);
        if(!mysql_query($query))
        {
         throw new ExceptionMySQL(mysql_error(), 
                                  $query,
                                  "������ ��������� ��������� - archive_deep_week");
        }
      }
    }
  }
  
  // ������� �������� ���������
  function archive_deep_month($tbl_arch_deep, $tbl_arch_deep_month)
  {
    // ��������� ������ ����
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y")) + 2;
    // ������ ��������� ������
    $begin_day = begin_day_arch($tbl_arch_deep, $tbl_arch_deep_month);
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
                         SUM(visit70) AS visit70,
                         SUM(visit80) AS visit80,
                         SUM(visit90) AS visit90,
                         SUM(visit100) AS visit100,
                         SUM(visitmore) AS visitmore
                  FROM $tbl_arch_deep $where";
        $ses = mysql_query($query);
        if(!$ses)
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ �������� ��������� - archive_deep_month()");
        }
  
        if(mysql_num_rows($ses))
        {
          $total = mysql_fetch_array($ses);
  
          $sql_deep[] = "(NULL,
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
                      $total[visit70], 
                      $total[visit80], 
                      $total[visit90], 
                      $total[visit100],
                      $total[visitmore])";
        }
      }
      // ��������� ������������� ������� � ��������� ��
      if(!empty($sql_deep))
      {
        $query = "INSERT INTO $tbl_arch_deep_month VALUES".implode(",", $sql_deep);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ �������� ��������� - archive_deep_month()");
        }
      }
    }
  }
?>