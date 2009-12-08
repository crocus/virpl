<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-������ SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // �����-������ radio
  ////////////////////////////////////////////////////////////
  // ���������� ������� ��������� ������ (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE);

  class field_radio extends field
  {
    // �������� �������
    protected $radio;
    // ����������� ������
    function __construct($name, 
                   $caption, 
                   $radio = array(),
                   $value,
                   $parameters = "", // horizontal
                   $help = "",
                   $help_url = "")
    {
      // �������� ����������� �������� ������ field ��� 
      // ������������� ��� ������
      parent::__construct($name, 
                   "radio", 
                   $caption, 
                   false, 
                   $value,
                   $parameters, 
                   $help,
                   $help_url);
      // �������������� ����� ������
      if($this->radio != "radio_rate") $this->radio = $radio;
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

      $this->type = "radio";
      // ��������� ���
      $tag = "";
      if(!empty($this->radio))
      {
        foreach($this->radio as $key => $value)
        {
          if($key == $this->value) $checked = "checked";
          else $checked ="";
          if(strpos($this->parameters, "horizontal") !== false)
          {
            $tag .= "<input $style $class 
                      type=".$this->type." 
                      name=".$this->name."[] 
                      $checked value='$key'>$value";
          }
          else
          {
            $tag[] = "<input $style $class 
                       type=".$this->type." 
                       name=".$this->name."[] 
                       $checked value='$key'>$value\n";
          }
        }
      }

      // ��������� ���������, ���� ��� �������
      $help = "";
      if(!empty($this->help))
      {
        $help .= "<span style='color:blue'>".
                    nl2br($this->help)
                ."</span>";
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
      // �������� ������ ��������� �������� ������
      if (!get_magic_quotes_gpc())
      {
        $this->value = mysql_escape_string($this->value);
      }
      if(!@in_array($this->value,array_keys($this->radio)))
      {
        if(empty($this->value))
        {
          return "���� \"".$this->caption."\" �������� ������������ ��������";
        }
      }

      return "";
    }
  }
?>