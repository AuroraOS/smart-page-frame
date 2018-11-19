<?php

namespace SmartPage\Pages;
use SmartPage\Model\SPPages;
use SmartPage\Dappurware\SPSettings;
use SmartPage\Dappurware\SPUtiles;
use Aos\Core\AosConfig;

use SmartPage\Pages\Module;


class Page
{
	protected $name;
	protected $default = 'home';
	public $obj;


	function __construct(string $page, array $values = null){
		if ($values['default']) {
			$this->default = $values['default'];
		}

		$this->name = $page;

		$obj = SPSettings::getPage($page);
		$obj = SPUtiles::arrayGet($obj);
		$this->obj = $obj;
		return $this;
	}

	public function asConfig(){
		$obj = new AosConfig($this->obj);
		return $obj;
	}

	public function __call($name, $arguments) {
		return $this->obj[$name];
	}

	public function __toString() {
		return $this->obj['name'];
	}

	public function __set($property, $value) {
    if (!property_exists($key, $property)) {
      return $this->$key = $property;
    }
  }

}
