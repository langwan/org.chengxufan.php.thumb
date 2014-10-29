<?php

/**
 *
 * author: https://github.com/langwan
 * version: 2.0.0 2014.07.16
 * document: https://github.com/README.md
 *
 */

Yii::import('cthumb.ChengxufanThumbCommand');

class CommandMw extends ChengxufanThumbCommand {
	public function run($sfile, $dfile, $dmine, $value) {
		$fw = $value;
		$this->create($sfile);
		$dw = $fw > $this->ssize[0] ? $this->ssize[0] : $fw;	
		$dh = $this->ssize[1] / $this->ssize[0] * $dw;
		$dimg = imagecreatetruecolor($dw, $dh);
		imagecopyresampled($dimg, $this->simg, 0, 0, 0, 0, $dw, $dh, $this->ssize[0], $this->ssize[1]);
		$this->save($dimg, $dfile, $dmine);	
	}
}
