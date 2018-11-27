<?php
/**
 * Created by PhpStorm.
 * User: Monk
 * Date: 07.09.17
 * Time: 0:42
 */

namespace common\components;


class BodyPost {

	/**
	 * Convert a data array to a query string ready to post.
	 *
	 * @param  array   $data        The data array.
	 * @param  string  $delimeter   Delimiter used in query string
	 * @param  boolean $urlencoded  If true encode the final query string
	 *
	 * @return string The array as a string.
	 */
	static public function arrayToQueryString(array $data, $delimiter = '&', $urlencoded = false)
	{
		$queryString = '';
		$delimiterLength = strlen($delimiter);

		// Parse each value pairs and concate to query string
		foreach ($data as $name => $value)
		{
			// Apply urlencode if it is required
			if ($urlencoded)
			{
				$value = urlencode($value);
				$name = urlencode($name);
			}
			$queryString .= $name . '=' . $value . $delimiter;
		}

		// remove the last delimiter
		return substr($queryString, 0, -1 * $delimiterLength);
	}


	//Method for forming part of a compound query
	public static function PartPost($name, $val, $urlEncode = true)
	{
		$body = 'Content-Disposition: form-data; name="' . $name . '"';
		// Проверяем передан ли класс oFile
		if($val instanceof InMemoryFile)
		{
			// Extract the file name
			$file = $val->Name();
			// Extract MIME type of the file
			$mime = $val->Mime();
			// Extract file content
			$cont = $val->Content();

			$body .= '; filename="' . $file . '"' . "\r\n";
			$body .= 'Content-Type: ' . $mime ."\r\n\r\n";
			$body .= $cont."\r\n";
		} else $body .= "\r\n\r\n". ( $urlEncode ? urlencode($val) : $val)."\r\n";
		return $body;
	}

	// The method that forms the body of the POST request from the passed array
	public static function Get(array $post, $delimiter='-------------0123456789')
	{
		if(is_array($post) && !empty($post))
		{
			$bool = false;
			// Check whether there is a file among the elements of the array
//			foreach($post as $val) if($val instanceof InMemoryFile) {$bool = true; break; };
//			if($bool)
//			{
				$ret = '';
				// We form from each element of the array, the composite body of the POST request
				foreach($post as $name=>$val)
					$ret .= '--' . $delimiter. "\r\n". self::PartPost($name, $val, false);
				$ret .= "--" . $delimiter . "--\r\n";
//			} else $ret = http_build_query($post);
		} else throw new \Exception('Error input param!');
		return $ret;
	}

} 