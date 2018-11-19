<?php
/**
 * SP Settings Class load all the necessary data from database.
 * Anywhere you need to get some data, call the proper function, and you will get it.
 */
namespace SmartPage\Dappurware;

use SmartPage\Model\SPConfigGroups;
use SmartPage\Model\SPConfig;
use SmartPage\Model\SPPages;
use SmartPage\Model\CoreConfig;
use SmartPage\Model\Custom;

/**
 * [SPSettings Class]
 * Its retrive the data for you...
 */
class SPSettings{



	/**
	 * Load the main Settings Groups from Smart Page.
	 * @method getGlobConf
	 * @return [array]          [Contains all the SP Settings.]
	 */

	public static function getGlobConf($field = 'type', $param = null){
		if ($field) {
			$config = SPConfigGroups::where($field, '=', $param)->with('config')->get();
		} else {
			$config = SPConfigGroups::with('config')->get();
		}

  	foreach ($config as $value) {
      	foreach ($value->config as $cfgvalue) {
          	$cfg[$cfgvalue->name] = SPUtiles::doJson($cfgvalue->data);
      	}
  	}

		return $cfg;
	}


	/**
	 * Return the page data....
	 *
	 * @method getPage
	 *
	 * @param  string  $name [description]
	 * @param  [type]  $type [description]
	 *
	 * @return [type]  [description]
	 */

	public static function getPage($name = 'home', $type = null){
		if ($type) {
			$page = SPPages::select("name", "title", "data", "visible", "meta", "modules", "patern","permission", "status","plugins", "type", "html")
			->where('name', '=', $name)
			->where('status', 1)
			->where('visible', 1)
			->where('type', '=', $type)
			->get()->toArray();
		} else {
			$page = SPPages::select("name", "title", "data", "visible", "meta", "modules", "patern","permission", "status","plugins", "type", "html")
			->where('name', '=', $name)
			->where('status', 1)
			->where('visible', 1)
			->get()->first()->toArray();
		}

		if (count($page)) {
			return $page;
		}
		return "This page is not on our database. So it does not have any other attributes.";
	}

	public static function pageModules($pageName, $modules){
		$modules = [
			"settings" => self::getModulesSettings($pageName),
			"modules" => self::getModules($modules)
		];

		return $modules;
	}


	public static function getModulesSettings($page = 'home'){
		$data = CoreConfig::select("name", "data")
		->where('type', '=', 'module-settings')
		->where('tag', '=', $page)
		->get()->toArray();

		foreach ($data as $key => $value) {
			$cfg[$value['name']] = SPUtiles::doJson($value['data']);
		}

		return $cfg;
	}


	public static function getModules($modules){
		$data = CoreConfig::select("name", "data", "type")
		->where('type', '=', 'module')
		->get()->toArray();

		foreach ($data as $key => $value) {
			$cfg[$value['name']] = SPUtiles::doJson($value);
		}

		foreach ($cfg as $key => $value) {
			if (in_array($value['name'], $modules)) {
				$return[$key] = SPUtiles::doJson($value['data']);
			}
		}

		return $return;
	}




	public  function  __callStatic($name, $arguments) {
			// make sure our class has this method
			if(method_exists($name, $method)) {
							call_user_func_array(array($name, $method), $args);
			}
			return null;
	}




	public function getRecord($field, $rel, $name){
		$model = CoreConfig::select("name", "data", "type", "group")->where($field, $rel, $name)
		->get()->first()->toArray();

		foreach ($model as $key => $value) {
			$arr[$key] = SPUtiles::doJson($model[$key]);

		}
		return $arr;
	}



}
