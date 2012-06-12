<?php

App::uses('Sanitize', 'Utility');


/**
 * Helper class for generating text as images dynamically.
 * Font file should exist in /app/fonts/ 
 * Respect font licenses.
 * 
 * for more information, see the article in the Bakery:
 * http://bakery.cakephp.org/articles/view/131
 * 
 * @version 1.0
 * @copyright Copyright (c) 2007, Rob Meek
 * @author Rob Meek
 * License: MIT
 * 
 * example usage:
 * 
 * $textImage->fontFile = "bodoni.ttf";
 * $textImage->setPointSize(32);
 * $textImage->image("Hello World");
 * 
 */
define('TEXT_IMAGE_PNG', 0);
define('TEXT_IMAGE_GIF', 1);

class TextImageHelper extends Helper
{	

	/**
	 * Name of the font file to use
	 * default is Verdana
	 * @var string
	 * @access public
	*/
	var $fontFile = "Verdana.TTF";
	
	/**
	 * Point size to render at
	 * default is 24
	 * best set using setPointSize()
	 * @var int
	 * @access public
	*/
	var $pointSize = 24;
	
	/**
	 * Color to render text in
	 * default is black
	 * best set using setColor()
	 * @var array
	 * @access public
	*/
	var $fgColor = array('r'=>0, 'g'=>0, 'b'=>0);
	
	/**
	 * Background color
	 * default is white
	 * best set using setBgColor()
	 * @var array
	 * @access public
	 */
	var $bgColor = array('r'=>255, 'g'=>255, 'b'=>255);
	
	/**
	 * Type of bitmap to render, PNG or GIF. Default PNG (TEXT_IMAGE_PNG)
	 * @var int
	 * @access public
	 */
	var $type = TEXT_IMAGE_PNG;	
	
	/**
	 * Caching control.
	 * -1 = no cacheing.
	 * 0 = cache permanently
	 * any positive number = cache for n seconds
	 * @var int
	 * @access public
	 */
	var $cache = -1;

	/**
	 * Turn aliasing on / off - useful for rendering pixel fonts with aliasing
	 * Note: the default setting of false means soft contours
	 * @var boolean
	 * @access public
	 */
	var $aliasing = false;
	
	/**
	 * Soften contours by rendering big and scaling down - can improve 
	 * perceived rendering quality, particularily at smaller point sizes
	 * set to 0 for no softening. Avoid high values (more than 6 would be crazy)
	 * @var int
	 * @access public
	 */
	var $softenFactor = 0;
	
	/**
	 * render a transparent background
	 * @var boolean
	 * @access public
	 */
	var $transparent = false;
	
	/**
	 * padding around the text
	 * best set with the setPadding function
	 * @var int
	 * @access public
	 */
	var $padTop = 0;
	var $padRight = 0;
	var $padBottom = 0;
	var $padLeft = 0;
	
	/**
	 * Linespacing setting for images with multiple lines of text
	 * @var float
	 * @access public
	 */
	var $lineSpacing = 0.8;
	
	/**
	 * Render an image sized for the maximum ascent and descent of the font
	 * and position the text baseline accordingly.
	 * @var boolean
	 * @access public
	 */
	var $baseAlign = true;

	/**
	* Path to where dynamic text images will be stored.
	* @var string
	*/
	var $__imagePath = 'dynimg';
	
	/**
	* Path to the font files to use relative to APP
	* @var string
	*/
	var $__fontPath = 'fonts';
	
	var $helpers = array('Html');
	
	/**
	* Return a full image tag for the given text.
	* @param string $text the text to be rendered
	* @param int $wrapWidth a pixel width to wrap at. 0 means no wrapping
	* @param string $imgName specify an optional filename for the image -
	* otherwise the filename will be formed automatically from the text
	* @param string $htmlAttr html attributes for the image tag.
	*/
	function image($text, $wrapWidth = 0, $imgName = null, $htmlAttr = null)
	{
		$imgAttr = $this->getImageAttributes($text, $wrapWidth, $imgName);
		$src = $imgAttr['src'];
		unset($imgAttr['src']);
		$sani = new Sanitize();
		//$imgAttr['alt'] = $sani->html($text);
		if ($htmlAttr)
		{
			$imgAttr = array_merge($imgAttr, $htmlAttr);
		}
		return $this->Html->image($src, $imgAttr);
	}

	/**
	* Return an array of valid attributes for the given text with the keys
	* 'src', 'height' and 'width'.
	* @param string $text the text to be rendered
	* @param int $wrapWidth a pixel width to wrap at. 0 means no wrapping
	* @param string $imgName specify an optional filename for the image -
	* otherwise the filename will be formed automatically from the text
	*/
	function getImageAttributes($text, $wrapWidth = 0, $imgName = null)
	{
		if (!$imgName)
		{
			$imgName = $this->cleanFilename($text);
		}
		$suffix = ($this->type == TEXT_IMAGE_PNG)?".png":".gif";
		$path = IMAGES_URL . $this->__imagePath . DS . $imgName . $suffix;
		$generate = false;
		$created = @filemtime($path); // false if file does not exist
		if ($this->cache == -1 || $created === false)
		{
			$generate = true;
		}
		else if ($this->cache > 0)
		{
			$generate = ((time() - $created) > $this->cache);
		}
		if ($generate)
		{
			$this->generate($text, $path, $wrapWidth);
		}		
		$src = $this->__imagePath . "/" . $imgName . $suffix;
		$imgSize = getimagesize($path);		
		$result = array("src" => $src, "width" => $imgSize[0], "height" => $imgSize[1]);		
		return $result;
	}

	/**
	 * Generate a rendered image and save it to disk
	* @param string $text the text to be rendered
	* @param string $filename specify the filename for the image
	* @param int $wrapWidth a pixel width to wrap at. 0 means no wrapping
	*/
	function generate($text, $filename, $wrapWidth = 0)
	{						
		$ps = $this->pointSize;
		$top = $this->padTop;
		$bottom = $this->padBottom;
		$left = $this->padLeft;
		$right = $this->padRight;
		if ($this->softenFactor > 0)
		{
			$ps *= $this->softenFactor;
			$top *= $this->softenFactor;
			$bottom *= $this->softenFactor;
			$left *= $this->softenFactor;
			$right *= $this->softenFactor;
		}		
		$font = APP . $this->__fontPath . DS . $this->fontFile;
		if (!file_exists($font))
		{
			echo "font file not found: " . $font;
			return;
		}
			
		// extended parameters for gd/freetype
		$xtraParamArr = array('linespacing' => $this->lineSpacing);
		
		// do hard wrap if required
		$numLines = 1;
		if ($wrapWidth != 0)
		{
			$text = $this->__hardwrap($text, $wrapWidth, $this->pointSize, $font, $xtraParamArr);
			$numLines = count(explode("\n", $text));
		}

		// try to calculate an optimal image height
		// for this point size and font
		// by rendering a text with big ascenders and descenders
		$testText = "gyT�?_";
		if ($wrapWidth != 0)
		{
			$testText = implode("\n", array_fill(0, $numLines, $testText));
		}
		$maxSizeArr = imageftbbox($ps, 0, $font, $testText, $xtraParamArr);
		$minY = min($maxSizeArr[5], $maxSizeArr[7]);
		$maxY = max($maxSizeArr[1], $maxSizeArr[3]);	
		$fontHeight = $maxY - $minY; 
		$imageH = $fontHeight + $top + $bottom; 

		// calculate baseline using a string with big ascender
		$baselineArr  = imageftbbox($ps, 0, $font, "�l", $xtraParamArr);
		$baselineY = (max($baselineArr[5], $baselineArr[7])) - $top;	

		// calculate image dimensions	
		$textSizeArr = imageftbbox($ps, 0, $font, $text, $xtraParamArr);

		// process image dimenstions
		$minX = min($textSizeArr[0], $textSizeArr[6]);
		$maxX = max($textSizeArr[2], $textSizeArr[4]);		
		$textW = ($maxX - $minX) + 2;
		if (!$this->baseAlign)
		{
			$minY = min($textSizeArr[5], $textSizeArr[7]);
			$maxY = max($textSizeArr[1], $textSizeArr[3]);
			$imageH = $maxY - $minY + $top + $bottom; 
			$baselineY = (max($textSizeArr[5], $textSizeArr[7])) - $top;
		}
				
		// make image
		$width = $textW; //max($wrapWidth, $textW);
		$width  += ($left + $right); 
		$im = imagecreatetruecolor($width, $imageH);
		
		// define colors 
		$backCol = imagecolorallocate($im, $this->bgColor['r'], $this->bgColor['g'], $this->bgColor['b']);
		if ($this->transparent)
{
    imagealphablending($im, false);
    $backCol = imagecolorallocatealpha($im, $this->bgColor['r'], $this->bgColor['g'], $this->bgColor['b'], 127);
    imagefill($im,0,0,$backCol);
    imagealphablending($im, true);
    imagesavealpha($im, true);

}
		else
		{
			imagefill($im, 0, 0, $backCol);
		}
		$textCol = imagecolorallocate ($im, $this->fgColor['r'], $this->fgColor['g'], $this->fgColor['b']);	
	
		// render text
		$col = $textCol;
		if ($this->aliasing)
		{
			$col = 0 - $col;
			if ($col == 0)
			{
				$col = -1;
			}
		}
		imagefttext($im, $ps, 0, (1-$minX) + $left, -1 - $baselineY,
			$col, $font,  $text,
			$xtraParamArr);	
		
		// save image to disk 
		if ($this->softenFactor > 0)
		{
			$im2=imagecreatetruecolor($width / $this->softenFactor, $imageH / $this->softenFactor); 
			// make real size image
			imagecopyresampled($im2,$im,0,0,0,0,imagesx($im2),imagesy($im2),imagesx($im),imagesy($im));
			if ($this->type == TEXT_IMAGE_PNG)
			{
				imagepng($im2, $filename);
			}
			else
			{
				imagegif($im2, $filename);
			}
		}
		else
		{
			if ($this->type == TEXT_IMAGE_PNG)
			{
				imagepng($im, $filename);
			}
			else
			{
				imagegif($im, $filename);
			}
		}
			
		// destroy images
		@imagedestroy($im);
		if ($this->softenFactor)
		{
			@imagedestroy($im2);
		}
	}
	
	/**
	* Set the directory where dynamic text images
	* are stored - relative to the /webroot/img folder
	* directory will be constructed if it doesn't exist
	* but without recursion in PHP4
 	*/
	function setImageDirectory($directory)
	{
		$this->__imagePath = $directory;
		if (!file_exists(IMAGES_URL . $this->__imagePath)) 
		{
			if (phpversion() < 5)
			{
				mkdir(IMAGES_URL . $this->__imagePath);
			}
			else
			{
				mkdir(IMAGES_URL . $this->__imagePath, 0777, true);
			} 

		}
	}
		
	/**
	*
	*/
	function setFontPath($fontPath)
	{
		$this->__fontPath = $fontPath;
	}

	/**
	 * Set the point size to render at
	 */
	function setPointSize($pointSize)
	{
		$this->pointSize = $pointSize / 96 * 72;
	}
	
	/**
	 * Set the foreground color for the images in hex e.g. 0xFF0000
	 */
	function setColor($color)
	{
		$rgb = hexdec($color);
		$this->fgColor['r'] = ($rgb & 0xFF0000) >> 16;
		$this->fgColor['g'] = ($rgb & 0xFF00) >> 8;
		$this->fgColor['b'] = ($rgb & 0xFF);
	}
	
	/**
	 * Set the background color for the images in hex e.g. 0xCCCCCC
	 */
	function setBgColor($color)
	{
		$rgb = hexdec($color);
		$this->bgColor['r'] = ($rgb & 0xFF0000) >> 16;
		$this->bgColor['g'] = ($rgb & 0xFF00) >> 8;
		$this->bgColor['b'] = ($rgb & 0xFF);
	}	
	
	/**
	 * Set pixel padding around the rendered text
	 * useful if clipping is occurring
	 */
	function setPadding($top, $right, $bottom, $left)
	{
		$this->padTop = $top;
		$this->padRight = $right;
		$this->padBottom = $bottom;
		$this->padLeft = $left;
	}
	
	/**
	* wrap a text for a specific width
	* inserts hard returns into the returned string
	*/
	function __hardwrap($text, $wrapWidth, $ptSize, $font, $xtraParamArr)
	{
		$text .= " "; 
		$spaces = array();
		$widths = array();
		$i = 0;
		// measure the widths of all the words
		while(true)
		{
			$nextSpace = strpos(substr($text,$i)," ");
			if(!($nextSpace === false))
			{
				$spaces[] = $nextSpace + $i;
				$bbox = imageftbbox($ptSize, 0, $font, substr($text, $i, $nextSpace + 1), $xtraParamArr);
				$left = ($bbox[0] > $bbox[6])?$bbox[6]:$bbox[0]; 
				$right = ($bbox[2] > $bbox[4])?$bbox[2]:$bbox[4]; 
				$widths[]= $right - $left; 
				$i = $nextSpace + $i + 1;
			}
			else
				break;
		}
		$lastspace =- 1;
		$lineWidth = 0;
		$result = "";
		for ($i = 0; $i < count($spaces); $i++)
		{
			if((($lineWidth > 0) && ($lineWidth + $widths[$i]) > $wrapWidth)) // time for a line break
			{
				// wrap
				$result .= "\r\n";
				$lineWidth = 0;
				$i--;
			}
			else 
			{
				// add a word to line
				// we'll always get at least one word (even if too wide) thanks to 
				// ($lineWidth > 0) test above
				$result .= substr($text, $lastspace + 1, $spaces[$i] - $lastspace);
				$lineWidth += $widths[$i];
				$lastspace = $spaces[$i];
			}
		}
		return $result;
	}	
	
	function cleanFilename($str)
	{
		uses('sanitize');
		$cleaner = new Sanitize();
		$str = str_replace(' ', '_', $str);
		$str = str_replace('&', '_and_', $str);
		$str = str_replace('/', '_', $str);
		$str = str_replace('\\', '_', $str);
		$str = str_replace('�', 'ae', $str);
		$str = str_replace('�', 'Ae', $str);
		$str = str_replace('�', 'ue', $str);
		$str = str_replace('�', 'Ue', $str);
		$str = str_replace('�', 'oe', $str);
		$str = str_replace('�', 'oe', $str);
		$str = str_replace('�', 'ss', $str);
		$str =  $cleaner->paranoid($str, array('_','-'));
		$str = str_replace('__', '_', $str);
		return strtolower($str);
	}		
	
}
?>