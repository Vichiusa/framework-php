<?php

// Escape HTML special characters to prevent XSS attacks
function e($string)
{
    return trim(htmlspecialchars($string, ENT_QUOTES, 'UTF-8'));
}

function app()
{
    return Core\Application::$app;
}