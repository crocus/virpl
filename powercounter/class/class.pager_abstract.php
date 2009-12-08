<?php
  abstract class pager_abstract extends pager
  {
    // Имя директории
    protected $dirname;
    // Количество позиций на странице
    protected $pnumber;
    // Количество ссылок слева и справа
    // от текущей страницы
    protected $page_link;
    // Параметры
    protected $parameters;
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
  }
?>
