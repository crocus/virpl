<?php
  class pager_file extends pager
  {
    // Имя файла
    protected $filename;
    // Количество позиций на странице
    private $pnumber;
    // Количество ссылок слева и справа
    // от текущей страницы
    private $page_link;
    // Параметры
    private $parameters;
    // Конструктор
    public function __construct($filename, 
                                $pnumber = 10, 
                                $page_link = 3, 
                                $parameters = "")
    {
      $this->filename   = $filename;
      $this->pnumber    = $pnumber;
      $this->page_link  = $page_link;
      $this->parameters = $parameters;
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
          fgets($fd, 10000);
          $countline++;
        }
        // Закрываем файл
        fclose($fd);
      }
      return $countline;
    }
    public function get_pnumber()
    {
      // Количество позиций на старнице
      return $this->pnumber;
    }
    public function get_page_link()
    {
      // Количество ссылок слева и справа
      // от текущей страницы
      return $this->page_link;
    }
    public function get_parameters()
    {
      // Дополнительные параметры, которые
      // необходимо передать по ссылке
      return $this->parameters;
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
      for($i = 0; $i < $total; $i++)
      {
        $str = fgets($fd, 10000);
        // Пока не достигнут номер $first
        // досрочно заканчиваем итерацию
        if($i < $first) continue;
        // Если достигнут конец выборки
        // досрочно покидаем цикл
        if($i > $first + $this->get_pnumber() - 1) break;
        // Помещаем строки файла в массив,
        // который будет возвращён методом
        $arr[] = $str;
      }
      fclose($fd);

      return $arr;
    }
  }
?>
