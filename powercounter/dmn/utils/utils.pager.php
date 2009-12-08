<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-������ SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // ������������ ���������
  ////////////////////////////////////////////////////////////
  // $page - ������� ��������, ��������� ����� GET-�������� page
  // $total - ����� ����� ������� � ���� ������
  // $pnumber - ����� ������� �� ����� ��������
  // $page_link - ����� ������ ����� � ������ �� ��������� ��������
  ///////////////////////////////////////////////////////////
  function pager($page, $total, $pnumber, $page_link, $parameters)
  {
    // ��������� ����� ������� � �������
    $number = (int)($total/$pnumber);
    if((float)($total/$pnumber) - $number != 0) $number++;
    // ��������� ���� �� ������ �����
    if($page - $page_link > 1)
    {
      echo "<span class=main_txt><a class=\"menu\" href=$_SERVER[PHP_SELF]?page=1{$parameters}>[1-$pnumber]</a>&nbsp;&nbsp;...&nbsp;&nbsp;</span>";
      // ����
      for($i = $page - $page_link; $i<$page; $i++)
      {
          echo "<span class=main_txt>&nbsp;<a class=\"menu\" href=$_SERVER[PHP_SELF]?page=$i{$parameters}> [".(($i - 1)*$pnumber + 1)."-".$i*$pnumber."]</a>&nbsp;</span>";
      }
    }
    else
    {
      // ���
      for($i = 1; $i<$page; $i++)
      {
          echo "<span class=main_txt>&nbsp;<a class=\"menu\" href=$_SERVER[PHP_SELF]?page=$i{$parameters}> [".(($i - 1)*$pnumber + 1)."-".$i*$pnumber."]</a>&nbsp;</span>";
      }
    }
    // ��������� ���� �� ������ ������
    if($page + $page_link < $number)
    {
      // ����
      for($i = $page; $i<=$page + $page_link; $i++)
      {
        if($page == $i)
          echo "<span class=main_txt>&nbsp;[".(($i - 1)*$pnumber + 1)."-".$i*$pnumber."]&nbsp;</span>";
        else
          echo "<span class=main_txt>&nbsp;<a class=\"menu\" href=$_SERVER[PHP_SELF]?page=$i{$parameters}>[".(($i - 1)*$pnumber + 1)."-".$i*$pnumber."]</a>&nbsp;</span>";
      }
      echo "<span class=main_txt>&nbsp;...&nbsp;&nbsp;<a class=\"menu\" href=$_SERVER[PHP_SELF]?page=$number{$parameters}> [".(($number - 1)*$pnumber + 1)."-$total]</a>&nbsp;</span>";
    }
    else
    {
      // ���
      for($i = $page; $i<=$number; $i++)
      {
        if($number == $i)
        {
          if($page == $i)
            echo "<span class=main_txt>&nbsp;[".(($i - 1)*$pnumber + 1)."-$total]&nbsp;</span>";
          else
            echo "<span class=main_txt>&nbsp;<a class=\"menu\" href=$_SERVER[PHP_SELF]?page=$i{$parameters}>[".(($i - 1)*$pnumber + 1)."-$total]</a>&nbsp;</span>";
        }
        else
        {
          if($page == $i)
            echo "<span class=main_txt>&nbsp;[".(($i - 1)*$pnumber + 1)."-".$i*$pnumber."]&nbsp;</span>";
          else
            echo "<span class=main_txt>&nbsp;<a class=\"menu\" href=$_SERVER[PHP_SELF]?page=$i{$parameters}>[".(($i - 1)*$pnumber + 1)."-".$i*$pnumber."]</a>&nbsp;</span>";
        }
      }
    }
  }
?>