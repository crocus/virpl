<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-студия SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // Если константа DEBUG определена, работает отладочный
  // вариант, в частности выводится подробные сообщения об
  // исключительных ситуациях, связанных с MySQL и ООП
  define("DEBUG", 1);
  // сейчас выставлен сервер локальной машины
  $dblocation = "localhost";
  // Имя базы данных, на хостинге или локальной машине
  $dbname = "foliantn_powercounter";
  $dbuser = "foliantn_iamcroc";
  $dbpasswd = "di13Bskj";

  // Аккаунты
  $tbl_accounts         = 'system_accounts';
  // Новости
  $tbl_news             = 'system_news';
  // Ответы и вопросы
  $tbl_faq              = 'system_faq';
  // CMS
  $tbl_catalog          = 'system_menu_catalog';
  $tbl_position         = 'system_menu_position';
  $tbl_paragraph        = 'system_menu_paragraph';
  $tbl_paragraph_image  = 'system_menu_paragraph_image';
  // Каталог
  $tbl_cat_catalog      = 'system_catalog';
  $tbl_cat_position     = 'system_position';
  // Блок контакты
  $tbl_contactaddress   = 'system_contactaddress';
  // Блок голосования
  $tbl_poll             = 'system_poll';
  $tbl_poll_answer      = 'system_poll_answer';
  $tbl_poll_session     = 'system_poll_session';
  // Гостевая книга
  $tbl_guestbook        = 'system_guestbook';
  // Пользователи сайта
  $tbl_users            = 'system_users';
  // Фотогалерея
  $tbl_photo_catalog    = 'system_photo_catalog';
  $tbl_photo_position   = 'system_photo_position';
  $tbl_photo_settings   = 'system_photo_settings';

  // Устанавливаем соединение с базой данных
  $dbcnx = mysql_connect($dblocation,$dbuser,$dbpasswd);
  if(!$dbcnx)
	exit("<P>В настоящий момент сервер базы данных не 
		  доступен, поэтому корректное отображение 
		  страницы невозможно.</P>" );
  // Выбираем базу данных
  if(! @mysql_select_db($dbname,$dbcnx))
	exit("<P>В настоящий момент база данных не доступна, 
		  поэтому корректное отображение страницы 
		  невозможно.</P>" );

  @mysql_query("SET NAMES 'cp1251'");
//  @mysql_query("SET time_zone = '+11:00'");
  if(!function_exists('get_magic_quotes_gpc'))
  {
	function get_magic_quotes_gpc()
	{
	  return false;
	}
  }
?>