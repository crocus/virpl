<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-студия SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // Текстовая область textarea
  ////////////////////////////////////////////////////////////
  // Выставляем уровень обработки ошибок (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE);

  class field_textarea extends field
  {
    // Размер текстового поля
    protected $cols;
    // Максимальный размер вводимых данных
    protected $rows;
    // Блокировка поля
    protected $disabled;
    // Только для чтения
    protected $readonly;
    // Отсуствие автоперевода строк
    protected $wrap;

    // Конструктор класса
    function __construct($name, 
                   $caption, 
                   $id_required = false, 
                   $value = "",
                   $cols = 35,
                   $rows = 7,
                   $disabled = false,
                   $readonly = false,
                   $wrap = false,
                   $parameters = "", 
                   $help = "",
                   $help_url = "")
    {
      // Вызываем конструктор базового класса field для 
      // инициализации его данных
      parent::__construct($name, 
                   "textarea", 
                   $caption, 
                   $id_required, 
                   $value,
                   $parameters, 
                   $help,
                   $help_url);
      // Инициируем члены класса field_text
      $this->cols     = $cols;
      $this->rows     = $rows;
      $this->disabled = $disabled;
      $this->readonly = $readonly;
      $this->wrap     = $wrap;
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
      if(!empty($this->cols))
      {
        $cols = "cols=".$this->cols;
      }
      else $cols = "";
      if(!empty($this->rows))
      {
        $rows = "rows=".$this->rows;
      }
      else $rows = "";

      // Атрибуты текстовой области
      if($this->disabled) $disabled = "disabled";
      else $disabled = "";
      if($this->readonly) $readonly = "readonly";
      else $readonly = "";
      if($this->wrap) $wrap = "wrap";
      else $wrap = "";


      if(is_array($this->value))
      {
        $this->value = implode("\r\n",$this->value);
      }
      if(!get_magic_quotes_gpc())
      {
        $output = str_replace('\r\n',"\r\n",$this->value);
      }
      else $output = $this->value;
      $tag = "<textarea $style $class
              name=\"".$this->name."\"
              $cols $rows $disabled $readonly $wrap>".
              htmlspecialchars($output, ENT_QUOTES).
             "</textarea>\n";

      // Если поле обязательно, помечаем этот факт
      if($this->is_required) $this->caption .= "&nbsp;*";

      // Формируем подсказку, если она имеется
      $help = "";
      if(!empty($this->help))
      {
        $help .= "<span style='color:blue'>".nl2br($this->help)."</span>";
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
      // Обезопасить текст перед внесением в базу данных
      if (!get_magic_quotes_gpc())
      {
        $this->value = mysql_escape_string($this->value);
      }
      if($this->is_required)
      {
        if(empty($this->value))
        {
          return "Поле \"".$this->caption."\" не заполнено";
        }
      }

      return "";
    }
  }
?>