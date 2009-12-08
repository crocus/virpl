<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-������ SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // �������� (�����)
  ////////////////////////////////////////////////////////////
  // ���������� ������� ��������� ������ (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE);

  class field_paragraph extends field
  {
    // ����������� ������
    function __construct($value = "",
                         $parameters = "")
    {
      // �������� ����������� �������� ������ field ��� 
      // ������������� ��� ������
      parent::__construct("", 
                   "paragraph", 
                   "", 
                   false, 
                   $value,
                   $parameters, 
                   "",
                   "");
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

      return array($this->caption, nl2br($tag));
    }

    // �����, ����������� ������������ ���������� ������
    function check()
    {
      return "";
    }
  }
?>