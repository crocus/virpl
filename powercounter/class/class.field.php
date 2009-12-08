<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-������ SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // ������� ����� �������� ���������� HTML-�����, �� 
  // ���� ����������� ��� ��������� �������� ����������
  ////////////////////////////////////////////////////////////
  // ���������� ������� ��������� ������ (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE);
  abstract class field
  {
    ///////////////
    // ����� ������
    ///////////////
    // ��� �������� ����������
    protected $name;
    // ��� �������� ����������
    protected $type;
    // �������� ����� �� �������� ����������
    protected $caption;
    // �������� �������� ����������
    protected $value;
    // ���������� �� ������� � ����������
    protected $is_required;
    // ������ �������������� ����������
    protected $parameters;
    // ���������
    protected $help;
    // ������ �� ���������
    protected $help_url;

    // ����� CSS
    public $css_class;
    // ����� CSS
    public $css_style;


    ////////////////
    // ������ ������
    ////////////////
    // ����������� ������
    function __construct($name, 
                   $type, 
                   $caption, 
                   $is_required = false, 
                   $value = "",
                   $parameters = "", 
                   $help = "",
                   $help_url = "")
    {
      $this->name        = $this->encodestring($name);
      $this->type        = $type;
      $this->caption     = $caption;
      $this->value       = $value;
      $this->is_required = $is_required;
      $this->parameters  = $parameters;
      $this->help        = $help;
      $this->help_url    = $help_url;
    }
    // ����� ����������� ������������ ���������� ����
    abstract function check();
    // ����������� �����, ��� �������� ����� �������� ����
    // � ������ ���� �������� ���������� (������ ���������
    // ������ ���� ����� ��������������)
    abstract function get_html();

    // ������ � �������� � ���������� ��������� ������
    // ������ ��� ������
    public function __get($key)
    {
      if(isset($this->$key)) return $this->$key;
      else 
      {
        throw new ExceptionMember($key, 
              "���� ".__CLASS__."::$key �� ����������");
      }
    }

    // ������� ������� ������ � �������� ����� � �������
    protected function encodestring($st)
    {
      // ������� �������� "��������������" ������.
      $st=strtr($st,"������������������������_",
      "abvgdeeziyklmnoprstufh'iei");
      $st=strtr($st,"�����Ũ������������������_",
      "ABVGDEEZIYKLMNOPRSTUFH'IEI");
      // ����� - "���������������".
      $st=strtr($st, 
                      array(
                          "�"=>"zh", "�"=>"ts", "�"=>"ch", "�"=>"sh", 
                          "�"=>"shch","�"=>"", "�"=>"yu", "�"=>"ya",
                          "�"=>"ZH", "�"=>"TS", "�"=>"CH", "�"=>"SH", 
                          "�"=>"SHCH","�"=>"", "�"=>"YU", "�"=>"YA",
                          "�"=>"i", "�"=>"Yi", "�"=>"ie", "�"=>"Ye"
                          )
               );
      // ���������� ���������.
      return $st;
    }
  }
?>