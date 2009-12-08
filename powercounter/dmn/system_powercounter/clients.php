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

  $title = '�������&nbsp;�&nbsp;��������';    
  $pageinfo = '�� ���� �������� �� ������ ������
  ���������� �� ������������ �������� � ���������
  �� ��� ������� ���������� ������� �� ����.';
  try
  {
    // �������� ��������� ��������
    require_once("../utils/topcounter.php");
  
    // �������� ������ ��������� ����������
    require_once("time_interval.php");

    // ��������� ������ � ���������� ������������ ������
    $os['win'] = "Windows";
    $os['lin'] = "Linux & Unix";
    $os['mac'] = "Macintosh";
    $os['os'] = "������";
    // ��������� ������ � ���������� ���������
    $br['ie'] = "Internet Explorer";
    $br['net'] = "Netscape";
    $br['opr'] = "Opera";
    $br['ffx'] = "FireFox";
    $br['mie'] = "MyIE";
    $br['moz'] = "Mozilla";
    $br['br'] = "������";
  
    // ����������� ������ �� ���� ��������� ����������
    // ����������� � ����� time_interval.php   
    for($i = 0; $i < 5; $i++)
    {
      list($hit['win'][$i], 
           $hit['lin'][$i], 
           $hit['mac'][$i], 
           $hit['os'][$i], 
           $hit['ie'][$i], 
           $hit['net'][$i], 
           $hit['opr'][$i], 
           $hit['ffx'][$i],
           $hit['mie'][$i],
           $hit['moz'][$i],
           $hit['br'][$i], 
           $totals[$i],
           $totalb[$i]) = system_info($time[$i]['begin'], 
                                     $time[$i]['end']);
    }
    ?>
    <table class="table" 
           width="100%" 
           border="0" 
           cellpadding="0" 
           cellspacing="0">
    <tr class="header" align="center">
      <td>&nbsp;</td>
      <td>C������</td>
      <td>�����</td>
      <td>�� 7 ����</td>
      <td>�� 30 ����</td>
      <td>�� �� �����</td>
    </tr>
    <tr class=subtitle><td colspan=6><b>������������ �������</b></td></tr>
    <?php
    // ��������� ���� "������������ �������"
    foreach($os as $key => $name)
    {
      echo "<tr align=right>";
      echo "<td class=field>$name</td>";
      for($i=0; $i<5; $i++)
      { 
        $total = sprintf("%d (%01.1f%s)",
                         $hit[$key][$i],
                         $hit[$key][$i]/$totals[$i]*100,
                         '%');
        echo "<td><p>$total</p></td>";
      }
      echo "</tr>";
    }
    echo "<tr class=subtitle><td colspan=6><b>��������</b></td></tr>";
    // ��������� ���� "��������" 
    foreach($br as $key => $name) 
    { 
      echo "<tr align=right>"; 
      echo "<td class=field>$name</td>"; 
      for($i=0; $i<5; $i++)
      {
        $total = sprintf("%d (%01.1f%s)",
                         $hit[$key][$i],
                         $hit[$key][$i]/$totalb[$i]*100,
                         '%');
        echo "<td><p>$total</p></td>";
      }
      echo "</tr>"; 
    } 
    echo "</table>";

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

  // ������� ���������� ������ �� ������ ����������,
  // � ����������� � ����� ����������� ������������
  // �� ��� ���� ������������ ������� ��� �������.
  // $begin - ����� ����, ������� ���������� ������� �� ������� ����,
  // ��� ���� ����� �������� ��������� ����� ���������� ���������
  // $end - ����� ����, ������� ���������� ������� �� ������� ����,
  // ��� ���� ����� �������� �������� ����� ���������� ���������
  // $tbl_ip - �������� �������, � ������� �������� IP-������
  // $tbl_arch_clients - �������� �������� �������
  function system_info($begin = 1, $end = 0)
  {
    // ��������� ����� ������ �����������
    global $tbl_arch_clients, $tbl_arch_clients_month, $tbl_ip;
 
    // �������� ���� � �����
    $hits = array();

    //////////////////////////////////////////////////////////////////
    // ������� �� ������� ������������
    //            begin end
    // �������      1    0  - ��� ��������� �� $tbl_ip
    // �����        2    1  - ��� ��������� �� $tbl_arch_clients
    // ������       7    0  - ��� ��������� �� $tbl_arch_clients,
    // �����       30    0  - ��� ��������� �� $tbl_arch_clients,
    // �� �����    0    0  - ��� ��������� �� $tbl_arch_clients_month
    //////////////////////////////////////////////////////////////////

	// �������
    if($begin == 1 && $end == 0)
    {
      $where = where_interval();
  
      // ��������� SQL-�������
      $begins = "SELECT COUNT(DISTINCT ip) FROM $tbl_ip 
                 $where AND systems NOT LIKE 'robot_%' AND 
                            systems = ";
      $beginb = "SELECT COUNT(DISTINCT ip) FROM $tbl_ip 
                 $where AND systems NOT LIKE 'robot_%' AND 
                            browsers = ";
      $query['win'] = $begins."'windows'";
      $query['lin'] = $begins."'unix'";
      $query['mac'] = $begins."'macintosh'";
      $query['snn'] = $begins."'none'";
      $query['ie']  = $beginb."'msie'";
      $query['opr'] = $beginb."'opera'";
      $query['net'] = $beginb."'netscape'";
      $query['ffx'] = $beginb."'firefox'";
      $query['mie'] = $beginb."'myie'";
      $query['moz'] = $beginb."'mozilla'";
      $query['bnn'] = $beginb."'none'";
      // ��������� SQL-�������
      foreach($query as $os => $value)
      {
        $hits[$os] = query_result($value);
      }
      $totals = $hits['win'] + $hits['lin'] + 
                $hits['mac'] + $hits['snn'];
      $totalb = $hits['ie'] + $hits['opr'] + 
                $hits['net'] + $hits['ffx'] + 
                $hits['mie'] + $hits['moz'] + $hits['bnn'];
      // �� ��������� ������� �� ���� ��������� ����� ����� �����
      if($totals == 0) $totals = 1;
      if($totalb == 0) $totalb = 1;
      // ���������� ������ ��������
      return array($hits['win'], 
                   $hits['lin'], 
                   $hits['mac'], 
                   $hits['snn'], 
                   $hits['ie'], 
                   $hits['net'], 
                   $hits['opr'], 
                   $hits['ffx'], 
                   $hits['mie'], 
                   $hits['moz'], 
                   $hits['bnn'], 
                   $totals,
                   $totalb);
    }
  
    // ��������� WHERE-������� ��� ���������� ���������
    $where = where_interval($begin, $end);

    // �� �����
    if($begin == 0 && $end == 0)
    {
      $end = "FROM $tbl_arch_clients $where";
      // ��������� SQL-�������
      $query['win'] = "SELECT SUM(systems_windows)   $end";
      $query['lin'] = "SELECT SUM(systems_unix)      $end";
      $query['mac'] = "SELECT SUM(systems_macintosh) $end";
      $query['snn'] = "SELECT SUM(systems_none)      $end";
      $query['ie']  = "SELECT SUM(browsers_msie)     $end";
      $query['opr'] = "SELECT SUM(browsers_opera)    $end";
      $query['net'] = "SELECT SUM(browsers_netscape) $end";
      $query['ffx'] = "SELECT SUM(browsers_firefox)  $end";
      $query['mie'] = "SELECT SUM(browsers_myie)     $end";
      $query['moz'] = "SELECT SUM(browsers_mozilla)  $end";
      $query['bnn'] = "SELECT SUM(browsers_none)     $end";
  
      // ��������� SQL-�������
      foreach($query as $os => $value)
      {
        $hits[$os] += query_result($value);
      }
  
      // �������� ����� ������ ����� �� ������� $tbl_arch_clients,
      // ��, ��� ����� ���� �� ������� $tbl_arch_clients_month
      $query = "SELECT UNIX_TIMESTAMP(MIN(putdate)) AS data FROM $tbl_arch_clients";
      $last_day = query_result($query);
      if($last_day)
      {
        $end = "FROM $tbl_arch_clients_month WHERE putdate < '".date("Y-m-01", $last_date)."'";
        // ��������� SQL-�������
        unset($query);
        $query['win'] = "SELECT SUM(systems_windows)   $end";
        $query['lin'] = "SELECT SUM(systems_unix)      $end";
        $query['mac'] = "SELECT SUM(systems_macintosh) $end";
        $query['snn'] = "SELECT SUM(systems_none)      $end";
        $query['ie']  = "SELECT SUM(browsers_msie)     $end";
        $query['opr'] = "SELECT SUM(browsers_opera)    $end";
        $query['net'] = "SELECT SUM(browsers_netscape) $end";
        $query['ffx'] = "SELECT SUM(browsers_firefox)  $end";
        $query['mie'] = "SELECT SUM(browsers_myie)     $end";
        $query['moz'] = "SELECT SUM(browsers_mozilla)  $end";
        $query['bnn'] = "SELECT SUM(browsers_none)     $end";
    
        // ��������� SQL-�������
        foreach($query as $os => $value)
        {
          $hits[$os] += query_result($value);
        }
      }
    }
    // ����� ������
    else
    {
      $end = "FROM $tbl_arch_clients $where";
      // ��������� SQL-�������
      $query['win'] = "SELECT SUM(systems_windows)   $end";
      $query['lin'] = "SELECT SUM(systems_unix)      $end";
      $query['mac'] = "SELECT SUM(systems_macintosh) $end";
      $query['snn'] = "SELECT SUM(systems_none)      $end";
      $query['ie']  = "SELECT SUM(browsers_msie)     $end";
      $query['opr'] = "SELECT SUM(browsers_opera)    $end";
      $query['net'] = "SELECT SUM(browsers_netscape) $end";
      $query['ffx'] = "SELECT SUM(browsers_firefox)  $end";
      $query['mie'] = "SELECT SUM(browsers_myie)     $end";
      $query['moz'] = "SELECT SUM(browsers_mozilla)  $end";
      $query['bnn'] = "SELECT SUM(browsers_none)     $end";
  
      // ��������� SQL-�������
      foreach($query as $os => $value)
      {
        $hits[$os] += query_result($value);
      }
    }
  
    $totals = $hits['win'] + $hits['lin'] + 
              $hits['mac'] + $hits['snn'];
    $totalb = $hits['ie'] + $hits['opr'] + 
              $hits['net'] + $hits['ffx'] + 
              $hits['mie'] + $hits['moz'] + $hits['bnn'];
  
    // �� ��������� ������� �� ���� ��������� ����� ����� �����
    if($totals == 0) $totals = 1;
    if($totalb == 0) $totalb = 1;
    // ���������� ������ ��������
    return array($hits['win'], 
                 $hits['lin'], 
                 $hits['mac'], 
                 $hits['snn'], 
                 $hits['ie'], 
                 $hits['net'], 
                 $hits['opr'], 
                 $hits['ffx'], 
                 $hits['mie'], 
                 $hits['moz'], 
                 $hits['bnn'], 
                 $totals,
                 $totalb);
}
?>
