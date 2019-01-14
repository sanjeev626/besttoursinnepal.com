<?php
/*	
	Copyright 2007 WebCheatSheet.com	
*/
class thumbnail
{
	function createThumbs($fname, $pathToImages, $pathToThumbs, $thumbWidth ) 
	{  
		// parse path for the extension
		$info = pathinfo($pathToImages.$fname);
		// continue only if this is a JPEG image
		if ( strtolower($info['extension']) == 'jpg' || strtolower($info['extension']) == 'jpeg' ) 
		{
		  // load image and get image size
		  $img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
		  $width = imagesx( $img );
		  $height = imagesy( $img );
	
		  // calculate thumbnail size
		  $new_width = $thumbWidth;
		  $new_height = floor( $height * ( $thumbWidth / $width ) );
	
		  // create a new tempopary image
		  $tmp_img = imagecreatetruecolor( $new_width, $new_height );
	
		  // copy and resize old image into new image 
		  imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
	
		  // save thumbnail into a file
		  imagejpeg( $tmp_img, "{$pathToThumbs}{$fname}" );
		}
		
		if ( strtolower($info['extension']) == 'png' ) 
		{
		  // load image and get image size
		  $img = imagecreatefrompng( "{$pathToImages}{$fname}" );
		  $width = imagesx( $img );
		  $height = imagesy( $img );
	
		  // calculate thumbnail size
		  $new_width = $thumbWidth;
		  $new_height = floor( $height * ( $thumbWidth / $width ) );
	
		  // create a new tempopary image
		  $tmp_img = imagecreatetruecolor( $new_width, $new_height );
	
		  // copy and resize old image into new image 
		  imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
	
		  // save thumbnail into a file
		  imagepng( $tmp_img, "{$pathToThumbs}{$fname}" );
		}
		
		if ( strtolower($info['extension']) == 'gif' ) 
		{
		  // load image and get image size
		  $img = imagecreatefromgif( "{$pathToImages}{$fname}" );
		  $width = imagesx( $img );
		  $height = imagesy( $img );
	
		  // calculate thumbnail size
		  $new_width = $thumbWidth;
		  $new_height = floor( $height * ( $thumbWidth / $width ) );
	
		  // create a new tempopary image
		  $tmp_img = imagecreatetruecolor( $new_width, $new_height );
	
		  // copy and resize old image into new image 
		  imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
	
		  // save thumbnail into a file
		  imagegif( $tmp_img, "{$pathToThumbs}{$fname}" );
		}
	}
	
	function createThumbsByHeight($fname, $pathToImages, $pathToThumbs, $thumbHeight) 
	{  
		if($this->getImageHeight($fname, $pathToImages)>$thumbHeight)
		{
		  // parse path for the extension
		  $info = pathinfo($pathToImages.$fname);
		  // continue only if this is a JPEG image
		  if ( strtolower($info['extension']) == 'jpg' || strtolower($info['extension']) == 'jpeg' ) 
		  {
		  // load image and get image size
		  $img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
		  $width = imagesx( $img );
		  $height = imagesy( $img );
	
		  // calculate thumbnail size
		  $new_width = floor( $width * ( $thumbHeight / $height ) );
		  $new_height = $thumbHeight;
	
		  // create a new tempopary image
		  $tmp_img = imagecreatetruecolor( $new_width, $new_height );
	
		  // copy and resize old image into new image 
		  imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
	
		  // save thumbnail into a file
		  imagejpeg( $tmp_img, "{$pathToThumbs}{$fname}" );
		  }
		
		  if ( strtolower($info['extension']) == 'png' ) 
		  {
		  // load image and get image size
		  $img = imagecreatefrompng( "{$pathToImages}{$fname}" );
		  $width = imagesx( $img );
		  $height = imagesy( $img );
	
		  // calculate thumbnail size
		  $new_width = floor( $width * ( $thumbHeight / $height ) );
		  $new_height = $thumbHeight;
	
		  // create a new tempopary image
		  $tmp_img = imagecreatetruecolor( $new_width, $new_height );
	
		  // copy and resize old image into new image 
		  imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
	
		  // save thumbnail into a file
		  imagepng( $tmp_img, "{$pathToThumbs}{$fname}" );
		  }
	
		  if ( strtolower($info['extension']) == 'gif' ) 
		  {
		  // load image and get image size
		  $img = imagecreatefromgif( "{$pathToImages}{$fname}" );
		  $width = imagesx( $img );
		  $height = imagesy( $img );
	
		  // calculate thumbnail size
		  $new_width = floor( $width * ( $thumbHeight / $height ) );
		  $new_height = $thumbHeight;
	
		  // create a new tempopary image
		  $tmp_img = imagecreatetruecolor( $new_width, $new_height );
	
		  // copy and resize old image into new image 
		  imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
	
		  // save thumbnail into a file
		  imagegif( $tmp_img, "{$pathToThumbs}{$fname}" );
		  }
		}
	}
	
	function getImageHeight($fname, $pathToImages) 
	{  
		// parse path for the extension
		$info = pathinfo($pathToImages.$fname);
		// continue only if this is a JPEG image
		if ( strtolower($info['extension']) == 'jpg' || strtolower($info['extension']) == 'jpeg' ) 
		{
		  // load image and get image size
		  $img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
		  $width = imagesx( $img );
		  $height = imagesy( $img );		  
		}
		
		if ( strtolower($info['extension']) == 'png' ) 
		{
		  // load image and get image size
		  $img = imagecreatefrompng( "{$pathToImages}{$fname}" );
		  $width = imagesx( $img );
		  $height = imagesy( $img );
		}
		
		if ( strtolower($info['extension']) == 'gif' ) 
		{
		  // load image and get image size
		  $img = imagecreatefromgif( "{$pathToImages}{$fname}" );
		  $width = imagesx( $img );
		  $height = imagesy( $img );
		}
	return $height;
	}
}
$thumbObj = new thumbnail();
?>