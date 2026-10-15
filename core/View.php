<?php

namespace Core;

class View
{
    protected $content;

    public function render($view, $data = [])
    {

        // Calea către fișier
        $viewFile = VIEWS_DIR . $view . '.tpl.php';
        $layouts = VIEWS_DIR . 'layouts/default.php';
        if (!file_exists($viewFile)) {
            throw new \Exception("Fișierul view nu a fost găsit: {$viewFile}");
        }

        // Transformă cheile din array în variabile (ex: $data['title'] devine $title)
        extract($data);

        // Verificam daca exista fisierul si incarcam fisierul view

        // pornim buffer
        ob_start();
        try {
            require $viewFile;
            $this->content = ob_get_clean(); // capturam contentul in variabila
        } catch (\Throwable $e) {
            ob_end_clean();
            throw $e;
        }

        //randam pagina cu loyauts daca avem si fara daca nu avem
        if (file_exists($layouts)) {
            $content = $this->content;
            require_once $layouts;
        } else {
            echo $this->content;
        }
    }
}