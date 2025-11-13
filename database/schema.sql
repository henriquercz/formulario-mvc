-- -----------------------------------------------------
-- Base de dados: expedicoes_lumina
-- Descrição: Estrutura das tabelas utilizadas pela aplicação MVC Expedições Lumina.
-- Autor: Henrique Rezende
-- Data: 13/11/2025
-- Versão: 1.0.0
-- -----------------------------------------------------

CREATE DATABASE IF NOT EXISTS expedicoes_lumina CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE expedicoes_lumina;

-- -----------------------------------------------------
-- Tabela: expedicoes
-- Objetivo: Persistir informações das expedições cadastradas pela equipe Lumina.
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS expedicoes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome_missao VARCHAR(120) NOT NULL,
    destino VARCHAR(120) NOT NULL,
    data_partida DATE NOT NULL,
    duracao_dias TINYINT UNSIGNED NOT NULL,
    guia_responsavel VARCHAR(120) NOT NULL,
    nivel_dificuldade ENUM('Leve', 'Moderado', 'Intenso') NOT NULL DEFAULT 'Moderado',
    vagas_total TINYINT UNSIGNED NOT NULL,
    vagas_disponiveis TINYINT UNSIGNED NOT NULL,
    descricao TEXT NOT NULL,
    status ENUM('Planejada', 'Inscrições Abertas', 'Em Andamento', 'Concluída') NOT NULL DEFAULT 'Planejada',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT chk_vagas CHECK (vagas_disponiveis <= vagas_total)
);

-- -----------------------------------------------------
-- Dados iniciais para demonstrar o funcionamento da aplicação.
-- -----------------------------------------------------
INSERT INTO expedicoes (nome_missao, destino, data_partida, duracao_dias, guia_responsavel, nivel_dificuldade, vagas_total, vagas_disponiveis, descricao, status)
VALUES
('Aurora Boreal Imersiva', 'Tromsø - Noruega', '2026-01-15', 7, 'Lia Monteiro', 'Moderado', 18, 12, 'Vivência ártica com workshops de fotografia noturna e visitas a aldeias Sami.', 'Inscrições Abertas'),
('Selva Bioacústica', 'Tefé - Amazônia', '2026-03-02', 10, 'Ícaro Guimarães', 'Intenso', 14, 6, 'Pesquisa colaborativa sobre sons da floresta, oficinas de gravação e reflorestamento comunitário.', 'Planejada'),
('Expedição Lumina Andes', 'Cusco - Peru', '2026-05-20', 8, 'Maite Arriaga', 'Moderado', 20, 20, 'Trekking cultural com módulos de arqueologia viva e práticas de respiração em altitude.', 'Planejada');
