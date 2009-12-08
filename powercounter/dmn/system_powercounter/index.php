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

  try
  {
    // Данные переменные определяют название страницы и подсказку.
    $title = 'Статистика&nbsp;посещений&nbsp;&nbsp;по
              &nbsp;страницам&nbsp;сайта'; 
    $pageinfo = 'Ниже перечислены страницы, которые участвуют в 
                 статистике. По гиперссылкам можно получить 
                 детальную статистику по каждой отдельной странице
  
    <br>Для получения статистики только по выбранной странице 
    щелкните на ее имени в таблице. Если страница не будет выбрана, 
    то статистика будет представлена для <a href=hits.php>всего 
    сайта</a>.';    
  
    // Включаем заголовок страницы
    require_once("../utils/topcounter.php");

    // Постраничная навигация
    if(empty($_GET['page'])) $page = 1;
    else $page = $_GET['page'];
    
    $page_link = 3;
    $first = ($page - 1)*$pnumber;

    // Сортировка
    if(empty($_GET['order']))
    {
      $orderstr = "num DESC" ;
      $order = "";
    }
    else $orderstr = "title";

    // Формируем WHERE-условие для временного интервала
    $where = where_interval($_GET['begin'], $_GET['end'], $tbl_ip);
    // Извлекаем количество страниц
    $query = "SELECT COUNT(DISTINCT $tbl_pages.id_page)
                     FROM $tbl_pages, $tbl_ip
                     $where AND $tbl_ip.id_page = $tbl_pages.id_page";
    $total = query_result($query);
  
    // Выводим ссылки на другие страницы
    pager($page, 
          $total, 
          $pnumber, 
          $page_link, 
          "&id_page=$id_page&order=$order&begin=$begin&end=$end");
    echo "<br><br>";
  
    // Выводим таблицу с адресами страниц, учавствующих в 
    // статистике и общее количество хитов для каждой из 
    // страниц.
    ?>
    <table class="table" width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr class="header">
      <td width=<?= 100/5 ?>% align=center><a href='index.php?begin=1&end=0&order=<?=$order?>'>Сегодня</a></td>
      <td width=<?= 100/5 ?>% align=center><a href='index.php?begin=2&end=1&order=<?=$order?>'>Вчера</a></td>
      <td width=<?= 100/5 ?>% align=center><a href='index.php?begin=7&end=0&order=<?=$order?>'>За 7 дней</a></td>
      <td width=<?= 100/5 ?>% align=center><a href='index.php?begin=30&end=0&order=<?=$order?>'>За 30 дней</a></td>
      <td width=<?= 100/5 ?>% align=center><a href='index.php?begin=0&end=0&order=<?=$order?>'>За всё время</a></td>
     </tr>
    </table><br><br>
    <table width="100%" class="table" border="0" cellpadding="0" cellspacing="0">      
      <tr class="header" align="center">
        <td><a href=index.php?page=<? echo "$page&begin=$begin&end=$end"; ?>&order=1 
               title="Сортировать таблицу по имени страниц">Страница</a></td>
        <td><a href=index.php?page=<? echo "$page&begin=$begin&end=$end" ?> 
               title="Сортировать таблицу по количеству посещений">Количество посещений</a></td>
        <td>Последнее посещение</td> 
        <td>Действие</td>
      </tr>
    <?php
    $query_hits = "SELECT $tbl_ip.id_page,
                          $tbl_pages.name,
                          $tbl_pages.title AS title,
                          COUNT($tbl_ip.id_ip) AS num,
                          MAX($tbl_ip.putdate) AS putdate
                   FROM $tbl_ip, $tbl_pages
                   $where AND $tbl_ip.id_page = $tbl_pages.id_page
                   GROUP BY $tbl_ip.id_page 
                   ORDER BY $orderstr 
                   LIMIT $first, $pnumber";
    $pgs = mysql_query($query_hits);
    if(!$pgs)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "Ошибка при обращении 
                               к таблице страниц");
    }
    if(mysql_num_rows($pgs))
    {
      while($pag = mysql_fetch_array($pgs))
      {
        if(empty($pag['title']))
        {
          $title = "http://{$_SERVER[SERVER_NAME]}{$pag[name]}";
        }
        else $title = $pag['title'];
        echo "<tr>
                <td><a href=addresses.php?id_page=$pag[id_page]>$title</a></td>
                <td>$pag[num]</td>
                <td>$pag[putdate]</td>
                <td align=center>
                  <a href=# onClick=\"delete_position('delpage.php?id_page=$pag[id_page]',".
                  "'Удаление устаревших(мёртвых) страниц из системы подсчёта');\">Удалить</a>
                </td>
             </tr>";
      }
    }
    echo "</table>";
    // Включаем завершение страницы
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