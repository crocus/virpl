<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-������ SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////

  // ��������� ������� �� � ���������� $dir
  // ���� .htaccess
  function is_htaccess($ftp_handle, $dir)
  {
    $is_htaccess_dir = false;
    $file_list = @ftp_rawlist($ftp_handle, $dir);
    if(!empty($file_list))
    {
      foreach($file_list as $file_single)
      {
        // ��������� ������ �� ���������� ��������
        list($acc,
             $bloks,
             $group,
             $user,
             $size, 
             $month, 
             $day, 
             $year, 
             $file) = preg_split("/[\s]+/", $file_single);
  
        if($file == ".htaccess") $is_htaccess_dir = true;
      }
    }
    return $is_htaccess_dir;
  }
  // ��������� ������� �� � ���������� $dir
  // ���� .htpasswd
  function is_htpasswd($ftp_handle, $dir)
  {
    $is_htpasswd_dir = false;
    $file_list = @ftp_rawlist($ftp_handle, $dir);
    if(!empty($file_list))
    {
      foreach($file_list as $file_single)
      {
        // ��������� ������ �� ���������� ��������
        list($acc,
             $bloks,
             $group,
             $user,
             $size, 
             $month, 
             $day, 
             $year, 
             $file) = preg_split("/[\s]+/", $file_single);
  
        if($file == ".htpasswd") $is_htpasswd_dir = true;
      }
    }
    return $is_htpasswd_dir;
  }
  // ������ $content � ���� .htpasswd
  function put_htpasswd($ftp_handle, $dir, $content)
  {
    $local_htpasswd = tempnam("files","down");
    $ftp_htpasswd = str_replace("//","/",$dir.'/.htpasswd');
    $fd = @fopen($local_htpasswd,"w");
    if($fd)
    {
      @fwrite($fd, $content);
      @fclose($fd);
    }
    @chmod($local_htpasswd, 0644);
    // ��������� ���� .htpasswd �� ������
    $ret = @ftp_nb_put($ftp_handle, 
                       $ftp_htpasswd, 
                       $local_htpasswd, 
                       FTP_BINARY);
    while ($ret == FTP_MOREDATA)
    {
      // ���������� ��������
      $ret = @ftp_nb_continue($ftp_handle);
    }
    if ($ret == FTP_FINISHED)
    {
      // �������� ����� ������� ��� ������ ���
      // ��������� ����������
      @ftp_chmod($ftp_handle, 0644, $ftp_htpasswd);
    }
    @unlink($local_htpasswd);
  }
  // ������ ����������� ����� .htpasswd
  function get_htpasswd($ftp_handle, $dir)
  {
    $local_htpasswd = tempnam("files","down");
    $ftp_htpasswd = str_replace("//","/",$dir.'/.htpasswd');
    $ret = @ftp_nb_get($ftp_handle, 
                       $local_htpasswd, 
                       $ftp_htpasswd, 
                       FTP_BINARY);
    while ($ret == FTP_MOREDATA)
    {
      // ���������� ��������
      $ret = @ftp_nb_continue($ftp_handle);
    }
    @chmod($local_htpasswd, 0644);
    $content = @file_get_contents($local_htpasswd);
    @unlink($local_htpasswd);
    return $content;
  }
  // ������ $content � ���� .htaccess
  function put_htaccess($ftp_handle, $dir, $content)
  {
    $local_htaccess = tempnam("files","down");
    $fd = @fopen($local_htaccess,"w");
    if($fd)
    {
      @fwrite($fd, $content);
      @fclose($fd);
    }
    @chmod($local_htaccess, 0644);
    // ��������� ���� .htaccess �� ������
    $ftp_name = str_replace("//","/",$dir.'/.htaccess');
    $ret = @ftp_nb_put($ftp_handle, 
                       $ftp_name, 
                       $local_htaccess, 
                       FTP_BINARY);
    while ($ret == FTP_MOREDATA)
    {
      // ���������� ��������
      $ret = @ftp_nb_continue($ftp_handle);
    }
    if ($ret == FTP_FINISHED)
    {
      // �������� ����� ������� ��� ������ ���
      // ��������� ����������
      @ftp_chmod($ftp_handle, 0644, $ftp_name);
    }
    @unlink($local_htaccess);
  }
  // ������ ����������� ����� .htaccess
  function get_htaccess($ftp_handle, $dir)
  {
    $local_htaccess = tempnam("files","down");
    $ftp_htaccess = str_replace("//","/",$dir.'/.htaccess');
    $ret = @ftp_nb_get($ftp_handle, 
                       $local_htaccess, 
                       $ftp_htaccess, 
                       FTP_BINARY);
    while ($ret == FTP_MOREDATA)
    {
      // ���������� ��������
      $ret = @ftp_nb_continue($ftp_handle);
    }
    @chmod($local_htaccess, 0644);
    $content = @file_get_contents($local_htaccess);
    @unlink($local_htaccess);
    return $content;
  }
?>