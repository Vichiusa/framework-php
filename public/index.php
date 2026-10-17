<?php

use Core\Application;
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';



// Inițializează și încarcă variabilele din .env
Dotenv\Dotenv::createImmutable(ROOT_DIR)->load();


require_once __DIR__ . '/../helpers/helpers.php';

Core\Handler::start(); // Activează Debug

$app = new Core\Application();
$app->run();