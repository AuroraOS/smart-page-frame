<?php
namespace SmartPage\Dappurware;


class SPApi{

	protected $conf = [
		'curl_header' => 0,
		'curl_return' => true,
		'db' => null,
		'query' => null,
		'method' => 'GET'
	];

	public function __construct($conf){
		$this->conf = array_merge($this->conf, $conf);
		return $this;
	}



	public function get(string $method = null, $override = null){
		if (!isset($this->conf['route'])) {
			return ['msg.err' => 'Invalid API Configurations. Base route must be defined.' ];
		}



		if (!$override) {
			$method = $this->conf['route'].'/'.$method;
		}
		$method = $method;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $method);
		curl_setopt($ch, CURLOPT_HEADER, $this->conf['curl_header']);            // No header in the result
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, $this->conf['curl_return']); // Return, do not echo result

		// Fetch and return content, save it.
		$raw_data = curl_exec($ch);
		curl_close($ch);

		// If the API is JSON, use json_decode.
		$data = json_decode($raw_data, true);

		if (count($data) == 1) {
			$data = $data[0];
		}

		return $data;
	}

	public function config(string $param = null, array $conf = null){
		if ($conf['type'] && $conf['url']) {
			$def = ["url" => null, "type" => null, "extract" => null];
			$def = array_merge($def, $conf);

			$link = $this->conf['route'].'/'.$def['url'].'?'.$def['type'].'='.$param;
			$arr = $this->get($link, true);
		}
		if (!$conf) {
			$link = $this->conf['route'].'/'.$param;
				$arr = $this->get($link, true);
		}

		return $arr;
	}



}
