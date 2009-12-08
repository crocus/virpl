<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-студия SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // Функция обработки bbCode
  ////////////////////////////////////////////////////////////
  function print_page($postbody)
  {
    // Разрезаем слишком длинные слова
    $postbody = preg_replace_callback(
              "|([a-zа-я\d!]{35,})|i",
              "split_text",
              $postbody);
    // Предотвращаем XSS-инъекции
    $postbody = htmlspecialchars($postbody, ENT_QUOTES);
    // Тэги
    $pattern = "#\[b\](.+)\[\/b\]#isU";
    $postbody = preg_replace($pattern, 
                             '<b>\\1</b>', 
                             $postbody);
    $pattern = "#\[i\](.+)\[\/i\]#isU";
    $postbody = preg_replace($pattern, 
                             '<i>\\1</i>', 
                             $postbody);
    $pattern = "#\[u\](.+)\[\/u\]#isU";
    $postbody = preg_replace($pattern, 
                             '<u>\\1</u>', 
                             $postbody);
    $pattern = "#\[sup\](.+)\[\/sup\]#isU";
    $postbody = preg_replace($pattern, 
                             '<sup>\\1</sup>', 
                             $postbody);
    $pattern = "#\[sub\](.+)\[\/sub\]#isU";
    $postbody = preg_replace($pattern, 
                             '<sub>\\1</sub>', 
                             $postbody);
    $pattern = "#\[url\][\s]*([\S]*)[\s]*\[\/url\]#si";
    $postbody = preg_replace_callback($pattern,
               "url_replace",
                $postbody);
    $pattern = "#\[url[\s]*=[\s]*([\S]+)[\s]*\][\s]*([^\[]*)\[/url\]#isU";
    $postbody = preg_replace_callback($pattern,
               "url_replace_name",
                $postbody);
    return $postbody;
  }
  function url_replace($matches)
  {
    if(substr($matches[1], 0, 7) != "http://") $matches[1] = "http://".$matches[1];
    return "<a href='$matches[1]' class=news_txt_lnk>$matches[1]</a>";
  }
  function url_replace_name($matches)
  {
    if(substr($matches[1], 0, 7) != "http://") $matches[1] = "http://".$matches[1];
    return "<a href='$matches[1]' class=news_txt_lnk>$matches[2]</a>";
  }
  function split_text($matches) 
  {
    return wordwrap($matches[1], 35, ' ',1);
  }
?>