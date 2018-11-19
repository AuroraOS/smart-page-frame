<?php

namespace SmartPage\Pages;
use SmartPage\Model\SPPages;
use SmartPage\Dappurware\SPSettings;
use SmartPage\Dappurware\SPUtiles;
use Aos\Core\AosConfig;

use SmartPage\Pages\Module;

class Modules
{
	protected $name;
	protected $values;
	protected $modules;

	function __construct($name, ModuleSettings $values){
		$this->name = $name;
		$this->values = $values;
		return $this;
	}

	public function add(Modules $module) : Modules {
    return new Modules($module);
  }



}
