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
  error_reporting(E_ALL & ~E_NOTICE); 
  $name = basename($_SERVER['PHP_SELF'])
?>
  <div <?php if('index.php'               == $name) echo 'class=active'; ?>><a class=menu href=index.php>������� �������� ��������</a></div>        
  <div <?php if('send.php'                == $name) echo 'class=active'; ?>><a class=menu href=send.php>�������� �����</a></div>
  <div <?php if('hits.php'                == $name) echo 'class=active'; ?>><a class=menu href=hits.php>�����&nbsp;�&nbsp;����</a></div>
  <div <?php if('hits.daily.php'          == $name) echo 'class=active'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<a class=menu href=hits.daily.php>���������� �����</a></div>
  <div <?php if('hits.weekly.php'         == $name) echo 'class=active'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<a class=menu href=hits.weekly.php>����������� �����</a></div>
  <div <?php if('hits.monthly.php'        == $name) echo 'class=active'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<a class=menu href=hits.monthly.php>���������� �����</a></div>
  <div <?php if('clients.php'             == $name) echo 'class=active'; ?>><a class=menu href=clients.php>�������&nbsp;�&nbsp;��������</a></div>
  <div <?php if('clients.daily.php'       == $name) echo 'class=active'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<a class=menu href=clients.daily.php>���������� �����</a></div>
  <div <?php if('clients.weekly.php'      == $name) echo 'class=active'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<a class=menu href=clients.weekly.php>����������� �����</a></div>
  <div <?php if('clients.monthly.php'     == $name) echo 'class=active'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<a class=menu href=clients.monthly.php>���������� �����</a></div>
  <div <?php if('addresses.php'           == $name) echo 'class=active'; ?>><a class=menu href=addresses.php?id_page=<?php echo $_GET['id_page']; ?>>IP-������</a></div>
  <div <?php if('addresses.daily.php'     == $name) echo 'class=active'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<a class=menu href=addresses.daily.php>���������� �����</a></div>
  <div <?php if('addresses.weekly.php'    == $name) echo 'class=active'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<a class=menu href=addresses.weekly.php>����������� �����</a></div>
  <div <?php if('addresses.monthly.php'   == $name) echo 'class=active'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<a class=menu href=addresses.monthly.php>���������� �����</a></div>
  <div <?php if('robots.php'              == $name) echo 'class=active'; ?>><a class=menu href=robots.php?id_page=<?php echo $_GET['id_page']; ?>>���������&nbsp;������</a></div>
  <div <?php if('robots.daily.php'        == $name) echo 'class=active'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<a class=menu href=robots.daily.php>���������� �����</a></div>
  <div <?php if('robots.weekly.php'       == $name) echo 'class=active'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<a class=menu href=robots.weekly.php>����������� �����</a></div>
  <div <?php if('robots.monthly.php'      == $name) echo 'class=active'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<a class=menu href=robots.monthly.php>���������� �����</a></div>
  <div <?php if('searchquery.php'         == $name) echo 'class=active'; ?>><a class=menu href=searchquery.php?id_page=<?php echo $_GET['id_page']; ?>>���������&nbsp;�������</a></div>
  <div <?php if('searchquery.daily.php'   == $name) echo 'class=active'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<a class=menu href=searchquery.daily.php>���������� �����</a></div>
  <div <?php if('searchquery.weekly.php'  == $name) echo 'class=active'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<a class=menu href=searchquery.weekly.php>����������� �����</a></div>
  <div <?php if('searchquery.monthly.php' == $name) echo 'class=active'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<a class=menu href=searchquery.monthly.php>���������� �����</a></div>
  <div <?php if('quers.php'               == $name) echo 'class=active'; ?>><a class=menu href=quers.php?id_page=<?php echo $_GET['id_page']; ?>>����������&nbsp;���������&nbsp;��������</a></div>
  <div <?php if('refferer.php'            == $name) echo 'class=active'; ?>><a class=menu href=refferer.php?id_page=<?php echo $_GET['id_page']; ?>>��������</a></div>
  <div <?php if('refferer.daily.php'      == $name) echo 'class=active'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<a class=menu href=refferer.daily.php>���������� �����</a></div>
  <div <?php if('refferer.weekly.php'     == $name) echo 'class=active'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<a class=menu href=refferer.weekly.php>����������� �����</a></div>
  <div <?php if('refferer.monthly.php'    == $name) echo 'class=active'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<a class=menu href=refferer.monthly.php>���������� �����</a></div>
  <div <?php if('enterpoint.php'          == $name) echo 'class=active'; ?>><a class=menu href=enterpoint.php?id_page=<?php echo $_GET['id_page']; ?>>�����&nbsp;�����</a></div>
  <div <?php if('deep.php'                == $name) echo 'class=active'; ?>><a class=menu href=deep.php?id_page=<?php echo $_GET['id_page']; ?>>�������&nbsp;���������</a></div>
  <div <?php if('deep.daily.php'          == $name) echo 'class=active'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<a class=menu href=deep.daily.php>���������� �����</a></div>
  <div <?php if('deep.weekly.php'         == $name) echo 'class=active'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<a class=menu href=deep.weekly.php>����������� �����</a></div>
  <div <?php if('deep.monthly.php'        == $name) echo 'class=active'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<a class=menu href=deep.monthly.php>���������� �����</a></div>
  <div <?php if('time.php'                == $name) echo 'class=active'; ?>><a class=menu href=time.php?id_page=<?php echo $_GET['id_page']; ?>>�����&nbsp;������</a></div>
  <div <?php if('time.daily.php'          == $name) echo 'class=active'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<a class=menu href=time.daily.php>���������� �����</a></div>
  <div <?php if('time.weekly.php'         == $name) echo 'class=active'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<a class=menu href=time.weekly.php>����������� �����</a></div>
  <div <?php if('time.monthly.php'        == $name) echo 'class=active'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<a class=menu href=time.monthly.php>���������� �����</a></div>
