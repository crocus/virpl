<?php
  ////////////////////////////////////////////////////////////
  // ������� ����� ������������ ����� - PowerCounter
  // 2003-2008 (C) IT-������ SoftTime (http://www.softtime.ru)
  // ���������: http://www.softtime.ru/forum/
  // �������� �.�. (simdyanov@softtime.ru)
  // ����� �.�. (loki_angel@mail.ru)
  // �������� �.�. (kuznetsov@softtime.ru)
  // ������� �.�. (softtime@softtime.ru)
  ////////////////////////////////////////////////////////////
  // ���������� ������� ��������� ������ 
  // (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE); 

  // �������� ������
  $tbl_ip       = 'powercounter_ip';             
  $tbl_pages    = 'powercounter_pages';          
  $tbl_refferer = 'powercounter_refferer';       
  $tbl_searchquerys = 'powercounter_searchquerys';

  // ��������� ����������
  $dblocation = "localhost";
  $dbname = "foliantn_powercounter";
  $dbuser = "foliantn_iamcroc";
  $dbpasswd = "di13Bskj";

  $ip = $_SERVER['REMOTE_ADDR'];
  if(empty($ip)) $ip = '0.0.0.0';

  // ����������� � �������� ���� ������
  $dbcnx = @mysql_connect($dblocation, $dbuser, $dbpasswd);
  if(!$dbcnx) return;
  // �������� ���� ������
  if(!@mysql_select_db($dbname,$dbcnx)) exit();
  // ���� �������� �� ������� - ��������� URL
  if(empty($titlepage)) 
  {
    $titlepage = "http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
  }
  // ���������� ����-�������
  $titlepage = mysql_escape_string($titlepage);
  // ��������� ��� �� ����� �������� � ���� ������
  $query = "SELECT id_page FROM $tbl_pages 
            WHERE title = '$titlepage'"; 
  $pgs = mysql_query($query); 
  if ($pgs) 
  {
    // �������, ��������� ���� (id_page) 
    // ������� ��������  (�� �������� ��������) 
    if(mysql_num_rows($pgs)>0) $id_page = mysql_result($pgs,0); 
    // ���� �������� ������ �������� ����������� � ������� pages 
    // �� ��������� ������� �� �� ������. 
    else 
    {   
      $query = "SELECT id_page FROM $tbl_pages 
                WHERE name='$_SERVER[PHP_SELF]'"; 
      $pgs = mysql_query($query); 
      if ($pgs) 
      {
        // �������� ���������� - ��������� � ��������
        if(mysql_num_rows($pgs)>0) 
        { 
         $id_page = mysql_result($pgs,0); 
         $query = "UPDATE $tbl_pages 
                   SET title = '$titlepage' 
                   WHERE id_page = $id_page"; 
         mysql_query($query); 
        } 
        // ���� ������ �������� ����������� � ������� pages 
        // � �� ���� �� ����������� - ��������� ������ 
        // �������� � �������. 
        else 
        {   
          $query = "INSERT INTO $tbl_pages 
                    VALUES (NULL, 
                            '$_SERVER[PHP_SELF]',
                            '$titlepage', 
                            0)";
          @mysql_query($query); 
          // �������� ��������� ���� ������ ��� ����������� 
          // �������� 
          $id_page = mysql_insert_id(); 
        } 
      }
    }
  }
  // ���������������� �����
  $useragent = $_SERVER['HTTP_USER_AGENT'];
  $browser = 'none';
  // �������� �������
  if(strpos($useragent, "Mozilla") !== false) $browser = 'mozilla';
  if(strpos($useragent, "MSIE")    !== false) $browser = 'msie';
  if(strpos($useragent, "MyIE")    !== false) $browser = 'myie';
  if(strpos($useragent, "Opera")   !== false) $browser = 'opera';
  if(strpos($useragent, "Netscape")!== false) $browser = 'netscape';
  if(strpos($useragent, "Firefox") !== false) $browser = 'firefox';
  // �������� ������������ �������
  $os = 'none';
  if(strpos($useragent, "Win")      !== false) $os = 'windows';
  if(strpos($useragent, "Linux")    !== false 
  || strpos($useragent, "Lynx")     !== false
  || strpos($useragent, "Unix")     !== false) $os = 'unix';
  if(strpos($useragent, "Macintosh")!== false) $os = 'macintosh';
  if(strpos($useragent, "PowerPC")  !== false) $os = 'macintosh';
  // �������� �������������� � ��������� �������
  if(strpos($useragent, "StackRambler") !== false) $os = 'robot_rambler';
  if(strpos($useragent, "Googlebot")    !== false) $os = 'robot_google';
  if(strpos($useragent, "Yandex")       !== false) $os = 'robot_yandex';
  if(strpos($useragent, "Aport")        !== false) $os = 'robot_aport';
  if(strpos($useragent, "msnbot")       !== false) $os = 'robot_msnbot';
  $search = 'none';

  // ��� ������� � ��������� - URL ��������, � �������
  // ���������� ������ �� ����
  if(!isset($_SERVER['HTTP_REFERER'])) $_SERVER['HTTP_REFERER'] = "";
  $reff = urldecode($_SERVER['HTTP_REFERER']);
  // �������� �������������� � ��������� ��������
  if(strpos($reff,"yandex"))  $search = 'yandex';
  if(strpos($reff,"rambler")) $search = 'rambler';
  if(strpos($reff,"google"))  $search = 'google';
  if(strpos($reff,"aport"))   $search = 'aport';
  if(strpos($reff,"mail") && strpos($reff,"search"))   $search = 'mail';
  if(strpos($reff,"msn") && strpos($reff,"results"))   $search = 'msn';
  $server_name = $_SERVER["SERVER_NAME"];
  if(substr($_SERVER["SERVER_NAME"],0,4) == "www.")
  {
    $server_name = substr($_SERVER["SERVER_NAME"], 4);
  }
  if(strpos($reff,$server_name)) $search = 'own_site';

  // ������� ��� ��������� ���������� � ���� ������
  $query_main = "INSERT INTO $tbl_ip VALUES (                                           
             NULL,
             INET_ATON('$ip'),
             NOW(),
             $id_page,
             '$browser',
             '$os')";
  @mysql_query($query_main);
  if(!empty($reff) && $search=="none")
  {
    $reff = mysql_escape_string($reff);
    $query_reff = "INSERT INTO $tbl_refferer VALUES (
             NULL,
             '$reff',
             now(),
             INET_ATON('$ip'),
             $id_page)";
    @mysql_query($query_reff);
  }
  //������ ��������� ������ � ��������������� �������
  if(!empty($reff) && $search!="none" && $search != "own_site")
  {
    switch($search)
    {
      case 'yandex':
      {
        preg_match("|text=([^&]+)|is", $reff."&", $out);
        if(strpos($reff,"yandpage")!=null)
          $quer = convert_cyr_string(urldecode($out[1]),"k","w");
        else
          $quer=utf8_win($out[1]);
        break;
      }
      case 'rambler':
      {
        preg_match("|words=([^&]+)|is", $reff."&", $out);
        $quer = $out[1];
        break;
      }
      case 'mail':
      {
        preg_match("|q=([^&]+)|is", $reff."&", $out);
        $quer = $out[1];
        break;
      }
      case 'google':
      {
        preg_match("|[^a]q=([^&]+)|is", $reff."&", $out);
        $quer = utf8_win($out[1]); 
        break;
      }
      case 'msn':
      {
        preg_match("|q=([^&]+)|is", $reff."&", $out);
        $quer = utf8_win($out[1]);
        break;
      }
      case 'aport':
      {
        preg_match("|r=([^&]+)|is", $reff."&", $out);
        $quer = $out[1];
        break;
      }
    }
    $symbols = array("\"", "'", "(", ")", "+", ",", "-"); 
    $quer = str_replace($symbols, " ", $quer); 
    $quer = trim($quer); 
    $quer = preg_replace('|[\s]+|',' ',$quer); 
    $query = "INSERT INTO $tbl_searchquerys 
              VALUES (NULL, 
                      '$quer', 
                      NOW(), 
                      INET_ATON('$ip'), 
                      $id_page, 
                      '$search')";
    @mysql_query($query);
  }

  function utf8_win($str)
  {
    $win = array("�","�","�","�","�","�","�","�","�","�",
                 "�","�","�","�","�","�","�","�","�","�",
                 "�","�","�","�","�","�","�","�","�","�",
                 "�","�","�","�","�","�","�","�","�","�",
                 "�","�","�","�","�","�","�","�","�","�",
                 "�","�","�","�","�","�","�","�","�","�",
                 "�","�","�","�","�","�"," ");
    $utf8 = array("\xD0\xB0","\xD0\xB1","\xD0\xB2","\xD0\xB3","\xD0\xB4",
                  "\xD0\xB5","\xD1\x91","\xD0\xB6","\xD0\xB7","\xD0\xB8",
                  "\xD0\xB9","\xD0\xBA","\xD0\xBB","\xD0\xBC","\xD0\xBD",
                  "\xD0\xBE","\xD0\xBF","\xD1\x80","\xD1\x81","\xD1\x82",
                  "\xD1\x83","\xD1\x84","\xD1\x85","\xD1\x86","\xD1\x87",
                  "\xD1\x88","\xD1\x89","\xD1\x8A","\xD1\x8B","\xD1\x8C",
                  "\xD1\x8D","\xD1\x8E","\xD1\x8F","\xD0\x90","\xD0\x91",
                  "\xD0\x92","\xD0\x93","\xD0\x94","\xD0\x95","\xD0\x81",
                  "\xD0\x96","\xD0\x97","\xD0\x98","\xD0\x99","\xD0\x9A",
                  "\xD0\x9B","\xD0\x9C","\xD0\x9D","\xD0\x9E","\xD0\x9F",
                  "\xD0\xA0","\xD0\xA1","\xD0\xA2","\xD0\xA3","\xD0\xA4",
                  "\xD0\xA5","\xD0\xA6","\xD0\xA7","\xD0\xA8","\xD0\xA9",
                  "\xD0\xAA","\xD0\xAB","\xD0\xAC","\xD0\xAD","\xD0\xAE",
                  "\xD0\xAF","+");
    return str_replace($utf8, $win, $str);
  }
?>