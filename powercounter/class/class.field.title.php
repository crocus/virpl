<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-������ SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // ��������� (�����)
  ////////////////////////////////////////////////////////////
  // ���������� ������� ��������� ������ (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE);

  class field_title extends field
  {
    // ������ ��������� 1, 2, 3, 4, 5, 6 ��� 
    // h1, h2, h3, h4, h5, h6, ��������������
    protected $h_type;
    // ����������� ������
    function __construct($value = "",
                         $h_type = 3,
                         $parameters = "")
    {
      // �������� ����������� �������� ������ field ��� 
      // ������������� ��� ������
      parent::__construct("", 
                   "title", 
                   "", 
                   false, 
                   $value,
                   $parameters, 
                   "",
                   "");
      if($h_type > 0 && $h_type < 7) $this->h_type = $h_type;
      // �� ��������� ����������� �������� 3
      else $this->h_type = 3;
    }

    // �����, ��� �������� ����� �������� ����
    // � ������ ���� �������� ����������
    function get_html()
    {
      // ��������� ���
      $tag = htmlspecialchars($this->value, ENT_QUOTES);
      $pattern = "#\[b\](.+)\[\/b\]#isU";
      $tag = preg_replace($pattern,'<b>\\1</b>',$tag);
      $pattern = "#\[i\](.+)\[\/i\]#isU";
      $tag = preg_replace($pattern,'<i>\\1</i>',$tag);
      $pattern = "#\[url\][\s]*((?=http:)[\S]*)[\s]*\[\/url\]#si";
      $tag = preg_replace($pattern,'<a href="\\1" target=_blank>\\1</a>',$tag);
      $pattern = "#\[url[\s]*=[\s]*((?=http:)[\S]+)[\s]*\][\s]*([^\[]*)\[/url\]#isU";
      $tag = preg_replace($pattern,
                          '<a href="\\1" target=_blank>\\2</a>',
                          $tag);
      if (get_magic_quotes_gpc()) $tag = stripcslashes($tag);
      $tag = "<h".$this->h_type.">".$this->value."</h".$this->h_type.">";

      return array($this->caption, $tag);
    }

    // �����, ����������� ������������ ���������� ������
    function check()
    {
      return "";
    }
  }
?>