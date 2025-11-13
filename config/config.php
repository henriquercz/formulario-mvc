<?php
/**
 * Arquivo: config/config.php
 * Descrição: Define constantes globais e parâmetros essenciais da aplicação Expedições Lumina.
 * Autor: Henrique Rezende
 * Data: 13/11/2025
 * Versão: 1.0.0
 */

declare(strict_types=1);

// Configuração do fuso horário para consistência em registros temporais.
date_default_timezone_set('America/Sao_Paulo');

// Caminhos e URLs base utilizados em toda a aplicação.
define('APP_NOME', 'Expedições Lumina');
define('APP_BASE_PATH', dirname(__DIR__));
define('APP_VIEW_PATH', APP_BASE_PATH . '/app/views');
define('APP_BASE_URL', 'http://localhost/formulario-mvc/public');

// Configurações do banco de dados MySQL local utilizado via PDO.
const DB_HOST = '127.0.0.1';
const DB_PORT = '3306';
const DB_NOME = 'expedicoes_lumina';
const DB_USUARIO = 'root';
const DB_SENHA = '';
const DB_CHARSET = 'utf8mb4';

// Ambiente padrão da aplicação (development, staging, production).
const APP_ENV = 'development';
