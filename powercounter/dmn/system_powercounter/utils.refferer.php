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
  function archive_refferer($tbl_refferer, $tbl_arch_refferer)
  {
    // ��������� ������ ����
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
    // ������ ��������� ������
    $begin_day = begin_day_arch($tbl_refferer, $tbl_arch_refferer);
    // ���������� ����, ���������� ���������
    $days = floor(($last_day - $begin_day)/24/60/60);
    // ���� ���������
    if($days)
    {
      $referer_number = REFFERER_NUMBER;
      for ($i = $days - 1; $i >= 0; $i--)
      {
        // ������������ ���������� ��������� �� ����� 
        $query = "SELECT name, COUNT(name) AS total FROM $tbl_refferer 
                  WHERE putdate LIKE '".date("Y-m-d", $last_day - $i*24*3600)."%'
                  GROUP BY name 
                  ORDER BY total DESC 
                  LIMIT $referer_number";
  
        $ref = mysql_query($query);
        if(!$ref)
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ �������� ��������� - archive_refferer()");
        }
        if(mysql_num_rows($ref))
        {
          while($referrer = mysql_fetch_array($ref))
          {
            $referrer['name'] = mysql_escape_string($referrer['name']);
            $sql_referrer[] = "(NULL,
                              '".date("Y-m-d", $last_day - $i*24*3600)."',
                              '$referrer[name]',
                                $referrer[total])";
          }
        }
      }
      if(!empty($sql_referrer))
      {
        $query = "INSERT INTO $tbl_arch_refferer VALUES ".implode(",", $sql_referrer);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ �������� ��������� - archive_refferer()");
        }
      }
    }
  }
  
  // ������� ��������� ��������� � ��������� �������
  function archive_refferer_week($tbl_arch_refferer, $tbl_arch_refferer_week)
  {
    // ��������� ������ ����
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
    // ������ ��������� ������
    $begin_day = begin_day_arch($tbl_arch_refferer, $tbl_arch_refferer_week, 'putdate_begin');
    // ��������� ������� ������ ������ � ���� ��������� ���������
    $week = floor(($last_day - $begin_day)/24/60/60/7);
    // ���� ������ ������ ������ - ���������� ������
    if ($week > 0)
    {
      // $begin_day - ���� ��������� ���������... - ������� ������ �� ��
      // ����� ������ (�����������). �������� �������� ������ � ������������ (1)
      // �� ����������� (0).
      $weekday = date('w', $begin_day);

      $referer_number = REFFERER_NUMBER;
  
      // �������� ������� ������������ ��������� �����
      $current_date = $begin_day;
      while(floor(($last_day - $current_date)/24/60/60/7))
      {
        $where = "WHERE putdate > '".date("Y-m-d", $current_date)."' AND
                        putdate <= '".date("Y-m-d", $current_date + 24*3600*(7 - $weekday))."'";
  
        // ��������� $referer_number ����� �������� ��������� �� ������
        $query = "SELECT name, SUM(total) AS total FROM $tbl_arch_refferer 
                  $where
                  GROUP BY name 
                  ORDER BY total DESC 
                  LIMIT $referer_number";
  
        $ref = mysql_query($query);
        if(!$ref)
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ ��������� ��������� - archive_refferer_week()");
        }
        if(mysql_num_rows($ref))
        {
          while($referrer = mysql_fetch_array($ref))
          {
            $referrer['name'] = mysql_escape_string($referrer['name']);
            $sql_referrer[] = "(NULL,
                                '".date("Y-m-d", $current_date)."',
                                '".date("Y-m-d", $current_date + 24*3600*(7 - $weekday))."', 
                                '$referrer[name]',
                                $referrer[total])";
          }
        }
  
        // ����������� ������� ����� �� ��������� ������
        $current_date += (7 - $weekday)*24*3600;
        $weekday = 0; // ����� ���� ����� �� ����� ������
      }
  
      // ��������� ������������� ������ � ��������� ���
      if(!empty($sql_referrer))
      {
        $query = "INSERT INTO $tbl_arch_refferer_week VALUES ".implode(",", $sql_referrer);
        if(!mysql_query($query))
        {
         throw new ExceptionMySQL(mysql_error(), 
                                  $query,
                                 "������ ��������� ��������� - archive_refferer_week()");
        }
      }
    }
  }
  
  // ������� �������� ���������
  function archive_refferer_month($tbl_arch_refferer, $tbl_arch_refferer_month)
  {
    // ��������� ������ ����
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y")) + 2;
    // ������ ��������� ������
    $begin_day = begin_day_arch($tbl_arch_refferer, $tbl_arch_refferer_month);
    // ��������� ������� ������ ������ � ���� ��������� ���������
    $month = (floor(date("Y",$last_day) - date("Y",$begin_day)))*12 + 
             floor(date("m",$last_day) - date("m",$begin_day)); 
    // ���� ������ ������ ������ - ���������� ������
    if($month > 0)
    {
      $referer_number = REFFERER_NUMBER;
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
  
        // ��������� $referer_number ����� �������� IP-������� ��������� �� �����
        $query = "SELECT name, SUM(total) AS total FROM $tbl_arch_refferer 
                  $where
                  GROUP BY name 
                  ORDER BY total DESC 
                  LIMIT $referer_number";
  
        $ref = mysql_query($query);
        if(!$ref)
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ �������� ��������� - archive_refferer_month()");
        }
        if(mysql_num_rows($ref))
        {
          while($referrer = mysql_fetch_array($ref))
          {
            $referrer['name'] = mysql_escape_string($referrer['name']);
            $sql_referrer[] = "(NULL,
                                '$year-".sprintf("%02d",$month)."-01',
                                '$referrer[name]',
                                $referrer[total])";
          }
        }
      }
  
      // ��������� ������������� ������ � ��������� ���
      if(!empty($sql_referrer))
      {
        $query = "INSERT INTO $tbl_arch_refferer_month VALUES ".implode(",", $sql_referrer);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "������ �������� ��������� - archive_refferer_month()");
        }
      }
    }
  }
?>