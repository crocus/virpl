<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-студия SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // Обращение к несуществующему члену
  ////////////////////////////////////////////////////////////
  class ExceptionMember extends Exception
  {
    // Имя не существующего члена
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
