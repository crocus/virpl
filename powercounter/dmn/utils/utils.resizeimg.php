<?php
  ////////////////////////////////////////////////////////////
  // 2006-2007 (C) IT-студия SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // Функция создающая уменьшенную копию фотографии $big,
  // которая помещается в файл $small
  // Уменьшенная копия имеет ширину и высоту равную
  // $width и $height пикселам, соответственно. Это максимально 
  // возможные значения. Они будут пересчитаны чтобы сохранить 
  // пропорции масштабируемого изображения.
  function resizeimg($big, $small, $width, $height) 
  { 
    // Имя файла с масштабируемым изображением 
    $big = "../../$big"; 
    // Имя файла с уменьшенной копией. 
    $small = "../../$small";     
    // определим коэффициент сжатия изображения, которое будем генерить 
    $ratio = $width / $height; 
    // получим размеры исходного изображения 
    $size_img = getimagesize($big); 
    list($width_src, $height_src) = getimagesize($big); 
    // Если размеры меньше, то масштабирования не нужно 
    if (($width_src<$width) && ($height_src<$height))
    {
      copy($big, $small);
      return true; 
    }
    // получим коэффициент сжатия исходного изображения 
    $src_ratio=$width_src/$height_src; 

    // Здесь вычисляем размеры уменьшенной копии, чтобы при 
    // масштабировании сохранились пропорции исходного изображения 
    if ($ratio<$src_ratio) 
    { 
      $height = $width/$src_ratio; 
    } 
    else 
    { 
      $width = $height*$src_ratio; 
    } 
    // создадим пустое изображение по заданным размерам 
    $dest_img = imagecreatetruecolor($width, $height);   
    $white = imagecolorallocate($dest_img, 255, 255, 255);        
    if ($size_img[2]==2)  $src_img = imagecreatefromjpeg($big);                       
    else if ($size_img[2]==1) $src_img = imagecreatefromgif($big);                       
    else if ($size_img[2]==3) $src_img = imagecreatefrompng($big); 

    // масштабируем изображение     функцией imagecopyresampled() 
    // $dest_img - уменьшенная копия 
    // $src_img - исходной изображение 
    // $width - ширина уменьшенной копии 
    // $height - высота уменьшенной копии         
    // $size_img[0] - ширина исходного изображения 
    // $size_img[1] - высота исходного изображения 
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
    // сохраняем уменьшенную копию в файл 
    if ($size_img[2]==2)  imagejpeg($dest_img, $small);                       
    else if ($size_img[2]==1) imagegif($dest_img, $small);                       
    else if ($size_img[2]==3) imagepng($dest_img, $small); 
    // чистим память от созданных изображений 
    imagedestroy($dest_img); 
    imagedestroy($src_img); 
    return true;          
  }   
?>