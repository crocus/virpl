<?php
  ////////////////////////////////////////////////////////////
  // Панель администрирования
  // 2006-2007 (C) IT-студия SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // Выставляем уровень обработки ошибок (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE); 

  // Анализируем содержимое каталога системы
  // администрирования для формирования меню

  // Открываем каталог /dmn
  $dir = opendir("..");
  // В цикле проходимся по всем файлам и
  // подкаталогам
  while (($file = readdir($dir)) !== false)
  {
    // Обрабатываем только подкаталоги, 
    // игнорируя файлы
    if(is_dir("../$file"))
    {
      // Исключаем текущий ".", родительский ".."
      // каталоги, а также каталог utils
      if($file != "." && $file != ".." && $file != "utils")
      {
        // Ищем в каталоге файл с описанием
        // блока .htdir
        if(file_exists("../$file/.htdir"))
        {
          // Файл .htdir существует - 
          // читаем название блока и его
          // описание
          list($block_name, 
               $block_description) = file("../$file/.htdir");
        }
        else
        {
          // Файл .htdir не существует -
          // в качестве его названия 
          // выступает имя подкаталога
          $block_name        = "$file";
          $block_description = "";
        }

        // Отмечаем текущий пункт другим стилем
        if(strpos($_SERVER['PHP_SELF'], $file) !== false) 
        {
          $style = 'class=active';
        }
        else $style = '';

        // Формируем пункт меню
        echo "<div $style>
                <a class=menu 
                   href='../$file' 
                   title='$block_description'>
                   $block_name
                </a>
              </div>";
      }
    }
  }
  // Закрываем каталог
  closedir($dir);
?>