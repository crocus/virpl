<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-студия SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  function menu_navigation($id_catalog, $link, $catalog)
  {
    $id_catalog = intval($id_catalog);
    $query = "SELECT * FROM $catalog 
              WHERE id_catalog = $id_catalog";
    $cat = mysql_query($query);
    if(!$cat)
    {
      throw new ExceptionMySQL(mysql_error(), 
                               $query,
                              "Ошибка обращения к 
                               таблице каталога 
                               menu_navigation()");
    }
    if(mysql_num_rows($cat) > 0)
    {
      $catalog_result = mysql_fetch_array($cat);
      $link = "<a class=menu 
              href=index.php?id_parent=".$catalog_result['id_catalog'].">
              ".$catalog_result['name']."</a>-&gt;".$link;
      $link = menu_navigation($catalog_result['id_parent'], 
                              $link, 
                              $catalog);
    }
    return $link;
  }
?>