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

  // �������� ���������
  require_once("archive.php");

  // ���� ������
  $body = "";

  try
  {
    // ��������� ������������ ���� 
    $query = "SELECT UNIX_TIMESTAMP(MAX(putdate_begin)) AS putdate_begin
              FROM $tbl_arch_hits_week";
    $putdate_begin = query_result($query);
  
    // ��������� ����� ����� � ������ �� ��������� ������
    $query = "SELECT * FROM $tbl_arch_hits_week
              WHERE putdate_begin = '".date("Y-m-d",$putdate_begin)."'";
    $arh = mysql_query($query);
    if(!$arh)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ������������ ���������� ��������� ������");
    }
    $arch_hits = mysql_fetch_array($arh);
  
    // ��������� ����� ��������� � ������������ ������ �� ��������� ������
    $query = "SELECT * FROM $tbl_arch_clients_week
              WHERE putdate_begin = '".date("Y-m-d",$putdate_begin)."'";
    $cnt = mysql_query($query);
    if(!$cnt)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ������������ ���������� ��������� ������");
    }
    $arch_clients = mysql_fetch_array($cnt);
  
    // ��������� ���������� ���������� �� ����� ����� � ������
    $query = "SELECT DATE_FORMAT(putdate,'%d.%m') AS putdate,
                     host,
                     hosts_total,
                     hits,
                     hits_total
              FROM $tbl_arch_hits 
              WHERE putdate > '".date("Y-m-d",$putdate_begin)."' AND
                    putdate <= '".date("Y-m-d",$putdate_begin + 7*24*3600)."'";
    $arh_week = mysql_query($query);
    if(!$arh_week)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ������������ ���������� ��������� ������");
    }
  
  
    // ��������� IP_NUMBER �������� �������� IP-�������
    $query = "SELECT INET_NTOA(ip) AS ip, total FROM $tbl_arch_ip_week
              WHERE putdate_begin = '".date("Y-m-d",$putdate_begin)."'";
    $ipt = mysql_query($query);
    if(!$ipt)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ������������ ���������� ��������� ������");
    }
  
    // ��������� ����� ��������� �� ��������� ������
    $query = "SELECT * FROM $tbl_arch_num_searchquery_week
              WHERE putdate_begin = '".date("Y-m-d",$putdate_begin)."'";
    $qnm = mysql_query($query);
    if(!$qnm)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ������������ ���������� ��������� ������");
    }
    $arch_num_searchquery = mysql_fetch_array($qnm);
  
    // ��������� YANDEX_NUMBER �������� ���������������� �������� Yandex
    $query = "SELECT * FROM $tbl_arch_searchquery_week
              WHERE searches = 'yandex' AND
                    putdate_begin = '".date("Y-m-d",$putdate_begin)."'";
    $ynd = mysql_query($query);
    if(!$ynd)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ������������ ���������� ��������� ������");
    }
  
    // ��������� RAMBLER_NUMBER �������� ���������������� �������� Rambler
    $query = "SELECT * FROM $tbl_arch_searchquery_week
              WHERE searches = 'rambler' AND
                    putdate_begin = '".date("Y-m-d",$putdate_begin)."'";
    $rbl = mysql_query($query);
    if(!$rbl)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ������������ ���������� ��������� ������");
    }
  
    // ��������� APORT_NUMBER �������� ���������������� �������� Aport
    $query = "SELECT * FROM $tbl_arch_searchquery_week
              WHERE searches = 'aport' AND
                    putdate_begin = '".date("Y-m-d",$putdate_begin)."'";
    $apt = mysql_query($query);
    if(!$apt)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ������������ ���������� ��������� ������");
    }
  
    // ��������� MSN_NUMBER �������� ���������������� �������� MSN
    $query = "SELECT * FROM $tbl_arch_searchquery_week
              WHERE searches = 'msn' AND
                    putdate_begin = '".date("Y-m-d",$putdate_begin)."'";
    $ms = mysql_query($query);
    if(!$ms)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ������������ ���������� ��������� ������");
    }
  
    // ��������� GOOGLE_NUMBER �������� ���������������� �������� Google
    $query = "SELECT * FROM $tbl_arch_searchquery_week
              WHERE searches = 'google' AND
                    putdate_begin = '".date("Y-m-d",$putdate_begin)."'";
    $gog = mysql_query($query);
    if(!$gog)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ������������ ���������� ��������� ������");
    }
  
    // ��������� REFFERER_NUMBER �������� ���������������� ���������
    $query = "SELECT * FROM $tbl_arch_refferer_week
              WHERE putdate_begin = '".date("Y-m-d",$putdate_begin)."'";
    $ref = mysql_query($query);
    if(!$ref)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ������������ ���������� ��������� ������");
    }
  
    // ��������� ENTERPOINT_NUMBER �������� ���������������� ����� �����
    $query = "SELECT * FROM $tbl_arch_enterpoint_week
              WHERE putdate_begin = '".date("Y-m-d",$putdate_begin)."'";
    $enp = mysql_query($query);
    if(!$enp)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ������������ ���������� ��������� ������");
    }
  
    // ��������� "������� ���������"
    $query = "SELECT * FROM $tbl_arch_deep_week
              WHERE putdate_begin = '".date("Y-m-d",$putdate_begin)."'";
    $dep = mysql_query($query);
    if(!$dep)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ������������ ���������� ��������� ������");
    }
    $arch_deep = mysql_fetch_array($dep);
  
    // ��������� "����� ������"
    $query = "SELECT * FROM $tbl_arch_time_week
              WHERE putdate_begin = '".date("Y-m-d",$putdate_begin)."'";
    $tim = mysql_query($query);
    if(!$tim)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ������������ ���������� ��������� ������");
    }
    $arch_time = mysql_fetch_array($tim);
  
    $header = "Content-Type: text/html; charset=KOI8-R\r\n\r\n";
  
    $body .= "<html>\r\n".
             "<head>\r\n".
             "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=KOI8-R\">\r\n".
             "<title></title>\r\n".
             "<style>\r\n".
             "  body, table {font-family: Arial, Helvetica, sans-serif; font-size: 12px}\r\n".
             "  .namepage{text-transform: uppercase; font-size: 140%; color: #651B17; border-bottom-style: solid; border-width: 5px; border-color: #C3C3C3; padding: 0px 0px 10px 0px}\r\n".
             "  .title{font-size: 120%; color: #000000; margin: 20px 0px 10px 0px}\r\n".
             "  table{width: 60%; margin: 10px 0px 10px 0px; background-color: #F9F9F9; border-top-style: solid; border-right-style: solid; border-width:1px; border-top-width:2px; border-color: #6C6C6C; border-top-color: #B9B9B9}\r\n".
             "  table.long{width: 80%;}\r\n".
             "  table.short{width: 40%;}\r\n".
             "  table td{padding: 2px 5px 2px 5px; border-left-style: solid; border-bottom-style: solid; border-width:1px; border-color: #969696}\r\n".
             "  table tr.header td{padding: 2px 5px 2px 5px; background-color: #214B84; color: #FFFFFF; font-weight: bold; text-align: center}\r\n".
             "  a {color: #173D76}\r\n".
             "  a:hover{color: #2156A6}\r\n".
             "</style>\r\n".
             "</head>\r\n".
             "<body>";
    $body .= "<h2 class=namepage>��������� ���������� �� ".date('d.m',$putdate_begin)." - ".date('d.m',$putdate_begin + 3600*24*7)."</h2>";
  
    $body .= "<h4 class=title>����� ���������� �� ������</h4>\r\n";
    $body .= "<table class=short border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n";
    $body .= "<tr class=header><td>��������</td><td>��������</td></tr>\r\n";
    $body .= "<tr><td>����������� �����</td><td>$arch_hits[host]</td></tr>\r\n";
    $body .= "<tr><td>����� ����� ������</td><td>$arch_hits[hosts_total]</td></tr>\r\n";
    $body .= "<tr><td>����������� ����</td><td>$arch_hits[hits]</td></tr>\r\n";
    $body .= "<tr><td>����� ����� �����</td><td>$arch_hits[hits_total]</td></tr>\r\n";
    $body .= "</table>\r\n";
    
    if(mysql_num_rows($arh_week) > 0)
    {
      $body .= "<h4 class=title>���������� ����������</h4>\r\n";
      $body .= "<table class=short border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n";
      $body .= "<tr class=header>
                  <td>����</td>
                  <td>�����</td>
                  <td>����������</td>
                  <td>����������� ����</td>
                  <td>����</td>
                </tr>\r\n";
      $k = 0;
      while($arch_ip_week = mysql_fetch_array($arh_week))
      {
        $k++;
        if($k < 6) $body .= "<tr>\r\n
                               <td>$arch_ip_week[putdate]</td>\r\n
                               <td>$arch_ip_week[host]</td>\r\n
                               <td>$arch_ip_week[hosts_total]</td>\r\n
                               <td>$arch_ip_week[hits]</td>\r\n
                               <td>$arch_ip_week[hits_total]</td>\r\n
                             </tr>\r\n";
        else $body .= "<tr>\r\n
                        <td><font color=red>$arch_ip_week[putdate]</td>\r\n
                        <td><font color=red>$arch_ip_week[host]</td>\r\n
                        <td><font color=red>$arch_ip_week[hosts_total]</td>\r\n
                        <td><font color=red>$arch_ip_week[hits]</td>\r\n
                        <td><font color=red>$arch_ip_week[hits_total]</td>\r\n
                      </tr>\r\n";
      }
      $body .= "</table>\r\n";
    }
  
    $body .= "<h4 class=title>������������� �� ������������ ��������</h4>\r\n";
    $body .= "<table class=short border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr>\r\n";
    $body .= "<tr class=header><td>������������ �������</td><td>���������</td></tr>\r\n";
    $body .= "<tr><td>Windows</td><td>$arch_clients[systems_windows]</td></tr>\r\n";
    $body .= "<tr><td>UNIX</td><td>$arch_clients[systems_unix]</td></tr>\r\n";
    $body .= "<tr><td>Macintosh</td><td>$arch_clients[systems_macintosh]</td></tr>\r\n";
    $body .= "<tr><td>�� ����������</td><td>$arch_clients[systems_none]</td></tr>\r\n";
    $body .= "</table>\r\n";
  
    $body .= "<h4 class=title>������������� �� ���������</h4>\r\n";
    $body .= "<table class=short border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n";
    $body .= "<tr class=header><td>�������</td><td>���������</td></tr>\r\n";
    $body .= "<tr><td>Internet Explorer</td><td>$arch_clients[browsers_msie]</td></tr>\r\n";
    $body .= "<tr><td>Opera</td><td>$arch_clients[browsers_opera]</td></tr>\r\n";
    $body .= "<tr><td>Netscape Navigator</td><td>$arch_clients[browsers_netscape]</td></tr>\r\n";
    $body .= "<tr><td>FireFox</td><td>$arch_clients[browsers_firefox]</td></tr>\r\n";
    $body .= "<tr><td>MyIE</td><td>$arch_clients[browsers_myie]</td></tr>\r\n";
    $body .= "<tr><td>Mozilla</td><td>$arch_clients[browsers_mozilla]</td></tr>\r\n";
    $body .= "<tr><td>�� ����������</td><td>$arch_clients[browsers_none]</td></tr>\r\n";
    $body .= "</table>\r\n";
  
    if(mysql_num_rows($ipt) > 0)
    {
      $body .= "<h4 class=title>".IP_NUMBER." �������� �������� IP-�������</h4>\r\n";
      $body .= "<table class=short border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n";
      $body .= "<tr class=header><td>IP-�����</td><td>���������</td></tr>\r\n";
      while($arch_ip = mysql_fetch_array($ipt))
      {
        $body .= "<tr><td>$arch_ip[ip]</td><td>$arch_ip[total]</td></tr>\r\n";
      }
      $body .= "</table>";
    }
  
    $body .= "<h4 class=title>����� ��������� �� ��������� ������</h4>\r\n";
    $body .= "<table class=short border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n";
    $body .= "<tr class=header><td>��������� �������</td><td>���������</td></tr>\r\n";
    $body .= "<tr><td>Yandex</td><td>$arch_num_searchquery[number_yandex]</td></tr>\r\n";
    $body .= "<tr><td>Google</td><td>$arch_num_searchquery[number_google]</td></tr>\r\n";
    $body .= "<tr><td>Rambler</td><td>$arch_num_searchquery[number_rambler]</td></tr>\r\n";
    $body .= "<tr><td>Aport</td><td>$arch_num_searchquery[number_aport]</td></tr>\r\n";
    $body .= "<tr><td>MSN</td><td>$arch_num_searchquery[number_msn]</td></tr>\r\n";
    $body .= "<tr><td>Mail.ru</td><td>$arch_num_searchquery[number_mail]</td></tr>\r\n";
    $body .= "</table>\r\n";
  
    if(mysql_num_rows($ynd) > 0)
    {
      $body .= "<h4 class=title>������� Yandex: ".YANDEX_NUMBER." �������� ���������������</h4>\r\n";
      $body .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n";
      $body .= "<tr class=header><td>��������� ������</td><td>���������</td></tr>\r\n";
      while($yandex = mysql_fetch_array($ynd))
      {
        $body .= "<tr><td>".htmlspecialchars($yandex['name'])."</td><td>$yandex[total]</td></tr>\r\n";
      }
      $body .= "</table>\r\n";
    }
  
    if(mysql_num_rows($gog) > 0)
    {
      $body .= "<h4 class=title>������� Google: ".GOOGLE_NUMBER." �������� ���������������</h4>\r\n";
      $body .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n";
      $body .= "<tr class=header><td>��������� ������</td><td>���������</td></tr>\r\n";
      while($google = mysql_fetch_array($gog))
      {
        $body .= "<tr><td>".htmlspecialchars($google['name'])."</td><td>$google[total]</td></tr>\r\n";
      }
      $body .= "</table>\r\n";
    }
  
    if(mysql_num_rows($rbl) > 0)
    {
      $body .= "<h4 class=title>������� Rambler: ".RAMBLER_NUMBER." �������� ���������������</h4>\r\n";
      $body .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n";
      $body .= "<tr class=header><td>��������� ������</td><td>���������</td></tr>\r\n";
      while($rambler = mysql_fetch_array($rbl))
      {
        $body .= "<tr><td>".htmlspecialchars($rambler['name'])."</td><td>$rambler[total]</td></tr>\r\n";
      }
      $body .= "</table>\r\n";
    }
  
    if(mysql_num_rows($apt) > 0)
    {
      $body .= "<h4 class=title>������� Aport: ".APORT_NUMBER." �������� ���������������</h4>\r\n";
      $body .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n";
      $body .= "<tr class=header><td>��������� ������</td><td>���������</td></tr>\r\n";
      while($aport = mysql_fetch_array($apt))
      {
        $body .= "<tr><td>".htmlspecialchars($aport['name'])."</td><td>$aport[total]</td></tr>\r\n";
      }
      $body .= "</table>";
    }
  
    if(mysql_num_rows($ms) > 0)
    {
      $body .= "<h4 class=title>������� MSN: ".MSN_NUMBER." �������� ���������������</h4>\r\n";
      $body .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n";
      $body .= "<tr class=header><td>��������� ������</td><td>���������</td></tr>\r\n";
      while($msn = mysql_fetch_array($ms))
      {
        $body .= "<tr><td>".htmlspecialchars($msn['name'])."</td><td>$msn[total]</td></tr>\r\n";
      }
      $body .= "</table>\r\n";
    }
  
    if(mysql_num_rows($ref) > 0)
    {
      $body .= "<h4 class=title>��������: ".REFFERER_NUMBER." �������� ���������������</h4>\r\n";
      $body .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n";
      $body .= "<tr class=header><td>�������</td><td>���������</td></tr>\r\n";
      while($referer = mysql_fetch_array($ref))
      {
        $body .= "<tr><td>".htmlspecialchars($referer['name'])."</td><td>$referer[total]</td></tr>\r\n";
      }
      $body .= "</table>\r\n";
    }
  
    if(mysql_num_rows($enp) > 0)
    {
      $body .= "<h4 class=title>����� �����: ".ENTERPOINT_NUMBER." �������� ���������������</h4>\r\n";
      $body .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n";
      $body .= "<tr class=header><td>����� �����</td><td>���������</td></tr>\r\n";
      while($enterpoint = mysql_fetch_array($enp))
      {
        $body .= "<tr><td>".htmlspecialchars($enterpoint['page'])."</td><td>$enterpoint[total]</td></tr>\r\n";
      }
      $body .= "</table>\r\n";
    }
  
    $body .= "<h4 class=title>������� ���������</h4>\r\n";
    $body .= "<table class=short border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n";
    $body .= "<tr class=header><td>���������� �������</td><td>����� �����������</td></tr>\r\n";
    $body .= "<tr><td>1 ��������</td><td>".$arch_deep['visit1']."</td></tr>\r\n";
    $body .= "<tr><td>2 ��������</td><td>".$arch_deep['visit2']."</td></tr>\r\n";
    $body .= "<tr><td>3 ��������</td><td>".$arch_deep['visit3']."</td></tr>\r\n";
    $body .= "<tr><td>4 ��������</td><td>".$arch_deep['visit4']."</td></tr>\r\n";
    $body .= "<tr><td>5 �������</td><td>".$arch_deep['visit5']."</td></tr>\r\n";
    $body .= "<tr><td>6 �������</td><td>".$arch_deep['visit6']."</td></tr>\r\n";
    $body .= "<tr><td>7 �������</td><td>".$arch_deep['visit7']."</td></tr>\r\n";
    $body .= "<tr><td>8 �������</td><td>".$arch_deep['visit8']."</td></tr>\r\n";
    $body .= "<tr><td>9 �������</td><td>".$arch_deep['visit9']."</td></tr>\r\n";
    $body .= "<tr><td>10 �������</td><td>".$arch_deep['visit10']."</td></tr>\r\n";
    $body .= "<tr><td>�� 10 �� 20 �������</td><td>".$arch_deep['visit20']."</td></tr>\r\n";
    $body .= "<tr><td>�� 20 �� 30 �������</td><td>".$arch_deep['visit30']."</td></tr>\r\n";
    $body .= "<tr><td>�� 30 �� 40 �������</td><td>".$arch_deep['visit40']."</td></tr>\r\n";
    $body .= "<tr><td>�� 40 �� 50 �������</td><td>".$arch_deep['visit50']."</td></tr>\r\n";
    $body .= "<tr><td>�� 50 �� 60 �������</td><td>".$arch_deep['visit60']."</td></tr>\r\n";
    $body .= "<tr><td>�� 60 �� 70 �������</td><td>".$arch_deep['visit70']."</td></tr>\r\n";
    $body .= "<tr><td>�� 70 �� 80 �������</td><td>".$arch_deep['visit80']."</td></tr>\r\n";
    $body .= "<tr><td>�� 80 �� 90 �������</td><td>".$arch_deep['visit90']."</td></tr>\r\n";
    $body .= "<tr><td>�� 90 �� 100 �������</td><td>".$arch_deep['visit100']."</td></tr>\r\n";
    $body .= "<tr><td>����� 100 �������</td><td>".$arch_deep['visitmore']."</td></tr>\r\n";
    $body .= "</table>\r\n";
  
    $body .= "<h4 class=title>����� ������</h4>\r\n";
    $body .= "<table class=short border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n";
    $body .= "<tr class=header><td>�����</td><td>����� �����������</td></tr>\r\n";
    $body .= "<tr><td>1 ������</td><td>".$arch_time['visit1']."</td></tr>\r\n";
    $body .= "<tr><td>2 ������</td><td>".$arch_time['visit2']."</td></tr>\r\n";
    $body .= "<tr><td>3 ������</td><td>".$arch_time['visit3']."</td></tr>\r\n";
    $body .= "<tr><td>4 ������</td><td>".$arch_time['visit4']."</td></tr>\r\n";
    $body .= "<tr><td>5 �����</td><td>".$arch_time['visit5']."</td></tr>\r\n";
    $body .= "<tr><td>6 �����</td><td>".$arch_time['visit6']."</td></tr>\r\n";
    $body .= "<tr><td>7 �����</td><td>".$arch_time['visit7']."</td></tr>\r\n";
    $body .= "<tr><td>8 �����</td><td>".$arch_time['visit8']."</td></tr>\r\n";
    $body .= "<tr><td>9 �����</td><td>".$arch_time['visit9']."</td></tr>\r\n";
    $body .= "<tr><td>10 �����</td><td>".$arch_time['visit10']."</td></tr>\r\n";
    $body .= "<tr><td>�� 10 �� 20 �����</td><td>".$arch_time['visit20']."</td></tr>\r\n";
    $body .= "<tr><td>�� 20 �� 30 �����</td><td>".$arch_time['visit30']."</td></tr>\r\n";
    $body .= "<tr><td>�� 30 �� 40 �����</td><td>".$arch_time['visit40']."</td></tr>\r\n";
    $body .= "<tr><td>�� 40 �� 50 �����</td><td>".$arch_time['visit50']."</td></tr>\r\n";
    $body .= "<tr><td>�� 50 �� 60 �����</td><td>".$arch_time['visit60']."</td></tr>\r\n";
    $body .= "<tr><td>�� 1 �� 2 �����</td><td>".$arch_time['visit2h']."</td></tr>\r\n";
    $body .= "<tr><td>�� 2 �� 3 �����</td><td>".$arch_time['visit3h']."</td></tr>\r\n";
    $body .= "<tr><td>�� 3 �� 4 �����</td><td>".$arch_time['visit4h']."</td></tr>\r\n";
    $body .= "<tr><td>�� 4 �� 5 �����</td><td>".$arch_time['visit5h']."</td></tr>\r\n";
    $body .= "<tr><td>�� 5 �� 6 �����</td><td>".$arch_time['visit6h']."</td></tr>\r\n";
    $body .= "<tr><td>�� 6 �� 7 �����</td><td>".$arch_time['visit7h']."</td></tr>\r\n";
    $body .= "<tr><td>�� 7 �� 8 �����</td><td>".$arch_time['visit8h']."</td></tr>\r\n";
    $body .= "<tr><td>�� 8 �� 9 �����</td><td>".$arch_time['visit9h']."</td></tr>\r\n";
    $body .= "<tr><td>�� 9 �� 10 �����</td><td>".$arch_time['visit10h']."</td></tr>\r\n";
    $arch_time['visit11h'] += $arch_time['visit12h'] + 
                              $arch_time['visit13h'] +
                              $arch_time['visit14h'] +
                              $arch_time['visit15h'] +
                              $arch_time['visit16h'] +
                              $arch_time['visit17h'] +
                              $arch_time['visit18h'] +
                              $arch_time['visit19h'] +
                              $arch_time['visit20h'] +
                              $arch_time['visit21h'] +
                              $arch_time['visit22h'] +
                              $arch_time['visit23h'] +
                              $arch_time['visit24h'];
    $body .= "<tr><td>�� 10 �� 24 �����</td><td>".$arch_time['visit11h']."</td></tr>\r\n";
    $body .= "</table>";
    $body .= "</body></html>\r\n";
  
    // �������� ���������
    $thm = convert_cyr_string("��������� ���������� �����",'w','k'); 
    $body = convert_cyr_string($body,'w','k'); 
    // ���������� ������
    @mail(EMAIL_ADDRESS, $thm, $body, $header);
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
?>