<?php

/**
 *
 * author: https://github.com/langwan
 * version: 2.0.0 2014.07.16
 * document: https://github.com/README.md
 *
 */

Yii::import('langwanthumb.LangwanThumbCommand');

class CommandS extends LangwanThumbCommand {
	public function run($sfile, $dfile, $dmine, $value) {

		$dw = $dh = $bgcolor = null;

		$values = explode('x', $value);
		
		if(count($values) == 1) {
			$dw = $dh = $values[0];
		} else if(count($values) == 2) {
			list($dw, $dh) = $values;
		} else {
			list($dw, $dh, $bgcolor) = $values;
		}

		$bgcolor = $bgcolor == null ? 'ffffff' : $bgcolor;

		$this->create($sfile);



		$diw = $dw;
		$dih = $dh;

		$rw = $diw / $this->ssize[0];
		$rh = $dih / $this->ssize[1];

		$dx = $dy = 0;

		if($rw > $rh) {
			$diw = $this->ssize[0] / $this->ssize[1] * $dih;
			$dx = ($dw - $diw) / 2;
		} else {
			$dih = $this->ssize[1] / $this->ssize[0] * $diw;
			$dy = ($dh - $dih) / 2;
		}

		$dimg = imagecreatetruecolor($dw, $dh);
		if($bgcolor != '000000') {
			$rgb = $this->hex2rgb($bgcolor);
			$color = imagecolorAllocate($dimg, $rgb['red'], $rgb['green'], $rgb['blue']);
			imagefill($dimg, 0, 0, $color); 
		}
		imagecopyresampled($dimg, $this->simg, $dx, $dy, 0, 0, $diw, $dih, $this->ssize[0], $this->ssize[1]);
		$this->save($dimg, $dfile, $dmine);	
	}
}
