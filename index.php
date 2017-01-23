<?php
date_default_timezone_set('UTC');
$config = array(
'password' => 'test',
'title' => 'S9wiki'
);

require "./lib/brickyard.php";
$f=new brickyard();
$f->inDevelMode = true;
$f->throwTheseErrors = E_ALL ^ (E_WARNING | E_NOTICE); // nojo, php
$f->init();
brick_compat::stripslashes();
$router = new strajt9_router;
$f->setRouter($router);
$f->setInstance('config', $config);
$storage = new brick_wiki_storage(dirname(__FILE__) . '/wiki');
$f->setInstance('storage', $storage);
$f->run();
