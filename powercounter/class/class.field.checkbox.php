<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-студия SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // Флажок checkbox
  ////////////////////////////////////////////////////////////
  // Выставляем уровень обработки ошибок (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE);

  class field_checkbox extends field
  {
    // Конструктор класса
    function __construct($name, 
                   $caption, 
                   $value = false,
                   $parameters = "", 
                   $help = "",
                   $help_url = "")
    {
      // Вызываем конструктор базового класса field для 
      // инициализации его данных
      parent::__construct($name, 
                   "checkbox", 
                   $caption, 
                   false, 
                   $value,
                   $parameters, 
                   $help,
                   $help_url);
      // Инициализируем члены класса
      if($value == "on") $this->value = true;
      else if($value === true) $this->value = true;
      else $this->value = false;
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
      
      // Проверяем отмечен ли флажок
      if($this->value) $checked = "checked";
      else $checked = "";

      // Формируем тэг
      $tag = "<input $style $class
                     type=\"".$this->type."\" 
                     name=\"".$this->name."\" 
                     $checked>\n";

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
      return "";
    }
  }
?>