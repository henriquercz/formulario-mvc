<?php
/**
 * Arquivo: app/core/Controller.php
 * Descrição: Classe base para controladores MVC, oferecendo utilidades de renderização e resposta.
 * Autor: Henrique Rezende
 * Data: 13/11/2025
 * Versão: 1.0.0
 */

/**
 * Classe Controller
 * Objetivo: Padronizar comportamentos comuns entre controladores, como carregamento de views.
 */
abstract class Controller
{
    /**
     * Método: view
     * Objetivo: Carregar um arquivo de view e disponibilizar variáveis para o template.
     * Entradas:
     *  - string $caminhoView: caminho relativo dentro de app/views (sem extensão).
     *  - array $dados: dados a serem extraídos para o escopo da view.
     */
    protected function view(string $caminhoView, array $dados = []): void
    {
        $arquivoView = APP_VIEW_PATH . '/' . $caminhoView . '.php';

        if (!file_exists($arquivoView)) {
            http_response_code(500);
            echo "View {$caminhoView} não encontrada.";
            return;
        }

        extract($dados, EXTR_SKIP);
        require $arquivoView;
    }

    /**
     * Método: json
     * Objetivo: Retornar respostas JSON padronizadas.
     * Entradas:
     *  - array $payload: dados a serializar.
     *  - int $status: código HTTP desejado.
     */
    protected function json(array $payload, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
