<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-������ SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // ��������� ������� textarea
  ////////////////////////////////////////////////////////////
  // ���������� ������� ��������� ������ (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE);

  class field_textarea extends field
  {
    // ������ ���������� ����
    protected $cols;
    // ������������ ������ �������� ������
    protected $rows;
    // ���������� ����
    protected $disabled;
    // ������ ��� ������
    protected $readonly;
    // ��������� ������������ �����
    protected $wrap;

    // ����������� ������
    function __construct($name, 
                   $caption, 
                   $id_required = false, 
                   $value = "",
                   $cols = 35,
                   $rows = 7,
                   $disabled = false,
                   $readonly = false,
                   $wrap = false,
                   $parameters = "", 
                   $help = "",
                   $help_url = "")
    {
      // �������� ����������� �������� ������ field ��� 
      // ������������� ��� ������
      parent::__construct($name, 
                   "textarea", 
                   $caption, 
                   $id_required, 
                   $value,
                   $parameters, 
                   $help,
                   $help_url);
      // ���������� ����� ������ field_text
      $this->cols     = $cols;
      $this->rows     = $rows;
      $this->disabled = $disabled;
      $this->readonly = $readonly;
      $this->wrap     = $wrap;
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
      if(!empty($this->cols))
      {
        $cols = "cols=".$this->cols;
      }
      else $cols = "";
      if(!empty($this->rows))
      {
        $rows = "rows=".$this->rows;
      }
      else $rows = "";

      // �������� ��������� �������
      if($this->disabled) $disabled = "disabled";
      else $disabled = "";
      if($this->readonly) $readonly = "readonly";
      else $readonly = "";
      if($this->wrap) $wrap = "wrap";
      else $wrap = "";


      if(is_array($this->value))
      {
        $this->value = implode("\r\n",$this->value);
      }
      if(!get_magic_quotes_gpc())
      {
        $output = str_replace('\r\n',"\r\n",$this->value);
      }
      else $output = $this->value;
      $tag = "<textarea $style $class
              name=\"".$this->name."\"
              $cols $rows $disabled $readonly $wrap>".
              htmlspecialchars($output, ENT_QUOTES).
             "</textarea>\n";

      // ���� ���� �����������, �������� ���� ����
      if($this->is_required) $this->caption .= "&nbsp;*";

      // ��������� ���������, ���� ��� �������
      $help = "";
      if(!empty($this->help))
      {
        $help .= "<span style='color:blue'>".nl2br($this->help)."</span>";
      }
      if(!empty($help)) $help .= "<br>";
      if(!empty($this->help_url))
      {
        $help .= "<span style='color:blue'>
                    <a href=".$this->help_url.">������</a>
                  </span>";
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
      if($this->is_required)
      {
        if(empty($this->value))
        {
          return "���� \"".$this->caption."\" �� ���������";
        }
      }

      return "";
    }
  }
?>