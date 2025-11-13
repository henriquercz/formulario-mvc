<?php
/**
 * Arquivo: app/controllers/ExpedicaoController.php
 * Descrição: Controlador principal para expedições, gerenciando rotas CRUD e fluxos de navegação.
 * Autor: Henrique Rezende
 * Data: 13/11/2025
 * Versão: 1.0.0
 */

declare(strict_types=1);

require_once APP_BASE_PATH . '/app/core/Controller.php';
require_once APP_BASE_PATH . '/app/models/ExpedicaoModel.php';

/**
 * Classe ExpedicaoController
 * Objetivo: Implementar ações de listagem, criação, edição e exclusão de expedições.
 */
class ExpedicaoController extends Controller
{
    private ExpedicaoModel $model;

    /**
     * Construtor: injeta dependência do Model.
     */
    public function __construct()
    {
        $this->model = new ExpedicaoModel();
    }

    /**
     * Método: index
     * Objetivo: Exibir listagem completa com todas as expedições.
     */
    public function index(): void
    {
        $expedicoes = $this->model->listarTodos();
        $this->view('expedicoes/index', ['expedicoes' => $expedicoes]);
    }

    /**
     * Método: mostrar
     * Objetivo: Apresentar detalhes de uma expedição específica.
     */
    public function mostrar(int $id): void
    {
        $expedicao = $this->model->buscarPorId($id);

        if (!$expedicao) {
            http_response_code(404);
            echo 'Expedição não encontrada';
            return;
        }

        $this->view('expedicoes/mostrar', ['expedicao' => $expedicao]);
    }

    /**
     * Método: criarForm
     * Objetivo: Renderizar formulário de nova expedição.
     */
    public function criarForm(): void
    {
        $this->view('expedicoes/criar', [
            'opcoesNivel' => $this->model->opcoesNivel(),
            'opcoesStatus' => $this->model->opcoesStatus(),
        ]);
    }

    /**
     * Método: criar
     * Objetivo: Processar submissão do formulário e persistir dados.
     */
    public function criar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido';
            return;
        }

        $dados = $this->sanitizar($_POST);

        if (!$this->validar($dados)) {
            $this->view('expedicoes/criar', [
                'erros' => $this->erros,
                'dados' => $dados,
                'opcoesNivel' => $this->model->opcoesNivel(),
                'opcoesStatus' => $this->model->opcoesStatus(),
            ]);
            return;
        }

        $dadosSanitizados = $this->prepararParaBD($dados);

        if ($this->model->criar($dadosSanitizados)) {
            header('Location: ' . APP_BASE_URL . '/expedicoes');
        } else {
            echo 'Erro ao salvar expedição';
        }
    }

    /**
     * Método: editarForm
     * Objetivo: Renderizar formulário de edição com dados preenchidos.
     */
    public function editarForm(int $id): void
    {
        $expedicao = $this->model->buscarPorId($id);

        if (!$expedicao) {
            http_response_code(404);
            echo 'Expedição não encontrada';
            return;
        }

        $this->view('expedicoes/editar', [
            'expedicao' => $expedicao,
            'opcoesNivel' => $this->model->opcoesNivel(),
            'opcoesStatus' => $this->model->opcoesStatus(),
        ]);
    }

    /**
     * Método: editar
     * Objetivo: Processar atualização de expedição existente.
     */
    public function editar(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido';
            return;
        }

        $dados = $this->sanitizar($_POST);

        if (!$this->validar($dados)) {
            $expedicao = $this->model->buscarPorId($id);
            $this->view('expedicoes/editar', [
                'expedicao' => $expedicao,
                'erros' => $this->erros,
                'dados' => $dados,
                'opcoesNivel' => $this->model->opcoesNivel(),
                'opcoesStatus' => $this->model->opcoesStatus(),
            ]);
            return;
        }

        $dadosSanitizados = $this->prepararParaBD($dados);

        if ($this->model->atualizar($id, $dadosSanitizados)) {
            header('Location: ' . APP_BASE_URL . '/expedicoes');
        } else {
            echo 'Erro ao atualizar expedição';
        }
    }

    /**
     * Método: excluir
     * Objetivo: Remover expedição após confirmação.
     */
    public function excluir(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido';
            return;
        }

        if ($this->model->excluir($id)) {
            header('Location: ' . APP_BASE_URL . '/expedicoes');
        } else {
            echo 'Erro ao excluir expedição';
        }
    }

    /** @var array<string,string> */
    private array $erros = [];

    /**
     * Método: validar
     * Objetivo: Aplicar regras de negócio básicas aos campos.
     */
    private function validar(array $dados): bool
    {
        $this->erros = [];

        if (empty(trim($dados['nome_missao']))) {
            $this->erros['nome_missao'] = 'Nome da missão é obrigatório';
        }

        if (empty(trim($dados['destino']))) {
            $this->erros['destino'] = 'Destino é obrigatório';
        }

        if (empty($dados['data_partida'])) {
            $this->erros['data_partida'] = 'Data de partida é obrigatória';
        } elseif (!strtotime($dados['data_partida'])) {
            $this->erros['data_partida'] = 'Data inválida';
        }

        if (empty($dados['duracao_dias']) || $dados['duracao_dias'] < 1) {
            $this->erros['duracao_dias'] = 'Duração deve ser maior que zero';
        }

        if (empty(trim($dados['guia_responsavel']))) {
            $this->erros['guia_responsavel'] = 'Guia responsável é obrigatório';
        }

        if (!in_array($dados['nivel_dificuldade'], $this->model->opcoesNivel(), true)) {
            $this->erros['nivel_dificuldade'] = 'Nível inválido';
        }

        if (empty($dados['vagas_total']) || $dados['vagas_total'] < 1) {
            $this->erros['vagas_total'] = 'Vagas totais devem ser maior que zero';
        }

        if (!isset($dados['vagas_disponiveis']) || $dados['vagas_disponiveis'] < 0) {
            $this->erros['vagas_disponiveis'] = 'Vagas disponíveis não pode ser negativo';
        } elseif (isset($dados['vagas_total']) && $dados['vagas_disponiveis'] > $dados['vagas_total']) {
            $this->erros['vagas_disponiveis'] = 'Disponíveis não podem exceder o total';
        }

        if (!in_array($dados['status'], $this->model->opcoesStatus(), true)) {
            $this->erros['status'] = 'Status inválido';
        }

        if (empty(trim($dados['descricao']))) {
            $this->erros['descricao'] = 'Descrição é obrigatória';
        }

        return empty($this->erros);
    }

    /**
     * Método: sanitizar
     * Objetivo: Limpar entradas do usuário para evitar XSS e problemas de codificação.
     */
    private function sanitizar(array $dados): array
    {
        return array_map(fn($valor) => is_string($valor) ? trim(htmlspecialchars($valor, ENT_QUOTES, 'UTF-8')) : $valor, $dados);
    }

    /**
     * Método: prepararParaBD
     * Objetivo: Converter tipos e mapear nomes de campos para o banco.
     */
    private function prepararParaBD(array $dados): array
    {
        return [
            ':nome_missao' => $dados['nome_missao'],
            ':destino' => $dados['destino'],
            ':data_partida' => $dados['data_partida'],
            ':duracao_dias' => (int) $dados['duracao_dias'],
            ':guia_responsavel' => $dados['guia_responsavel'],
            ':nivel_dificuldade' => $dados['nivel_dificuldade'],
            ':vagas_total' => (int) $dados['vagas_total'],
            ':vagas_disponiveis' => (int) $dados['vagas_disponiveis'],
            ':descricao' => $dados['descricao'],
            ':status' => $dados['status'],
        ];
    }
}
