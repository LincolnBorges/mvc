<?php

namespace Core;

class View
{

    public function filter(&$value)
    {
        $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Renderiza a view
     *
     * @param string $view  "Arquivo da view"
     * @param array $args  o array dos dados que ira para a view
     *
     * @return void
     */
    public static function render($view, $args = [])
    {
        // Filtrar o array com htmlspecialchars de modo recursivo
        $obj = new View();
        array_walk_recursive($args, array($obj, 'filter'));
        // Obs.: Caso precisar por algum motivo dar o display do codigo HTML
        // na variavel, na view use o htmlspecialchars_decode($variavel)

        // Converte a key do array em variavel
        extract($args, EXTR_SKIP);

        $file = "../App/Views/$view";  // Caminho relativo

        if (is_readable($file)) {
            require $file;
        } else {
            echo "$file not found";
        }
    }
}
