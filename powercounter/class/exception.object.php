<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-������ SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // ��������� � �������, ��������� �� field-������������
  ////////////////////////////////////////////////////////////

  class ExceptionObject extends Exception
  {
    // ��� �������
    protected $key;

    public function __construct($key, $message)
    {
      $this->key = $key;

      // �������� ����������� �������� ������
      parent::__construct($message);
    }

    public function getKey()
    {
      return $this->key;
    }
  }
?>