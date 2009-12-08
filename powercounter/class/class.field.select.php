<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-студия SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // Выпадающий список select
  ////////////////////////////////////////////////////////////
  // Выставляем уровень обработки ошибок (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE);

  class field_select extends field
  {
    // Размер текстового поля
    protected $options;
    // Является ли список - мультисписком
    protected $multi;
    // Высота списка
    protected $select_size;
    // Конструктор класса
    function __construct($name, 
                   $caption, 
                   $options = array(),
                   $value,
                   $multi = false,
                   $select_size = 4,
                   $parameters = "")
    {
      // Вызываем конструктор базового класса field для 
      // инициализации его данных
      parent::__construct($name, 
                   "select", 
                   $caption, 
                   false, 
                   $value,
                   $parameters);
      // Инициализируем члены класса
      $this->options     = $options;
      $this->multi       = $multi;
      $this->select_size = $select_size;
    }

    // Метод, для возврата имени названия поля
    // и самого тэга элемента управления
    function get_html()
    {
      // Если элементы оформления не пусты - учитываем их
      if(!empty($this->css_style))
      {
        $style = "style=\"".$this->css_style."\"";
      }
      else $style = "";
      if(!empty($this->css_class))
      {
        $class = "class=\"".$this->css_class."\"";
      }
      else $class = "";

      if($this->multi && $this->select_size)
      { 
        $multi = "multiple size=".$this->select_size;
        $this->name = $this->name."[]";
      }
      else $multi = "";
      // Формируем тэг
      $tag = "<select $style $class name=\"".$this->name."\" $multi>\n";
      if(!empty($this->options))
      {
        foreach($this->options as $key => $value)
        {
          if(is_array($this->value))
          {
            if(in_array($key,$this->value)) $selected = "selected";
            else $selected = "";
          }
          else if($key == trim($this->value)) $selected = "selected";
          else $selected = "";
          $tag .= "<option value='".
                    htmlspecialchars($key, ENT_QUOTES)
                   ."' $selected>".
                    htmlspecialchars($value, ENT_QUOTES)
                   ."</option>\n";
        }
      }
      $tag .= "</select>\n";

      // Формируем подсказку, если она имеется
      $help = "";
      if(!empty($this->help))
      {
        $help .= "<span style='color:blue'>".
                    nl2br($this->help)
                ."</span>";
      }
      if(!empty($help)) $help .= "<br>";
      if(!empty($this->help_url))
      {
        $help .= "<span style='color:blue'>
                    <a href=".$this->help_url.">помощь</a>
                  </span>";
      }

      return array($this->caption, $tag, $help);
    }

    // Метод, проверяющий корректность переданных данных
    function check()
    {
      // Получаем список возможных значений списка
      if(!in_array($this->value,array_keys($this->options)))
      {
        if(empty($this->value))
        {
          return "Поле \"".$this->caption."\" 
                  содержит недопустимое значение";
        }
      }
      if (!get_magic_quotes_gpc()) 
      {
        for($i = 0; $i < count($this->value); $i++)
        {
          $this->value[$i] = mysql_escape_string($this->value[$i]);
        }
      }

      return "";
    }
    // Выбранный элемент
    function selected()
    {
      return $this->value[0];
    }
  }
?>