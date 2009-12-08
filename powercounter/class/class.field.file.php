<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-������ SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // �������� ����� �� ������ file
  ////////////////////////////////////////////////////////////
  // ���������� ������� ��������� ������ (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE);

  class field_file extends field
  {
    // ���������� ����������
    protected $dir;
    // �������
    protected $prefix;
    // ����������� ������
    function __construct($name, 
                   $caption, 
                   $is_required = false, 
                   $value, // $_FILES
                   $dir,
                   $prefix = "",
                   $help = "",
                   $help_url = "")
    {
      // �������� ����������� �������� ������ field ��� 
      // ������������� ��� ������
      parent::__construct($name, 
                   "file", 
                   $caption, 
                   $is_required, 
                   $value,
                   "", 
                   $help,
                   $help_url);
      $this->dir = $dir;
      $this->prefix = $prefix;

      if(!empty($this->value))
      {
        // ���������, �� �������� �� ���� �������� PHP 
        // ��� Perl, html, ���� ��� ��� ����������� ��� � ������ .txt
        $extentions = array("#\.php#is",
                            "#\.phtml#is",
                            "#\.php3#is",
                            "#\.html#is",
                            "#\.htm#is",
                            "#\.hta#is",
                            "#\.pl#is",
                            "#\.xml#is",
                            "#\.inc#is",
                            "#\.shtml#is", 
                            "#\.xht#is", 
                            "#\.xhtml#is");
        // �������� ������� ������� �� ��������
        $this->value[$this->name]['name'] = 
              $this->encodestring($this->value[$this->name]['name']);
        // ��������� �� ����� ����� ����������
        $path_parts = pathinfo($this->value[$this->name]['name']);
        $ext = ".".$path_parts['extension'];
        $path = basename($this->value[$this->name]['name'],$ext);
        $add = $ext;
        foreach($extentions AS $exten) 
        {
          if(preg_match($exten, $ext)) $add = ".txt"; 
        }
        $path .= $add; 
        $path = str_replace("//","/",$dir."/".$prefix.$path);
        // ���������� ���� �� ��������� ���������� ������� �
        // ���������� /files Web-����������
        if (copy($this->value[$this->name]['tmp_name'], $path))
        {
          // ���������� ���� �� ��������� ����������
          @unlink($this->value[$this->name]['tmp_name']);
          // �������� ����� ������� � �����
          @chmod($path, 0644);
        }
      }
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

      // ��������� ���
      $tag = "<input $style $class
                     type=\"".$this->type."\" 
                     name=\"".$this->name."\">\n";

      // ���� ���� �����������, �������� ���� ����
      if($this->is_required) $this->caption .= " *";

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
      if($this->is_required)
      {
        if(empty($this->value[$this->name]))
        {
          return "���� \"".$this->caption."\" �� ���������";
        }
      }

      return "";
    }

    // ���������� ���������������� ��� �����
    function get_filename()
    {
      if(!empty($this->value)) 
      {
        if(!empty($this->value[$this->name]['name']))
        {
          return mysql_escape_string($this->encodestring(
            $this->prefix.$this->value[$this->name]['name']));
        }
        else return "";
      }
      else return "";
    }
  }
?>