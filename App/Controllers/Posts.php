<?php

namespace App\Controllers;

class Posts extends \Core\Controller
{
    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        echo 'index';
    }

    /**
     * Show the add new page
     *
     * @return void
     */
    public function addNewAction()
    {
        echo 'addnew';
    }

    /**
     * Show the edit page
     *
     * @return void
     */
    public function editAction()
    {
        var_dump($this->route_params);
    }
}
