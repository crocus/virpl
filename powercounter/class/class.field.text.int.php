<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-������ SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // ��������� ���� � �������������� ����������
  ////////////////////////////////////////////////////////////
  // ���������� ������� ��������� ������ (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE);

  class field_text_int extends field_text
  {
    // ����������� �������� ����
    protected $min_value;
    // ������������ ������� ����
    protected $max_value;
    // ����������� ������
    function __construct($name, 
                   $caption, 
                   $is_required = false, 
                   $value = "",
                   $min_value = 0,
                   $max_value = 0,
                   $maxlength = 255,
                   $size = 41,
                   $parameters = "", 
                   $help = "",
                   $help_url = "")
    {
      // �������� ����������� �������� ������ field_text ��� 
      // ������������� ��� ������
      parent::__construct($name, 
                   $caption, 
                   $is_required, 
                   $value,
                   $maxlength,
                   $size,
                   $parameters, 
                   $help,
                   $help_url);
      $this->min_value = intval($min_value);
      $this->max_value = intval($max_value);

      // ����������� �������� ������ ���� ������ �������������
      if($this->min_value > $this->max_value)
      {
        throw Exception("����������� �������� ������ 
                         ���� ������ ������������ 
                         ��������. ���� \"".$this->caption."\".");
      }
    }

    // �����, ����������� ������������ ���������� ������
    function check()
    {
      $pattern = "|^[-\d]*$|i";
      if($this->is_required)
      {
        // ��������� ���� value �� ������������ � ����������� ��������
        if($this->min_value != $this->max_value)
        {
          if($this->value < $this->min_value || 
             $this->value > $this->max_value)
          {
            return "���� \"".$this->caption."\" 
                    ������ ���� ������ ".$this->min_value." 
                    � ������ ".$this->max_value."";
          }
        }
        $pattern = "|^[-\d]+$|i";
      }
      // ���������, �������� �� �������� ��������
      // ����� ������
      if(!preg_match($pattern, $this->value))
      {
        return "���� \"".$this->caption."\" 
                ������ ��������� ���� �����";
      }

      return "";
    }
  }
?>