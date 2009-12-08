<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-студия SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // Базовый класс элемента управления HTML-формы, от 
  // него наследуются все остальные элементы управления
  ////////////////////////////////////////////////////////////
  // Выставляем уровень обработки ошибок (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE);
  abstract class field
  {
    ///////////////
    // Члены класса
    ///////////////
    // Имя элемента управления
    protected $name;
    // Тип элемента управления
    protected $type;
    // Название слева от элемента управления
    protected $caption;
    // Значение элемента управления
    protected $value;
    // Обязателен ли элемент к заполнению
    protected $is_required;
    // Строка дополнительных параметров
    protected $parameters;
    // Подсказка
    protected $help;
    // Ссылка на подсказку
    protected $help_url;

    // Класс CSS
    public $css_class;
    // Стиль CSS
    public $css_style;


    ////////////////
    // Методы класса
    ////////////////
    // Конструктор класса
    function __construct($name, 
                   $type, 
                   $caption, 
                   $is_required = false, 
                   $value = "",
                   $parameters = "", 
                   $help = "",
                   $help_url = "")
    {
      $this->name        = $this->encodestring($name);
      $this->type        = $type;
      $this->caption     = $caption;
      $this->value       = $value;
      $this->is_required = $is_required;
      $this->parameters  = $parameters;
      $this->help        = $help;
      $this->help_url    = $help_url;
    }
    // Метод проверяющий корректность заполнения поля
    abstract function check();
    // Абстрактный метод, для возврата имени названия поля
    // и самого тэга элемента управления (каждый наследник
    // должен этот метод переопределить)
    abstract function get_html();

    // Доступ к закрытым и защищённым элементам класса
    // только для чтения
    public function __get($key)
    {
      if(isset($this->$key)) return $this->$key;
      else 
      {
        throw new ExceptionMember($key, 
              "Член ".__CLASS__."::$key не существует");
      }
    }

    // функция превода текста с русского языка в траслит
    protected function encodestring($st)
    {
      // Сначала заменяем "односимвольные" фонемы.
      $st=strtr($st,"абвгдеёзийклмнопрстуфхъыэ_",
      "abvgdeeziyklmnoprstufh'iei");
      $st=strtr($st,"АБВГДЕЁЗИЙКЛМНОПРСТУФХЪЫЭ_",
      "ABVGDEEZIYKLMNOPRSTUFH'IEI");
      // Затем - "многосимвольные".
      $st=strtr($st, 
                      array(
                          "ж"=>"zh", "ц"=>"ts", "ч"=>"ch", "ш"=>"sh", 
                          "щ"=>"shch","ь"=>"", "ю"=>"yu", "я"=>"ya",
                          "Ж"=>"ZH", "Ц"=>"TS", "Ч"=>"CH", "Ш"=>"SH", 
                          "Щ"=>"SHCH","Ь"=>"", "Ю"=>"YU", "Я"=>"YA",
                          "ї"=>"i", "Ї"=>"Yi", "є"=>"ie", "Є"=>"Ye"
                          )
               );
      // Возвращаем результат.
      return $st;
    }
  }
?>