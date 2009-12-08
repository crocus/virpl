<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-студия SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // Элемент управления для выбора даты
  ////////////////////////////////////////////////////////////
  // Выставляем уровень обработки ошибок (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE);

  class field_date extends field
  {
    // Время в time
    protected $time;
    // Начальный год
    protected $begin_year;
    // Конечный год
    protected $end_year;
    // Конструктор класса
    function __construct($name, 
                   $caption, 
                   $time,
                   $begin_year = 1970,
                   $end_year = 2020,
                   $parameters = "", 
                   $help = "",
                   $help_url = "")
    {
      // Вызываем конструктор базового класса field для 
      // инициализации его данных
      parent::__construct($name, 
                   "date", 
                   $caption, 
                   $is_required, 
                   $value,
                   $parameters, 
                   $help,
                   $help_url);
      
      if(empty($time)) $this->time = time();
      else if(is_array($time))
      {
        $this->time     = mktime($time['hour'],
                                 $time['minute'],
                                 0,
                                 $time['month'],
                                 $time['day'],
                                 $time['year']);
      }
      else $this->time  = $time;
      if(!empty($begin_year)) $this->begin_year = $begin_year;
      else $this->begin_year = 1970;
      if(!empty($end_year)) $this->end_year   = $end_year;
      else $this->end_year   = 2020;
    }

    // Дата в формате MySQL
    function get_mysql_format()
    {
      return date("Y-m-d", $this->time);
    }

    // Метод, для возврата имени названия поля
    // и самого тэга элемента управления
    function get_html()
    {
      // Если элементы оформления не пусты - учитываем их
      if(!empty($this->css_style)) $style = "style=\"".$this->css_style."\"";
      else $style = "";
      if(!empty($this->css_class)) $class = "class=\"".$this->css_class."\"";
      else $class = "";

      // Формируем тэг
      $date_month  = @date("m", $this->time);
      $date_day    = @date("d", $this->time);
      $date_year   = @date("Y", $this->time);
      $date_hour   = @date("H", $this->time);
      $date_minute = @date("i", $this->time);

      // Выпадающий список для дня
      $tag = "<select title='День' $style $class type=text name='".$this->name."[day]'>\n";
      for($i = 1; $i <= 31; $i++)
      {
        if($date_day == $i) $temp = "selected";
        else $temp = "";
        $tag .= "<option value=$i $temp>".sprintf("%02d", $i);
      }
      $tag .= "</select>";
      // Выпадающий список для месяца
      $tag .= "<select title='Месяц' $style $class type=text name='".$this->name."[month]'>";
      for($i = 1; $i <= 12; $i++)
      {
        if($date_month == $i) $temp = "selected";
        else $temp = "";
        $tag .= "<option value=$i $temp>".sprintf("%02d", $i);
      }
      $tag .= "</select>";
      // Выпадающий список для года
      $tag .= "<select title='Год' $style $class type=text name='".$this->name."[year]'>";
      for($i = $this->begin_year; $i <= $this->end_year; $i++)
      {
        if($date_year == $i) $temp = "selected";
        else $temp = "";
        $tag .= "<option value=$i $temp>$i";
      }
      $tag .= "</select>";

      // Если поле обязательно, помечаем этот факт
      if($this->is_required) $this->caption .= " *";

      // Формируем подсказку, если она имеется
      $help = "";
      if(!empty($this->help)) $help .= "<span style='color:blue'>".nl2br($this->help)."</span>";
      if(!empty($help)) $help .= "<br>";
      if(!empty($this->help_url)) $help .= "<span style='color:blue'><a href=".$this->help_url.">помощь</a></span>";

      return array($this->caption, $tag, $help);
    }

    // Метод, проверяющий корректность переданных данных
    function check()
    {
      if(date('Y', $this->time) > $this->end_year || date('Y', $this->time) < $this->begin_year)
      {
        return "Поле \"".$this->caption."\" содержит недопустимое значение (его значение должно лежать в диапазоне ".$this->begin_year."-".$this->end_year.")";
      }

      return "";
    }
  }
?>