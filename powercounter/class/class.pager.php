<?php
  abstract class pager
  {
    abstract function get_total();
    abstract function get_pnumber();
    abstract function get_page_link();
    abstract function get_parameters();
    
    // Ссылки на другие страницы
    public function __toString()
    {
      // Строка для возвращаемого результата
      $return_page = "";

      // Через GET-параметр page передаётся номер
      // текущей страницы
      $page = intval($_GET['page']);
      if(empty($page)) $page = 1;

      // Вычисляем число страниц в системе
      $number = (int)($this->get_total()/$this->get_pnumber());
      if((float)($this->get_total()/$this->get_pnumber()) - $number != 0)
      {
        $number++;
      }
      // Проверяем есть ли ссылки слева
      if($page - $this->get_page_link() > 1)
      {
        $return_page .= "<a href=$_SERVER[PHP_SELF]".
              "?page=1{$this->get_parameters()} class=main_txt_lnk>[1-{$this->get_pnumber()}]</a>&nbsp;&nbsp;...&nbsp;&nbsp;";
        // Есть
        for($i = $page - $this->get_page_link(); $i<$page; $i++)
        {
          $return_page .= "&nbsp;<a href=$_SERVER[PHP_SELF]".
                 "?page=$i{$this->get_parameters()} class=main_txt_lnk>[".
                 (($i - 1)*$this->get_pnumber() + 1).
                  "-".$i*$this->get_pnumber()."]</a>&nbsp;";
        }
      }
      else
      {
        // Нет
        for($i = 1; $i<$page; $i++)
        {
          $return_page .= "&nbsp;<a href=$_SERVER[PHP_SELF]".
                 "?page=$i{$this->get_parameters()} class=main_txt_lnk>[".
                 (($i - 1)*$this->get_pnumber() + 1).
                 "-".$i*$this->get_pnumber()."]</a>&nbsp;";
        }
      }
      // Проверяем есть ли ссылки справа
      if($page + $this->get_page_link() < $number)
      {
        // Есть
        for($i = $page; $i<=$page + $this->get_page_link(); $i++)
        {
          if($page == $i)
            $return_page .= "&nbsp;[".
                (($i - 1) * $this->get_pnumber() + 1).
                 "-".$i*$this->get_pnumber()."]&nbsp;";
          else
            $return_page .= "&nbsp;<a href=$_SERVER[PHP_SELF]".
                 "?page=$i{$this->get_parameters()} class=main_txt_lnk>[".
                 (($i - 1)*$this->get_pnumber() + 1).
                 "-".$i*$this->get_pnumber()."]</a>&nbsp;";
        }
        $return_page .= "&nbsp;...&nbsp;&nbsp;".
             "<a href=$_SERVER[PHP_SELF]".
             "?page=$number{$this->get_parameters()} class=main_txt_lnk>[".
             (($number - 1)*$this->get_pnumber() + 1).
             "-{$this->get_total()}]</a>&nbsp;";
      }
      else
      {
        // Нет
        for($i = $page; $i<=$number; $i++)
        {
          if($number == $i)
          {
            if($page == $i)
              $return_page .= "&nbsp;[".
                              (($i - 1)*$this->get_pnumber() + 1).
                              "-{$this->get_total()}]&nbsp;";
            else
              $return_page .= "&nbsp;<a href=$_SERVER[PHP_SELF]".
                   "?page=$i{$this->get_parameters()} class=main_txt_lnk>[".(($i - 1)*$this->get_pnumber() + 1).
                   "-{$this->get_total()}]</a>&nbsp;";
          }
          else
          {
            if($page == $i)
              $return_page .= "&nbsp;[".
                  (($i - 1)*$this->get_pnumber() + 1).
                   "-".$i*$this->get_pnumber()."]&nbsp;";
            else
              $return_page .= "&nbsp;<a href=$_SERVER[PHP_SELF]".
                   "?page=$i{$this->get_parameters()} class=main_txt_lnk>[".(($i - 1)*$this->get_pnumber() + 1)."-".($i*$this->get_pnumber())."]</a>&nbsp;";
          }
        }
      }
      return $return_page;
    }

    // Альтернативный вид постраничной навигации
    public function print_page()
    {
      // Строка для возвращаемого результата
      $return_page = "";

      // Через GET-параметр page передаётся номер
      // текущей страницы
      $page = intval($_GET['page']);
      if(empty($page)) $page = 1;

      // Вычисляем число страниц в системе
      $number = (int)($this->get_total()/$this->get_pnumber());
      if((float)($this->get_total()/$this->get_pnumber()) - $number != 0)
      {
        $number++;
      }

      // Ссылка на первую страницу
      $return_page .= "<a href='$_SERVER[PHP_SELF]?page=1{$this->get_parameters()}' class=main_txt_lnk>&lt;&lt;</a> ... ";
      // Выводим ссылку "Назад", если это не первая страница 
      if($page != 1) $return_page .= " <a href='$_SERVER[PHP_SELF]?page=".($page - 1)."{$this->get_parameters()}' class=main_txt_lnk>&lt;</a> ... "; 
      
      // Выводим предыдущие элементы 
      if($page > $this->get_page_link() + 1) 
      { 
        for($i = $page - $this->get_page_link(); $i < $page; $i++) 
        { 
          $return_page .= "<a href='$_SERVER[PHP_SELF]?page=$i' class=main_txt_lnk>$i</a> "; 
        } 
      } 
      else 
      { 
        for($i = 1; $i < $page; $i++) 
        { 
          $return_page .= "<a href='$_SERVER[PHP_SELF]?page=$i' class=main_txt_lnk>$i</a> "; 
        } 
      } 
      // Выводим текущий элемент 
      $return_page .= "$i "; 
      // Выводим следующие элементы 
      if($page + $this->get_page_link() < $number) 
      { 
        for($i = $page + 1; $i <= $page + $this->get_page_link(); $i++) 
        { 
          $return_page .= "<a href='$_SERVER[PHP_SELF]?page=$i' class=main_txt_lnk>$i</a> "; 
        } 
      } 
      else 
      { 
        for($i = $page + 1; $i <= $number; $i++) 
        { 
          $return_page .= "<a href='$_SERVER[PHP_SELF]?page=$i' class=main_txt_lnk>$i</a> "; 
        } 
      } 

      // Выводим ссылку вперёд, если это не последняя страница 
      if($page != $number) $return_page .= " ... <a href='$_SERVER[PHP_SELF]?page=".($page + 1)."{$this->get_parameters()}' class=main_txt_lnk>&gt;</a>"; 
      // Ссылка на последнюю страницу
      $return_page .= " ... <a href='$_SERVER[PHP_SELF]?page=$number{$this->get_parameters()}' class=main_txt_lnk>&gt;&gt;</a>";
  
      return $return_page;
    }
  }
?>