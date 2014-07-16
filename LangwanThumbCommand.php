<?php

/**
 *
 * author: https://github.com/langwan
 * version: 2.0.0 2014.07.16
 * document: https://github.com/README.md
 *
 */

abstract class LangwanThumbCommand {
	public $ssize;
	public $simg;
	public $sfile;
	public $dfile;
	public $dmime;

	public function create($sfile) {
		$this->sfile = $sfile;
		$this->ssize = getimagesize($this->sfile);
		$mime = $this->ssize['mime'];
		if($mime == 'image/png') {
			$this->simg = imagecreatefrompng($this->sfile);
		} else if($mime == 'image/jpeg') {
			$this->simg = imagecreatefromjpeg($this->sfile);
		} else if($mime == 'image/gif') {
			$this->simg = imagecreatefromgif($this->sfile);
		}
	}

	public function save($dimg, $dfile, $dmime) {

		if($dmime == 'image/png') {
			imagepng($dimg, $dfile);
		} else if($dmime == 'image/jpeg') {
			imagejpeg($dimg, $dfile);
		} else if($dmime == 'image/gif') {
			imagegif($dimg, $dfile);
		}
		ImageDestroy($dimg);
	}

	abstract public function run($sfile, $dfile, $dmine, $value);

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

}



	