<?php
  ////////////////////////////////////////////////////////////
  // ������� ����� ������������ ����� - PowerCounter
  // 2003-2008 (C) IT-������ SoftTime (http://www.softtime.ru)
  // ���������: http://www.softtime.ru/forum/
  // �������� �.�. (simdyanov@softtime.ru)
  // �������� �.�. (kuznetsov@softtime.ru)
  // ����� �.� (loki_angel@mail.ru)
  // ������� �.�. (softtime@softtime.ru)
  ////////////////////////////////////////////////////////////
  // ���������� ������� ��������� ������ 
  // (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE); 
  // ������������� ���������� � ����� ������
  require_once("config.php");
  // ���������� SoftTime FrameWork
  require_once("../../config/class.config.dmn.php");
  // ���������� ���� �����������
  require_once("../utils/security_mod.php");
  // ���������� ���� ����������� ������ � ���� ��������
  require_once("../utils/utils.print_page.php");
  // ������������ WHERE-�������
  require_once("utils.where.php");
  // ���������� �������
  require_once("utils.query_result.php");

  $title='�����&nbsp;�&nbsp;����';  
  $pageinfo='�� ���� �������� �� ������ ����� ����������
  �� ����������� �����. <br><b>�����</b> � ��� ����������
  ���������� ����������� ������ �����, <b>����</b> � ���
  ����� ���������� ������� �����.  <br>��� �������� ��
  ������� "<b>�������</b>", "<b>�����</b>" ������������
  ��������� ��������� ���������� ��������� �� ��������� ����.
  ��� �������� �� ������� "<b>�� 7 ����</b>" � "<b>�� 30 ����
  </b>" ������������ ��������� �������� ���������� �� ���
  ������� �������.';

  try
  {
    // �������� ��������� ��������
    require_once("../utils/topcounter.php");
  
    // �������� ������ ��������� ����������
    require_once("time_interval.php");
  
    // ����������� ������ �� ���� ��������� ����������
    // ����������� � ����� time_interval.php   
    for($i = 0; $i < 5; $i++)
    {
      list($hits_total[$i], 
           $hits[$i], 
           $hosts_total[$i], 
           $hosts[$i]) = show_ip_host($time[$i]['begin'], 
                                      $time[$i]['end']);
    }
  ?>
  <table class="table" 
       width="100%" 
       border="0" 
       cellpadding="0" 
       cellspacing="0">
  <tr class="header" align="center">
    <td width=<?= 100/6 ?>% align=center>&nbsp;</td>
    <td width=<?= 100/6 ?>% align=center>�������</td>
    <td width=<?= 100/6 ?>% align=center>�����</td>
    <td width=<?= 100/6 ?>% align=center>�� 7 ����</td>
    <td width=<?= 100/6 ?>% align=center>�� 30 ����</td>
    <td width=<?= 100/6 ?>% align=center>�� �� �����</td>
  </tr>
  <tr><td class=field>����������� �����</td>
    <?php
      foreach($hosts as $value)
        echo "<td align=center><p>$value</p></td>";
    ?>
  </tr>
  <tr><td class=field>�����</td>
    <?php
      foreach($hosts_total as $value)
        echo "<td align=center><p>$value</p></td>";
    ?>
  </tr>
  <tr><td class=field>����������� ����</td>
    <?php
      foreach($hits as $value)
        echo "<td align=center><p>$value</p></td>";
    ?>
  </tr>
  <tr><td class=field>����</td>
    <?php
      foreach($hits_total as $value)
        echo "<td align=center><p>$value</p></td>";
    ?>
  </tr>
  </table>
  <?php
    // �������� ���������� ��������
    require_once("../utils/bottomcounter.php");
  }
  catch(ExceptionObject $exc) 
  {
    require("../utils/exception_object.php"); 
  }
  catch(ExceptionMySQL $exc)
  {
    require("../utils/exception_mysql.php"); 
  }
  catch(ExceptionMember $exc)
  {
    require("../utils/exception_member.php"); 
  }

  // ������� ���������� ������ �� ������ ���������� (��� ���������):
  // ����� ���������� �����,
  // ���������� ����������� �����,
  // ���������� ������,
  // ���������� ����������� ������.
  // $begin - ����� ����, ������� ���������� ������� �� ������� ����,
  // ��� ���� ����� �������� ��������� ����� ���������� ���������
  // $end - ����� ����, ������� ���������� ������� �� ������� ����,
  // ��� ���� ����� �������� �������� ����� ��������� ���������
  function show_ip_host($begin = 1, $end = 0)
  {
    // ��������� ����� ������ �����������
    global $tbl_arch_hits, $tbl_arch_hits_month, $tbl_ip;
    // �������� ���� � �����
    $hosts_total = 0;
    $hosts       = 0;
    $hits_total  = 0;
    $hits        = 0;
  
    //////////////////////////////////////////////////////////
    // ������� �� ������� ������������
    //            begin end
    // �������      1    0  - ��� ��������� �� $tbl_ip
    // �����        2    1  - ��� ��������� �� $tbl_arch_hits
    // ������       7    0  - ��� ��������� �� $tbl_arch_hits
    // �����       30    0  - ��� ��������� �� $tbl_arch_hits
    // �� �����    0    0  - ��� ��������� �� $tbl_arch_month
    //////////////////////////////////////////////////////////
  
    // ��������� WHERE-������� ��� ���������� ���������
    $where = where_interval($begin, $end);

	// �������
    if($begin == 1 && $end == 0)
    {
      // ����� ���������� �����
      $query_hit_total = "SELECT COUNT(*) 
                          FROM $tbl_ip $where";
      // ����������� ����
      $query_hit       = "SELECT COUNT(*) FROM $tbl_ip
                          $where AND systems!='none' AND
                                 systems NOT LIKE 'robot_%'";
      // ������������ ���������� IP-������� (������)
      $query_host_total= "SELECT COUNT(DISTINCT ip) 
                          FROM $tbl_ip $where";
      // ������������ ���������� ���������� ����������� �� �����
      $query_host      = "SELECT COUNT(DISTINCT ip) 
                          FROM $tbl_ip 
                          $where AND systems!='none' AND
                                 systems NOT LIKE 'robot_%'";
  
      return array(query_result($query_hit_total), 
                   query_result($query_hit),
                   query_result($query_host_total),
                   query_result($query_host));
    }
	 
    // �� �����
    if($begin == 0 && $end == 0)
    {
      // ����� ����� �����
      $query_hit_total = "SELECT SUM(hits_total) FROM $tbl_arch_hits";
      // ����������� ����
      $query_hit       = "SELECT SUM(hits) FROM $tbl_arch_hits";
      // ������������ ����� IP-������� (������)
      $query_host_total= "SELECT SUM(hosts_total) FROM $tbl_arch_hits";
      // ������������ ����� ���������� ����������� �� �����
      $query_host   = "SELECT SUM(host) FROM $tbl_arch_hits";
  
      // ���� ������� ���������� ������,
      // �������� ���������
      $hits_total  += query_result($query_hit_total);
      $hits        += query_result($query_hit);
      $hosts_total += query_result($query_host_total);
      $hosts       += query_result($query_host);
  
      // �������� ����� ������ ����� �� ������� $tbl_arch_hits,
      // ��, ��� ����� ���� �� ������� $tbl_arch_hits_month
      $query = "SELECT UNIX_TIMESTAMP(MIN(putdate)) AS data FROM $tbl_arch_hits";
      $last_day = query_result($query);
      if($last_day)
      {
        $where = "WHERE putdate < '".date("Y-m-01", $last_date)."'";
        // ����� ����� �����
        $query_hit_total = "SELECT SUM(hits_total) 
                            FROM $tbl_arch_hits_month $where";
        // ����������� ����
        $query_hit       = "SELECT SUM(hits) 
                            FROM $tbl_arch_hits_month $where";
        // ������������ ����� IP-������� (������)
        $query_host_total= "SELECT SUM(hosts_total) 
                            FROM $tbl_arch_hits_month $where";
        // ������������ ����� ���������� ����������� �� �����
        $query_host   = "SELECT SUM(host) 
                            FROM $tbl_arch_hits_month $where";
    
        // ���� ������� ���������� ������,
        // �������� ���������
        $hits_total  += query_result($query_hit_total);
        $hits        += query_result($query_hit);
        $hosts_total += query_result($query_host_total);
        $hosts       += query_result($query_host);
      }
    }
    // ����� ������
    else
    {
      // ����� ����� �����
      $query_hit_total = "SELECT SUM(hits_total) 
                          FROM $tbl_arch_hits $where";
      // ����������� ����
      $query_hit       = "SELECT SUM(hits) 
                          FROM $tbl_arch_hits $where";
      // ������������ ����� IP-������� (������)
      $query_host_total= "SELECT SUM(hosts_total) 
                          FROM $tbl_arch_hits $where";
      // ������������ ����� ���������� ����������� �� �����
      $query_host      = "SELECT SUM(host) 
                          FROM $tbl_arch_hits $where";
  
      // ���� ������� ���������� ������,
      // �������� ���������
      $hits_total  += query_result($query_hit_total);
      $hits        += query_result($query_hit);
      $hosts_total += query_result($query_host_total);
      $hosts       += query_result($query_host);
    }
    // ���������� ���������
    return array($hits_total, $hits, $hosts_total, $hosts);
  }
?>
