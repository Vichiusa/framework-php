<?php

namespace Core;

use Symfony\Component\ErrorHandler\Debug;

class Handler
{
    public static function start()
    {
        $isDebug = filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN);

        if ($isDebug) {
            // Activează interfața completă de debugging (erori detaliate, stack trace interactiv)
            Debug::enable();

        } else {
            // În producție, activezi doar handler-ul de erori pentru a le captura și loga în siguranță
            set_exception_handler(function (\Throwable $exception) {
                http_response_code(500);
                $hederFile = VIEWS_DIR . 'layouts/header.php';
                $errorPage = VIEWS_DIR . 'pages/errors/500.php';
                if (file_exists($errorPage) && file_exists($hederFile)) {
                    require_once $hederFile;
                    require_once $errorPage;
                } else {
                    echo "Ops! Internal Server Error. Please try again later.";
                }
            });
        }
    }
}