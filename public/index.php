<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';


// Inițializează și încarcă variabilele din .env
Dotenv\Dotenv::createImmutable(ROOT_DIR)->load();

// Activează Debug
Core\Handler::start();

// Pornim routerul
Core\Router::dispatch();