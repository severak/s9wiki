<?php
class strajt9_router implements brickyard_router_interface
{

	public function getController()
	{
		return 'wiki';
	}

	public function getMethod()
	{
		if (isset($_REQUEST['act'])) {
			return $_REQUEST['act'];
		}
		return 'show';
	}
	
	public function getArgs()
	{
		$page = 'index';
		if (isset($_GET['tema'])) {
			$page = $_GET['tema'];
		}
		if (isset($_POST['page'])) {
			$page = $_POST['page'];
		}
		return array($page);
	}
	
	public function getLink($controller = null, $method = null, $args=array() )
	{
	
	}
}