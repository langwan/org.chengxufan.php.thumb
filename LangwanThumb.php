<?php

/**
 *
 * author: https://github.com/langwan
 * version: 2.0.0 2014.07.16
 * document: https://github.com/README.md
 *
 */

Yii::import('cthumb.command.*');

class ChengxufanThumb {

	public $cmds = null;
	public $force = true;
	public $key = null;
	public $srcDirectory = null;
	public $destDirectory = null;
	public $name = null;
	public $srcFile = null;
	public $destFile = null;
	public $isError = false;
	public $mine = 'image/png';

	public function setKey($key) {
		$this->key = $key;
		return $this;
	}

	public function setDestDirectory($destDirectory) {
		$this->destDirectory = $destDirectory;
		return $this;
	}

	public function setSrcDirectory($srcDirectory) {
		$this->srcDirectory = $srcDirectory;
		return $this;
	}

	public function setForce($force) {
		$this->force = $force;
		return $this;
	}

	public function setMine($mine) {
		$this->mine = $mine;
	}

	public function execute() {
		
		$this->parse();

		if($this->force != true) {
			if(file_exists($this->destFile)) {
				return;
			}
		}

		if(!getimagesize($this->srcFile)) {
			$this->isError = true;
			return;
		}

		$this->executeCommands();
	}

	public function getSrcFileInfo() {
		return getimagesize($this->srcFile);
	}


	public function parse() {
		$items = explode(',', $this->key);
		$this->name = $items[0];
		unset($items[0]);
		$this->srcFile = $this->srcDirectory.$this->name;
		if(count($items) > 0) {
			$this->cmds = $items;		
			$this->destFile = $this->destDirectory.$this->key;
		} else {
			$this->destFile = $this->srcFile ;			
		}
	}

	public function executeCommands() {
	
		if($this->cmds == null)
			return;
		
		$sfile = $this->srcFile;
		$dfile = $this->destFile;

		foreach($this->cmds as $cmd) {
			$this->executeCommand($sfile, $dfile, $cmd);
			$sfile = $dfile = $this->destFile;
		}
	}

	public function executeCommand($sfile, $dfile, $cmd) {
		list($key, $value) = explode('_', $cmd);
		$class = 'Command'.ucwords(strtolower($key));
		if(!class_exists($class))
			return;
		$command = new $class;
		$command->run($sfile, $dfile, $this->mine, $value);
	}

	public function isError() {
		return $this->isError;
	}

	public function getMine() {
		return $this->mine;
	}


	public function body() {
	
		if(file_exists($this->destFile))
			return @file_get_contents($this->destFile);
		else 
			return 'error';
	}

}