<?php
if (!function_exists('simple_glob')){
	/** Jednodušší náhrada funkce glob()
	* @param string vyhledávací maska může v názvu souboru obsahovat znak * a ?
	* @return array pole obsahující všecny nalezené soubory/adresáře
	* @copyright Jakub Vrána, http://php.vrana.cz/
	*/
	function simple_glob($mask) {
	$dirname = preg_replace('~[^/]*$~', '', $mask);
	$dir = opendir(strlen($dirname) ? $dirname : ".");
	$return = array();
	if ($dir) {
		$pattern = '~^' . strtr(preg_quote($mask, '~'), array('\\*' => '.*', '\\?' => '.')) . '$~';
			while (($filename = readdir($dir)) !== false) {
				if ($filename != "." && $filename != ".." && preg_match($pattern, "$dirname$filename")) {
					$return[] = "$dirname$filename";
				}
			}
			closedir($dir);
			sort($return);
		}
		return $return;
	}
}

class brick_wiki_storage
{
	protected $_path = '';
	
	function __construct($path)
	{
		$this->_path = $path;
	}
	
	public function getSource($page='index')
	{
		$fn = $this->_path . '/' . $page . '.txt';
		if (file_exists($fn)) {
			return file_get_contents($fn);
		}
		return null;
	}
	
	public function saveChanges($page='index', $text='', $meta=array())
	{
		if (!$this->isChanged($page, $text)) {
			return false;
		}
		$log = $this->getHistory($page);
		
		if (!$log) {
			$log = array();
		}
		$hash = sha1($text);
		$meta['hash'] = $hash;
		$meta['date'] = date('Y-m-d H:i:s');
		$log[] = $meta;
		if (!file_exists($this->_path . '/old')) {
			mkdir($this->_path . '/old');
		}
		if (file_put_contents($this->_path . '/old/' . $hash . '.old', $text)) {
			file_put_contents($this->_path . '/' . $page . '.log', json_encode($log));
			file_put_contents($this->_path . '/' . $page . '.txt', $text);
			return true;
		}
		return false;
	}
	
	public function getHistory($page='index')
	{
		if (file_exists($this->_path . '/' . $page . '.log')) {
			return json_decode(file_get_contents($this->_path . '/' . $page . '.log'));
		}
		return null;
	}
	
	public function listPageNames($pattern='*')
	{
		$found = simple_glob($this->_path . '/' .$pattern .'.txt');
		$path = preg_quote($this->_path .'/', '~');
		$suffix  = preg_quote('.txt', '~');
		$regexp = '~' . $path . '(.*)' . $suffix . '~';
		$found = preg_filter($regexp, '$1', $found);
		return $found;
	}
	
	protected function isChanged($page, $text)
	{
		if ($text == $this->getSource($page)) {
			return false;
		}
		return true;
	}
}
