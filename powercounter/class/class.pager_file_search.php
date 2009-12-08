<?php
  class pager_file_search extends pager_file
  {
    // ������ �����
    private $search;
    // �����������
    public function __construct($search,
                                $filename, 
                                $pnumber = 10, 
                                $page_link = 3)
    {
      parent::__construct($filename, 
                          $pnumber, 
                          $page_link, 
                          "&search=".urlencode($search));
      $this->search   = $search;
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
          $str = fgets($fd, 10000);
          if(preg_match("|^".preg_quote($this->search)."|i", $str)) $countline++;
        }
        // ��������� ����
        fclose($fd);
      }
      return $countline;
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
      while(!feof($fd))
      {
        $str = fgets($fd, 10000);
        if(preg_match("|^".preg_quote($this->search)."|i", $str))
        {
          $countline++;
          // ���� �� ��������� ����� $first
          // �������� ����������� ��������
          if($countline < $first) continue;
          // ���� ��������� ����� �������
          // �������� �������� ����
          if($countline > $first + $this->get_pnumber() - 1) break;
          // �������� ������ ����� � ������,
          // ������� ����� ��������� �������
          $arr[] = $str;
        }
      }
      // ��������� ����
      fclose($fd);

      return $arr;
    }
  }
?>