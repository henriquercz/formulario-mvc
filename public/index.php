<?php
/**
 * Arquivo: public/index.php
 * Descrição: Ponto de entrada da aplicação MVC Expedições Lumina. Configura autoloader, inicializa roteador e despacha requisições.
 * Autor: Henrique Rezende
 * Data: 13/11/2025
 * Versão: 1.0.0
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/config/config.php';

spl_autoload_register(function ($classe) {
    $caminho = APP_BASE_PATH . '/app/' . str_replace('\\', '/', $classe) . '.php';
    if (file_exists($caminho)) {
        require_once $caminho;
    }
});

require_once APP_BASE_PATH . '/app/core/Router.php';
require_once APP_BASE_PATH . '/app/controllers/ExpedicaoController.php';

$roteador = new Router();

$roteador->get('/', [ExpedicaoController::class, 'index']);
$roteador->get('/expedicoes', [ExpedicaoController::class, 'index']);
$roteador->get('/expedicoes/mostrar/{id}', [ExpedicaoController::class, 'mostrar']);
$roteador->get('/expedicoes/criar', [ExpedicaoController::class, 'criarForm']);
$roteador->post('/expedicoes/criar', [ExpedicaoController::class, 'criar']);
$roteador->get('/expedicoes/editar/{id}', [ExpedicaoController::class, 'editarForm']);
$roteador->post('/expedicoes/editar/{id}', [ExpedicaoController::class, 'editar']);
$roteador->post('/expedicoes/excluir/{id}', [ExpedicaoController::class, 'excluir']);

$uri = $_SERVER['REQUEST_URI'] ?? '/';
$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$roteador->dispatch($uri, $metodo);
