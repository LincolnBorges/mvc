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

    /**
     * Metodo magico chamado __call() invoca classes publicas / privadas / protegidas
     * e ate mesmo nao existentes, com isso podemos receber os parametros
     * passar primeiro pelo "before" e depois de executado passar pelo "after"
     * caso seja necessario alguma validacao especifica.
     * Para chamar o metodo, basta declarar ele com o sufixo "Action"
     * Ex. indexAction, editAction e etc.
     *
     * @param string $name  Method
     * @param array $args Argumentos para o Method
     *
     * @return void
     */
    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            echo "Método $method (no controller ".get_class($this).") não foi encontrado ";
        }
    }

    /**
     * Filtro depois da execucao do metodo
     *
     * @return void
     */
    protected function before()
    {
    }

    /**
     * Filtro antes da execucao do metodo
     *
     * @return void
     */
    protected function after()
    {
    }
}
