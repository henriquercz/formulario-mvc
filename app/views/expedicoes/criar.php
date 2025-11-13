<?php
/**
 * Arquivo: app/views/expedicoes/criar.php
 * Descrição: Formulário de cadastro de novas expedições com validação client-side.
 * Autor: Henrique Rezende
 * Data: 13/11/2025
 * Versão: 1.0.0
 */

ob_start();
?>

<section class="formulario-expedicao">
    <div class="cabecalho-form">
        <h2>Cadastrar Nova Expedição</h2>
        <a href="<?= APP_BASE_URL ?>/expedicoes" class="btn btn-secondary">← Voltar</a>
    </div>

    <form method="POST" action="<?= APP_BASE_URL ?>/expedicoes/criar" class="form-expedicao" novalidate>
        <div class="form-grid">
            <div class="form-coluna">
                <div class="form-group">
                    <label for="nome_missao">Nome da Missão *</label>
                    <input type="text" id="nome_missao" name="nome_missao" required
                           value="<?= $dados['nome_missao'] ?? '' ?>"
                           class="<?= isset($erros['nome_missao']) ? 'erro' : '' ?>">
                    <?php if (isset($erros['nome_missao'])): ?>
                        <span class="msg-erro"><?= $erros['nome_missao'] ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="destino">Destino *</label>
                    <input type="text" id="destino" name="destino" required
                           value="<?= $dados['destino'] ?? '' ?>"
                           class="<?= isset($erros['destino']) ? 'erro' : '' ?>">
                    <?php if (isset($erros['destino'])): ?>
                        <span class="msg-erro"><?= $erros['destino'] ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="data_partida">Data de Partida *</label>
                        <input type="date" id="data_partida" name="data_partida" required
                               value="<?= $dados['data_partida'] ?? '' ?>"
                               class="<?= isset($erros['data_partida']) ? 'erro' : '' ?>">
                        <?php if (isset($erros['data_partida'])): ?>
                            <span class="msg-erro"><?= $erros['data_partida'] ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="duracao_dias">Duração (dias) *</label>
                        <input type="number" id="duracao_dias" name="duracao_dias" min="1" required
                               value="<?= $dados['duracao_dias'] ?? '' ?>"
                               class="<?= isset($erros['duracao_dias']) ? 'erro' : '' ?>">
                        <?php if (isset($erros['duracao_dias'])): ?>
                            <span class="msg-erro"><?= $erros['duracao_dias'] ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="guia_responsavel">Guia Responsável *</label>
                    <input type="text" id="guia_responsavel" name="guia_responsavel" required
                           value="<?= $dados['guia_responsavel'] ?? '' ?>"
                           class="<?= isset($erros['guia_responsavel']) ? 'erro' : '' ?>">
                    <?php if (isset($erros['guia_responsavel'])): ?>
                        <span class="msg-erro"><?= $erros['guia_responsavel'] ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-coluna">
                <div class="form-group">
                    <label for="nivel_dificuldade">Nível de Dificuldade *</label>
                    <select id="nivel_dificuldade" name="nivel_dificuldade" required
                            class="<?= isset($erros['nivel_dificuldade']) ? 'erro' : '' ?>">
                        <option value="">Selecione...</option>
                        <?php foreach ($opcoesNivel as $nivel): ?>
                            <option value="<?= $nivel ?>" <?= ($dados['nivel_dificuldade'] ?? '') === $nivel ? 'selected' : '' ?>>
                                <?= $nivel ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($erros['nivel_dificuldade'])): ?>
                        <span class="msg-erro"><?= $erros['nivel_dificuldade'] ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="vagas_total">Vagas Totais *</label>
                        <input type="number" id="vagas_total" name="vagas_total" min="1" required
                               value="<?= $dados['vagas_total'] ?? '' ?>"
                               class="<?= isset($erros['vagas_total']) ? 'erro' : '' ?>">
                        <?php if (isset($erros['vagas_total'])): ?>
                            <span class="msg-erro"><?= $erros['vagas_total'] ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="vagas_disponiveis">Vagas Disponíveis *</label>
                        <input type="number" id="vagas_disponiveis" name="vagas_disponiveis" min="0" required
                               value="<?= $dados['vagas_disponiveis'] ?? '' ?>"
                               class="<?= isset($erros['vagas_disponiveis']) ? 'erro' : '' ?>">
                        <?php if (isset($erros['vagas_disponiveis'])): ?>
                            <span class="msg-erro"><?= $erros['vagas_disponiveis'] ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="status">Status *</label>
                    <select id="status" name="status" required
                            class="<?= isset($erros['status']) ? 'erro' : '' ?>">
                        <option value="">Selecione...</option>
                        <?php foreach ($opcoesStatus as $status): ?>
                            <option value="<?= $status ?>" <?= ($dados['status'] ?? '') === $status ? 'selected' : '' ?>>
                                <?= $status ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($erros['status'])): ?>
                        <span class="msg-erro"><?= $erros['status'] ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição *</label>
                    <textarea id="descricao" name="descricao" rows="6" required
                              class="<?= isset($erros['descricao']) ? 'erro' : '' ?>"><?= $dados['descricao'] ?? '' ?></textarea>
                    <?php if (isset($erros['descricao'])): ?>
                        <span class="msg-erro"><?= $erros['descricao'] ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="form-acoes">
            <button type="submit" class="btn btn-primary">Cadastrar Expedição</button>
            <a href="<?= APP_BASE_URL ?>/expedicoes" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</section>

<?php
$conteudo = ob_get_clean();
require APP_VIEW_PATH . '/layouts/principal.php';
?>
