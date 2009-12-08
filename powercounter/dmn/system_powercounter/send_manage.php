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
  // Устанавливаем соединение с базой данных
  require_once("config.php");
  // Подключаем SoftTime FrameWork
  require_once("../../config/class.config.dmn.php");
  // Подключаем блок авторизации
  require_once("../utils/security_mod.php");
  // Подключаем блок отображения текста в окне браузера
  require_once("../utils/utils.print_page.php");

  // Рассылка на за одни день
  if($_GET['freq'] == 1) require_once("send_day.php");
  // Рассылка на за неделю
  if($_GET['freq'] == 7) require_once("send_week.php");
  // Рассылка на за месяц
  if($_GET['freq'] == 30) require_once("send_month.php");
  // Если запрос выполнен удачно, осуществляем автоматический переход
  // на страницу управления рассылкой
  header("Location: send.php");
?>