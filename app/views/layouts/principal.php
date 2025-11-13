<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? APP_NOME ?></title>
    <link rel="stylesheet" href="<?= APP_BASE_URL ?>/css/style.css">
</head>
<body>
    <header class="cabecalho">
        <div class="container">
            <h1 class="logo">
                <a href="<?= APP_BASE_URL ?>/expedicoes"><?= APP_NOME ?></a>
            </h1>
            <nav class="navegacao">
                <ul>
                    <li><a href="<?= APP_BASE_URL ?>/expedicoes">Expedições</a></li>
                    <li><a href="<?= APP_BASE_URL ?>/expedicoes/criar" class="btn btn-primary">Nova Expedição</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="conteudo">
        <div class="container">
            <?php if (isset($erros) && !empty($erros)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($erros as $erro): ?>
                            <li><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?= $conteudo ?? '' ?>
        </div>
    </main>

    <footer class="rodape">
        <div class="container">
            <p>&copy; <?= date('Y') ?> <?= APP_NOME ?> - Todos os direitos reservados</p>
        </div>
    </footer>

    <script src="<?= APP_BASE_URL ?>/js/app.js"></script>
</body>
</html>
