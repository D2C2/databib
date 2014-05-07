<?php
 

namespace Knplabs\Snappy;
 
require_once('../Knplabs/Snappy/Media.php');
require_once('../Knplabs/Snappy/Image.php');
 
 $width = 1024;
 $height = 800;
 $new_width = 640;
 $new_height = 500;
 $compression = 75;
 $min_filesize = 40 * 1024;
 $max_filesize = 600 * 1024;
 $final_min_filesize = 10 * 1024;
 
 $options = array('disable-javascript' => true,
 //'width' => 800, 'disable-smart-width' => false,
 'crop-h' => $height, 'crop-y' => 0);
 try {
	/* 'wkhtmltoimage' executable  is located in the current directory */
	$snap = new Image('xvfb-run --server-args="-screen 0, 1280x1024x24" wkhtmltoimage-i386 --use-xserver ', $options);
	 
	set_time_limit(30);
	$snap->save($url, $img_path);
	
	if(filesize($img_path) < $min_filesize || filesize($img_path) > $max_filesize) {
		unlink($img_path);
	} else {
		list($width_orig, $height_orig) = getimagesize($img_path);
		
		$ratio_orig = $width_orig/$height_orig;

		if ($new_width/$new_height > $ratio_orig) {
		   $new_width = $new_height*$ratio_orig;
		} else {
		   $new_height = $new_width/$ratio_orig;
		}
		
		$image_p = imagecreatetruecolor($new_width, $new_height);
		$image = imagecreatefromjpeg($img_path);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
		imagejpeg($image_p,$img_path,$compression);
		
		if(filesize($img_path) < $final_min_filesize) {
			unlink($img_path);
		}
		else {
			echo " (SUCCEEDED) " . $line;
			ob_flush(); 
			flush();
			usleep(50000);
		}
	}
 } catch (Exception $e) {
	echo " (FAILED) " . $line;
}
?>
