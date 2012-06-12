<?php
/*******************************************************************************************************
*	Powered by tractor CMS. Copyright aSecondSystem.com
*
*	Usage granted for one domain and website.
*
*	Not for resale or distribution or any other use without permission from the authors. 
*
********************************************************************************************************/
class ImageHelper extends Helper {
	var $helpers = array('Html'); 
	var $cacheDir = 'imagecache';
 
	function resize($path, $width, $height, $aspect = true, $htmlAttributes = array(), $return = false) {
		$path = trim($path);
		$types = array(1 => "gif", "jpeg", "png", "swf", "psd", "wbmp"); // used to determine image type 
 
		$fullpath = ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.IMAGES_URL;
 
		$url = $fullpath.$path;
			
		if (!($size = getimagesize($url)))
			return; // image doesn't exist
 
		if ($aspect) { // adjust to aspect.
			if (($size[1]/$height) > ($size[0]/$width))  // $size[0]:width, [1]:height, [2]:type
				$width = ceil(($size[0]/$size[1]) * $height);
			else
				$height = ceil($width / ($size[0]/$size[1]));
		}
 
		$relfile = $this->cacheDir.'/'.$width.'x'.$height.'_'.basename($path); // relative file
		$cachefile = $fullpath.$this->cacheDir.DS.$width.'x'.$height.'_'.basename($path);  // location on server
 
		if (file_exists($cachefile)) {
		$csize = getimagesize($cachefile);
		$cached = ($csize[0] == $width && $csize[1] == $height); // image is cached
		if (@filemtime($cachefile) < @filemtime($url)) // check if up to date
			$cached = false;
		} else {
			$cached = false;
		}
 
		if (!$cached) {
			# wb - changed to resize little images too. 
			//$resize = ($size[0] > $width || $size[1] > $height) || ($size[0] < $width || $size[1] < $height);
			$resize = true;
		} else {
			$resize = false;
		}
 
		if ($resize) {
			$image = call_user_func('imagecreatefrom'.$types[$size[2]], $url);
			if (function_exists("imagecreatetruecolor") && ($temp = imagecreatetruecolor ($width, $height))) {
				imagecopyresampled ($temp, $image, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
			} else {
				$temp = imagecreate ($width, $height);
				imagecopyresized ($temp, $image, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
			}
				call_user_func("image".$types[$size[2]], $temp, $cachefile);
				imagedestroy ($image);
				imagedestroy ($temp);
		}
		return $this->output(sprintf($this->Html->image($relfile,$htmlAttributes)));
    }
}
?>