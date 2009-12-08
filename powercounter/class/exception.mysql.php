<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-студия SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // Ошибки обращения к СУБД MySQL
  ////////////////////////////////////////////////////////////

  class ExceptionMySQL extends Exception
  {
    // Сообщение об ошибке
    protected $mysql_error;
    // SQL-запрос
    protected $sql_query;

    public function __construct($mysql_error, $sql_query, $message)
    {
      $this->mysql_error = $mysql_error;
      $this->sql_query = $sql_query;

      // Вызываем конструктор базового класса
      parent::__construct($message);
    }

    public function getMySQLError()
    {
      return $this->mysql_error;
    }
    public function getSQLQuery()
    {
      return $this->sql_query;
    }
  }
?>
