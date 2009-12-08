<?php
  class pager_mysql extends pager
  {
    // Имя таблицы
    protected $tablename;
    // WHERE-условие
    protected $where;
    // Критерий сортировки ORDER
    protected $order;
    // Количество позиций на странице
    private $pnumber;
    // Количество ссылок слева и справа
    // от текущей страницы
    private $page_link;
    // Параметры
    private $parameters;
    // Конструктор
    public function __construct($tablename, 
                                $where = "",
                                $order = "",
                                $pnumber = 10, 
                                $page_link = 3, 
                                $parameters = "")
    {
      $this->tablename  = $tablename;
      $this->where      = $where;
      $this->order      = $order;
      $this->pnumber    = $pnumber;
      $this->page_link  = $page_link;
      $this->parameters = $parameters;
    }
    public function get_total()
    {
      // Формируем запрос на получение
      // общего количества записей в таблице
      $query = "SELECT COUNT(*) FROM {$this->tablename}
                {$this->where}
                {$this->order}";
      $tot = mysql_query($query);
      if(!$tot) 
      {
        throw new ExceptionMySQL(mysql_error(), 
                                 $query,
                                 "Ошибка подсчёта количества записей");
      }
      return mysql_result($tot, 0);
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
      $page = intval($_GET['page']);
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
      // Извлекаем позиции для текущей страницы
      $query = "SELECT * FROM {$this->tablename}
                {$this->where}
                {$this->order}
                LIMIT $first, {$this->get_pnumber()}";
      $tbl = mysql_query($query);
      if(!$tbl)
      {
        throw new ExceptionMySQL(mysql_error(), 
                                 $query,
                                 "Ошибка извлечений позиций");
      }
      // Если имеется хотя бы один элемент,
      // заполняем массив $arr
      if(mysql_num_rows($tbl))
      {
        while($arr[] = mysql_fetch_array($tbl));
      }
      // Удаляем последний нулевой элемент 
      // массива $arr
      unset($arr[count($arr) - 1]);

      return $arr;
    }
  }
?>