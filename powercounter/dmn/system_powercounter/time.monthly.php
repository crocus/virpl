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
    $query = "SELECT COUNT(DISTINCT putdate) 
              FROM $tbl_arch_time_month";
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
    $query = "SELECT UNIX_TIMESTAMP(putdate) as putdate
              FROM $tbl_arch_time_month
              GROUP BY putdate
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
                <td align=center width=50%>Дата</td>
                <td align=center width=50%>Ссылка</td>
              </tr>";
      while ($hits=mysql_fetch_array($arh))
      {
        // Формируем дату
        $date_table = date("Y.m",$hits['putdate']);
        // Меняем английские названия дней недели на русские
        echo "<tr>
                <td align=center>$date_table</td>
                <td align=center><a href=$_SERVER[PHP_SELF]?date=$hits[putdate]>смотреть</a></td>
              </tr>";
      }
      echo "</table><br><br>";
    }
  
    // Если параметр $_GET['date'] не пуст, запрашиваем IP-адреса
    // за этот день
    if(!empty($_GET['date']))
    {
      $_GET['date'] = intval($_GET['date']);
      $query = "SELECT * FROM $tbl_arch_time_month 
                WHERE putdate LIKE '".date("Y-m",$_GET['date'])."%'";
      $ipt = mysql_query($query);
      if(!$ipt)
      {
         throw new ExceptionMySQL(mysql_error(), 
                                  $query,
                                 "Ошибка извлечения месячной статистики");
      }
      if(mysql_num_rows($ipt))
      {
        echo "<table class=table width=100% border=0 cellpadding=0 cellspacing=0>
                <tr class=header align=center>
                  <td width=150>Время</td>
                  <td width=150>Число обращений</td>
                  <td>Гистограмма</td>
                </tr>";
        $arch_time = mysql_fetch_array($ipt);
        unset($arch_time['id_time'], $arch_time['putdate']);
        $total = array_sum($arch_time);
        echo "<tr>
                <td>1 минута</td>
                <td>".$arch_time['visit1']."</td>
                <td><img src=images/parm.gif border=0 width=".(100*$arch_time['visit1']/$total)."% height=6></td>
              </tr>\r\n";
        echo "<tr>
                <td>2 минуты</td>
                <td>".$arch_time['visit2']."</td>
                <td><img src=images/parm.gif border=0 width=".(100*$arch_time['visit2']/$total)."% height=6></td>
              </tr>\r\n";
        echo "<tr>
                <td>3 минуты</td>
                <td>".$arch_time['visit3']."</td>
                <td><img src=images/parm.gif border=0 width=".(100*$arch_time['visit3']/$total)."% height=6></td>
              </tr>\r\n";
        echo "<tr>
                <td>4 минуты</td>
                <td>".$arch_time['visit4']."</td>
                <td><img src=images/parm.gif border=0 width=".(100*$arch_time['visit4']/$total)."% height=6></td>
              </tr>\r\n";
        for($i = 5; $i < 11; $i++)
        {
          echo "<tr>
                  <td>$i минут</td>
                  <td>".$arch_time['visit'.$i]."</td>
                  <td><img src=images/parm.gif border=0 width=".(100*$arch_time['visit'.$i]/$total)."% height=6></td>
                </tr>\r\n";
        }
        for($i = 10; $i < 60; $i = $i + 10)
        {
          echo "<tr>
                  <td>от ".$i." до ".($i+10)." минут</td>
                  <td>".$arch_time['visit'.($i+10)]."</td>
                  <td><img src=images/parm.gif border=0 width=".(100*$arch_time['visit'.($i+10)]/$total)."% height=6></td>
                </tr>\r\n";
        }
        for($i = 1; $i < 24; $i++)
        {
          echo "<tr>
                  <td>от ".$i." до ".($i+1)." часов</td>
                  <td>".$arch_time['visit'.($i+1).'h']."</td>
                  <td><img src=images/parm.gif border=0 width=".(100*$arch_time['visit'.($i+1).'h']/$total)."% height=6></td>
                </tr>\r\n";
        }
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