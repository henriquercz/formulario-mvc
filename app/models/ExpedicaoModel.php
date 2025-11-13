<?php
/**
 * Arquivo: app/models/ExpedicaoModel.php
 * Descrição: Camada de acesso a dados para a entidade Expedição, oferecendo operações CRUD com validação.
 * Autor: Henrique Rezende
 * Data: 13/11/2025
 * Versão: 1.0.0
 */

declare(strict_types=1);

require_once APP_BASE_PATH . '/config/database.php';

/**
 * Classe ExpedicaoModel
 * Objetivo: Centralizar interações com a tabela expedicoes e encapsular regras de negócio básicas.
 */
class ExpedicaoModel
{
    private PDO $conexao;

    /**
     * Construtor: estabelece conexão única via classe Database.
     */
    public function __construct()
    {
        $this->conexao = Database::getConexao();
    }

    /**
     * Método: listarTodos
     * Objetivo: recuperar todas as expedições ordenadas por data de partida.
     * Saída: array associativo com registros completos.
     */
    public function listarTodos(): array
    {
        $sql = 'SELECT * FROM expedicoes ORDER BY data_partida ASC, nome_missao ASC';
        return $this->conexao->query($sql)->fetchAll();
    }

    /**
     * Método: buscarPorId
     * Objetivo: obter expedição específica através do identificador.
     * Entradas: $id (int) - chave primária.
     */
    public function buscarPorId(int $id): ?array
    {
        $stmt = $this->conexao->prepare('SELECT * FROM expedicoes WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $registro = $stmt->fetch();

        return $registro ?: null;
    }

    /**
     * Método: criar
     * Objetivo: inserir nova expedição com dados validados.
     * Entradas: $dadosSanitizados - array seguro.
     */
    public function criar(array $dadosSanitizados): bool
    {
        $sql = 'INSERT INTO expedicoes (nome_missao, destino, data_partida, duracao_dias, guia_responsavel, nivel_dificuldade, vagas_total, vagas_disponiveis, descricao, status)
                VALUES (:nome_missao, :destino, :data_partida, :duracao_dias, :guia_responsavel, :nivel_dificuldade, :vagas_total, :vagas_disponiveis, :descricao, :status)';

        $stmt = $this->conexao->prepare($sql);
        return $stmt->execute($dadosSanitizados);
    }

    /**
     * Método: atualizar
     * Objetivo: realizar update de expedição existente.
     */
    public function atualizar(int $id, array $dadosSanitizados): bool
    {
        $sql = 'UPDATE expedicoes SET nome_missao = :nome_missao, destino = :destino, data_partida = :data_partida, duracao_dias = :duracao_dias,
                    guia_responsavel = :guia_responsavel, nivel_dificuldade = :nivel_dificuldade, vagas_total = :vagas_total,
                    vagas_disponiveis = :vagas_disponiveis, descricao = :descricao, status = :status WHERE id = :id';

        $stmt = $this->conexao->prepare($sql);
        $dados = array_merge($dadosSanitizados, ['id' => $id]);
        return $stmt->execute($dados);
    }

    /**
     * Método: excluir
     * Objetivo: remover expedição existente.
     */
    public function excluir(int $id): bool
    {
        $stmt = $this->conexao->prepare('DELETE FROM expedicoes WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Método: opcoesNivel
     * Objetivo: fornecer lista controlada de níveis aceitos.
     */
    public function opcoesNivel(): array
    {
        return ['Leve', 'Moderado', 'Intenso'];
    }

    /**
     * Método: opcoesStatus
     * Objetivo: fornecer lista controlada de status válidos.
     */
    public function opcoesStatus(): array
    {
        return ['Planejada', 'Inscrições Abertas', 'Em Andamento', 'Concluída'];
    }
}
