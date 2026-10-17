<?php

namespace Core;

use Throwable;

class View
{
    public function render($view, $data = [])
    {

        // Calea către fișier
        $__viewFile = VIEWS_DIR . $view . '.tpl.php';
        $__layouts = VIEWS_DIR . 'layouts/default.php';
        // Verificam daca exista fisierul si incarcam fisierul view
        if (!is_file($__viewFile)) {
            throw new \Exception("View inexistent: $view");
        }

        // Transformă cheile din array în variabile (ex: $data['title'] devine $title)
        extract($data, EXTR_SKIP);

        try {
            // pornim buffer
            ob_start();
            require $__viewFile;
            $content = ob_get_clean(); // capturam contentul in variabila

            //randam pagina cu loyauts daca avem si fara daca nu avem
            if (file_exists($__layouts)) {
                // pornim buffer
                ob_start();
                require $__layouts;
                return ob_get_clean(); // capturam contentul in variabila;
            }

            return $content;
        } catch (Throwable $e) {
            ob_end_clean();
            throw $e;

        }
    }
}