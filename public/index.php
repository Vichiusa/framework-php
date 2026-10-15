<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';


// Inițializează și încarcă variabilele din .env
Dotenv\Dotenv::createImmutable(ROOT_DIR)->load();

Core\Handler::start(); // Activează Debug

// Pornim routerul
Core\Router::dispatch();