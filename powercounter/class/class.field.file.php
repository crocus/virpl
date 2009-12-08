<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-студия SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // Загрузка файла на сервер file
  ////////////////////////////////////////////////////////////
  // Выставляем уровень обработки ошибок (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE);

  class field_file extends field
  {
    // Директория назначения
    protected $dir;
    // Префикс
    protected $prefix;
    // Конструктор класса
    function __construct($name, 
                   $caption, 
                   $is_required = false, 
                   $value, // $_FILES
                   $dir,
                   $prefix = "",
                   $help = "",
                   $help_url = "")
    {
      // Вызываем конструктор базового класса field для 
      // инициализации его данных
      parent::__construct($name, 
                   "file", 
                   $caption, 
                   $is_required, 
                   $value,
                   "", 
                   $help,
                   $help_url);
      $this->dir = $dir;
      $this->prefix = $prefix;

      if(!empty($this->value))
      {
        // Проверяем, не является ли файл скриптом PHP 
        // или Perl, html, если это так преобразуем его в формат .txt
        $extentions = array("#\.php#is",
                            "#\.phtml#is",
                            "#\.php3#is",
                            "#\.html#is",
                            "#\.htm#is",
                            "#\.hta#is",
                            "#\.pl#is",
                            "#\.xml#is",
                            "#\.inc#is",
                            "#\.shtml#is", 
                            "#\.xht#is", 
                            "#\.xhtml#is");
        // Заменяем русские символы на транслит
        $this->value[$this->name]['name'] = 
              $this->encodestring($this->value[$this->name]['name']);
        // Извлекаем из имени файла расширение
        $path_parts = pathinfo($this->value[$this->name]['name']);
        $ext = ".".$path_parts['extension'];
        $path = basename($this->value[$this->name]['name'],$ext);
        $add = $ext;
        foreach($extentions AS $exten) 
        {
          if(preg_match($exten, $ext)) $add = ".txt"; 
        }
        $path .= $add; 
        $path = str_replace("//","/",$dir."/".$prefix.$path);
        // Перемещаем файл из временной директории сервера в
        // директорию /files Web-приложения
        if (copy($this->value[$this->name]['tmp_name'], $path))
        {
          // Уничтожаем файл во временной директории
          @unlink($this->value[$this->name]['tmp_name']);
          // Изменяем права доступа к файлу
          @chmod($path, 0644);
        }
      }
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

      // Формируем тэг
      $tag = "<input $style $class
                     type=\"".$this->type."\" 
                     name=\"".$this->name."\">\n";

      // Если поле обязательно, помечаем этот факт
      if($this->is_required) $this->caption .= " *";

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
      if($this->is_required)
      {
        if(empty($this->value[$this->name]))
        {
          return "Поле \"".$this->caption."\" не заполнено";
        }
      }

      return "";
    }

    // Возвращает перекодированное имя файла
    function get_filename()
    {
      if(!empty($this->value)) 
      {
        if(!empty($this->value[$this->name]['name']))
        {
          return mysql_escape_string($this->encodestring(
            $this->prefix.$this->value[$this->name]['name']));
        }
        else return "";
      }
      else return "";
    }
  }
?>