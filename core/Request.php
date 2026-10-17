<?php

namespace Core;

class Request
{
    // Obține metoda HTTP a cererii
    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    // Verifică dacă cererea este de tip POST
    public function isGet(): bool
    {
        return self::method() === 'GET';
    }

    public function isPost(): bool
    {
        return self::method() === 'POST';
    }

    // Obține valoarea unui input din $_POST, cu o valoare implicită dacă nu există
    public function post(string $key, mixed $default = ''): string
    {
        return trim($_POST[$key] ?? $default);
    }

    // Obține toate datele din $_POST
    public function all(): array
    {
        return $_POST;
    }

}