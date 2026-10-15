<?php

namespace Core;

use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\ErrorHandler\ErrorHandler;

class Handler
{
    public static function start()
    {
        $isDebug = filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN);

        //dd($isDebug);

        if ($isDebug) {
            // Activează interfața completă de debugging (erori detaliate, stack trace interactiv)
            Debug::enable();

        } else {
            // În producție, activezi doar handler-ul de erori pentru a le captura și loga în siguranță
            //$handler = ErrorHandler::register();
            set_exception_handler(function (\Throwable $exception) {
                self::error($exception->getMessage() . " in " . $exception->getFile() . ":" . $exception->getLine());
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

    public static function log(string $message, string $level = 'INFO'): void
    {
        $date = date('Y-m-d H:i:s');
        $line = "[{$date}] [{$level}] {$message}" . PHP_EOL;

        $file = LOG_DIR . date('Y-m-d') . '.log';

        if (!file_exists(LOG_DIR)) {
            mkdir(LOG_DIR);
        }

        file_put_contents($file, $line, FILE_APPEND);
    }

    public static function error(string $message): void
    {
        self::log($message, 'ERROR');
    }

    public static function info(string $message): void
    {
        self::log($message, 'INFO');
    }

    public static function warning(string $message): void
    {
        self::log($message, 'WARNING');
    }
}