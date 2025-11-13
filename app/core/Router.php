<?php
/**
 * Arquivo: app/core/Router.php
 * Descrição: Implementa roteador mínimo para mapear URIs em controladores/metodos do padrão MVC.
 * Autor: Henrique Rezende
 * Data: 13/11/2025
 * Versão: 1.0.0
 */

declare(strict_types=1);

/**
 * Classe Router
 * Objetivo: Registrar rotas (GET/POST) e direcionar requisições para controladores definidos no projeto.
 */
class Router
{
    /** @var array<string,array<int,array{pattern:string,callback:callable|string}>> */
    private array $rotas = [
        'GET' => [],
        'POST' => [],
    ];

    /**
     * Método: get
     * Objetivo: Registrar rotas HTTP GET.
     * Entradas: caminho (string) e callback (callable ou [ControllerClass, metodo]).
     */
    public function get(string $caminho, $callback): void
    {
        $this->registrarRota('GET', $caminho, $callback);
    }

    /**
     * Método: post
     * Objetivo: Registrar rotas HTTP POST.
     */
    public function post(string $caminho, $callback): void
    {
        $this->registrarRota('POST', $caminho, $callback);
    }

    /**
     * Método: dispatch
     * Objetivo: Executar a rota correspondente à URI solicitada.
     * Entradas: URI requisitada e método HTTP.
     */
    public function dispatch(string $uri, string $metodo): void
    {
        $caminho = parse_url($uri, PHP_URL_PATH) ?? '/';
        $basePath = rtrim(parse_url(APP_BASE_URL, PHP_URL_PATH) ?? '', '/');

        if ($basePath !== '' && $caminho !== $basePath && str_starts_with($caminho, $basePath)) {
            $caminho = substr($caminho, strlen($basePath)) ?: '/';
        }

        $caminho = $caminho === '' ? '/' : $caminho;
        $rotasDoMetodo = $this->rotas[$metodo] ?? [];

        foreach ($rotasDoMetodo as $rota) {
            if (preg_match($rota['pattern'], $caminho, $matches)) {
                $parametros = array_filter(
                    $matches,
                    fn($key) => !is_int($key),
                    ARRAY_FILTER_USE_KEY
                );

                return $this->executarCallback($rota['callback'], $parametros);
            }
        }

        http_response_code(404);
        echo 'Página não encontrada';
    }

    /**
     * Método: registrarRota
     * Objetivo: Converter o caminho fornecido em regex e armazenar o callback associado.
     */
    private function registrarRota(string $metodo, string $caminho, $callback): void
    {
        $pattern = preg_replace('/\//', '\/', $caminho);
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^\/]+)', $pattern ?? '');
        $pattern = '/^' . $pattern . '$/';

        $this->rotas[$metodo][] = [
            'pattern' => $pattern,
            'callback' => $callback,
        ];
    }

    /**
     * Método: executarCallback
     * Objetivo: Resolver instâncias de controlador e executar método definido.
     */
    private function executarCallback($callback, array $parametros): void
    {
        if (is_callable($callback)) {
            call_user_func_array($callback, $parametros);
            return;
        }

        if (is_array($callback) && count($callback) === 2) {
            [$controlador, $metodo] = $callback;

            if (!class_exists($controlador)) {
                http_response_code(500);
                echo "Controlador {$controlador} não encontrado";
                return;
            }

            $instancia = new $controlador();

            if (!method_exists($instancia, $metodo)) {
                http_response_code(500);
                echo "Método {$metodo} inexistente em {$controlador}";
                return;
            }

            call_user_func_array([$instancia, $metodo], $parametros);
            return;
        }

        http_response_code(500);
        echo 'Callback inválido.';
    }
}
