<?php

$envDir = dirname(dirname(__DIR__));

$dotenv = Dotenv\Dotenv::createImmutable($envDir);
$dotenv->load();

$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS']);

define("DB_HOST", $_ENV['DB_HOST']);
define("DB_NAME", $_ENV['DB_NAME']);
define("DB_USER", $_ENV['DB_USER']);
define("DB_PASS", $_ENV['DB_PASS']);

$dotenv->required(['RABBIT_HOST', 'RABBIT_PORT', 'RABBIT_USER', 'RABBIT_PASS']);

define("RABBIT_HOST", $_ENV['RABBIT_HOST']);
define("RABBIT_PORT", $_ENV['RABBIT_PORT']);
define("RABBIT_USER", $_ENV['RABBIT_USER']);
define("RABBIT_PASS", $_ENV['RABBIT_PASS']);