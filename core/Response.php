<?php

namespace Core;

class Response
{
    public function json(array $data, int $statusCode = 200)
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($statusCode);
        return json_encode($data);
    }

    public function redirect(string $url, int $statusCode = 302): void
    {
        $url = str_replace(["\r", "\n"], '', $url); // elimină CRLF
        http_response_code($statusCode);
        header("Location: $url");
        exit;
    }
}