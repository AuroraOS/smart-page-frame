<?php
namespace SmartPage\Dappurware;


class SPUtiles{

	/**
	 * [arrayGet function will return formatted, and reduced data, socket_recvfrom
	 * the database search query.]
	 *
	 * @method arrayGet
	 *
	 * @param  array    $array     [Input array]
	 * @param  array|string   $excludeId [If it is string, will return the key only,
	 * if it is array, return the keys.]
	 *
	 * @return array   [Reduced array]
	 */

	public static function arrayGet(array $array, $excludeId = null){
		foreach ($array as $key => $value) {
			if (is_array($excludeId)) {
				if(in_array($key, $excludeId))
				$data[$key] = SPUtiles::doJson($value);
			} else {
				if ($excludeId && ($excludeId == $key)) {
						return SPUtiles::doJson($value);
				}
				$data[$key] = SPUtiles::doJson($value);
			}
    }
		return $data;
	}

	public static function isJson($string) {
    return ((is_string($string) &&
            (is_object(json_decode($string)) ||
            is_array(json_decode($string))))) ? true : false;
	}

	public static function doJson($string){
		if (self::isJson($string)) {
			return json_decode($string, true);
		}
		return $string;
	}


	public function  searchForId($id, $array) {
	   foreach ($array as $key => $val) {
	       if ($val['uid'] === $id) {
	           return $key;
	       }
	   }
	   return null;
	}
	/**
	 * Checks if a string (haystack) contains a specific needle.
	 * @param string $baseWord Base string.
	 * @param array /string $needle Searched phrase.
	 * @param bool $sensitive Case sensitive?
	 * @return bool Result.
	 */
	public function stringContains($baseWord, $searchedPhrase, $sensitive = true)
	{
	    if (is_array($searchedPhrase)){
	        $pos = false;
	        foreach ($searchedPhrase as $str) {
	            $pos = stringContains($baseWord, $str, $sensitive);
	            if (!$pos)
	                return $pos;
	        }
	        return $pos;
	    } else {
	        if ($sensitive)
	            return strpos(strtolower($baseWord), strtolower($searchedPhrase)) !== false;
	        else
	            return strpos($baseWord, $searchedPhrase) !== false;
	    }
	}

	/**
	 *
	 * @param string $haystack
	 * @param string $needle
	 * @return boolean
	 */
	function startsWith($haystack, $needle)
	{
	    $length = strlen($needle);
	    return (substr($haystack, 0, $length) === $needle);
	}

	/**
	 *
	 * @param string $haystack
	 * @param string $needle
	 * @return boolean
	 */
	function endsWith($haystack, $needle)
	{
	    $length = strlen($needle);
	    if ($length == 0)
	    {
	        return true;
	    }

	    return (substr($haystack, -$length) === $needle);
	}

	function trimLength($message, $length, $append = null)
	{
	    if (strlen($message) > $length)
	    {
	        $message = substr($message, 0, $length);
	        if ($append)
	            $message .= $append;
	    }
	    return $message;
	}

	public function getFile(string $path = null, $decode = true, $relative = true){
		if ($relative) {
			$path = __DIR__ . $path;
		}

		// Get the list of quotes.
		if (file_exists($path)) {
			$file = file_get_contents( $path );
		} else {
			return ["msg.err" => "Searched file not exists: ".$path ];
		}

		// Convert JSON document to PHP array.
		if ($decode) {
			$file = json_decode( $file, true );
			if (json_last_error() === JSON_ERROR_NONE) {
			  return $file;
			} else {
			  return ["msg.err" => "This file is not valid JSON: ".$path ];
			}
		}

		return $file;
	}


	public function getPath($opt, string $root = null){
		if (is_array($opt)) {
			return self::doArray($opt, $root);
		}

		return self::doString($opt, $root);
	}

	private function doArray($opt, $root = null){
		foreach ($opt as $key => $value) {
			$arr[$key] = $root . $value;
		}
		return $arr;
	}

	private function doString($opt, $root = null){
		return $root . $opt;
	}

	public function nameCase(string $string, string $replace = null, string $with = null){
		if(!$replace){ $replace = '-'; }
		if(!$with){ $with = '.'; }
		// remove duplicate -
		$string = str_replace($replace, $with, $string);
		// lowercase
		$string = strtolower($string);
		return $string;
	}

	public static function flat(array $array)
{
	$flatten = function ($input, $parent = []) use (&$flatten) {
	    $return = [];

	    foreach ($input as $k => $v) {
	        if (is_array($v)) {
	            $return = array_merge($return, $flatten($v, array_merge($parent, [$k])));
	        } else {
	            if ($parent) {
	                $key = implode('.', $parent) . '.' . $k;

	                if (substr_count($key, '') != substr_count($key, '')) {
	                    $key = preg_replace('/\]/', '', $key, 1);
	                }
	            } else {
	                $key = $k;
	            }

	            $return[$key] = $v;
	        }
	    }

	    return $return;
	};
	return $flatten($array);
}

	public function removeFirst(string $text = null, string $cut = null, string $rep = '') {
		return str_replace($text,$rep,$cut);
	}

	public function scanDir($path){
		if ($handle = opendir($path)) {

    while (false !== ($entry = readdir($handle))) {

        if ($entry != "." && $entry != "..") {

            $arr[] = $entry;
        }
    }

    closedir($handle);
		return $arr;
}
	}

	public function slugify(string $string, string $c = '-'){
		// replace non letter or digits by -
		$string = preg_replace('~[^\pL\d]+~u', $c, $string);
		// transliterate
		$string = iconv('utf-8', 'us-ascii//TRANSLIT', $string);
		// remove unwanted characters
		$string = preg_replace('~[^-\w]+~', '', $string);
		// trim
		$string = trim($string, $c);
		// remove duplicate -
		$string = preg_replace('~-+~', $c, $string);
		// lowercase
		$string = strtolower($string);

		if (empty($string)) {
				return false;
		}

		return $string;
	}

	/**
	 * Search trough the array, and find the coressponding key.
	 *
	 * @method search
	 *
	 * @param  [type] $array  [Search trough this array]
	 * @param  [type] $value  [Look for this value]
	 * @param  [type] $column [In this column name]
	 *
	 * @return [type] [description]
	 */

	public function search($array, $value, $column){
		$key = array_search($value, array_column($array, $column));
		return $key;
	}

}
