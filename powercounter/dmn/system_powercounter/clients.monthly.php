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
  // Постраничная навигация
  require_once("../utils/utils.pager.php");
  // Формирование WHERE-условий
  require_once("utils.where.php");
  // Выполнение запроса
  require_once("utils.query_result.php");

  // Данные переменные определяют название страницы и подсказку.
  $title = 'Помесячный отчёт'; 

  try
  {
    // Включаем заголовок страницы
    require_once("../utils/topcounter.php");

    // Постраничная навигация
    if(empty($_GET['page'])) $page = 1;
    else $page = $_GET['page'];

    // Извлекаем количество страниц
    $query = "SELECT COUNT(*) FROM $tbl_arch_clients_month";
    $total = query_result($query);

    $page_link = 3;
    $first = ($page - 1)*$pnumber;
  
    // Выводим ссылки на другие страницы
    pager($page, 
          $total, 
          $pnumber, 
          $page_link, 
          "");
    echo "<br><br>";

    // Извлекаем данные для текущей страницы
    $query = "SELECT DATE_FORMAT(putdate, '%Y.%m') as putdate, 
                     browsers_msie,
                     browsers_opera,
                     browsers_netscape,
                     browsers_firefox,
                     browsers_myie,
                     browsers_mozilla,
                     browsers_none,
                     systems_windows,
                     systems_unix,
                     systems_macintosh,
                     systems_none
              FROM $tbl_arch_clients_month
              ORDER BY putdate DESC
              LIMIT $first, $pnumber";
    $arh = mysql_query($query);
    if(!$arh)
    {
       throw new ExceptionMySQL(mysql_error(), 
                                $query,
                               "Ошибка извлечения месячной статистики");
    }
    if(mysql_num_rows($arh))
    {
      echo "<table class=table width=100% border=0 cellpadding=0 cellspacing=0>
              <tr class=header align=center>
                <td align=center width=".(100/12)."%>Дата</td>
                <td align=center width=".(100/12)."%>IE</td>
                <td align=center width=".(100/12)."%>Opera</td>
                <td align=center width=".(100/12)."%>Netscape</td>
                <td align=center width=".(100/12)."%>Firefox</td>
                <td align=center width=".(100/12)."%>MyIE</td>
                <td align=center width=".(100/12)."%>Mozilla</td>
                <td align=center width=".(100/12)."%>Неопред.</td>
                <td align=center width=".(100/12)."%>Windows</td>
                <td align=center width=".(100/12)."%>UNIX</td>
                <td align=center width=".(100/12)."%>Macintosh</td>
                <td align=center width=".(100/12)."%>Неопред.</td>
              </tr>";
      while ($hits=mysql_fetch_array($arh))
      {
        echo "<tr>
                <td align=center>$hits[putdate]</td>
                <td align=center>$hits[browsers_msie]</td>
                <td align=center>$hits[browsers_opera]</td>
                <td align=center>$hits[browsers_netscape]</td>
                <td align=center>$hits[browsers_firefox]</td>
                <td align=center>$hits[browsers_myie]</td>
                <td align=center>$hits[browsers_mozilla]</td>
                <td align=center>$hits[browsers_none]</td>
                <td align=center>$hits[systems_windows]</td>
                <td align=center>$hits[systems_unix]</td>
                <td align=center>$hits[systems_macintosh]</td>
                <td align=center>$hits[systems_none]</td>
              </tr>";
      }
      echo "</table>";
    }

    // Завершение страницы
    require_once("../utils/bottomcounter.php");
  }
  catch(ExceptionObject $exc) 
  {
    require("../utils/exception_object.php"); 
  }
  catch(ExceptionMySQL $exc)
  {
    require("../utils/exception_mysql.php"); 
  }
  catch(ExceptionMember $exc)
  {
    require("../utils/exception_member.php"); 
  }
?>