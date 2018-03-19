<?php

namespace App\Controllers;

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
        echo "(before) ";
    }

    /**
     * Filtro depois da execucao do metodo
     *
     * @return void
     */
    protected function after()
    {
        echo " (after)";
    }

    /**
     * @return void
     */
    public function indexAction()
    {
        echo 'Testando';
    }
}
