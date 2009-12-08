<?php
  class pager_dir extends pager_abstract
  {
    // Конструктор
    public function __construct($dirname, 
                                $pnumber = 10, 
                                $page_link = 3, 
                                $parameters = "")
    {
      // Удаляем последний символ /, если он имеется
      $this->dirname    = trim($dirname, "/");
      $this->pnumber    = $pnumber;
      $this->page_link  = $page_link;
      $this->parameters = $parameters;
    }
    public function get_total()
    {
      $countline = 0;
      // Открываем директорию
      if(($dir = opendir($this->dirname)) !== false)
      {
        while(($file = readdir($dir)) !== false)
        {
          // Если текущая позиция является файлом
          // подсчитываем её
          if(is_file($this->dirname."/".$file)) $countline++;
        }
        // Закрываем директорию
        closedir($dir);
      }
      return $countline;
    }
    // Возвращает массив строк файла, по 
    // номеру страницы $index
    public function get_page()
    {
      // Текущая страница
      $page = $_GET['page'];
      if(empty($page)) $page = 1;
      // Количество записей в файле
      $total = $this->get_total();
      // Вычисляем число страниц в системе
      $number = (int)($total/$this->get_pnumber());
      if((float)($total/$this->get_pnumber()) - $number != 0) $number++;
      // Проверяем попадает ли запрашиваемый номер 
      // страницы в интервал от 1 до get_total()
      if($page <= 0 || $page > $number) return 0;
      // Извлекаем позиции текущей страницы
      $arr = array();
      // Номер, начиная с которого следует
      // выбирать строки файла
      $first = ($page - 1)*$this->get_pnumber();
      // Открываем директорию
      if(($dir = opendir($this->dirname)) === false) return 0;
      $i = -1;
      while(($file = readdir($dir)) !== false)
      {
        // Если текущая позиция является файлом
        if(is_file($this->dirname."/".$file))
        {
          // Увеличиваем счётчик
          $i++;
          // Пока не достигнут номер $first
          // досрочно заканчиваем итерацию
          if($i < $first) continue;
          // Если достигнут конец выборки
          // досрочно покидаем цикл
          if($i > $first + $this->get_pnumber() - 1) break;
          // Помещаем пути к файлам в массив,
          // который будет возвращён методом
          $arr[] = $this->dirname."/".$file;
        }
      }
      // Закрываем директорию
      closedir($dir);

      return $arr;
    }
  }
?>
