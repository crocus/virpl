<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-������ SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // ����� HTML-�����
  ////////////////////////////////////////////////////////////
  // ���������� ������� ��������� ������ (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE);

  class form
  {
    // ������ ��������� ����������
    public $fields;
    // �������� ������ HTML-�����
    protected $button_name;

    // ����� CSS ������ �������
    protected $css_td_class;
    // ����� CSS ������ �������
    protected $css_td_style;
    // ����� CSS �������� ����������
    protected $css_fld_class;
    // ����� CSS �������� ����������
    protected $css_fld_style;

    // ����������� ������
    public function __construct($flds, 
                         $button_name, 
                         $css_td_class = "", 
                         $css_td_style = "",
                         $css_fld_class = "",
                         $css_fld_style = "")
    {
      $this->fields       = $flds;
      $this->button_name  = $button_name;

      $this->css_td_class = $css_td_class;
      $this->css_td_style = $css_td_style;
      $this->css_fld_class = $css_fld_class;
      $this->css_fld_style = $css_fld_style;

      // ���������, �������� �� �������� ������� $flds
      // ������������ ������ field
      foreach($flds as $key => $obj)
      {
        if(!is_subclass_of($obj, "field"))
        {
          throw new ExceptionObject($key, 
                "\"$key\" �� �������� ��������� ����������");
        }
      }
    }

    // ����� HTML-����� � ���� ��������
    public function print_form()
    {
      $enctype = "";
      if(!empty($this->fields))
      {
        foreach($this->fields as $obj)
        {
          // ��������� ���� ��������� ���������� ������ �����
          if(!empty($this->css_fld_class))
          {
            $obj->css_class = $this->css_fld_class;
          }
          if(!empty($this->css_fld_class))
          {
            $obj->css_style = $this->css_fld_style;
          }
          // ��������� ��� �� ����� ��������� ����������
          // ���� file, ���� �������, �������� ������
          // enctype='multipart/form-data'
          if($obj->type == "file")
          {
            $enctype = "enctype='multipart/form-data'";
          }
        }
      }

      // ���� �������� ���������� �� ����� - ��������� ��
      if(!empty($this->css_td_style))
      {
        $style = "style=\"".$this->css_td_style."\"";
      }
      else $style = "";
      if(!empty($this->css_td_class))
      {
        $class = "class=\"".$this->css_td_class."\"";
      }
      else $class = "";
      
      // ������� HTML-�����
      echo "<form name=form $enctype method=post>";
      echo "<table>";
      if(!empty($this->fields))
      {
        foreach($this->fields as $obj)
        {
          // �������� �������� ����, � ��� HTML-�������������
          list($caption, $tag, $help, $alternative) = $obj->get_html();
          if(is_array($tag)) $tag = implode("<br>",$tag);
          switch($obj->type)
          {
            case "hidden":
              // ������� ����
              echo $tag;
              break;
            case "paragraph":
            case "title":
              echo "<tr>
                      <td $style $class colspan=2 valign=top>$tag</td>
                    </tr>\n";
              break;
/*            case "city":
              echo "<tr>
                      <td width=100 $style $class valign=top>$caption:</td>
                      <td $style $class>$tag</td>
                    </tr>\n";
              echo "<tr>
                      <td width=100 $style $class valign=top>���� ������<br> ��� � ������:</td>
                      <td $style $class>$alternative $help</td>
                    </tr>\n";
              break;*/
            default:
              // �������� ���������� �� ���������
              echo "<tr>
                      <td width=150 
                          $style $class valign=top>$caption:</td>
                      <td $style $class valign=top>$tag</td>
                    </tr>\n";
              if(!empty($help))
              {
                echo "<tr>
                        <td>&nbsp;</td>
                        <td $style $class valign=top>$help</td>
                      </tr>";
              }
              break;
          }
        }
      }

      // ������� ������ �������������
      echo "<tr>
              <td $style $class></td>
              <td $style $class>
                <input class=button 
                       type=submit 
                       value=\"".htmlspecialchars($this->button_name, ENT_QUOTES)."\">
              </td>
            </tr>\n";
      echo "</table>";
      echo "</form>";
    }

    // ���������� ������������ ������ __toString()
    public function __toString()
    {
      $this->print_form();
    }

    // �����, ����������� ������������ ����� ������ � �����
    public function check()
    {
      // ��������������� �������� ����� check ��� �������
      // ������� field, ������������� ������
      $arr = array();
      if(!empty($this->fields))
      {
        foreach($this->fields as $obj)
        {
          $str = $obj->check();
          if(!empty($str)) $arr[] = $str;
        }
      }
      return $arr;
    }
  }
?>