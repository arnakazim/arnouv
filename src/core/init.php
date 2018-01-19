<?php

define('DS',DIRECTORY_SEPARATOR);

chdir('..'.DS);

define('ROOT', getcwd());
define('APP', ROOT.DS.'app');
// define('PUB', ROOT.DS.'public');
define('CORE', ROOT.DS.'core');
// define('VIEW', APP.DS.'view');
define('JSON', APP.DS.'json');

define('BASE_URL',dirname($_SERVER['SCRIPT_NAME']));

function debug($var) {
	echo '<pre>';
	print_r($var);
	echo '</pre>';
}

function __autoload($className) {
    $className = str_replace('\\', DS, $className);

    $path = explode(DS, $className);
    $className = array_pop($path);
    
    foreach($path as $k => $v) {
        $path[$k] = strtolower($v);
    }

    require ROOT . DS . implode(DS, $path) . DS . $className . '.php';
}

new \Core\Core();

?>