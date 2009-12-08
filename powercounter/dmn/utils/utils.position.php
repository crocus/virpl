<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-студия SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // Выставляем уровень обработки ошибок 
  // (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE); 
  // Подключаем SoftTime FrameWork
  require_once("../../config/class.config.dmn.php");

  // Отображение позиции
  function show($id_position, $tbl_name, $where = "", $fld_name = "id_position")
  {
    // Проверяем GET-параметр, предотвращая SQL-инъекцию
    $id_position = intval($id_position);

    // Отображаем позицию
    $query = "UPDATE $tbl_name SET hide='show' 
              WHERE $fld_name=$id_position $where";
    if(!mysql_query($query))
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "Ошибка при отображении 
                               позиции");
    }
  }

  // Сокрытие позиции
  function hide($id_position, $tbl_name, $where = "", $fld_name = "id_position")
  {
    // Проверяем GET-параметр, предотвращая SQL-инъекцию
    $id_position = intval($id_position);

    // Скрываем позицию
    $query = "UPDATE $tbl_name SET hide='hide' 
              WHERE $fld_name=$id_position $where";
    if(!mysql_query($query))
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "Ошибка при сокрытии
                               позиции");
    }
  }

  // Подъём блока на одну позицию вверх
  function up($id_position, $tbl_name, $where = "", $fld_name = "id_position")
  {
    // Извлекаем текущую позицию
    $query = "SELECT pos FROM $tbl_name
              WHERE $fld_name = $id_position
              LIMIT 1";
    $pos = mysql_query($query);
    if(!$pos)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "Ошибка при извлечении 
                               текущей позиции");
    }
    if(mysql_num_rows($pos))
    {
      $pos_current = mysql_result($pos, 0);
    }
    // Извлекаем предыдую позицию
    $query = "SELECT pos FROM $tbl_name
              WHERE pos < $pos_current $where
              ORDER BY pos DESC
              LIMIT 1";
    $pos = mysql_query($query);
    if(!$pos)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "Ошибка при извлечении 
                               предыдущей позиции");
    }
    if(mysql_num_rows($pos))
    {
      $pos_preview = mysql_result($pos, 0);
  
      // Меняем местами текущую и предыдущую позиции
      $query = "UPDATE $tbl_name
                SET pos = $pos_current + $pos_preview - pos
                WHERE pos IN ($pos_current, $pos_preview) $where";
      if(!mysql_query($query))
      {
        throw new ExceptionMySQL(mysql_error(), 
                                 $query,
                                "Ошибка изменения
                                 позиции");
      }
    }
  }

  // Опускание блока на одну позицию вниз
  function down($id_position, $tbl_name, $where = "", $fld_name = "id_position")
  {
    // Извлекаем текущую позицию
    $query = "SELECT pos FROM $tbl_name
              WHERE $fld_name = $id_position
              LIMIT 1";
    $pos = mysql_query($query);
    if(!$pos)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "Ошибка при извлечении 
                               текущей позиции");
    }
    if(mysql_num_rows($pos))
    {
      $pos_current = mysql_result($pos, 0);
    }
    // Извлекаем следующую позицию
    $query = "SELECT pos FROM $tbl_name
              WHERE pos > $pos_current $where
              ORDER BY pos
              LIMIT 1";
    $pos = mysql_query($query);
    if(!$pos)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "Ошибка при извлечении 
                               следующей позиции");
    }
    if(mysql_num_rows($pos))
    {
      $pos_next = mysql_result($pos, 0);
  
      // Меняем местами текущую и следующую позиции
      $query = "UPDATE $tbl_name
                SET pos = $pos_next + $pos_current - pos
                WHERE pos IN ($pos_next, $pos_current) $where";
      if(!mysql_query($query))
      {
        throw new ExceptionMySQL(mysql_error(), 
                                 $query,
                                "Ошибка изменения
                                 позиции");
      }
    }
  }
?>