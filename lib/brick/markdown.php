<?php
class brick_markdown
{
	static function removePandocBlock($text)
	{
		$lines = explode("\n", $text);
		for ($i = 1; $i <= 3; $i++) {
			$line = reset($lines);
			if (substr($line, 0, 1)==='%') {
				array_shift($lines);
			}
		}
		return implode("\n", $lines);
	}
	
	static function readMetadata($text)
	{
		$meta = array();
		$lines = explode("\n", $text);
		for ($i = 0; $i <= 2; $i++) {
			if (substr($lines[$i], 0, 1)==='%') {
				if ($i==0) {
					$meta['title'] = trim(substr($lines[$i], 1));
				} elseif ($i==1) {
					$meta['author'] = trim(substr($lines[$i], 1));
				} elseif ($i==2) {
					$meta['date'] = trim(substr($lines[$i], 1));
				}
			}
		}
		return $meta;
	}
	
}