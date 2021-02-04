<?php

ob_start(); // turn on output buffering

define("PRIVATE_PATH", dirname(__FILE__));
define("PROJECT_PATH", dirname(PRIVATE_PATH));
define("PUBLIC_PATH", PROJECT_PATH . '/public');

require_once('Config.php');
require_once('Loader.php');
#require_once('factory.loader.php');

$preloadedSystemInstances = Loader::preloadClasses();

