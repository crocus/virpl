<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-������ SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // ��������� ���� ��� ����������� ������
  ////////////////////////////////////////////////////////////
  // ���������� ������� ��������� ������ (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE);

  class field_text_english extends field_text
  {
    // �����, ����������� ������������ ���������� ������
    function check()
    {
      // ����������� ����� ����� ��������� � ���� ������
      if (!get_magic_quotes_gpc())
      {
        $this->value = mysql_escape_string($this->value);
      }
      if($this->is_required) $pattern = "|^[a-z]+$|i";
      else $pattern = "|^[a-z]*$|i";

      // ��������� ���� value �� ���������� ������
      if(!preg_match($pattern, $this->value))
      {
        return "���� \"{$this->caption}\" ������ ��������� ������ ������� ���������� ��������";
      }

      return "";
    }
  }
?>