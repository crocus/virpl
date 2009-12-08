<?php
  class pager_file_search extends pager_file
  {
    // Начало слова
    private $search;
    // Конструктор
    public function __construct($search,
                                $filename, 
                                $pnumber = 10, 
                                $page_link = 3)
    {
      parent::__construct($filename, 
                          $pnumber, 
                          $page_link, 
                          "&search=".urlencode($search));
      $this->search   = $search;
    }
    public function get_total()
    {
      $countline = 0;
      // Открываем файл
      $fd = fopen($this->filename, "r");
      if($fd)
      {
        // Подсчитываем количество записей
        // в файле
        while(!feof($fd))
        {
          $str = fgets($fd, 10000);
          if(preg_match("|^".preg_quote($this->search)."|i", $str)) $countline++;
        }
        // Закрываем файл
        fclose($fd);
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
      $fd = fopen($this->filename, "r");
      if(!$fd) return 0;
      // Номер, начиная с которого следует
      // выбирать строки файла
      $first = ($page - 1)*$this->get_pnumber();
      while(!feof($fd))
      {
        $str = fgets($fd, 10000);
        if(preg_match("|^".preg_quote($this->search)."|i", $str))
        {
          $countline++;
          // Пока не достигнут номер $first
          // досрочно заканчиваем итерацию
          if($countline < $first) continue;
          // Если достигнут конец выборки
          // досрочно покидаем цикл
          if($countline > $first + $this->get_pnumber() - 1) break;
          // Помещаем строки файла в массив,
          // который будет возвращён методом
          $arr[] = $str;
        }
      }
      // Закрываем файл
      fclose($fd);

      return $arr;
    }
  }
?>