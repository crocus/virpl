<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-������ SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // ��������� ���� text
  ////////////////////////////////////////////////////////////
  // ���������� ������� ��������� ������ (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE);

  class field_text extends field
  {
    // ������ ���������� ����
    public $size;
    // ������������ ������ �������� ������
    public $maxlength;
    // ����������� ������
    function __construct($name, 
                   $caption, 
                   $is_required = false, 
                   $value = "",
                   $maxlength = 255,
                   $size = 41,
                   $parameters = "", 
                   $help = "",
                   $help_url = "")
    {
      // �������� ����������� �������� ������ field ��� 
      // ������������� ��� ������
      parent::__construct($name, 
                   "text", 
                   $caption, 
                   $is_required, 
                   $value,
                   $parameters, 
                   $help,
                   $help_url);
      // �������������� ����� ������
      $this->size = $size;
      $this->maxlength = $maxlength;
    }

    // �����, ��� �������� ����� �������� ����
    // � ������ ���� �������� ����������
    function get_html()
    {
      // ���� �������� ���������� �� ����� - ��������� ��
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

      // ���� ���������� ������� - ��������� ��
      if(!empty($this->size)) $size = "size=".$this->size;
      else $size = "";
      if(!empty($this->maxlength))
      {
        $maxlength = "maxlength=".$this->maxlength;
      }
      else $maxlength = "";

      // ��������� ���
      $tag = "<input $style $class
                 type=\"".$this->type."\" 
                 name=\"".$this->name."\" 
                 value=\"".
                 htmlspecialchars($this->value, ENT_QUOTES)."\"
                 $size $maxlength>\n";

      // ���� ���� �����������, �������� ���� ����
      if($this->is_required) $this->caption .= "&nbsp;*";

      // ��������� ���������, ���� ��� �������
      $help = "";
      if(!empty($this->help))
      {
        $help .= "<span style='color:blue'>".
                        nl2br($this->help)."</span>";
      }
      if(!empty($help)) $help .= "<br>";
      if(!empty($this->help_url))
      {
        $help .= "<span style='color:blue'><a href=".
                  $this->help_url.">������</a></span>";
      }

      return array($this->caption, $tag, $help);
    }

    // �����, ����������� ������������ ���������� ������
    function check()
    {
      // ����������� ����� ����� ��������� � ���� ������
      if (!get_magic_quotes_gpc())
      {
        $this->value = mysql_escape_string($this->value);
      }

      // ���� ���� ����������� ��� ����������
      if($this->is_required)
      {
        // ��������� �� ����� �� ���
        if(empty($this->value))
        {
          return "���� \"".$this->caption."\" �� ���������";
        }
      }

      return "";
    }
  }
?>