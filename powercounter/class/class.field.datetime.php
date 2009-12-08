<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-������ SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // ������� ���������� ��� ������ ���� � �������
  ////////////////////////////////////////////////////////////
  // ���������� ������� ��������� ������ (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE);

  class field_datetime extends field
  {
    // ����� � time
    protected $time;
    // ��������� ���
    protected $begin_year;
    // �������� ���
    protected $end_year;
    // ����������� ������
    function __construct($name, 
                   $caption, 
                   $time,
                   $begin_year = 2000,
                   $end_year = 2020,
                   $parameters = "", 
                   $help = "",
                   $help_url = "")
    {
      // �������� ����������� �������� ������ field ��� 
      // ������������� ��� ������
      parent::__construct($name, 
                   "datetime", 
                   $caption, 
                   false, 
                   $value,
                   $parameters, 
                   $help,
                   $help_url);

      if(empty($time)) $this->time = time();
      else if(is_array($time))
      {
        $this->time     = mktime($time['hour'],
                                 $time['minute'],
                                 0,
                                 $time['month'],
                                 $time['day'],
                                 $time['year']);
      }
      else $this->time  = $time;
      $this->begin_year = $begin_year;
      $this->end_year   = $end_year;
    }

    // ���� � ������� MySQL
    function get_mysql_format()
    {
      return date("Y-m-d H:i:s", $this->time);
    }

    // �����, ��� �������� ����� �������� ����
    // � ������ ���� �������� ����������
    function get_html()
    {
      // ���� �������� ���������� �� ����� - ��������� ��
      if(!empty($this->css_style))
      {
        $style = "style=\"".$this->css_style."\"";
      }
      else $style = "";
      if(!empty($this->css_class))
      {
        $class = "class=\"".$this->css_class."\"";
      }
      else $class = "";

      // ��������� ���
      $date_month  = @date("m", $this->time);
      $date_day    = @date("d", $this->time);
      $date_year   = @date("Y", $this->time);
      $date_hour   = @date("H", $this->time);
      $date_minute = @date("i", $this->time);

      // ���������� ������ ��� ���
      $tag = "<select title='����' 
               $style $class type=text 
               name='".$this->name."[day]'>\n";
      for($i = 1; $i <= 31; $i++)
      {
        if($date_day == $i) $temp = "selected";
        else $temp = "";
        $tag .= "<option value=$i $temp>".sprintf("%02d", $i);
      }
      $tag .= "</select>";
      // ���������� ������ ��� ������
      $tag .= "<select title='�����' 
                $style $class type=text 
                name='".$this->name."[month]'>";
      for($i = 1; $i <= 12; $i++)
      {
        if($date_month == $i) $temp = "selected";
        else $temp = "";
        $tag .= "<option value=$i $temp>".sprintf("%02d", $i);
      }
      $tag .= "</select>";
      // ���������� ������ ��� ����
      $tag .= "<select title='���' 
                $style $class type=text 
                name='".$this->name."[year]'>";
      for($i = 2004; $i <= 2017; $i++)
      {
        if($date_year == $i) $temp = "selected";
        else $temp = "";
        $tag .= "<option value=$i $temp>$i";
      }
      $tag .= "</select>";
      // ���������� ������ ��� ����
      $tag .= "&nbsp;&nbsp;<select 
               title='����' $style $class 
               type=text name='".$this->name."[hour]'>";
      for($i = 0; $i <= 23; $i++)
      {
        if($date_hour == $i) $temp = "selected";
        else $temp = "";
        $tag .= "<option value=$i $temp>".sprintf("%02d",$i);
      }
      $tag .= "</select>";
      // ���������� ������ ��� �����
      $tag .= "<select title='������' 
                $style $class 
                type=text 
                name='".$this->name."[minute]'>";
      for($i = 0; $i <= 59; $i++)
      {
        if($date_minute == $i) $temp = "selected";
        else $temp = "";
        $tag .= "<option value=$i $temp>".sprintf("%02d",$i);
      }
      $tag .= "</select>";

      // ���� ���� �����������, �������� ���� ����
      if($this->is_required) $this->caption .= " *";

      // ��������� ���������, ���� ��� �������
      $help = "";
      if(!empty($this->help))
      {
        $help .= "<span style='color:blue'>".
                    nl2br($this->help)
                ."</span>";
      }
      if(!empty($help)) $help .= "<br>";
      if(!empty($this->help_url))
      {
        $help .= "<span style='color:blue'>
                    <a href=".$this->help_url.">������</a>
                  </span>";
      }

      return array($this->caption, $tag, $help);
    }

    // �����, ����������� ������������ ���������� ������
    function check()
    {
      if(date('Y', $this->time) > $this->end_year || 
         date('Y', $this->time) < $this->begin_year)
      {
        return "���� \"".$this->caption."\" �������� 
                ������������ �������� (��� �������� 
                ������ ������ � ��������� ".
                $this->begin_year."-".$this->end_year.")";
      }

      return "";
    }
  }
?>