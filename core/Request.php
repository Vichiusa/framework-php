<?php

namespace Core;

class Request
{
    // Obține metoda HTTP a cererii
    public static function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    // Verifică dacă cererea este de tip POST
    public static function isGet(): bool
    {
        return self::method() === 'GET';
    }

    public static function isPost(): bool
    {
        return self::method() === 'POST';
    }

    // Obține valoarea unui input din $_POST, cu o valoare implicită dacă nu există
    public static function post(string $key, mixed $default = ''): string
    {
        return trim($_POST[$key] ?? $default);
    }

    // Obține toate datele din $_POST
    public static function all(): array
    {
        return $_POST;
    }

}