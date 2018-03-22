<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Post;

class Posts extends \Core\Controller
{
    /**
     * @return void
     */
    public function indexAction()
    {
        $args['posts'] = Post::getAll();
        View::render('Posts/index.php', $args);
    }

    /**
     * @return void
     */
    public function addNewAction()
    {
        echo 'addnew';
    }

    /**
     * @return void
     */
    public function editAction()
    {
        var_dump($this->route_params);
    }
}
