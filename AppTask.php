<?php
// Caminho do arquivo JSON
$arquivo = "dados.json";

// Se não existir, cria com estrutura vazia
if (!file_exists($arquivo)) {
    file_put_contents($arquivo, json_encode([]));
}

// Lê o JSON e transforma em array
$tarefas = json_decode(file_get_contents($arquivo), true);

// Criar tarefa
if (isset($_POST['acao']) && $_POST['acao'] === 'criar') {
    $nova = [
        "id" => time(),
        "nome" => $_POST['nome'],
        "descricao" => $_POST['descricao'],
        "status" => "Pendente"
    ];
    $tarefas[] = $nova;

    file_put_contents($arquivo, json_encode($tarefas, JSON_PRETTY_PRINT));
    header("Location: index.php");
    exit;
}

// Concluir tarefa
if (isset($_GET['concluir'])) {
    foreach ($tarefas as &$tarefa) {
        if ($tarefa["id"] == $_GET['concluir']) {
            $tarefa["status"] = "Concluída";
        }
    }
    file_put_contents($arquivo, json_encode($tarefas, JSON_PRETTY_PRINT));
    header("Location: index.php");
    exit;
}

// Excluir tarefa
if (isset($_GET['excluir'])) {
    $tarefas = array_filter($tarefas, function($tarefa) {
        return $tarefa["id"] != $_GET['excluir'];
    });

    file_put_contents($arquivo, json_encode(array_values($tarefas), JSON_PRETTY_PRINT));
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciador de Tarefas</title>
    <style>
        body { font-family: Arial; max-width: 600px; margin: 20px auto; }
        .card { padding: 10px; border: 1px solid #ccc; margin-bottom: 10px; border-radius: 5px; }
        .btn { padding: 5px 10px; text-decoration: none; border: 1px solid #000; border-radius: 3px; margin-right: 5px; }
        .pendente { color: orange; font-weight: bold; }
        .concluida { color: green; font-weight: bold; }
    </style>
</head>
<body>

<h2>Criar Nova Tarefa</h2>

<form method="POST">
    <input type="hidden" name="acao" value="criar">

    <label>Nome da tarefa:</label><br>
    <input type="text" name="nome" required><br><br>

    <label>Descrição:</label><br>
    <textarea name="descricao" required></textarea><br><br>

    <button type="submit">Criar</button>
</form>

<hr>

<h2>Lista de Tarefas</h2>

<?php if (count($tarefas) == 0): ?>
    <p>Nenhuma tarefa cadastrada.</p>
<?php endif; ?>

<?php foreach ($tarefas as $tarefa): ?>
<div class="card">
    <strong><?= $tarefa["nome"] ?></strong><br>
    <small><?= $tarefa["descricao"] ?></small><br><br>

    Status: 
    <?php if ($tarefa["status"] === "Pendente"): ?>
        <span class="pendente">Pendente</span>
    <?php else: ?>
        <span class="concluida">Concluída</span>
    <?php endif; ?>
    <br><br>

    <?php if ($tarefa["status"] === "Pendente"): ?>
        <a class="btn" href="?concluir=<?= $tarefa['id'] ?>">Concluir</a>
    <?php endif; ?>

    <a class="btn" href="?excluir=<?= $tarefa['id'] ?>" style="color:red;">Excluir</a>
</div>
<?php endforeach; ?>

</body>
</html>
