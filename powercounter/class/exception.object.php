<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-студия SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // Обращение к объекту, отличному от field-производного
  ////////////////////////////////////////////////////////////

  class ExceptionObject extends Exception
  {
    // Имя объекта
    protected $key;

    public function __construct($key, $message)
    {
      $this->key = $key;

      // Вызываем конструктор базового класса
      parent::__construct($message);
    }

    public function getKey()
    {
      return $this->key;
    }
  }
?>