<?php
class c_wiki
{
	function index()
	{
		$this->show();
	}
	
	function show($page='index')
	{
		$config = $this->framework->getDependency('config');
		$storage = $this->framework->getDependency('storage');
		$text = $storage->getSource($page);
		if (!$text) {
			throw new brickyard_exception_404("Wiki page not found.");
		}
		$metadata = brick_markdown::readMetadata($text);
		$text = brick_markdown::removePandocBlock($text);
		$text = Parsedown::instance()->parse($text);
		
		$out = array('title'=>$config['title'], 'text'=>$text);
		$out = $metadata + $out;
		
		$menu = $storage->getSource('menu');
		if ($menu) {
			$menu = Parsedown::instance()->parse($menu);
			$out['menu'] = $menu;
		}
		
		echo $this->framework->view->show('show', $out);
	}
	
	function edit($page='index')
	{
		$prev = null;
		$messages = array();
		$config = $this->framework->getDependency('config');
		$storage = $this->framework->getDependency('storage');
		if (isset($_POST['save']) && isset($_POST['text'])) {
			if ($_POST['pass']==$config['password']) {
				$saved = $storage->saveChanges($_POST['page'], $_POST['text'], array('msg'=>$_POST['msg']));
				if (!$saved) {
					$messages[] = 'Nepodařilo se uložit.';
				} else {
					$messages[] = 'Uloženo.';
				}
			} else {
				$messages[] = 'Špatné heslo!';
			}
		}
		$text = $storage->getSource($page);
		if (!$text) {
			$text = '';
			$messages[] = 'Zakládáte novou stránku.';
		}
		if (isset($_POST['prev']) && isset($_POST['text'])) {
			$text = $_POST['text'];
			$prev = brick_markdown::removePandocBlock($text);
			$prev = Parsedown::instance()->parse($prev);
			$messages[] = 'POZOR! Pouze náhled.';
		}
		
		$form =  $this->framework->view->show('form', array('page'=>$page, 'text'=>$text, 'messages'=>$messages, 'preview'=>$prev));
		echo $this->framework->view->show('show', array('title'=>'ps9', 'text'=>$form));
	}
	
	function find()
	{
		$config = $this->framework->getDependency('config');
		$storage = $this->framework->getDependency('storage');
		$found = $storage->listPageNames($_GET['q']);
		$found = implode($found, '<br/>');
		echo $this->framework->view->show('show', array('title'=>'Vyhledávání', 'text'=>$found));
	}
}
