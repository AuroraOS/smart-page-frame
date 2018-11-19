<?php

namespace SmartPage\Pages;
use SmartPage\Model\SPPages;
use SmartPage\Dappurware\SPSettings;
use SmartPage\Dappurware\SPUtiles;
use Aos\Core\AosConfig;

class Module
{
  private $stringRepresentation;
	private $schema;
	private $values;

  private function __construct(array $data, string $stringRepresentation) {
      $this->stringRepresentation = $stringRepresentation;
			$this->schema = $data['schema'];
			$this->values = $data['values'];
			$this->values = $data;
  }


	public static function Header(array $data = array("schema" => "yeah", "values" => "true"), string $stringRepresentation = 'HUF') : Module {
	       return new self($data, $stringRepresentation);
	}

	public static function Static(array $data = array("schema" => "yeah", "values" => "true"), string $stringRepresentation = 'HUF') : Module {
	       return new self($data, $stringRepresentation);
	}

	public static function Global(array $data = array("schema" => "yeah", "values" => "true"), string $stringRepresentation = 'HUF') : Module {
	       return new self($data, $stringRepresentation);
	}

	public static function Widget(array $data = array("schema" => "yeah", "values" => "true"), string $stringRepresentation = 'HUF') : Module {
	       return new self($data, $stringRepresentation);
	}



}
