<?php

namespace Core;

class Router
{
    protected static $notFoundAction = null;

    // Save routes
    protected static $routes = [];

    public static function notFound($action)
    {
        self::$notFoundAction = $action;
    }

    // API PUBLIC: definire rute
    public static function get($uri, $action)
    {
        self::addRoute('GET', $uri, $action);
    }

    public static function post($uri, $action)
    {
        self::addRoute('POST', $uri, $action);
    }

    public static function put($uri, $action)
    {
        self::addRoute('PUT', $uri, $action);
    }

    public static function patch($uri, $action)
    {
        self::addRoute('PATCH', $uri, $action);
    }

    public static function delete($uri, $action)
    {
        self::addRoute('DELETE', $uri, $action);
    }

    // dispatch logic
    protected static function addRoute($method, $uri, $action)
    {
        // Normalizăm URI-ul (ex: '/about/' devine 'about')
        $uri = trim($uri, '/');

        self::$routes[] = [
            'method' => $method,
            'uri' => $uri,
            'action' => $action
        ];
    }

    public static function dispatch()
    {
        // Încărcăm fișierul de rute
        require ROOT_DIR . 'routes/routes.php';

        // Preluăm metoda HTTP (GET, POST etc.)
        $method = $_SERVER['REQUEST_METHOD'];

        // Preluăm URI-ul curent și curățăm query string-ul (ex: /products?id=5 devine products)
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = trim($uri, '/');

        // Trecem prin toate rutele salvate
        foreach (self::$routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            // Transformăm {id} sau {slug} într-un grup de captură regex: ([^/]+)
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([^/]+)', $route['uri']);
            $pattern = '#^' . $pattern . '$#';

            // Verificăm dacă URL-ul accesat se potrivește cu șablonul rutei
            if (preg_match($pattern, $uri, $matches)) {
                // Eliminăm prima potrivire (care este tot URL-ul complet)
                array_shift($matches);

                $action = $route['action'];

                // Dacă acțiunea este o funcție anonimă (Closure), o executăm și îi pasăm parametrii
                if (is_callable($action)) {
                    return call_user_func_array($action, $matches);
                }

                // Dacă acțiunea este de tipul ['ControllerName', 'method']
                if (is_array($action)) {
                    $controller = new $action[0]();
                    $methodName = $action[1];
                    return call_user_func_array([$controller, $methodName], $matches);
                }
            }
        }

        // Dacă nicio rută nu a fost găsită, returnăm actiunea setata pentru 404 sau un mesaj implicit
        http_response_code(404);
        if ($method === 'GET') {
            if (self::$notFoundAction) {
                return call_user_func(self::$notFoundAction);
            } else {
                echo "404 Not Found";
            }
        }
    }
}