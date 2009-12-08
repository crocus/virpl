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
  // Выставляем уровень обработки ошибок 
  // (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE); 

  // Помещаем время старта в переменную $begin_time
  $part_time = explode(' ',microtime()); 
  $begin_time = $part_time[1].substr($part_time[0],1); 

  // Устанавливаем соединение с базой данных
  require_once("config.php");
  // Архивируем информацию
  require_once("archive.php");
  // Выполнение запроса
  require_once("utils.query_result.php");
  // Управление объёмом базы данных
  require_once("utils.database.php");

  $namepage = "Система администрирования";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title><?php echo $title; ?></title>
<link rel="StyleSheet" type="text/css" href="../utils/cms.css">
</head>
<body leftmargin="0" marginheight="0" marginwidth="0" rightmargin="0" bottommargin="0" topmargin="0" >
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr valign="top">
    <td colspan="3">
<table class=topmenu border=0>
  <tr>
    <td width=5%>&nbsp;</td>
    <td>
      <h1 class=title><?php echo $namepage; ?></h1>
<?php
    // Выводим дату начала регистрации данных и число прошедших с начала регистрации
    // дней - определяем дату в таблице $tbl_ip и $tbl_arch_hits

    $query = "SELECT UNIX_TIMESTAMP(MIN(putdate)) AS data 
              FROM $tbl_ip";
    $date_ip = query_result($query);

    $query = "SELECT UNIX_TIMESTAMP(MIN(putdate)) AS data 
              FROM $tbl_arch_hits";
    $date_arch = query_result($query);

    if(empty($date_ip) && empty($date_arch)) $date = time();
    else
    {
      if(empty($date_ip)) $date = $date_arch;
      else if(empty($date_ip)) $date = $date_ip;
      else
      {
        if($date_ip < $date_arch) $date = $date_ip;
        else $date = $date_arch;
      }
    }
    if(empty($date)) $date = time();

    // Извлекаем объём базы данных
    $value = get_value_database();

    echo "<div>";
    printf("Система работает: <b> %d </b> дн.",ceil((time()-$date)/3600/24));
    echo " Объём базы данных: <b><a href=database.php title='Управление объёмом базы данных'>".valuesize($value)."</a></b>";
    echo "</div>";
?>    
    </td>
    <td>  
       <a href="../index.php" title="Вернуться на страницу администрированию сайта">Администрирование</b></a>&nbsp;&nbsp;
       <a href="../../index.php" title="Вернуться на головную страницу сайта" >Вернуться на сайт</b></a>&nbsp;&nbsp;
    </td>
  </tr>
</table>      
    </td>
  </tr>
  <tr valign=top>
    <td class=menu>
<?php
  include "menu.php";
?>
    </td>
  <td class=main height=100%>
    <h1 class=namepage><?php echo $title ?>&nbsp;&nbsp;</h1>
    <?php echo "<p class=help>$pageinfo</p>"; ?><br>
