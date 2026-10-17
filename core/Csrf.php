<?php

namespace Core;

class Csrf
{

    // Generare token
    public function generate(): void
    {
        $token = bin2hex(random_bytes(32));  // Generăm un token aleatoriu de 32 de bytes și îl convertim în hex
        setcookie('_csrf_token', $token, time() + 3600, '/'); // Setăm cookie-ul cu tokenul CSRF, valabil timp de 1 oră 
        app()->session->set('_csrf_token', $token); // Salvăm tokenul în sesiune pentru validare ulterioară
    }

    // Validare token
    public function validate(): bool
    {
        $token = app()->session->get('_csrf_token') ?? '';

        if (!hash_equals($_COOKIE['_csrf_token'] ?? '', $token)) {
            return false;
        } else {
            app()->session->unset('_csrf_token'); // Ștergem tokenul din sesiune după validare pentru a preveni reutilizarea
            return true;
        }
    }
}