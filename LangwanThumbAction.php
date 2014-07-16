<?php

/**
 *
 * author: https://github.com/langwan
 * version: 2.0.0 2014.07.16
 * document: https://github.com/README.md
 *
 */

Yii::import('langwanthumb.LangwanThumb');

class LangwanThumbAction extends CAction {

    public $srcDirectory;
    public $destDirectory;

	public function run() {
		$thumb = new LangwanThumb;
		$thumb->setSrcDirectory($this->srcDirectory)
		->setKey($_GET['uri'])
		->setDestDirectory($this->destDirectory)
		//->setForce(true)
		->execute();
		if($thumb->isError()) {
			die("resize image error.");
		}
		header(sprintf("Content-type: %s", $thumb->getMine()));
		echo $thumb->body();
	}

}