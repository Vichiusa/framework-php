<?php

namespace Core;

class Response
{
    // Trimite un răspuns JSON
    public function json(array $data, int $statusCode = 200)
    {
        // Ne asigurăm că nimeni nu a trimis text înainte
        if (!headers_sent()) {
            header('Content-Type: application/json; charset=utf-8');
        }

        http_response_code($statusCode);

        // Singurul echo din toată aplicația pentru răspunsuri JSON!
        echo json_encode($data);
        exit; // Oprim execuția scriptului imediat
    }

    // Trimite text simplu sau HTML (opțional, dacă ai nevoie în alte zone)
    public function html(string $content, int $statusCode = 200)
    {
        if (!headers_sent()) {
            header('Content-Type: text/html; charset=utf-8');
        }
        http_response_code($statusCode);
        echo $content;
        exit;
    }

    public function redirect($url)
    {
        $url = str_replace(["\r", "\n"], '', $url); // elimină CRLF
        if (!headers_sent()) {
            header("Location: $url", true, 302);
        }
        exit;
    }
}