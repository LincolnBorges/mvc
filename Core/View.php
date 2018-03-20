<?php

namespace Core;

class View
{

    /**
     * Chama o arquivo da view
     *
     * @param string $view  "Arquivo da view"
     *
     * @return void
     */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = "../App/Views/$view";  // Caminho relativo

        if (is_readable($file)) {
            require $file;
        } else {
            echo "$file not found";
        }
    }
}
