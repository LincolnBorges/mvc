<?php

namespace Core;

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

    /**
     * Dispacha a rota, criando o objeto do controller e rodando o metodo action
     *
     * @param string $url URL da rota
     *
     * @return void
     */
    public function dispatch($url)
    {
        $url = $this->removeQueryStringVariables($url);
        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            //Assim fica dinâmico dar o load no namespace do controller para chamar seus métodos
            //$controller = "App\Controllers\\$controller";
            $controller = $this->getNamespace().$controller;

            if (class_exists($controller)) {
                $controller_object = new $controller($this->params);
                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);
                // Medida de seguranca
                // Caso o usuário espertinho saiba como funciona as classes do sistema
                // E tenta entrar diretamente com o Sufixo "Action"
                // Ele conseguria acesso ao metodo sem passar pelo "before"
                // Entao e melhor remover caso houver o sufixo "action"
                $action = preg_replace('/action$/i', "", $action);
                $controller_object->$action();
            } else {
                throw new \Exception("Controller class $controller não foi encontrado");
            }
        } else {
            throw new \Exception('Rota não encontrada.');
        }
    }

    /**
     * Converte strings com hifens para StudlyCaps (PSR-1),
     * ex. post-authors => PostAuthors
     *
     * @param string $string String a ser convertido
     *
     * @return string
     */
    protected function convertToStudlyCaps($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Converte strings com hifens para camelCase,
     * ex. add-new => addNew
     *
     * @param string $string String a ser convertido
     *
     * @return string
     */
    protected function convertToCamelCase($string)
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    /**
     * Remove qualquer query string, pois precisamos apenas do controller e do método
     * lidando com essa query string mais tarde.
     * exemplo:
     *
     *   URL                           $_SERVER['QUERY_STRING']  Rota
     *   -------------------------------------------------------------------
     *   localhost                     ''                        ''
     *   localhost/?                   ''                        ''
     *   localhost/?page=1             page=1                    ''
     *   localhost/posts?page=1        posts&page=1              posts
     *   localhost/posts/index         posts/index               posts/index
     *   localhost/posts/index?page=1  posts/index&page=1        posts/index
     *
     * @param string $url String do URL
     *
     * @return string da URL só que sem a query
     */
    protected function removeQueryStringVariables($url)
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }

        return $url;
    }

    /**
     * Pega o namespace da classe do controller.
     * O namespace definido no parametro da rota e adicionado
     * caso estiver presente.
     *
     * @return string URL
     */
    protected function getNamespace()
    {
        $namespace = 'App\Controllers\\';

        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }
}
