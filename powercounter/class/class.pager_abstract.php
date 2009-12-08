<?php
  abstract class pager_abstract extends pager
  {
    // ��� ����������
    protected $dirname;
    // ���������� ������� �� ��������
    protected $pnumber;
    // ���������� ������ ����� � ������
    // �� ������� ��������
    protected $page_link;
    // ���������
    protected $parameters;
    // �����������
    public function __construct($dirname, 
                                $pnumber = 10, 
                                $page_link = 3, 
                                $parameters = "")
    {
      // ������� ��������� ������ /, ���� �� �������
      $this->dirname    = trim($dirname, "/");
      $this->pnumber    = $pnumber;
      $this->page_link  = $page_link;
      $this->parameters = $parameters;
    }
    public function get_pnumber()
    {
      // ���������� ������� �� ��������
      return $this->pnumber;
    }
    public function get_page_link()
    {
      // ���������� ������ ����� � ������
      // �� ������� ��������
      return $this->page_link;
    }
    public function get_parameters()
    {
      // �������������� ���������, �������
      // ���������� �������� �� ������
      return $this->parameters;
    }
  }
?>
