<?php

/**
 *
 * author: https://github.com/langwan
 * version: 2.0.0 2014.07.16
 * document: https://github.com/README.md
 *
 */

Yii::import('cthumb.ChengxufanThumbCommand');

class CommandR extends ChengxufanThumbCommand {
	public function run($sfile, $dfile, $dmine, $value) {

		$dw = $dh = 0;
		
		$values = explode('x', $value);
		
		if(count($values) == 1) {
			$dw = $dh = $values[0];
		} else {
			list($dw, $dh) = $values;
		}

		$this->create($sfile);
		$dimg = imagecreatetruecolor($dw, $dh);
		imagecopyresampled($dimg, $this->simg, 0, 0, 0, 0, $dw, $dh, $this->ssize[0], $this->ssize[1]);
		$this->save($dimg, $dfile, $dmine);	
	}
}
