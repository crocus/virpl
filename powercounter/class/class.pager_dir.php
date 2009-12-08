<?php
  class pager_dir extends pager_abstract
  {
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
    public function get_total()
    {
      $countline = 0;
      // ��������� ����������
      if(($dir = opendir($this->dirname)) !== false)
      {
        while(($file = readdir($dir)) !== false)
        {
          // ���� ������� ������� �������� ������
          // ������������ �
          if(is_file($this->dirname."/".$file)) $countline++;
        }
        // ��������� ����������
        closedir($dir);
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
      // �����, ������� � �������� �������
      // �������� ������ �����
      $first = ($page - 1)*$this->get_pnumber();
      // ��������� ����������
      if(($dir = opendir($this->dirname)) === false) return 0;
      $i = -1;
      while(($file = readdir($dir)) !== false)
      {
        // ���� ������� ������� �������� ������
        if(is_file($this->dirname."/".$file))
        {
          // ����������� �������
          $i++;
          // ���� �� ��������� ����� $first
          // �������� ����������� ��������
          if($i < $first) continue;
          // ���� ��������� ����� �������
          // �������� �������� ����
          if($i > $first + $this->get_pnumber() - 1) break;
          // �������� ���� � ������ � ������,
          // ������� ����� ��������� �������
          $arr[] = $this->dirname."/".$file;
        }
      }
      // ��������� ����������
      closedir($dir);

      return $arr;
    }
  }
?>
