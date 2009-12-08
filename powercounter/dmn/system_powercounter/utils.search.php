<?php
  ////////////////////////////////////////////////////////////
  // Система учёта посещаемости сайта - PowerCounter
  // 2003-2008 (C) IT-студия SoftTime (http://www.softtime.ru)
  // Поддержка: http://www.softtime.ru/forum/
  // Симдянов И.В. (simdyanov@softtime.ru)
  // Кузнецов М.В. (kuznetsov@softtime.ru)
  // Левин А.В (loki_angel@mail.ru)
  // Голышев С.В. (softtime@softtime.ru)
  ////////////////////////////////////////////////////////////
  // Выставляем уровень обработки ошибок 
  // (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE); 

  // Функция суточной архивации
  function archive_searchquery($tbl_searchquerys, $tbl_arch_searchquery)
  {
    // Последний полный день
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
    // Начало архивации данных
    $begin_day = begin_day_arch($tbl_searchquerys, $tbl_arch_searchquery);
    // Количество дней, подлежащих архивации
    $days = floor(($last_day - $begin_day)/24/60/60);
    // Блок архивации
    if($days)
    {
      $yandex_number  = YANDEX_NUMBER;
      $rambler_number = RAMBLER_NUMBER;
      $google_number  = GOOGLE_NUMBER;
      $aport_number   = APORT_NUMBER;
      $msn_number     = MSN_NUMBER;
  
      for ($i = $days - 1; $i >= 0; $i--)
      {
        // Вспомогательное условие
        $tmp = "putdate LIKE '".date("Y-m-d", $last_day - $i*24*3600)."%'";
  
        // Извлекаем $xxx_number самых распространённых запросов за сутки
        $query_yandex = "SELECT query, COUNT(query) AS total FROM $tbl_searchquerys 
                         WHERE searches = 'yandex' AND $tmp
                         GROUP BY query 
                         ORDER BY total DESC 
                         LIMIT $yandex_number";
        // Извлекаем $xxx_number самых распространённых запросов за сутки
        $query_rambler = "SELECT query, COUNT(query) AS total FROM $tbl_searchquerys 
                         WHERE searches = 'rambler' AND $tmp
                         GROUP BY query 
                         ORDER BY total DESC 
                         LIMIT $rambler_number";
        // Извлекаем $xxx_number самых распространённых запросов за сутки
        $query_google  = "SELECT query, COUNT(query) AS total FROM $tbl_searchquerys 
                         WHERE searches = 'google' AND $tmp
                         GROUP BY query 
                         ORDER BY total DESC 
                         LIMIT $google_number";
        // Извлекаем $xxx_number самых распространённых запросов за сутки
        $query_aport   = "SELECT query, COUNT(query) AS total FROM $tbl_searchquerys 
                         WHERE searches = 'aport' AND $tmp
                         GROUP BY query 
                         ORDER BY total DESC 
                         LIMIT $aport_number";
        // Извлекаем $xxx_number самых распространённых запросов за сутки
        $query_msn     = "SELECT query, COUNT(query) AS total FROM $tbl_searchquerys 
                         WHERE searches = 'msn' AND $tmp
                         GROUP BY query 
                         ORDER BY total DESC 
                         LIMIT $msn_number";
  
        $ynd = mysql_query($query_yandex);
        if(!$ynd)
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "Ошибка суточной архивации - archive_searchquery()");
        }
        $gog = mysql_query($query_google);
        if(!$gog)
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "Ошибка суточной архивации - archive_searchquery()");
        }
        $rbl = mysql_query($query_rambler);
        if(!$rbl)
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "Ошибка суточной архивации - archive_searchquery()");
        }
        $apt = mysql_query($query_aport);
        if(!$apt)
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "Ошибка суточной архивации - archive_searchquery()");
        }
        $msn = mysql_query($query_msn);
        if(!$msn)
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "Ошибка суточной архивации - archive_searchquery()");
        }
  
        // Формируем запрос для ахивации наиболее частых запросов в таблицу $tbl_arch_searchquery
        while($yandex = mysql_fetch_array($ynd))
        {
          $yandex['query'] = mysql_escape_string($yandex['query']);
          $sql_yandex[] = "(NULL,
                           '".date("Y-m-d", $last_day - $i*24*3600)."',
                           '$yandex[query]', 
                           $yandex[total],
                           'yandex')";
        }
        while($google = mysql_fetch_array($gog))
        {
          $google['query'] = mysql_escape_string($google['query']);
          $sql_google[] = "(NULL,
                           '".date("Y-m-d", $last_day - $i*24*3600)."',
                           '$google[query]', 
                           $google[total],
                           'google')";
        }
        while($rambler = mysql_fetch_array($rbl))
        {
          $rambler['query'] = mysql_escape_string($rambler['query']);
          $sql_rambler[] = "(NULL,
                           '".date("Y-m-d", $last_day - $i*24*3600)."',
                           '$rambler[query]', 
                           $rambler[total],
                           'rambler')";
        }
        while($aport = mysql_fetch_array($apt))
        {
          $aport['query'] = mysql_escape_string($aport['query']);
          $sql_aport[] = "(NULL,
                           '".date("Y-m-d", $last_day - $i*24*3600)."',
                           '$aport[query]', 
                           $aport[total],
                           'aport')";
        }
        while($ms = mysql_fetch_array($msn))
        {
          $ms['query'] = mysql_escape_string($ms['query']);
          $sql_msn[] = "(NULL,
                           '".date("Y-m-d", $last_day - $i*24*3600)."',
                           '$ms[query]', 
                           $ms[total],
                           'aport')";
        }
      }
      if(!empty($sql_yandex))
      {
        $query = "INSERT INTO $tbl_arch_searchquery VALUES".implode(",", $sql_yandex);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "Ошибка суточной архивации - archive_searchquery()");
        }
      }
      if(!empty($sql_google))
      {
        $query = "INSERT INTO $tbl_arch_searchquery VALUES".implode(",", $sql_google);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "Ошибка суточной архивации - archive_searchquery()");
        }
      }
      if(!empty($sql_rambler))
      {
        $query = "INSERT INTO $tbl_arch_searchquery VALUES".implode(",", $sql_rambler);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "Ошибка суточной архивации - archive_searchquery()");
        }
      }
      if(!empty($sql_aport))
      {
        $query = "INSERT INTO $tbl_arch_searchquery VALUES".implode(",", $sql_aport);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "Ошибка суточной архивации - archive_searchquery()");
        }
      }
      if(!empty($sql_msn))
      {
        $query = "INSERT INTO $tbl_arch_searchquery VALUES".implode(",", $sql_msn);
        if(!mysql_query($query))
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "Ошибка суточной архивации - archive_searchquery()");
        }
      }
    }
  }
  
  // Функция недельной архивации
  function archive_searchquery_week($tbl_arch_searchquery, $tbl_arch_searchquery_week)
  {
    // Последний полный день
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
    // Начало архивации данных
    $begin_day = begin_day_arch($tbl_arch_searchquery, $tbl_arch_searchquery_week, 'putdate_begin');
    // Вычисляем сколько недель прошло с даты последней архивации
    $week = floor(($last_day - $begin_day)/24/60/60/7);
    // Если прошло больше недели - архивируем данные
    if ($week > 0)
    {
      // $begin_day - дата последней архивации... - смотрим далеко ли до
      // конца недели (воскресенье). Интервал включает данные с Понедельника (1)
      // до воскресенья (0).
      $weekday = date('w', $begin_day);
  
      $yandex_number  = YANDEX_NUMBER;
      $rambler_number = RAMBLER_NUMBER;
      $google_number  = GOOGLE_NUMBER;
      $aport_number   = APORT_NUMBER;
      $msn_number     = MSN_NUMBER;
  
      // Текущему времени приравниваем начальную точку
      $current_date = $begin_day;
      while(floor(($last_day - $current_date)/24/60/60/7))
      {
        $where = "WHERE putdate > '".date("Y-m-d", $current_date)."' AND
                        putdate <= '".date("Y-m-d", $current_date + 24*3600*(7 - $weekday))."'";
  
        // Извлекаем $xxx_number самых распространённых запросов за неделю
        $query_yandex = "SELECT name, SUM(total) AS total FROM $tbl_arch_searchquery 
                         $where AND searches = 'yandex'
                         GROUP BY name 
                         ORDER BY total DESC 
                         LIMIT $yandex_number";
        // Извлекаем $xxx_number самых распространённых запросов за неделю
        $query_rambler = "SELECT name, SUM(total) AS total FROM $tbl_arch_searchquery 
                         $where AND searches = 'rambler'
                         GROUP BY name 
                         ORDER BY total DESC 
                         LIMIT $rambler_number";
        // Извлекаем $xxx_number самых распространённых запросов за неделю
        $query_google  = "SELECT name, SUM(total) AS total FROM $tbl_arch_searchquery 
                         $where AND searches = 'google'
                         GROUP BY name 
                         ORDER BY total DESC 
                         LIMIT $google_number";
        // Извлекаем $xxx_number самых распространённых запросов за неделю
        $query_aport   = "SELECT name, SUM(total) AS total FROM $tbl_arch_searchquery 
                         $where AND searches = 'aport'
                         GROUP BY name 
                         ORDER BY total DESC 
                         LIMIT $aport_number";
        // Извлекаем $xxx_number самых распространённых запросов за неделю
        $query_msn     = "SELECT name, SUM(total) AS total FROM $tbl_arch_searchquery 
                         $where AND searches = 'msn'
                         GROUP BY name 
                         ORDER BY total DESC 
                         LIMIT $msn_number";
  
        $ynd = mysql_query($query_yandex);
        if(!$ynd)
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "Ошибка недельной архивации - archive_searchquery_week()");
        }
        $gog = mysql_query($query_google);
        if(!$gog)
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "Ошибка недельной архивации - archive_searchquery_week()");
        }
        $rbl = mysql_query($query_rambler);
        if(!$rbl)
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "Ошибка недельной архивации - archive_searchquery_week()");
        }
        $apt = mysql_query($query_aport);
        if(!$apt)
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "Ошибка недельной архивации - archive_searchquery_week()");
        }
        $msn = mysql_query($query_msn);
        if(!$msn)
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "Ошибка недельной архивации - archive_searchquery_week()");
        }
  
        // Формируем запрос для ахивации наиболее частых запросов в таблицу $tbl_arch_searchquery_week
        while($yandex = mysql_fetch_array($ynd))
        {
          $yandex['name'] = mysql_escape_string($yandex['name']);
          $sql_yandex[] = "(NULL,
                           '".date("Y-m-d", $current_date)."',
                           '".date("Y-m-d", $current_date + 24*3600*(7 - $weekday))."', 
                           '$yandex[name]', 
                           $yandex[total],
                           'yandex')";
        }
        while($google = mysql_fetch_array($gog))
        {
          $google['name'] = mysql_escape_string($google['name']);
          $sql_google[] = "(NULL,
                           '".date("Y-m-d", $current_date)."',
                           '".date("Y-m-d", $current_date + 24*3600*(7 - $weekday))."', 
                           '$google[name]', 
                           $google[total],
                           'google')";
        }
        while($rambler = mysql_fetch_array($rbl))
        {
          $rambler['name'] = mysql_escape_string($rambler['name']);
          $sql_rambler[] = "(NULL,
                           '".date("Y-m-d", $current_date)."',
                           '".date("Y-m-d", $current_date + 24*3600*(7 - $weekday))."', 
                           '$rambler[name]', 
                           $rambler[total],
                           'rambler')";
        }
        while($aport = mysql_fetch_array($apt))
        {
          $aport['name'] = mysql_escape_string($aport['name']);
          $sql_aport[] = "(NULL,
                           '".date("Y-m-d", $current_date)."',
                           '".date("Y-m-d", $current_date + 24*3600*(7 - $weekday))."', 
                           '$aport[name]', 
                           $aport[total],
                           'aport')";
        }
        while($ms = mysql_fetch_array($msn))
        {
          $ms['name'] = mysql_escape_string($ms['name']);
          $sql_msn[] = "(NULL,
                           '".date("Y-m-d", $current_date)."',
                           '".date("Y-m-d", $current_date + 24*3600*(7 - $weekday))."', 
                           '$ms[name]', 
                           $ms[total],
                           'msn')";
        }
  
        // Увеличиваем текущее время до следующей недели
        $current_date += (7 - $weekday)*24*3600;
        $weekday = 0; // Далее идут циклы по целой недели
      }
  
      if(!empty($sql_yandex))
      {
        $query = "INSERT INTO $tbl_arch_searchquery_week VALUES".implode(",", $sql_yandex);
        if(!mysql_query($query))
        {
         throw new ExceptionMySQL(mysql_error(), 
                                  $query,
                                 "Ошибка недельной архивации - archive_searchquery_week()");
        }
      }
      if(!empty($sql_google))
      {
        $query = "INSERT INTO $tbl_arch_searchquery_week VALUES".implode(",", $sql_google);
        if(!mysql_query($query))
        {
         throw new ExceptionMySQL(mysql_error(), 
                                  $query,
                                 "Ошибка недельной архивации - archive_searchquery_week()");
        }
      }
      if(!empty($sql_rambler))
      {
        $query = "INSERT INTO $tbl_arch_searchquery_week VALUES".implode(",", $sql_rambler);
        if(!mysql_query($query))
        {
         throw new ExceptionMySQL(mysql_error(), 
                                  $query,
                                 "Ошибка недельной архивации - archive_searchquery_week()");
        }
      }
      if(!empty($sql_aport))
      {
        $query = "INSERT INTO $tbl_arch_searchquery_week VALUES".implode(",", $sql_aport);
        if(!mysql_query($query))
        {
         throw new ExceptionMySQL(mysql_error(), 
                                  $query,
                                 "Ошибка недельной архивации - archive_searchquery_week()");
        }
      }
      if(!empty($sql_msn))
      {
        $query = "INSERT INTO $tbl_arch_searchquery_week VALUES".implode(",", $sql_msn);
        if(!mysql_query($query))
        {
         throw new ExceptionMySQL(mysql_error(), 
                                  $query,
                                 "Ошибка недельной архивации - archive_searchquery_week()");
        }
      }
      if(!empty($sql_met))
      {
        $query = "INSERT INTO $tbl_arch_searchquery_week VALUES".implode(",", $sql_met);
        if(!mysql_query($query))
        {
         throw new ExceptionMySQL(mysql_error(), 
                                  $query,
                                 "Ошибка недельной архивации - archive_searchquery_week()");
        }
      }
    }
  }
  
  // Функция месячной архивации
  function archive_searchquery_month($tbl_arch_searchquery, $tbl_arch_searchquery_month)
  {
    // Последний полный день
    $last_day = mktime(0, 0, 0, date("m"), date("d")-1, date("Y")) + 2;
    // Начало архивации данных
    $begin_day = begin_day_arch($tbl_arch_searchquery, $tbl_arch_searchquery_month);
    // Вычисляем сколько недель прошло с даты последней архивации
    $month = (floor(date("Y",$last_day) - date("Y",$begin_day)))*12 + 
             floor(date("m",$last_day) - date("m",$begin_day)); 
    // Если прошло больше месяца - архивируем данные
    if($month > 0)
    {
      $yandex_number  = YANDEX_NUMBER;
      $rambler_number = RAMBLER_NUMBER;
      $google_number  = GOOGLE_NUMBER;
      $aport_number   = APORT_NUMBER;
      $msn_number     = MSN_NUMBER;
  
      // Архивируем данные по всем месяцам, по которым архивация
      // не проводилась
      for($i = date("Y",$begin_day)*12 + date("m",$begin_day); $i < date("Y",$last_day)*12 + date("m",$last_day); $i++)
      {
        $year = (int)($i/12);
        $month = ($i%12);
        if($month == 0)
        {
          $year--;
          $month = 12;
        }
  
        $tmp = "YEAR(putdate) = $year AND
                MONTH(putdate) = '".sprintf("%02d",$month)."'";
  
        // Извлекаем $xxx_number самых распространённых запросов за неделю
        $query_yandex = "SELECT name, SUM(total) AS total FROM $tbl_arch_searchquery 
                         WHERE searches = 'yandex' AND $tmp
                         GROUP BY name 
                         ORDER BY total DESC 
                         LIMIT $yandex_number";
        // Извлекаем $xxx_number самых распространённых запросов за неделю
        $query_rambler = "SELECT name, SUM(total) AS total FROM $tbl_arch_searchquery 
                         WHERE searches = 'rambler' AND $tmp
                         GROUP BY name 
                         ORDER BY total DESC 
                         LIMIT $rambler_number";
        // Извлекаем $xxx_number самых распространённых запросов за неделю
        $query_google  = "SELECT name, SUM(total) AS total FROM $tbl_arch_searchquery 
                         WHERE searches = 'google' AND $tmp
                         GROUP BY name 
                         ORDER BY total DESC 
                         LIMIT $google_number";
        // Извлекаем $xxx_number самых распространённых запросов за неделю
        $query_aport   = "SELECT name, SUM(total) AS total FROM $tbl_arch_searchquery 
                         WHERE searches = 'aport' AND $tmp
                         GROUP BY name 
                         ORDER BY total DESC 
                         LIMIT $aport_number";
        // Извлекаем $xxx_number самых распространённых запросов за неделю
        $query_msn     = "SELECT name, SUM(total) AS total FROM $tbl_arch_searchquery 
                         WHERE searches = 'msn' AND $tmp
                         GROUP BY name 
                         ORDER BY total DESC 
                         LIMIT $msn_number";
  
        $ynd = mysql_query($query_yandex);
        if(!$ynd)
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "Ошибка месячной архивации - archive_searchquery_month()");
        }
        $gog = mysql_query($query_google);
        if(!$gog)
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "Ошибка месячной архивации - archive_searchquery_month()");
        }
        $rbl = mysql_query($query_rambler);
        if(!$rbl)
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "Ошибка месячной архивации - archive_searchquery_month()");
        }
        $apt = mysql_query($query_aport);
        if(!$apt)
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "Ошибка месячной архивации - archive_searchquery_month()");
        }
        $msn = mysql_query($query_msn);
        if(!$msn)
        {
           throw new ExceptionMySQL(mysql_error(), 
                                    $query,
                                   "Ошибка месячной архивации - archive_searchquery_month()");
        }
  
        // Формируем запрос для ахивации наиболее частых запросов в таблицу $tbl_arch_searchquery_week
        while($yandex = mysql_fetch_array($ynd))
        {
          $yandex['name'] = mysql_escape_string($yandex['name']);
          $sql_yandex[] = "(NULL,
                           '$year-".sprintf("%02d",$month)."-01',
                           '$yandex[name]', 
                           $yandex[total],
                           'yandex')";
        }
        while($google = mysql_fetch_array($gog))
        {
          $google['name'] = mysql_escape_string($google['name']);
          $sql_google[] = "(NULL,
                           '$year-".sprintf("%02d",$month)."-01',
                           '$google[name]', 
                           $google[total],
                           'google')";
        }
        while($rambler = mysql_fetch_array($rbl))
        {
          $rambler['name'] = mysql_escape_string($rambler['name']);
          $sql_rambler[] = "(NULL,
                           '$year-".sprintf("%02d",$month)."-01',
                           '$rambler[name]', 
                           $rambler[total],
                           'rambler')";
        }
        while($aport = mysql_fetch_array($apt))
        {
          $aport['name'] = mysql_escape_string($aport['name']);
          $sql_aport[] = "(NULL,
                           '$year-".sprintf("%02d",$month)."-01',
                           '$aport[name]', 
                           $aport[total],
                           'aport')";
        }
        while($ms = mysql_fetch_array($msn))
        {
          $ms['name'] = mysql_escape_string($ms['name']);
          $sql_msn[] = "(NULL,
                           '$year-".sprintf("%02d",$month)."-01',
                           '$ms[name]', 
                           $ms[total],
                           'msn')";
        }
      }
  
      if(!empty($sql_yandex))
      {
        $query = "INSERT INTO $tbl_arch_searchquery_month VALUES ".implode(",", $sql_yandex);
        if(!mysql_query($query))
        {
         throw new ExceptionMySQL(mysql_error(), 
                                  $query,
                                 "Ошибка недельной архивации - archive_searchquery_week()");
        }
      }
      if(!empty($sql_google))
      {
        $query = "INSERT INTO $tbl_arch_searchquery_month VALUES ".implode(",", $sql_google);
        if(!mysql_query($query))
        {
         throw new ExceptionMySQL(mysql_error(), 
                                  $query,
                                 "Ошибка недельной архивации - archive_searchquery_week()");
        }
      }
      if(!empty($sql_rambler))
      {
        $query = "INSERT INTO $tbl_arch_searchquery_month VALUES ".implode(",", $sql_rambler);
        if(!mysql_query($query))
        {
         throw new ExceptionMySQL(mysql_error(), 
                                  $query,
                                 "Ошибка недельной архивации - archive_searchquery_week()");
        }
      }
      if(!empty($sql_aport))
      {
        $query = "INSERT INTO $tbl_arch_searchquery_month VALUES ".implode(",", $sql_aport);
        if(!mysql_query($query))
        {
         throw new ExceptionMySQL(mysql_error(), 
                                  $query,
                                 "Ошибка недельной архивации - archive_searchquery_week()");
        }
      }
      if(!empty($sql_msn))
      {
        $query = "INSERT INTO $tbl_arch_searchquery_month VALUES ".implode(",", $sql_msn);
        if(!mysql_query($query))
        {
         throw new ExceptionMySQL(mysql_error(), 
                                  $query,
                                 "Ошибка недельной архивации - archive_searchquery_week()");
        }
      }
    }
  }
?>