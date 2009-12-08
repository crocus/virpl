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
  function archive_ip($tbl_ip, $tbl_arch_ip)
  {
    // ��������� ������ ����
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
    // ������ ��������� ������
    $begin_day = begin_day_arch($tbl_ip, $tbl_arch_ip);
    // ���������� ����, ���������� ���������
    $days = floor(($last_day - $begin_day)/24/60/60);
    // ���� ���������
    if($days)
    {
      // ����� ������������ IP-������� �� �������
      $ip_number = IP_NUMBER;
      for ($i = $days - 1; $i >= 0; $i--)
      {
        // ������������ ���������� ��������� �� ����� 
        $query = "SELECT ip, COUNT(ip) AS total FROM $tbl_ip
                  WHERE putdate LIKE '".date("Y-m-d", $last_day - $i*24*3600)."%'
                  GROUP BY ip
                  ORDER BY total DESC 
                  LIMIT $ip_number";

        $ipc = mysql_query($query);
        if(!$ipc)
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ �������� ��������� - archive_ip()");
        }
        if(mysql_num_rows($ipc))
        {
          while($ip = mysql_fetch_array($ipc))
          {
            $sql_ip[] = "(NULL,
                         '".date("Y-m-d", $last_day - $i*24*3600)."',
                         '$ip[ip]',
                          $ip[total])";
          }
        }
      }
      if(!empty($sql_ip))
      {
        $query = "INSERT INTO $tbl_arch_ip VALUES ".implode(",", $sql_ip);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ �������� ��������� - archive_ip()");
        }
      }
    }
  }
  
  function archive_ip_week($tbl_arch_ip, $tbl_arch_ip_week)
  {
    // ��������� ������ ����
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
    // ������ ��������� ������
    $begin_day = begin_day_arch($tbl_arch_ip, $tbl_arch_ip_week, 'putdate_begin');
    // ��������� ������� ������ ������ � ���� ��������� ���������
    $week = floor(($last_day - $begin_day)/24/60/60/7);
    // ���� ������ ������ ������ - ���������� ������
    if ($week > 0)
    {
      // $begin_day - ���� ��������� ���������... - ������� ������ �� ��
      // ����� ������ (�����������). �������� �������� ������ � ������������ (1)
      // �� ����������� (0).
      $weekday = date('w', $begin_day);

      $ip_number = IP_NUMBER;
  
      // �������� ������� ������������ ��������� �����
      $current_date = $begin_day;
      while(floor(($last_day - $current_date)/24/60/60/7))
      {
        $where = "WHERE putdate > '".date("Y-m-d", $current_date)."' AND
                        putdate <= '".date("Y-m-d", $current_date + 24*3600*(7 - $weekday))."'";
  
        // ��������� $ip_number ����� �������� IP-������� �� ������
        $query = "SELECT ip, SUM(total) AS total FROM $tbl_arch_ip 
                  $where
                  GROUP BY ip 
                  ORDER BY total DESC 
                  LIMIT $ip_number";
  
        $ipc = mysql_query($query);
        if(!$ipc)
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ ��������� ��������� - archive_refferer_week()");
        }
        if(mysql_num_rows($ipc))
        {
          while($ip = mysql_fetch_array($ipc))
          {
            $sql_ip[] = "(NULL,
                         '".date("Y-m-d", $current_date)."',
                         '".date("Y-m-d", $current_date + 24*3600*(7 - $weekday))."', 
                         $ip[ip], 
                         $ip[total])";
          }
        }
  
        // ����������� ������� ����� �� ��������� ������
        $current_date += (7 - $weekday)*24*3600;
        $weekday = 0; // ����� ���� ����� �� ����� ������
      }
  
      if(!empty($sql_ip))
      {
        $query = "INSERT INTO $tbl_arch_ip_week VALUES".implode(",", $sql_ip);
        if(!mysql_query($query))
        {
         throw new ExceptionMySQL(mysql_error(), 
                                  $query,
                                 "������ ��������� ��������� - archive_ip_week()");
        }
      }
    }
  }
  
  // ������� �������� ���������
  function archive_ip_month($tbl_arch_ip, $tbl_arch_ip_month)
  {
    // ��������� ������ ����
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y")) + 2;
    // ������ ��������� ������
    $begin_day = begin_day_arch($tbl_arch_ip, $tbl_arch_ip_month);
    // ��������� ������� ������ ������ � ���� ��������� ���������
    $month = (floor(date("Y",$last_day) - date("Y",$begin_day)))*12 + 
             floor(date("m",$last_day) - date("m",$begin_day)); 
    // ���� ������ ������ ������ - ���������� ������
    if($month > 0)
    {
      $ip_number = IP_NUMBER;
  
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
  
        // ��������� $ip_number ����� �������� IP-������� �� �����
        $query = "SELECT ip, SUM(total) AS total FROM $tbl_arch_ip 
                  $where
                  GROUP BY ip 
                  ORDER BY total DESC 
                  LIMIT $ip_number";
  
        $ipc = mysql_query($query);
        if(!$ipc)
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ �������� ��������� - archive_ip_month()");
        }
  
        if(mysql_num_rows($ipc))
        {
          while($ip = mysql_fetch_array($ipc))
          {
            $sql_ip[] = "(NULL,
                        '$year-".sprintf("%02d",$month)."-01',
                         $ip[ip], 
                         $ip[total])";
          }
        }
      }
  
      if(!empty($sql_ip))
      {
        $query = "INSERT INTO $tbl_arch_ip_month VALUES".implode(",", $sql_ip);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ �������� ��������� - archive_ip_month()");
        }
      }
    }
  }
?>