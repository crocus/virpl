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
  // ������������ ���������
  require_once("../utils/utils.pager.php");
  // ������������ WHERE-�������
  require_once("utils.where.php");
  // ���������� �������
  require_once("utils.query_result.php");

  try
  {
    // ������ ���������� ���������� �������� �������� � ���������.
    $title = '����������&nbsp;���������&nbsp;&nbsp;��
              &nbsp;���������&nbsp;�����'; 
    $pageinfo = '���� ����������� ��������, ������� ��������� � 
                 ����������. �� ������������ ����� �������� 
                 ��������� ���������� �� ������ ��������� ��������
  
    <br>��� ��������� ���������� ������ �� ��������� �������� 
    �������� �� �� ����� � �������. ���� �������� �� ����� �������, 
    �� ���������� ����� ������������ ��� <a href=hits.php>����� 
    �����</a>.';    
  
    // �������� ��������� ��������
    require_once("../utils/topcounter.php");

    // ������������ ���������
    if(empty($_GET['page'])) $page = 1;
    else $page = $_GET['page'];
    
    $page_link = 3;
    $first = ($page - 1)*$pnumber;

    // ����������
    if(empty($_GET['order']))
    {
      $orderstr = "num DESC" ;
      $order = "";
    }
    else $orderstr = "title";

    // ��������� WHERE-������� ��� ���������� ���������
    $where = where_interval($_GET['begin'], $_GET['end'], $tbl_ip);
    // ��������� ���������� �������
    $query = "SELECT COUNT(DISTINCT $tbl_pages.id_page)
                     FROM $tbl_pages, $tbl_ip
                     $where AND $tbl_ip.id_page = $tbl_pages.id_page";
    $total = query_result($query);
  
    // ������� ������ �� ������ ��������
    pager($page, 
          $total, 
          $pnumber, 
          $page_link, 
          "&id_page=$id_page&order=$order&begin=$begin&end=$end");
    echo "<br><br>";
  
    // ������� ������� � �������� �������, ������������ � 
    // ���������� � ����� ���������� ����� ��� ������ �� 
    // �������.
    ?>
    <table class="table" width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr class="header">
      <td width=<?= 100/5 ?>% align=center><a href='index.php?begin=1&end=0&order=<?=$order?>'>�������</a></td>
      <td width=<?= 100/5 ?>% align=center><a href='index.php?begin=2&end=1&order=<?=$order?>'>�����</a></td>
      <td width=<?= 100/5 ?>% align=center><a href='index.php?begin=7&end=0&order=<?=$order?>'>�� 7 ����</a></td>
      <td width=<?= 100/5 ?>% align=center><a href='index.php?begin=30&end=0&order=<?=$order?>'>�� 30 ����</a></td>
      <td width=<?= 100/5 ?>% align=center><a href='index.php?begin=0&end=0&order=<?=$order?>'>�� �� �����</a></td>
     </tr>
    </table><br><br>
    <table width="100%" class="table" border="0" cellpadding="0" cellspacing="0">      
      <tr class="header" align="center">
        <td><a href=index.php?page=<? echo "$page&begin=$begin&end=$end"; ?>&order=1 
               title="����������� ������� �� ����� �������">��������</a></td>
        <td><a href=index.php?page=<? echo "$page&begin=$begin&end=$end" ?> 
               title="����������� ������� �� ���������� ���������">���������� ���������</a></td>
        <td>��������� ���������</td> 
        <td>��������</td>
      </tr>
    <?php
    $query_hits = "SELECT $tbl_ip.id_page,
                          $tbl_pages.name,
                          $tbl_pages.title AS title,
                          COUNT($tbl_ip.id_ip) AS num,
                          MAX($tbl_ip.putdate) AS putdate
                   FROM $tbl_ip, $tbl_pages
                   $where AND $tbl_ip.id_page = $tbl_pages.id_page
                   GROUP BY $tbl_ip.id_page 
                   ORDER BY $orderstr 
                   LIMIT $first, $pnumber";
    $pgs = mysql_query($query_hits);
    if(!$pgs)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "������ ��� ��������� 
                               � ������� �������");
    }
    if(mysql_num_rows($pgs))
    {
      while($pag = mysql_fetch_array($pgs))
      {
        if(empty($pag['title']))
        {
          $title = "http://{$_SERVER[SERVER_NAME]}{$pag[name]}";
        }
        else $title = $pag['title'];
        echo "<tr>
                <td><a href=addresses.php?id_page=$pag[id_page]>$title</a></td>
                <td>$pag[num]</td>
                <td>$pag[putdate]</td>
                <td align=center>
                  <a href=# onClick=\"delete_position('delpage.php?id_page=$pag[id_page]',".
                  "'�������� ����������(������) ������� �� ������� ��������');\">�������</a>
                </td>
             </tr>";
      }
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
?>