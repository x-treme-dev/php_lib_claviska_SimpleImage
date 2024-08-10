<?php
require_once('./vendor/autoload.php');
define('SAMPLE_IMAGE' , './sample.jpg');
define('MODIFIED_IMAGE', './sample2.jpg');

function getChangeImage($path, $name){
	try{
	$image = new \claviska\SimpleImage();
	 $image
	  ->fromFile($path . $name) // load image.png
	  ->autoOrient() // adjust orientation based on exif data
	  ->resize(100, 100) // resize to 320x200 pixels
	  ->flip('x') // flip horizontally
	  ->colorize('DarkBlue') // tint dark blue
	  ->toFile('newavatar/'. $name, 'image/png'); // convert to PNG and save in a new directory
	}catch(Excepiton $err){
		 echo $err->getMessage();
	}
}

?>