<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-студия SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // Выставляем уровень обработки ошибок 
  // (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE); 

  // Устанавливаем соединение с базой данных
  require_once("../../config/config.php");
  // Подключаем блок авторизации
  require_once("../utils/security_mod.php");
  // Подключаем SoftTime FrameWork
  require_once("../../config/class.config.dmn.php");

  // Данные переменные определяют название страницы и подсказку.
  $title = 'Управление аккаунтами';
  $pageinfo = '<p class=help>Здесь можно добавить нового 
               пользователя, отредактировать или удалить 
               существующего. Вы не можете узнать пароль
               существующего пользователя, так как он 
               шифруется необратимо, однако вы можете 
               назначить ему новый пароль</p>';

  // Включаем заголовок страницы
  require_once("../utils/top.php");

  try
  {
    // Число ссылок в постраничной навигации
    $page_link = 3;
    // Число позиций на странице
    $pnumber = 10;
    // Объявляем объект постраничной навигации
    $obj = new pager_mysql($tbl_accounts,
                           "",
                           "ORDER BY name",
                           $pnumber,
                           $page_link);
  
    // Добавить аккаунт
    echo "<a href=addaccount.php?page=$_GET[page]
             title='Добавить новый аккаунт'>
             Добавить аккаунт</a><br><br>";
  
    // Получаем содержимое текущей страницы
    $accounts = $obj->get_page();
    // Если имеется хотя бы одна запись - выводим
    if(!empty($accounts))
    {
      ?>
      <table width="100%" 
             class="table" 
             border="0" 
             cellpadding="0" 
             cellspacing="0">      
        <tr class="header" align="center">
          <td>Пользователь</td>
          <td>Действия</td>
        </tr>
      <?php
      for($i = 0; $i < count($accounts); $i++)
      {
        // Выводим строку таблицы
        echo "<tr>
                <td align=center>{$accounts[$i][name]}</td>
                <td align=center>
                  <a href=# 
                     onClick=\"delete_position('".
                    "delaccount.php?page=$_GET[page]&".
                    "id_account={$accounts[$i][id_account]}',".
                    "'Вы действительно хотите удалить аккаунт?');\" 
                     title='Удалить пользователя'>Удалить</a></td>
              </tr>";
      }
      echo "</table><br>";
    }
  
    // Выводим ссылки на другие страницы
    echo $obj;
  }
  catch(ExceptionMySQL $exc)
  {
    require("../utils/exception_mysql.php"); 
  }

  // Включаем завершение страницы
  require_once("../utils/bottom.php");
?>