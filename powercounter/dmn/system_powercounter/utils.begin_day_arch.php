<?php
  ////////////////////////////////////////////////////////////
  // ������� ����� ������������ ����� - PowerCounter
  // 2003-2008 (C) IT-������ SoftTime (http://www.softtime.ru)
  // ���������: http://www.softtime.ru/forum/
  // �������� �.�. (simdyanov@softtime.ru)
  // ����� �.�. (loki_angel@mail.ru)
  // �������� �.�. (kuznetsov@softtime.ru)
  // ������� �.�. (softtime@softtime.ru)
  ////////////////////////////////////////////////////////////
  // ��������� ���������������� ����
  function begin_day_arch($tbl, $tbl_arch, $column = 'putdate')
  {
    // �����
    if(substr($tbl_arch, -5) == 'month') $interval = '+ INTERVAL 1 MONTH';
    // ������
    if(substr($tbl_arch, -4) == 'week') $interval = '+ INTERVAL 1 WEEK';

    // �������� ��������� ����, ������� ���� ��������������
    $query = "SELECT UNIX_TIMESTAMP(MAX($column{$interval})) FROM $tbl_arch";
    $last_date = query_result($query);
    if(empty($last_date))
    {
      $query = "SELECT UNIX_TIMESTAMP(MIN(putdate)) AS data FROM $tbl";
      $begin_date = query_result($query);
      if(!empty($begin_date))
      {
        // ���� ������ ������ - ���� ���� �� $tbl 
        $last_date = $begin_date;
      }
      else
      {
        // ����� ���� ������� �����
        $last_date = time();
      }
    }
    return $last_date;
  }
?>