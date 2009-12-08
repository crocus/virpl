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
  $title = 'Посуточный отчёт'; 

  try
  {
    // Включаем заголовок страницы
    require_once("../utils/topcounter.php");

    // Постраничная навигация
    if(empty($_GET['page'])) $page = 1;
    else $page = $_GET['page'];

    // Извлекаем количество страниц
    $query = "SELECT COUNT(*) FROM $tbl_arch_num_searchquery";
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
    $query = "SELECT UNIX_TIMESTAMP(putdate) as putdate, 
                     number_yandex,
                     number_google,
                     number_rambler,
                     number_aport,
                     number_msn,
                     number_mail
              FROM $tbl_arch_num_searchquery
              ORDER BY putdate DESC
              LIMIT $first, $pnumber";
    $arh = mysql_query($query);
    if(!$arh)
    {
       throw new ExceptionMySQL(mysql_error(), 
                                $query,
                               "Ошибка извлечения суточной статистики");
    }
    if(mysql_num_rows($arh))
    {
      echo "<table class=table width=100% border=0 cellpadding=0 cellspacing=0>
              <tr class=header align=center>
                <td align=center width=".(100/7)."%>Дата</td>
                <td align=center width=".(100/7)."%>Yandex</td>
                <td align=center width=".(100/7)."%>Rambler</td>
                <td align=center width=".(100/7)."%>Google</td>
                <td align=center width=".(100/7)."%>Aport</td>
                <td align=center width=".(100/7)."%>MSN</td>
                <td align=center width=".(100/7)."%>Mail.ru</td>
              </tr>";
      $eng = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
      $rus = array("Пн","Вт","Ср","Чт","Пт","Сб","Вс");
      while ($hits=mysql_fetch_array($arh))
      {
        // Формируем дату
        if(date("w", $hits['putdate']) == 0 || date("w", $hits['putdate']) == 6)
        {
          // Суббота и воскресенье
          $date_table = "<div style='color:red'>".date("d.m D", $hits['putdate'])."</div>";
        }
        else
        {
          // Будни
          $date_table = date("d.m D",$hits['putdate']);
        }
        // Меняем английские названия дней недели на русские
        $date_table = str_replace($eng,$rus,$date_table);
        echo "<tr>
                <td align=center>$date_table</td>
                <td align=center>$hits[number_yandex]</td>
                <td align=center>$hits[number_rambler]</td>
                <td align=center>$hits[number_google]</td>
                <td align=center>$hits[number_aport]</td>
                <td align=center>$hits[number_msn]</td>
                <td align=center>$hits[number_mail]</td>
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