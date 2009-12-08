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

  if (!isset($_GET['begin'])) $begin = 1;
  else $begin = intval($_GET['begin']);
  
  if (!isset($_GET['nav'])) $nav = 0;
  else $nav = intval($_GET['nav']);
  if ($nav==0) 
  {
    $dateofput = "min( putdate )";
    $title = '����� �����';
    $pageinfo = '�� ���� �������� �� ������ ������ ����� 
    ����� �������� ���������� ������� �� ��� ������';
  }
  else 
  {
    $dateofput = "max( putdate )";
    $title = '����� ������';
    $pageinfo = '�� ���� �������� �� ������ ������ �� 
    ����� �������� ���������� �������� ��� ������';
  }
 
  try
  {
    // �������� ��������� ��������
    require_once("../utils/topcounter.php");
  
    // �������� ������ ��������� ����������
    require_once("time_interval.php");

    ?>
      <table width=100% border=0>
        <tr valign=top>
          <td width=30%>
    <?php
      echo "<a href='enterpoint.php";
      if ($nav==0) echo "?nav=1'>����� ������";
      else echo "?nav=0'>����� �����";
      echo "</a>";  
    ?>
         </td>  
         <td align=left>
           <table class="table" 
                  width="60%" 
                  border="0" 
                  cellpadding="0" 
                  cellspacing="0">
         <tr class="header" align="center">
           <td>��������</td>
           <td>
             <?php if ($nav==0) print "������";
              else print "�������"; ?>
           </td></tr>
    <?php
    $pages = array();
    for ($i = $begin; $i > $end; $i--)
    {
      // ��������� WHERE-������� ��� ���������� ���������
      $where = where_interval($begin, $end);
      //������ ������������� �� ���� ��� ����� ����� �� �����
      $query = "SELECT ip, $dateofput as putdate
                FROM $tbl_ip
                $where AND
                  systems != 'none' AND
                  systems != 'robot_yandex' AND
                  systems != 'robot_google' AND
                  systems != 'robot_rambler' AND
                  systems != 'robot_aport' AND
                  systems != 'robot_msn'
                GROUP BY ip";

      $pag = mysql_query($query);    
      if(!$pag)
      {
        throw new ExceptionMySQL(mysql_error(), 
                                 $query,
                                "������ ��� ��������� 
                                 � ������� �������");
      }
      if(mysql_num_rows($pag))
      {
        // ���������� ����� ����� � ��������� ������.
        // ���� ������ ����� ����������� ������� ���, 
        // �� ������� ����� ����� ����������.
        while($page = mysql_fetch_array($pag))
        {
          $query = "SELECT id_page FROM $tbl_ip 
                    WHERE ip='$page[ip]' AND 
                          putdate='$page[putdate]'";
          $pages[] = query_result($query);
        }
      }
    }

    //�������� ������ � ����������, id � �������� �������
    $query = "SELECT * FROM $tbl_pages";
    $pag = mysql_query($query);
    if(!$pag)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ��������� 
                               � ������� �������");
    }
    $names = array();
    if(mysql_num_rows($pag))
    {
      while($page = mysql_fetch_array($pag))
      {
        $names[$page['id_page']]['name'] = $page['name'];
        $names[$page['id_page']]['title'] = $page['title'];
      } 
    }

    // ������� ���������� ������ �� ������ ��������  
    if (isset($pages))
    {
      $points = array_count_values($pages); 
      // ��������� �� ��������� ������ � �������� �������
      arsort($points);  
      // ������� ������� ��� ����� �������� �������� � 
      // ���������� ������� ����� ���
      if(count($points) > 0)
      foreach ($points as $id => $hits)
      { 
        if(count($names) > 0)
        foreach ($names as $id2 => $name)
        {  
          if ($id == $id2) 
          { 
            $link = "<a href=http://{$_SERVER[SERVER_NAME]}".
                    "{$names[$id][name]} target=_blank ".
                    "title='������� �������� �����'".
                    ">http://{$_SERVER[SERVER_NAME]}{$names[$id][name]}</a>";
            print "<tr><td>$link</td><td>$hits</td><tr>"; 
          }
        }
      }
    }
    // ������� ������� ������� 
/*    if (count($points) > 0)
    {
      $arr[] = "0";
      foreach ($points as $id => $hits) $arr[] = $id;
    } 
    $query = "SELECT * FROM $tbl_pages 
              WHERE id_page NOT IN (".implode(",", $arr)."0)";
    $pag = mysql_query($query);
    if(!$pag)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ��������� 
                               � ������� �������");
    }
    if(mysql_num_rows($pag))
    {
      while ($zero=mysql_fetch_array($qwery))
      {
        $link = "<a href=http://{$_SERVER[SERVER_NAME]}".
                "$zero[name] target=_blank ".
                "title='������� �������� �����'".
                ">http://{$_SERVER[SERVER_NAME]}{$zero[name]}</a>";
        print "<tr>$link<td></td><td>0</td><tr>";
      }
    }*/

    echo "</table>";
    echo "</td></tr></table>";
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
?>