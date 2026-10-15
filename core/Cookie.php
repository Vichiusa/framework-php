<?php

namespace Core;

class Cookie
{
    public function set(
        string $key,
        string $value,
        int $minutes = 60,
        string $path = '/',
        bool $httpOnly = true,
        bool $secure = false
    ): void {
        setcookie(
            $key,
            $value,
            time() + ($minutes * 60),
            $path,
            '',
            $secure,
            $httpOnly
        );
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $_COOKIE[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return isset($_COOKIE[$key]);
    }

    public function forget(string $key): void
    {
        setcookie($key, '', time() - 3600, '/');
        unset($_COOKIE[$key]);
    }
}