<?php

namespace Core;

abstract class Controller
{

    /**
     * Parametros que deu match na rota
     * @var array
     */
    protected $route_params = [];

    /**
     * Class constructor
     *
     * @param array $route_params  Parametros da rota
     *
     * @return void
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }
}
