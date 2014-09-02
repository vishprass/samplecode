<?php

//
// class imagehandler.php
//
//


class Imagehandler{
	
	public $main_path;
	public  function uploadOriginals($tmpfile, $filename, $array){
		$targetpath = $array['targetpath'].$filename;
		move_uploaded_file($tmpfile, $targetpath);
		$this->main_path = $targetpath;
		list($width, $height)= getimagesize($this->main_path);
		foreach($array as $key => $val){
			if(preg_match("/_width/",$key)){
					$width =  $val;
			}
			if(preg_match("/_height/",$key)){
					$height =  $val;
			}
			
			if((!intval($val))  && (!preg_match("/_height/",$key))){
				$fldrpath = $val.$filename;
				$this->resizeImage($width, $height, $fldrpath);	
			}
		}	
	}
	
	
	public function resizeImage($ow, $oh, $path){
			list($width, $height)= getimagesize($this->main_path);
			$src = @imagecreatefromjpeg($this->main_path);
			if(!$src) $src = @imagecreatefrompng($this->main_path);
			if(!$src) $src = @imagecreatefromwbmp($this->main_path);
			if(!$src) $src = @imagecreatefromxbm($this->main_path);
			if(!$src) $src = @imagecreatefromxpm($this->main_path);
			
			$nw = $ow; $nh = $oh;
			$dw = $width / $nw; $dh = $height / $nh;
			if ( $dw > $dh )
				$nw = $nh * $width / $height;
			else
				$nh = $nw * $height / $width;
			$mx = 1;
			$nh *= $mx; $nw *= $mx;
			$nx = ($nw - $ow) / 2;
			$ny = ($nh - $oh) / 2;
			$dest = imagecreatetruecolor($ow, $oh);
			imageantialias($dest, TRUE);
			$bg = imagecreatetruecolor($nw, $nh);
			imageantialias($dest, TRUE);
			imagecopyresampled($bg, $src, 0, 0, 0, 0, $nw, $nh, $width, $height);
			imagecopy($dest, $bg, 0, 0, $nx, $ny, $ow, $oh);
			imagejpeg($dest, $path, 80);
	}

}

?>