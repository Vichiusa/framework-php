<?php

namespace Core;

class Session
{
    function __construct()
    {
        $this->start();// auto start sesiune cand folosim aceasta clasa
    }

    // Pornim sesiunea daca nu a fost pornita
    public function start(): void
    {
        $appname = $_ENV['APP_NAME'] ?? 'app_name';

        // Curățăm numele: păstrăm doar litere, cifre și underscore (_)
        $sessionName = preg_replace('/[^a-zA-Z0-9_]/', '', str_replace(' ', '_', $appname));

        // Dacă în urma curățării rămâne un string gol, punem un fallback sigur
        if (empty($sessionName)) {
            $sessionName = 'app_name';
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_name($sessionName);
            session_start();
        }
    }

    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function unset(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function destroy(): void
    {
        session_destroy();
    }

    // ── Flash messages (există doar un singur request) ──
    public function setFlash(string $key, mixed $value): void
    {
        $_SESSION['_flash'][$key] = $value;
    }

    public function getFlash(string $key, mixed $default = null): mixed
    {
        $value = $_SESSION['_flash'][$key] ?? $default;
        unset($_SESSION['_flash'][$key]);
        return $value;
    }
}