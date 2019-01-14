<?php
extract($_REQUEST);
function GetFileFormat($picfile)
{
	$source = fopen ($picfile, "r");
	$head = fread($source, 32);	
	if(preg_match("/^\xFF\xD8/",$head)){
		return "JPEG";
	}elseif(preg_match("/^GIF8[79]a/",$head)){
		return "GIF";
	}elseif(preg_match("/^\x89PNG\x0d\x0a\x1a\x0a/",$head)){	   		
		return "PNG";
	}else{
		return "unknown";
	}
}
$upfile = $_REQUEST['upfile'];
$bool=file_exists($upfile);

if(!$bool)
{
	$upfile="../pics/noimage.jpg";
	exit();
}
else
{
	$format = GetFileFormat($upfile);
}

$size = GetImageSize($upfile); 
$width = $size[0];
$height = $size[1];

$x_ratio = $max_width / $width;
$y_ratio = $max_height / $height;

if( ($width <= $max_width) && ($height <= $max_height) )
{
	$tn_width = $width;
	$tn_height = $height;
}
elseif (($x_ratio * $height) < $max_height)
{
	$tn_height = ceil($x_ratio * $height);
	$tn_width = $max_width;
}
else
{
	$tn_width = ceil($y_ratio * $width);
	$tn_height = $max_height;
}

ini_set('memory_limit', '32M');

if ($format == "JPEG")
{
	Header("Content-type: image/jpeg");
	$src = imagecreatefromjpeg($upfile);
	$dst = ImageCreateTrueColor($tn_width, $tn_height);
}
else if ($format == "GIF")
{
	Header("Content-type: image/gif");
	$src = imagecreatefromgif($upfile);
	$dst = ImageCreateTrueColor($tn_width, $tn_height);
}
else if ($format == "PNG")
{
	Header("Content-type: image/gif");
	$src = imagecreatefrompng($upfile);
	$dst = ImageCreateTrueColor($tn_width, $tn_height);
}

imagecopyresampled($dst, $src, 0, 0, 0, 0, $tn_width, $tn_height, $width, $height);
Imagepng($dst);
ImageDestroy($src);
ImageDestroy($dst);
?>