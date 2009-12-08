<?php
  ////////////////////////////////////////////////////////////
  // Панель администрирования
  // 2006-2007 (C) IT-студия SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // Выставляем уровень обработки ошибок (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE); 

  // Включаем заголовок страницы
  require_once("../utils/top.php");

  echo "<p class=help>{$exc->getMessage()}</p>";
  echo "<p class=help><a href=# onclick='history.back()'>Вернуться</a></p>";

  // Включаем завершение страницы
  require_once("../utils/bottom.php");
  exit();
?>