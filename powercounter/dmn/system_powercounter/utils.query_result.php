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
  function query_result($query)
  {
    $tot = mysql_query($query);
    if(!$tot)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ���������� �������");
    }
    if(mysql_num_rows($tot))
    {
      return @mysql_result($tot, 0);
    }
    else
    {
      return false;
    }
  }
?>