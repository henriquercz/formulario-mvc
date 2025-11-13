<?php
/**
 * Arquivo: config/database.php
 * Descrição: Implementa a classe de conexão PDO reutilizável para toda a aplicação.
 * Autor: Henrique Rezende
 * Data: 13/11/2025
 * Versão: 1.0.0
 */

require_once __DIR__ . '/config.php';

/**
 * Classe Database
 * Responsável por entregar instâncias PDO configuradas.
 */
class Database
{
    /** @var PDO|null $conexao Mantém instância compartilhada para reduzir overhead */
    private static ?PDO $conexao = null;

    /**
     * Método: getConexao
     * Objetivo: Retornar conexão ativa com o banco MySQL.
     * Saída: Instância PDO pronta para uso.
     */
    public static function getConexao(): PDO
    {
        if (self::$conexao === null) {
            $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', DB_HOST, DB_PORT, DB_NOME, DB_CHARSET);

            $opcoes = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            self::$conexao = new PDO($dsn, DB_USUARIO, DB_SENHA, $opcoes);
        }

        return self::$conexao;
    }
}
