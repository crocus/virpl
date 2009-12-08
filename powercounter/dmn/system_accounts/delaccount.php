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

  // Проверяем GET-параметр, предотвращая SQL-инъекцию
  $_GET['id_account'] = intval($_GET['id_account']);

  try
  {
    // Проверяем не удаляется ли последний аккаунт -
    // если он будет удалён в систему нельзя будет войти
    $query = "SELECT COUNT(*) FROM $tbl_accounts";
    $acc = mysql_query($query);
    if(!$acc)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "Ошибка удаления
                               пользователя");
    }
    if(mysql_result($acc, 0) > 1)
    {
      $query = "DELETE FROM $tbl_accounts 
                WHERE id_account=".$_GET['id_account'];
      if(mysql_query($query))
      {
        header("Location: index.php?page=".$_GET['page']);
      }
      else
      {
        throw new ExceptionMySQL(mysql_error(), 
                                 $query,
                                "Ошибка удаления
                                 пользователя");
      }
    }
    else
    {
      throw new Exception("Нельзя удалить 
                           единственный аккаунт");
    }
  }
  catch(ExceptionMySQL $exc)
  {
    require("../utils/exception_mysql.php"); 
  }
  catch(Exception $exc)
  {
    require("../utils/exception.php"); 
  }
?>