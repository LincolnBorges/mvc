<?php

require '../Core/Router.php';

$router = new Router();

// Teste - Adicionando rotas fixas
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);

// Teste - Adicionando rotas variáveis
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');

// Mostra as fotas
echo '<pre>';
echo htmlspecialchars(print_r($router->getRoutes(), true));
echo '</pre>';


// Da o MATCH nas rotas seguindo o padrão de controller e action (podendo ter o id no meio)
$url = $_SERVER['QUERY_STRING'];

if ($router->match($url)) {
    echo '<pre>';
    var_dump($router->getParams());
    echo '</pre>';
    // Exemplo "produto/1/edit"
    // Retorno:
    // array (size=3)
    // 'controller' => string 'produto' (length=7)
    // 'id' => string '1' (length=1)
    // 'action' => string 'edit' (length=4)
} else {
    echo "Nenhuma rota encontrada para a URL '$url'";
}
