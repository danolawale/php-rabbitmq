<?php
error_reporting( E_ALL | E_STRICT );

$envDir = dirname(dirname(__DIR__));

$dotenv = Dotenv\Dotenv::createImmutable($envDir);
$dotenv->load();

$dotenv->required(['DB_HOST_TEST', 'DB_NAME_TEST', 'DB_USER_TEST', 'DB_PASS_TEST']);

define("DB_HOST_TEST", $_ENV['DB_HOST_TEST']);
define("DB_NAME_TEST", $_ENV['DB_NAME_TEST']);
define("DB_USER_TEST", $_ENV['DB_USER_TEST']);
define("DB_PASS_TEST", $_ENV['DB_PASS_TEST']);


require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/AbstractTestCaseService.php';
require __DIR__ . '/AbstractTestProxyService.php';
