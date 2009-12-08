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

  // Массив временных интервалов
  // "Сегодня"
  $time[0]['begin'] = 1;
  $time[0]['end'] = 0;
  // "Вчера"
  $time[1]['begin'] = 2;
  $time[1]['end'] = 1;
  // "За 7 дней"
  $time[2]['begin'] = 7;
  $time[2]['end'] = 0;
  // "За 30 дней"
  $time[3]['begin'] = 30;
  $time[3]['end'] = 0;
  // "За всё время"
  $time[4]['begin'] = 0;
  $time[4]['end'] = 0;
?>