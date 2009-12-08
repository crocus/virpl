<?php
  ////////////////////////////////////////////////////////////
  // Система учёта посещаемости сайта - PowerCounter
  // 2003-2008 (C) IT-студия SoftTime (http://www.softtime.ru)
  // Поддержка: http://www.softtime.ru/forum/
  // Симдянов И.В. (simdyanov@softtime.ru)
  // Левин А.В. (loki_angel@mail.ru)
  // Кузнецов М.В. (kuznetsov@softtime.ru)
  // Голышев С.В. (softtime@softtime.ru)
  ////////////////////////////////////////////////////////////
  function query_result($query)
  {
    $tot = mysql_query($query);
    if(!$tot)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "Ошибка выполнения запроса");
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