<?php
/**
 * Created by PhpStorm.
 * User: Monk
 * Date: 07.09.17
 * Time: 0:47
 */

namespace common\components;

class InMemoryFile {
	private $name;
	private $mime;
	private $content;

	public function __construct($name, $mime=null, $content=null)
	{
		// If content is empty $name contains path to file
		if(is_null($content))
		{
			// Get file info (path, name and extension)
			$info = pathinfo($name);
			// check if string contain file name and can we read the file
			if(!empty($info['basename']) && is_readable($name))
			{
				$this->name = $info['basename'];
				// detect the MIME type of the file
				$this->mime = mime_content_type($name);
				// Load the file
				$content = file_get_contents($name);
				// Check that the file was read successfully
				if($content!==false) $this->content = $content;
				else throw new \Exception('Don`t get content - "'.$name.'"');
			} else throw new \Exception('Error param');
		} else
		{
			// сохраняем имя файла
			$this->name = $name;
			// Если не был передан тип MIME пытаемся сами его определить
			if(is_null($mime)) $mime = mime_content_type($name);
			// Сохраняем тип MIME файла
			$this->mime = $mime;
			// Сохраняем в свойстве класса содержимое файла
			$this->content = $content;
		};
	}

	// Метод возвращает имя файла
	public function Name() { return $this->name; }

	// Метод возвращает тип MIME
	public function Mime() { return $this->mime; }

	// Метод возвращает содержимое файла
	public function Content() { return $this->content; }

} 