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

  // Объём занимаемый таблицей
  function get_value_table($tbl)
  {
    $query = "SHOW TABLE STATUS LIKE '$tbl'";
    $val = mysql_query($query);
    if(!$val)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "Ошибка при получении объёма таблицы");
    }
    if(mysql_num_rows($val))
    {
      $value = mysql_fetch_array($val);
      return $value['Data_length'] + $value['Index_length'];
    }
    else return 0;
  }
  // Объём занимаемый базой данных
  function get_value_database()
  {
    global $tbl_ip, $tbl_pages, $tbl_links, $tbl_thits,
           $tbl_refferer, $tbl_searchquerys, $tbl_cities,
           $tbl_ip_compact, $tbl_regions, $tbl_arch_hits,
           $tbl_arch_ip, $tbl_arch_clients, $tbl_arch_robots,
           $tbl_arch_refferer, $tbl_arch_searchquery,
           $tbl_arch_num_searchquery, $tbl_arch_enterpoint,
           $tbl_arch_deep, $tbl_arch_time, $tbl_arch_time_temp,
           $tbl_arch_hits_week, $tbl_arch_robots_week,
           $tbl_arch_ip_week, $tbl_arch_clients_week,
           $tbl_arch_refferer_week, $tbl_arch_searchquery_week,
           $tbl_arch_num_searchquery_week, $tbl_arch_enterpoint_week,
           $tbl_arch_deep_week, $tbl_arch_time_week,
           $tbl_arch_hits_month, $tbl_arch_robots_month,
           $tbl_arch_ip_month, $tbl_arch_clients_month,
           $tbl_arch_refferer_month, $tbl_arch_searchquery_month,
           $tbl_arch_num_searchquery_month, $tbl_arch_enterpoint_month,
           $tbl_arch_deep_month, $tbl_arch_time_month;
    // Получаем объём базы данных
    $value = 0;
    $value += get_value_table($tbl_ip);
    $value += get_value_table($tbl_pages);
    $value += get_value_table($tbl_thits);
    $value += get_value_table($tbl_refferer);
    $value += get_value_table($tbl_searchquerys);
    $value += get_value_table($tbl_cities);
    $value += get_value_table($tbl_ip_compact);
    $value += get_value_table($tbl_regions);
    $value += get_value_table($tbl_arch_hits);
    $value += get_value_table($tbl_arch_ip);
    $value += get_value_table($tbl_arch_clients);
    $value += get_value_table($tbl_arch_robots);
    $value += get_value_table($tbl_arch_refferer);
    $value += get_value_table($tbl_arch_searchquery);
    $value += get_value_table($tbl_arch_num_searchquery);
    $value += get_value_table($tbl_arch_enterpoint);
    $value += get_value_table($tbl_arch_deep);
    $value += get_value_table($tbl_arch_time);
    $value += get_value_table($tbl_arch_time_temp);
    $value += get_value_table($tbl_arch_hits_week);
    $value += get_value_table($tbl_arch_robots_week);
    $value += get_value_table($tbl_arch_ip_week);
    $value += get_value_table($tbl_arch_clients_week);
    $value += get_value_table($tbl_arch_refferer_week);
    $value += get_value_table($tbl_arch_searchquery_week);
    $value += get_value_table($tbl_arch_num_searchquery_week);
    $value += get_value_table($tbl_arch_enterpoint_week);
    $value += get_value_table($tbl_arch_deep_week);
    $value += get_value_table($tbl_arch_time_week);
    $value += get_value_table($tbl_arch_hits_month);
    $value += get_value_table($tbl_arch_robots_month);
    $value += get_value_table($tbl_arch_ip_month);
    $value += get_value_table($tbl_arch_clients_month);
    $value += get_value_table($tbl_arch_refferer_month);
    $value += get_value_table($tbl_arch_searchquery_month);
    $value += get_value_table($tbl_arch_num_searchquery_month);
    $value += get_value_table($tbl_arch_enterpoint_month);
    $value += get_value_table($tbl_arch_deep_month);
    $value += get_value_table($tbl_arch_time_month);

    return $value;
  }
  // Форматирование объёма базы данных
  function valuesize($filesize)
  {
    // Если размер файл превышает 1024 байта,
    // пересчитываем размер в Кб
    if($filesize > 1024)
    {
      $filesize = (float)($filesize/1024);
      // Если размер файл превышает 1024 Кбайта,
      // пересчитываем размер в Мбайты
      if($filesize > 1024)
      {
        $filesize = (float)($filesize/1024);
        // Округляем дробную часть до
        // первого знака после запятой
        $filesize = round($filesize, 1);
        return $filesize." Мб";
      }
      else
      {
        // Округляем дробную часть до
        // первого знака после запятой
        $filesize = round($filesize, 1);
        return $filesize." Кб";
      }
    }
    else
    {
      return $filesize." байт";
    }
  }
?>
