<?php
/**
 * Arquivo: app/views/expedicoes/index.php
 * Descrição: Listagem geral de expedições com filtros e ações rápidas.
 * Autor: Henrique Rezende
 * Data: 13/11/2025
 * Versão: 1.0.0
 */

ob_start();
?>

<section class="expedicoes-lista">
    <div class="cabecalho-lista">
        <h2>Expedições Disponíveis</h2>
        <a href="<?= APP_BASE_URL ?>/expedicoes/criar" class="btn btn-primary">
            + Cadastrar Nova Expedição
        </a>
    </div>

    <?php if (empty($expedicoes)): ?>
        <div class="vazio">
            <p>Nenhuma expedição cadastrada ainda.</p>
            <a href="<?= APP_BASE_URL ?>/expedicoes/criar" class="btn btn-secondary">
                Criar Primeira Expedição
            </a>
        </div>
    <?php else: ?>
        <div class="expedicoes-grid">
            <?php foreach ($expedicoes as $expedicao): ?>
                <article class="cartao-expedicao">
                    <header class="cartao-cabecalho">
                        <h3><?= htmlspecialchars($expedicao['nome_missao'], ENT_QUOTES, 'UTF-8') ?></h3>
                        <span class="status status-<?= strtolower(str_replace(' ', '-', $expedicao['status'])) ?>">
                            <?= htmlspecialchars($expedicao['status'], ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </header>

                    <div class="cartao-corpo">
                        <div class="info-grid">
                            <div class="info-item">
                                <strong>Destino:</strong>
                                <span><?= htmlspecialchars($expedicao['destino'], ENT_QUOTES, 'UTF-8') ?></span>
                            </div>
                            <div class="info-item">
                                <strong>Data:</strong>
                                <span><?= date('d/m/Y', strtotime($expedicao['data_partida'])) ?></span>
                            </div>
                            <div class="info-item">
                                <strong>Duração:</strong>
                                <span><?= $expedicao['duracao_dias'] ?> dias</span>
                            </div>
                            <div class="info-item">
                                <strong>Guia:</strong>
                                <span><?= htmlspecialchars($expedicao['guia_responsavel'], ENT_QUOTES, 'UTF-8') ?></span>
                            </div>
                            <div class="info-item">
                                <strong>Nível:</strong>
                                <span class="nivel nivel-<?= strtolower($expedicao['nivel_dificuldade']) ?>">
                                    <?= htmlspecialchars($expedicao['nivel_dificuldade'], ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </div>
                            <div class="info-item">
                                <strong>Vagas:</strong>
                                <span><?= $expedicao['vagas_disponiveis'] ?>/<?= $expedicao['vagas_total'] ?></span>
                            </div>
                        </div>

                        <p class="descricao">
                            <?= nl2br(htmlspecialchars(substr($expedicao['descricao'], 0, 150), ENT_QUOTES, 'UTF-8')) ?>
                            <?= strlen($expedicao['descricao']) > 150 ? '...' : '' ?>
                        </p>
                    </div>

                    <footer class="cartao-acoes">
                        <a href="<?= APP_BASE_URL ?>/expedicoes/mostrar/<?= $expedicao['id'] ?>" class="btn btn-sm btn-info">
                            Ver Detalhes
                        </a>
                        <a href="<?= APP_BASE_URL ?>/expedicoes/editar/<?= $expedicao['id'] ?>" class="btn btn-sm btn-warning">
                            Editar
                        </a>
                        <form method="POST" action="<?= APP_BASE_URL ?>/expedicoes/excluir/<?= $expedicao['id'] ?>" 
                              onsubmit="return confirm('Tem certeza que deseja excluir esta expedição?')" 
                              class="form-inline">
                            <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                        </form>
                    </footer>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php
$conteudo = ob_get_clean();
require APP_VIEW_PATH . '/layouts/principal.php';
?>
