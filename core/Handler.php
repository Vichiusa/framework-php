<?php

namespace Core;

use Symfony\Component\ErrorHandler\ErrorHandler;
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
            // În producție
            $errorHandler = ErrorHandler::register();
            $errorHandler->setExceptionHandler(function (\Throwable $exception) {
                http_response_code(500);
                echo app()->view->render(ERROR_PAGE);
            });
        }
    }
}