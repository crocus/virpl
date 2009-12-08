<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-������ SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // ������� ��������� ����������� ����� ���������� $big,
  // ������� ���������� � ���� $small
  // ����������� ����� ����� ������ � ������ ������
  // $width � $height ��������, ��������������. ��� ����������� 
  // ��������� ��������. ��� ����� ����������� ����� ��������� 
  // ��������� ��������������� �����������.
  function resizeimg($big, $small, $width, $height) 
  { 
    // ��� ����� � �������������� ������������ 
    $big = "../../$big"; 
    // ��� ����� � ����������� ������. 
    $small = "../../$small";     
    // ��������� ����������� ������ �����������, ������� ����� �������� 
    $ratio = $width / $height; 
    // ������� ������� ��������� ����������� 
    $size_img = getimagesize($big); 
    list($width_src, $height_src) = getimagesize($big); 
    // ���� ������� ������, �� ��������������� �� ����� 
    if (($width_src<$width) && ($height_src<$height))
    {
      copy($big, $small);
      return true; 
    }
    // ������� ����������� ������ ��������� ����������� 
    $src_ratio=$width_src/$height_src; 

    // ����� ��������� ������� ����������� �����, ����� ��� 
    // ��������������� ����������� ��������� ��������� ����������� 
    if ($ratio<$src_ratio) 
    { 
      $height = $width/$src_ratio; 
    } 
    else 
    { 
      $width = $height*$src_ratio; 
    } 
    // �������� ������ ����������� �� �������� �������� 
    $dest_img = imagecreatetruecolor($width, $height);   
    $white = imagecolorallocate($dest_img, 255, 255, 255);        
    if ($size_img[2]==2)  $src_img = imagecreatefromjpeg($big);                       
    else if ($size_img[2]==1) $src_img = imagecreatefromgif($big);                       
    else if ($size_img[2]==3) $src_img = imagecreatefrompng($big); 

    // ������������ �����������     �������� imagecopyresampled() 
    // $dest_img - ����������� ����� 
    // $src_img - �������� ����������� 
    // $width - ������ ����������� ����� 
    // $height - ������ ����������� �����         
    // $size_img[0] - ������ ��������� ����������� 
    // $size_img[1] - ������ ��������� ����������� 
    imagecopyresampled($dest_img, 
                       $src_img, 
                       0, 
                       0, 
                       0, 
                       0, 
                       $width, 
                       $height, 
                       $width_src, 
                       $height_src);
    // ��������� ����������� ����� � ���� 
    if ($size_img[2]==2)  imagejpeg($dest_img, $small);                       
    else if ($size_img[2]==1) imagegif($dest_img, $small);                       
    else if ($size_img[2]==3) imagepng($dest_img, $small); 
    // ������ ������ �� ��������� ����������� 
    imagedestroy($dest_img); 
    imagedestroy($src_img); 
    return true;          
  }   
?>