<?php
  ////////////////////////////////////////////////////////////
  // Система учёта посещаемости сайта - PowerCounter
  // 2003-2008 (C) IT-студия SoftTime (http://www.softtime.ru)
  // Поддержка: http://www.softtime.ru/forum/
  // Симдянов И.В. (simdyanov@softtime.ru)
  // Кузнецов М.В. (kuznetsov@softtime.ru)
  // Левин А.В (loki_angel@mail.ru)
  // Голышев С.В. (softtime@softtime.ru)
  ////////////////////////////////////////////////////////////
  // Выставляем уровень обработки ошибок 
  // (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE); 
  // Устанавливаем соединение с базой данных
  require_once("config.php");
  // Подключаем SoftTime FrameWork
  require_once("../../config/class.config.dmn.php");
  // Подключаем блок авторизации
  require_once("../utils/security_mod.php");
  // Подключаем блок отображения текста в окне браузера
  require_once("../utils/utils.print_page.php");

  $title = 'Отправка почтового отчёта';  
  $pageinfo = 'На этой странице можно отправить почтовый отчёт 
  за сутки, неделю и месяц. E-mail отправки можно изменить в 
  конфигурационном файле config.php системы администрирования 
  (константа EMAIL_ADDRESS)';

  try
  {
    // Включаем заголовок страницы
    require_once("../utils/topcounter.php");

    echo "<table class=table width=100% border=0 cellpadding=0 cellspacing=0>
            <tr>
              <td><a href=send_manage.php?freq=1>Отослать</a> ежедневный отчёт на ".EMAIL_ADDRESS."</td>
            </tr>
            <tr>
              <td><a href=send_manage.php?freq=7>Отослать</a> ежедненедельный отчёт на ".EMAIL_ADDRESS."</td>
            </tr>
            <tr>
              <td><a href=send_manage.php?freq=30>Отослать</a> ежемесячный отчёт на ".EMAIL_ADDRESS."</td>
            </tr>
         </table>";
  
    // Завершение страниц
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
  }?>