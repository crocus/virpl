<?php
  ////////////////////////////////////////////////////////////
  // ������ �����������������
  // 2006-2007 (C) IT-������ SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // ���������� ������� ��������� ������ (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE); 

  // ������������ ����������, ����������� ��� 
  // ��������� � ���� MySQL

  // �������� ��������� ��������
  require_once("../utils/top.php");

  echo "<p class=help>��������� �������������� 
        �������� (ExceptionMySQL) ��� ���������
        � ���� MySQL.</p>";
  echo "<p class=help>{$exc->getMySQLError()}<br>
       ".nl2br($exc->getSQLQuery())."</p>";
  echo "<p class=help>������ � ����� {$exc->getFile()}
        � ������ {$exc->getLine()}.</p>";

  // �������� ���������� ��������
  require_once("../utils/bottom.php");
  exit();
?>