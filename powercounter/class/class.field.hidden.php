<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-������ SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // ������� ���� hidden
  ////////////////////////////////////////////////////////////
  // ���������� ������� ��������� ������ (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE);

  class field_hidden extends field
  {
    // ����������� ������
    function __construct($name, 
                   $id_required = false, 
                   $value = "")
    {
      // �������� ����������� �������� ������ field ��� 
      // ������������� ��� ������
      parent::__construct($name, 
                   "hidden", 
                   "-", 
                   $id_required, 
                   $value,
                   $parameters, 
                   "",
                   "");
    }
    
    // �����, ��� �������� ����� �������� ����
    // � ������ ���� �������� ����������
    function get_html()
    {
      $tag = "<input type=\"".$this->type."\" 
                     name=\"".$this->name."\" 
                     value=\"".htmlspecialchars($this->value, ENT_QUOTES)."\">\n";
      return array("", $tag);
    }
    // �����, ����������� ������������ ���������� ������
    function check()
    {
      // ����������� ����� ����� ��������� � ���� ������
      if (!get_magic_quotes_gpc())
      {
        $this->value = mysql_escape_string($this->value);
      }
      if($this->is_required)
      {
        if(empty($this->value)) return "������� ���� �� ���������";
      }

      return "";
    }
  }
?>