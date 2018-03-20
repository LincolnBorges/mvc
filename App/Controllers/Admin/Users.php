<?php

namespace App\Controllers\Admin;

class Users extends \Core\Controller
{

    /**
     * Filtro Before
     *
     * @return void
     */
    protected function before()
    {
        // verificar as permissões do usuário ou algum campo _POST ou _GET
        // return false;
    }

    /**
     * @return void
     */
    public function indexAction()
    {
        echo 'admin index';
    }
}
