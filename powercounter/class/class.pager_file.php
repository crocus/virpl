<?php
  class pager_file extends pager
  {
    // ��� �����
    protected $filename;
    // ���������� ������� �� ��������
    private $pnumber;
    // ���������� ������ ����� � ������
    // �� ������� ��������
    private $page_link;
    // ���������
    private $parameters;
    // �����������
    public function __construct($filename, 
                                $pnumber = 10, 
                                $page_link = 3, 
                                $parameters = "")
    {
      $this->filename   = $filename;
      $this->pnumber    = $pnumber;
      $this->page_link  = $page_link;
      $this->parameters = $parameters;
    }
    public function get_total()
    {
      $countline = 0;
      // ��������� ����
      $fd = fopen($this->filename, "r");
      if($fd)
      {
        // ������������ ���������� �������
        // � �����
        while(!feof($fd))
        {
          fgets($fd, 10000);
          $countline++;
        }
        // ��������� ����
        fclose($fd);
      }
      return $countline;
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
    // ���������� ������ ����� �����, �� 
    // ������ �������� $index
    public function get_page()
    {
      // ������� ��������
      $page = $_GET['page'];
      if(empty($page)) $page = 1;
      // ���������� ������� � �����
      $total = $this->get_total();
      // ��������� ����� ������� � �������
      $number = (int)($total/$this->get_pnumber());
      if((float)($total/$this->get_pnumber()) - $number != 0) $number++;
      // ��������� �������� �� ������������� ����� 
      // �������� � �������� �� 1 �� get_total()
      if($page <= 0 || $page > $number) return 0;
      // ��������� ������� ������� ��������
      $arr = array();
      $fd = fopen($this->filename, "r");
      if(!$fd) return 0;
      // �����, ������� � �������� �������
      // �������� ������ �����
      $first = ($page - 1)*$this->get_pnumber();
      for($i = 0; $i < $total; $i++)
      {
        $str = fgets($fd, 10000);
        // ���� �� ��������� ����� $first
        // �������� ����������� ��������
        if($i < $first) continue;
        // ���� ��������� ����� �������
        // �������� �������� ����
        if($i > $first + $this->get_pnumber() - 1) break;
        // �������� ������ ����� � ������,
        // ������� ����� ��������� �������
        $arr[] = $str;
      }
      fclose($fd);

      return $arr;
    }
  }
?>
