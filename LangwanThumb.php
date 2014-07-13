<?php

/**
 * author: langwan@langwan.com
 * version: 2014.07.13.16.11
 *
 * resize image
 *
 * url src is http://www.langwan.com/img/abc
 * access to :
 * auto width and fixed height
 * http://www.langwan.com/img/abc_f-0-200
 * auto height and fixed width
 * http://www.langwan.com/img/abc_f-200-0
 * scaled down fill the background
 * http://www.langwan.com/img/abc_a-200-200
 * cut off the excess part
 * http://www.langwan.com/img/abc_c-200-200 
 * resize image drawing this
 * /img/abc_r-200-200
 *
 * example:
 * <?php
 *
 * $thumb = new LangwanThumb;
 * $thumb->root("/upload/images/")
 * ->uri($_GET['uri'])
 * ->thumbRoot("/upload/thumb/")
 * ->execute();
 * if($thumb->isError()) {
 * 	die("thumb image error.");
 * }
 * header(sprintf("Content-type: %s", $thumb->header()));
 * echo $thumb->body();
 * 
 * ?>
 *
 */

class LangwanThumb {
	
	private $force = false;
	private $src;
	private $info;
	private $im;
	private $size;
	private $thumbSize;
	private $error = false;
	private $cmd = null;
	private $limitWidth = 0;
	private $limitHeight = 0;
	private $bgcolor = 'ffffff';
	private $uri;
	private $path;

	public function force($b) {
		$this->force = $b;
		return $this;
	}

	public function uri($uri) {
		$this->uri = $uri;
		return $this;
	}

	public function root($root) {
		$this->root = $root;
		return $this;
	}

	public function thumbRoot($thumbRoot) {
		$this->thumbRoot = $thumbRoot;
		return $this;
	}

	public function resize() {

		$sw = $this->info[0];
		$sh = $this->info[1];
		$x = $y = $sx = $sy = 0;
		$cw = $w = $this->limitWidth;
		$ch = $h = $this->limitHeight;
		$size = array('cw' => $cw, 'ch' => $ch, 'x' => $x, 'y' => $y, 'w' => $w, 'h' => $h, 'sx' => $sx, 'sy' => $sy, 'sw' => $sw, 'sh' => $sh);

		return $size;
	}

	public function auto() {

		$sw = $this->info[0];
		$sh = $this->info[1];	
		$rw = $sw / $this->limitWidth;
		$rh = $sh / $this->limitHeight;	
		$cw = $this->limitWidth;
		$ch = $this->limitHeight;
		$sx = $sy = 0;

		if($rw == $rh) {
			return $this->resize();
		} else if($rw > $rh) {
			$w = $cw;
			$x = 0;
			$h = $sh / $rw;
			$y = ($ch - $h) / 2;
		} else if($rw < $rh) {
			$h = $ch;
			$y = 0;
			$w = $sw / $rh;
			$x = ($cw - $w) / 2;
		}
		$size = array('cw' => $cw, 'ch' => $ch, 'x' => $x, 'y' => $y, 'w' => $w, 'h' => $h, 'sx' => $sx, 'sy' => $sy, 'sw' => $sw, 'sh' => $sh);
	
		return $size;
	}

	public function fixed() {

		$autoWidth = $this->limitWidth == 0 ? true : false;

		$sw = $this->info[0];
		$sh = $this->info[1];

		$x = $y = $sx = $sy = 0;
	
		if($autoWidth) {
			$h = $this->limitHeight;
			$r = $sh / $this->limitHeight;
			$w = $sw / $r;

		} else {
			$w = $this->limitWidth;
			$r = $sw / $this->limitWidth;
			$h = $sh / $r;
		}

		$cw = $w;
		$ch = $h;

		$size = array('cw' => $cw, 'ch' => $ch, 'x' => $x, 'y' => $y, 'w' => $w, 'h' => $h, 'sx' => $sx, 'sy' => $sy, 'sw' => $sw, 'sh' => $sh);

		return $size;
	}

	public function cut() {

		$autoWidth = $this->limitWidth == 0 ? true : false;

		$width = $this->info[0];
		$height = $this->info[1];

		$rw = $width / $this->limitWidth;
		$rh = $height / $this->limitHeight;

		$x = $y = 0;

		$cw = $w = $this->limitWidth;
		$ch = $h = $this->limitHeight;

		if($rw == $rh) {
			return $this->resize();
		} else if($rw > $rh) {
			$sy = 0;
			$sh = $height;
			$sw = $w * $rh;
			$sx = ($width - $sw) / 2;
		} else if($rw < $rh) {
			$sx = 0;
			$sw = $width;
			$sh = $h * $rw;
			$sy = ($height - $sh) / 2;			
		}

		$size = array('cw' => $cw, 'ch' => $ch, 'x' => $x, 'y' => $y, 'w' => $w, 'h' => $h, 'sx' => $sx, 'sy' => $sy, 'sw' => $sw, 'sh' => $sh);

		return $size;
	}

	public function execute() {

		$items = explode("_", $this->uri);
		$this->uri = $items[0];
		$this->path = $this->root.$this->uri;


		if(count($items) == 1) {
			$this->cmd = null;
			$this->realPath = $this->path;
		} else {
			$cmd = $items[1];
			$params = explode("-", $cmd);
			$this->cmd = $params[0];

			if($this->cmd == 'a') {
				$this->limitWidth = isset($params[1]) ? $params[1] : 0;
				$this->limitHeight = isset($params[2]) ? $params[2] : 0;
				$this->bgcolor = isset($params[3]) ? $params[3] : $this->bgcolor;

			} else {
				$this->limitWidth = isset($params[1]) ? $params[1] : 0;
				$this->limitHeight = isset($params[2]) ? $params[2] : 0;			
			}

			$this->realPath = sprintf("%s_%s_%s_%s_%s", $this->thumbRoot.'/'.str_replace('/', '_', $this->uri), $this->cmd, $this->limitWidth, $this->limitHeight, $this->bgcolor);

		}

		if($this->force != true) {
			if(file_exists($this->realPath)) {
				$info = getimagesize($this->realPath);
				if($info === false)
					$this->error = true;
				return;
			}
		}

		if(!$this->getSrcInfo()) {
			$this->error = true;
			return;
		}
	
		$this->init();
		$size = array();
		if($this->cmd == 'a') {
			$size = $this->auto();
		} else if($this->cmd == 'f') {
			$size = $this->fixed();	
		} else if($this->cmd == 'r') {
			$size = $this->resize();
		} else if($this->cmd == 'c') {
			$size = $this->cut();
		}
		$this->resizeImg($size);
	}

	public function isError() {
		return $this->error == true ? true : false;
	}

	function hex2rgb( $colour ) {
		if ( strlen( $colour ) == 6 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
		} elseif ( strlen( $colour ) == 3 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
		} else {
			return false;
		}
		$r = hexdec( $r );
		$g = hexdec( $g );
		$b = hexdec( $b );
		return array( 'red' => $r, 'green' => $g, 'blue' => $b );
	}

	public function resizeImg($size) {
		$new = imagecreatetruecolor($size['cw'], $size['ch']);
		if($this->bgcolor != '000000') {
			$rgb = $this->hex2rgb($this->bgcolor);
			$color = imagecolorAllocate($new, $rgb['red'], $rgb['green'], $rgb['blue']);
			imagefill($new, 0, 0, $color); 
		}
		imagecopyresampled($new, $this->im, $size['x'], $size['y'], $size['sx'], $size['sy'], $size['w'], $size['h'], $size['sw'], $size['sh']);
		$this->save($new);		
	}

	public function header() {
		return $this->info['mime'];
	}

	public function body() {
	
		if(file_exists($this->realPath))
			return @file_get_contents($this->realPath);
		else 
			return 'error';
	}


	public function getSrcInfo() {
		if(!file_exists($this->path))
			return false;
		$this->info = getimagesize($this->path);		
		return true;
	}

	public function init() {
		$mime = $this->info['mime'];
		if($mime == 'image/png') {
			$this->im = imagecreatefrompng($this->path);
		} else if($mime == 'image/jpeg') {
			$this->im = imagecreatefromjpeg($this->path);
		} else if($mime == 'image/gif') {
			$this->im = imagecreatefromgif($this->path);
		}
	}



	public function save($image) {

		$mime = $this->info['mime'];
		if($mime == 'image/png') {
			imagepng($image, $this->realPath);
		} else if($mime == 'image/jpeg') {
			imagejpeg($image, $this->realPath);
		} else if($mime == 'image/gif') {
			imagegif($image, $this->realPath);
		}
		ImageDestroy($image);
	}

	public function getThumbSize($size) {

		$width = $this->info[0];
		$height = $this->info[1];

		if($width <= $size[0] && $height <= $size[1]) {
			return array($width, $height);
		}

		$rw = $width / $size[0];
		$rh = $height / $size[1];
		$sw = true;

		if($rw < $rh) {
			$sw = false;
		}

		if($sw == true) {
			$w = $size[0];
			$h = floor($height / $rw);
		} else {
			$h = $size[1];
			$w = floor($width / $rh);
		}

		return array($w, $h);
	}

}