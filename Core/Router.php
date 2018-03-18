<?php
/**
 * Rotas
 */

class Router
{

    /**
     * Array das rotas (tabela de rotas)
     * @var array
     */
    protected $routes = [];

    /**
     * Parâmetros para verificar as rotas
     * @var array
     */
    protected $params = [];

    /**
     * Adiciona as rotas na tabela de rotas
     *
     * @param string $route  rota URL
     * @param array  $params Parâmetros (controller, action, etc.)
     *
     * @return void
     */
    public function add($route, $params = [])
    {
        // Converte a rota para uma expressao regular : dando um escape no ultimo slash
        $route = preg_replace('/\//', '\\/', $route);

        // Converte variáveis exemplo: {Controller}
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        // Converte variáveis com uma expressão regular customizada exemplo {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        // Adiciona no começo e no fim delimitadores, deixando case insensitive com o /i
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    /**
     * Retorna todas as rotas da tabela de rotas
     *
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Encontra a rota na tabela de rotas e assim seta o $params caso encontre
     *
     * @param string $url É a rota URL
     *
     * @return boolean  TRUE caso encontrar, FALSO se não
     */
    public function match($url)
    {
        // Da o match quando a URL for no formato por exemplo "/controller/action"
        //$reg_exp = "/^(?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)$/";

        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                /**
                 * Traz o que foi capturado (que será a key controller e a key action),
                 * pois nesse match também terá números, o que não importa
                 */
                //$params = [];

                // Solução interessante para extrair somente os nomes mas precisa do PHP 5.6+
                // $matches = array_filter($matches, "is_string", ARRAY_FILTER_USE_KEY);
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }

                $this->params = $params;
                return true;
            }
        }

        return false;
    }

    /**
     * Retorna os parâmetros encontrados
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
}
