<?php

namespace App\Controllers;

use \Core\View;

class Home extends \Core\Controller
{
    /**
     * Filtro antes da execucao do metodo
     * Por exemplo, se o usuario não tiver permissao
     * Voce pode estar colocando dentro dessa funcao "before"
     * retornando false, assim o sistema não executa nada.
     * @return void
     */
    protected function before()
    {
    }

    /**
     * Filtro depois da execucao do metodo
     *
     * @return void
     */
    protected function after()
    {
    }

    /**
     * @return void
     */
    public function indexAction()
    {
        //echo 'Testando';
        $args = [
            'nome' => 'Lincoln',
            'tipo' => ['Alto','Gostoso']
        ];
        View::render('Home/index.php', $args);
    }
}
