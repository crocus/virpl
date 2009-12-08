<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-студия SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // Радио-кнопки radio
  ////////////////////////////////////////////////////////////
  // Выставляем уровень обработки ошибок (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE);

  class field_radio extends field
  {
    // Варианты ответов
    protected $radio;
    // Конструктор класса
    function __construct($name, 
                   $caption, 
                   $radio = array(),
                   $value,
                   $parameters = "", // horizontal
                   $help = "",
                   $help_url = "")
    {
      // Вызываем конструктор базового класса field для 
      // инициализации его данных
      parent::__construct($name, 
                   "radio", 
                   $caption, 
                   false, 
                   $value,
                   $parameters, 
                   $help,
                   $help_url);
      // Инициализируем члены класса
      if($this->radio != "radio_rate") $this->radio = $radio;
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

      $this->type = "radio";
      // Формируем тэг
      $tag = "";
      if(!empty($this->radio))
      {
        foreach($this->radio as $key => $value)
        {
          if($key == $this->value) $checked = "checked";
          else $checked ="";
          if(strpos($this->parameters, "horizontal") !== false)
          {
            $tag .= "<input $style $class 
                      type=".$this->type." 
                      name=".$this->name."[] 
                      $checked value='$key'>$value";
          }
          else
          {
            $tag[] = "<input $style $class 
                       type=".$this->type." 
                       name=".$this->name."[] 
                       $checked value='$key'>$value\n";
          }
        }
      }

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
      if (!get_magic_quotes_gpc())
      {
        $this->value = mysql_escape_string($this->value);
      }
      if(!@in_array($this->value,array_keys($this->radio)))
      {
        if(empty($this->value))
        {
          return "Поле \"".$this->caption."\" содержит недопустимое значение";
        }
      }

      return "";
    }
  }
?>