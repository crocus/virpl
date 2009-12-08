<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-студия SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // Текстовое поле text
  ////////////////////////////////////////////////////////////
  // Выставляем уровень обработки ошибок (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE);

  class field_text extends field
  {
    // Размер текстового поля
    public $size;
    // Максимальный размер вводимых данных
    public $maxlength;
    // Конструктор класса
    function __construct($name, 
                   $caption, 
                   $is_required = false, 
                   $value = "",
                   $maxlength = 255,
                   $size = 41,
                   $parameters = "", 
                   $help = "",
                   $help_url = "")
    {
      // Вызываем конструктор базового класса field для 
      // инициализации его данных
      parent::__construct($name, 
                   "text", 
                   $caption, 
                   $is_required, 
                   $value,
                   $parameters, 
                   $help,
                   $help_url);
      // Инициализируем члены класса
      $this->size = $size;
      $this->maxlength = $maxlength;
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

      // Если определены размеры - учитываем их
      if(!empty($this->size)) $size = "size=".$this->size;
      else $size = "";
      if(!empty($this->maxlength))
      {
        $maxlength = "maxlength=".$this->maxlength;
      }
      else $maxlength = "";

      // Формируем тэг
      $tag = "<input $style $class
                 type=\"".$this->type."\" 
                 name=\"".$this->name."\" 
                 value=\"".
                 htmlspecialchars($this->value, ENT_QUOTES)."\"
                 $size $maxlength>\n";

      // Если поле обязательно, помечаем этот факт
      if($this->is_required) $this->caption .= "&nbsp;*";

      // Формируем подсказку, если она имеется
      $help = "";
      if(!empty($this->help))
      {
        $help .= "<span style='color:blue'>".
                        nl2br($this->help)."</span>";
      }
      if(!empty($help)) $help .= "<br>";
      if(!empty($this->help_url))
      {
        $help .= "<span style='color:blue'><a href=".
                  $this->help_url.">помощь</a></span>";
      }

      return array($this->caption, $tag, $help);
    }

    // Метод, проверяющий корректность переданных данных
    function check()
    {
      // Обезопасить текст перед внесением в базу данных
      if (!get_magic_quotes_gpc())
      {
        $this->value = mysql_escape_string($this->value);
      }

      // Если поле обязательно для заполнения
      if($this->is_required)
      {
        // Проверяем не пусто ли оно
        if(empty($this->value))
        {
          return "Поле \"".$this->caption."\" не заполнено";
        }
      }

      return "";
    }
  }
?>