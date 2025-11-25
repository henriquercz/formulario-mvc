# Expedições Lumina - Sistema MVC de Gestão de Expedições

**Autor:** Henrique Rezende e Artur Liu
**Data:** 13/11/2025  
**Versão:** 1.0.0  
**Disciplina:** Programação WEB III  

## 📋 Descrição

Aplicação web completa desenvolvida em PHP seguindo o padrão arquitetural MVC (Model-View-Controller) para gerenciamento de expedições turísticas. O sistema permite operações CRUD completas (Criar, Ler, Atualizar, Excluir) com interface moderna e responsiva, conectada a banco de dados MySQL local.

## 🏗️ Estrutura do Projeto

```
formulario-mvc/
├── app/
│   ├── core/
│   │   ├── Controller.php      # Classe base para controladores
│   │   └── Router.php          # Sistema de roteamento simples
│   ├── controllers/
│   │   └── ExpedicaoController.php  # Controlador principal de expedições
│   ├── models/
│   │   └── ExpedicaoModel.php  # Camada de acesso a dados
│   └── views/
│       ├── layouts/
│       │   └── principal.php   # Template principal
│       └── expedicoes/
│           ├── index.php       # Listagem de expedições
│           ├── criar.php       # Formulário de criação
│           └── (outras views)
├── config/
│   ├── config.php              # Constantes e configurações globais
│   └── database.php            # Classe de conexão PDO
├── database/
│   └── schema.sql              # Script SQL para criação do banco
├── public/
│   ├── index.php               # Ponto de entrada da aplicação
│   ├── css/
│   │   └── style.css           # Estilos responsivos modernos
│   └── js/
│       └── app.js              # Interações client-side
└── README.md
```

## 🛠 Tecnologias Utilizadas

- **Backend:** PHP 8.0+ (com `declare(strict_types=1)`)
- **Banco de Dados:** MySQL via PDO
- **Frontend:** HTML5, CSS3 (Grid/Flexbox), JavaScript ES6+
- **Arquitetura:** MVC (Model-View-Controller)
- **Padrões:** PSR-4 (autoloading), validações server/client-side

## ⚡ Funcionalidades

### ✅ CRUD Completo
- **Criar:** Formulário validado para novas expedições
- **Ler:** Listagem visual com cards e detalhes individuais
- **Atualizar:** Edição de expedições existentes
- **Excluir:** Remoção com confirmação JavaScript

### 🎨 Interface Responsiva
- Design moderno com CSS Grid e Flexbox
- Cores consistentes via variáveis CSS
- Layout adaptável para mobile/desktop
- Feedback visual em todas as ações

### 🔧 Validações
- **Server-side:** PHP com sanitização e regras de negócio
- **Client-side:** JavaScript para UX imediata
- **Segurança:** Proteção XSS via `htmlspecialchars()`

### 🗃️ Banco de Dados
- Schema normalizado com constraints
- Enum para campos controlados (status, dificuldade)
- Dados iniciais para demonstração

## 🚀 Instalação e Configuração

### Pré-requisitos
- PHP 8.0+ com extensão PDO MySQL
- MySQL 5.7+ ou MariaDB 10.2+
- Servidor web (Apache/Nginx) ou PHP Development Server

### Passo a Passo

1. **Configurar Banco de Dados**
   ```sql
   -- Execute o script database/schema.sql no MySQL Workbench
   ```

2. **Ajustar Configurações (se necessário)**
   ```php
   // config/config.php
   const DB_HOST = '127.0.0.1';
   const DB_PORT = '3306';
   const DB_NOME = 'expedicoes_lumina';
   const DB_USUARIO = 'root';
   const DB_SENHA = ''; // Altere se necessário
   ```

3. **Configurar Servidor Web**
   - DocumentRoot deve apontar para pasta `public/`
   - Apache: configure .htaccess para rewrite rules

4. **Acessar Aplicação**
   - URL base: `http://localhost/formulario-mvc/public`
   - Listagem: `http://localhost/formulario-mvc/public/expedicoes`

### PHP Development Server (Alternativa)
```bash
cd public
php -S localhost:8000
# Acesse: http://localhost:8000
```

## 📖 Uso do Sistema

### Fluxo Principal
1. **Listagem Inicial:** Dashboard com cards de todas as expedições
2. **Criar Expedição:** Preencher formulário completo com validações
3. **Visualizar Detalhes:** Clique em "Ver Detalhes" no card
4. **Editar:** Modificar dados de expedições existentes
5. **Excluir:** Remover com confirmação (ação irreversível)

### Campos da Expedição
- **Nome da Missão:** Identificação única (obrigatório)
- **Destino:** Localização da expedição (obrigatório)
- **Data de Partida:** Não pode ser anterior a hoje
- **Duração:** Número de dias (1-365)
- **Guia Responsável:** Nome do guia principal
- **Nível de Dificuldade:** Leve, Moderado ou Intenso
- **Vagas:** Total e disponíveis (com validação)
- **Status:** Planejada, Inscrições Abertas, Em Andamento, Concluída
- **Descrição:** Texto livre com detalhes

## 🔒 Segurança Implementada

- **XSS Protection:** `htmlspecialchars()` em todas as saídas
- **SQL Injection:** Prepared statements via PDO
- **Input Validation:** Server e client-side
- **Error Handling:** Mensagens amigáveis sem expor detalhes técnicos

## 📄 Schema SQL

```sql
CREATE DATABASE IF NOT EXISTS expedicoes_lumina CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE expedicoes_lumina;

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
```

## 📝 Licença

Projeto desenvolvido para fins acadêmicos na disciplina Programação WEB III do curso de Desenvolvimento de Sistemas da ETEC de Taboão da Serra. Código-fonte disponível para estudo e referência.

---

**Nota:** Este projeto segue rigorosamente as diretrizes da disciplina, incluindo cabeçalhos detalhados, comentários explicativos em português, estrutura MVC clara e documentação completa.

---


## Autor

- **Henrique Rezende** - [GitHub](https://github.com/henriquercz)
- **Artur Liu** - [GitHub](https://github.com/liuzinho777)


