<?php
  ////////////////////////////////////////////////////////////
  // Панель администрирования
  // 2006-2007 (C) IT-студия SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // Выставляем уровень обработки ошибок (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE); 

  // Устанавливаем соединение с базой данных
  require_once("../../config/config.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title><?php echo $title; ?></title>
<link rel="StyleSheet" type="text/css" href="../utils/cms.css">
</head>
<body leftmargin="0" 
      marginheight="0" 
      marginwidth="0" 
      rightmargin="0" 
      bottommargin="0" 
      topmargin="0" >
<table width="100%" 
       border="0" 
       cellspacing="0" 
       cellpadding="0" 
       height="100%">
  <tr valign="top">
    <td colspan="3">
      <table class=topmenu border=0>
        <tr>
          <td width=5%>&nbsp;</td>
          <td>
            <h1 class=title><?php echo $title; ?></h1>
          </td>
          <td>  

            <a href="../index.php" 
               title="Вернуться на страницу администрированию сайта">
                 Администрирование</a>&nbsp;&nbsp;

            <a href="../../index.php" 
               title="Вернуться на головную страницу сайта" >
                 Вернуться на сайт</a>

          </td>
        </tr>
      </table>      
    </td>
  </tr>
  <tr valign=top>
    <td class=menu>
      <?php
        // Формируем меню системы администрирования
        include "menu.php";
      ?>
    </td>
  <td class=main height=100%>
    <h1 class=namepage><?php echo htmlspecialchars($title, ENT_QUOTES) ?></h1>
    <?php echo $pageinfo ?><br>
