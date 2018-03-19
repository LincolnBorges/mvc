<?php

namespace App\Controllers;

class Posts extends \Core\Controller
{

    /**
     *
     * @return void
     */
    public function index()
    {
        echo 'Método index';
        var_dump($_GET);
    }

    /**
     *
     * @return void
     */
    public function addNew()
    {
        echo 'Método addNew';
    }

    /**
     *
     * @return void
     */
    public function edit()
    {
        var_dump($this->route_params);
    }
}
