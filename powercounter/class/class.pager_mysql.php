<?php
  class pager_mysql extends pager
  {
    // ��� �������
    protected $tablename;
    // WHERE-�������
    protected $where;
    // �������� ���������� ORDER
    protected $order;
    // ���������� ������� �� ��������
    private $pnumber;
    // ���������� ������ ����� � ������
    // �� ������� ��������
    private $page_link;
    // ���������
    private $parameters;
    // �����������
    public function __construct($tablename, 
                                $where = "",
                                $order = "",
                                $pnumber = 10, 
                                $page_link = 3, 
                                $parameters = "")
    {
      $this->tablename  = $tablename;
      $this->where      = $where;
      $this->order      = $order;
      $this->pnumber    = $pnumber;
      $this->page_link  = $page_link;
      $this->parameters = $parameters;
    }
    public function get_total()
    {
      // ��������� ������ �� ���������
      // ������ ���������� ������� � �������
      $query = "SELECT COUNT(*) FROM {$this->tablename}
                {$this->where}
                {$this->order}";
      $tot = mysql_query($query);
      if(!$tot) 
      {
        throw new ExceptionMySQL(mysql_error(), 
                                 $query,
                                 "������ �������� ���������� �������");
      }
      return mysql_result($tot, 0);
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
      $page = intval($_GET['page']);
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
      // ��������� ������� ��� ������� ��������
      $query = "SELECT * FROM {$this->tablename}
                {$this->where}
                {$this->order}
                LIMIT $first, {$this->get_pnumber()}";
      $tbl = mysql_query($query);
      if(!$tbl)
      {
        throw new ExceptionMySQL(mysql_error(), 
                                 $query,
                                 "������ ���������� �������");
      }
      // ���� ������� ���� �� ���� �������,
      // ��������� ������ $arr
      if(mysql_num_rows($tbl))
      {
        while($arr[] = mysql_fetch_array($tbl));
      }
      // ������� ��������� ������� ������� 
      // ������� $arr
      unset($arr[count($arr) - 1]);

      return $arr;
    }
  }
?>