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
  function archive_hit_hosts($tbl_ip, $tbl_arch_hits)
  {
    // ��������� ������ ����
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
    // ������ ��������� ������
    $begin_day = begin_day_arch($tbl_ip, $tbl_arch_hits);
    // ���������� ����, ���������� ���������
    $days = floor(($last_day - $begin_day)/24/60/60);
    // ���� ���������
    if($days)
    {
      for ($i = $days - 1; $i >= 0; $i--)
      {
        $end = " putdate LIKE '".date("Y-m-d", $last_day - $i*24*3600)."%'";
  
        // ����� ���������� ����� �� �����
        $query_total_hit = "SELECT COUNT(*) FROM $tbl_ip WHERE $end";
        // ����������� ���� �� �����
        $query_hit = "SELECT COUNT(*) FROM $tbl_ip WHERE systems != 'none' AND $end";
        // ������������ ����� IP-������� (������) �� �����
        $query_total_host = "SELECT COUNT(DISTINCT ip) FROM $tbl_ip WHERE $end";
        // ������������ ����� ������ IP-������� (������) �� �����
        $query_host = "SELECT COUNT(DISTINCT ip) FROM $tbl_ip WHERE
                         systems != 'none' AND
                         systems != 'robot_yandex' AND
                         systems != 'robot_google' AND
                         systems != 'robot_rambler' AND
                         systems != 'robot_aport' AND
                         systems != 'robot_msnbot' AND  $end";
  
        // ��������� ������ ��� ��������� ����� � ������ � ������� $tbl_arch_hits
        $totalhists = query_result($query_total_hit);
        $hists      = query_result($query_hit);
        $totalhosts = query_result($query_total_host);
        $hosts      = query_result($query_host);
        $sql_hits[] = "(NULL, 
                       '".date("Y-m-d", $last_day - $i*24*3600)."',
                       $totalhosts, 
                       $hosts, 
                       $totalhists, 
                       $hists)";
  
      }
      if(!empty($sql_hits))
      {
        $query = "INSERT INTO $tbl_arch_hits VALUES".implode(",", $sql_hits);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ �������� ��������� - archive_hit_hosts()");
        }
      }
    }
  }
  
  // ������� ��������� ���������
  function archive_hit_hosts_week($tbl_arch_hits, $tbl_arch_hits_week)
  {
    // ��������� ������ ����
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
    // ������ ��������� ������
    $begin_day = begin_day_arch($tbl_arch_hits, $tbl_arch_hits_week, 'putdate_begin');
    // ��������� ������� ������ ������ � ���� ��������� ���������
    $week = floor(($last_day - $begin_day)/24/60/60/7);
    // ���� ������ ������ ������ - ���������� ������
    if($week > 0)
    {
      // $begin_day - ���� ��������� ���������... - ������� ������ �� ��
      // ����� ������ (�����������). �������� �������� ������ � ������������ (1)
      // �� ����������� (0).
      $weekday = date('w', $begin_day);
  
      // �������� ������� ������������ ��������� �����
      $current_date = $begin_day;
      while(floor(($last_day - $current_date)/24/60/60/7))
      {
        $end = "FROM $tbl_arch_hits
                WHERE putdate > '".date("Y-m-d", $current_date)."' AND
                      putdate <= '".date("Y-m-d", $current_date + 24*3600*(7 - $weekday))."'";
  
        // ������������ ���������� ��������� �� ������
        $total_hit  = query_result("SELECT SUM(hits_total) $end");
        $hit        = query_result("SELECT SUM(hits) $end");
        $total_host = query_result("SELECT SUM(hosts_total) $end");
        $host       = query_result("SELECT SUM(host) $end");
        $sql_hits[] = "(NULL,
                       '".date("Y-m-d", $current_date)."',
                       '".date("Y-m-d", $current_date + 24*3600*(7 - $weekday))."',
                       $total_host, $host, $total_hit, $hit)";
  
        // ����������� ������� ����� �� ��������� ������
        $current_date += (7 - $weekday)*24*3600;
        $weekday = 0; // ����� ���� ����� �� ����� ������
      }
  
      // ��������� ������������� ������� � ��������� ��
      if(!empty($sql_hits))
      {
        $query = "INSERT INTO $tbl_arch_hits_week VALUES".implode(",", $sql_hits);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ ��������� ��������� - archive_hit_hosts_week()");
        }
      }
    }
  }
  
  // ������� ��������� ������, ����� � ��������� �������
  function archive_hit_hosts_month($tbl_arch_hits, $tbl_arch_hits_month)
  {
    // ��������� ������ ����
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y")) + 2;
    // ������ ��������� ������
    $begin_day = begin_day_arch($tbl_arch_hits, $tbl_arch_hits_month);
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

        $end = "FROM $tbl_arch_hits
                WHERE YEAR(putdate) = $year AND
                      MONTH(putdate) = '".sprintf("%02d",$month)."'";
  
        // ������������ ���������� ��������� �� �����
        $total_hit      = query_result("SELECT SUM(hits_total) $end");
        $hit            = query_result("SELECT SUM(hits) $end");
        $total_host     = query_result("SELECT SUM(hosts_total) $end");
        $host           = query_result("SELECT SUM(host) $end");

        // ��������� ������ ��� �������� �������
        $sql_hits[] = "(NULL,
                      '$year-".sprintf("%02d",$month)."-01',
                       $total_host, $host, $total_hit, $hit)";
      }
  
      // ��������� ������������� ������� � ��������� ��
      if(!empty($sql_hits))
      {
        $query = "INSERT INTO $tbl_arch_hits_month VALUES".implode(",", $sql_hits);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ �������� ��������� - archive_hit_hosts_month()");
        }
      }
    }
  }
?>