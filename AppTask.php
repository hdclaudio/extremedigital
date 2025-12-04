/**
 * AppTask
 * 
 * Classe responsável pelo gerenciamento de tarefas e autenticação de usuários.
 * Implementa funcionalidades de login, logout, criação, conclusão, exclusão e listagem de tarefas.
 * 
 * @package ExtremeDigital
 * @version 1.0.0
 */

// Inicia a sessão PHP
session_start();

/**
 * Construtor da classe AppTask
 * 
 * Inicializa a sessão PHP necessária para manter o estado de autenticação do usuário.
 * 
 * @return void
 */
public function __construct() {
    // Inicializa a sessão
}

/**
 * Autentica um usuário através de email e senha
 * 
 * Valida as credenciais do usuário contra a lista de usuários registrados.
 * Se as credenciais forem válidas, cria uma sessão e retorna redirecionamento para dashboard.
 * 
 * @param string $email Email do usuário
 * @param string $password Senha do usuário
 * 
 * @return array Array associativo contendo:
 *               - 'success' (bool): Indica se a autenticação foi bem-sucedida
 *               - 'redirect' (string): URL para redirecionamento em caso de sucesso
 *               - 'message' (string): Mensagem de erro em caso de falha
 */
public function login($email, $password) {
    // Lógica de autenticação
}

/**
 * Encerra a sessão do usuário autenticado
 * 
 * Destrói a sessão PHP e limpa o usuário atual do contexto da aplicação.
 * 
 * @return void
 */
public function logout() {
    // Lógica para encerrar a sessão
}

/**
 * Cria uma nova tarefa para o usuário autenticado
 * 
 * Valida se o usuário está autenticado antes de criar a tarefa.
 * Atribui um ID único, timestamp de criação e status inicial "Pendente".
 * 
 * @param string $name Nome da tarefa
 * @param string $description Descrição detalhada da tarefa
 * 
 * @return array Array associativo contendo:
 *               - 'success' (bool): Indica se a tarefa foi criada com sucesso
 *               - 'task' (array): Dados da tarefa criada em caso de sucesso
 *               - 'message' (string): Mensagem de erro em caso de falha
 */
public function createTask($name, $description) {
    // Lógica para criar uma nova tarefa
}

/**
 * Marca uma tarefa como concluída
 * 
 * Localiza a tarefa pelo ID e altera seu status para "Concluída".
 * 
 * @param string $taskId ID único da tarefa a ser concluída
 * 
 * @return array Array associativo contendo:
 *               - 'success' (bool): Indica se a tarefa foi concluída com sucesso
 *               - 'message' (string): Mensagem de erro em caso de falha
 */
public function completeTask($taskId) {
    // Lógica para marcar a tarefa como concluída
}

/**
 * Deleta uma tarefa existente
 * 
 * Remove permanentemente a tarefa do array de tarefas baseado em seu ID.
 * 
 * @param string $taskId ID único da tarefa a ser deletada
 * 
 * @return array Array associativo contendo:
 *               - 'success' (bool): Indica se a tarefa foi deletada com sucesso
 *               - 'message' (string): Mensagem de erro em caso de falha
 */
public function deleteTask($taskId) {
    // Lógica para deletar a tarefa
}

/**
 * Retorna todas as tarefas registradas
 * 
 * Lista completa de tarefas armazenadas na memória da aplicação.
 * 
 * @return array Array de tarefas contendo todos os dados de cada uma
 */
public function getTasks() {
    // Lógica para obter todas as tarefas
}

/**
 * Verifica se o usuário está autenticado
 * 
 * Valida se existe uma sessão de usuário ativa.
 * 
 * @return bool True se o usuário está autenticado, false caso contrário
 */
public function isAuthenticated() {
    // Lógica para verificar autenticação
}

// Código para processar ações do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura a ação do formulário
    $action = $_POST['action'] ?? '';

    // Processa o login
    if ($action === 'login') {
        $result = $app->login($_POST['email'] ?? '', $_POST['password'] ?? '');
        if ($result['success']) {
            header('Location: ' . $result['redirect']);
            exit;
        }
        $message = $result['message'];
    }

    // Processa o logout
    if ($action === 'logout') {
        $app->logout();
        header('Location: /');
        exit;
    }

    // Cria uma nova tarefa
    if ($action === 'create_task' && $app->isAuthenticated()) {
        $result = $app->createTask($_POST['name'] ?? '', $_POST['description'] ?? '');
        $message = $result['success'] ? 'Tarefa criada!' : $result['message'];
    }

    // Marca uma tarefa como concluída
    if ($action === 'complete_task' && $app->isAuthenticated()) {
        $result = $app->completeTask($_POST['task_id'] ?? '');
        $message = $result['success'] ? 'Tarefa concluída!' : $result['message'];
    }

    // Deleta uma tarefa
    if ($action === 'delete_task' && $app->isAuthenticated()) {
        $result = $app->deleteTask($_POST['task_id'] ?? '');
        $message = $result['success'] ? 'Tarefa deletada!' : $result['message'];
    }
}

// Obtém todas as tarefas e verifica autenticação
$tasks = $app->getTasks();
$isAuth = $app->isAuthenticated();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AppTask - Gerenciador de Tarefas</title>
    <style>
        /* Estilos para a página */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 800px; margin: 20px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        input, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
        textarea { resize: vertical; min-height: 80px; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; margin-right: 10px; }
        button:hover { background: #0056b3; }
        .logout-btn { background: #dc3545; }
        .logout-btn:hover { background: #c82333; }
        .message { padding: 10px; margin-bottom: 20px; border-radius: 4px; }
        .message.success { background: #d4edda; color: #155724; }
        .message.error { background: #f8d7da; color: #721c24; }
        .login-form { max-width: 400px; }
        .task-item { border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 4px; }
        .task-item.completed { background: #e8f5e9; }
        .task-status { display: inline-block; padding: 5px 10px; border-radius: 3px; font-size: 12px; font-weight: bold; }
        .status-pendente { background: #fff3cd; color: #856404; }
        .status-concluida { background: #d4edda; color: #155724; }
        .task-actions { margin-top: 10px; }
        .task-actions button { margin-right: 5px; padding: 8px 15px; font-size: 12px; }
        .complete-btn { background: #28a745; }
        .complete-btn:hover { background: #218838; }
        .delete-btn { background: #dc3545; }
        .delete-btn:hover { background: #c82333; }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!$isAuth): ?>
            <h1>📋 AppTask - Login</h1>
            <?php if ($message): ?>
                <div class="message error"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <form method="POST" class="login-form">
                <input type="hidden" name="action" value="login">
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Senha:</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit">Entrar</button>
            </form>
        <?php else: ?>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <h1>📋 AppTask - Dashboard</h1>
                <form method="POST" style="margin: 0;">
                    <input type="hidden" name="action" value="logout">
                    <button type="submit" class="logout-btn">Sair</button>
                </form>
            </div>

            <?php if ($message): ?>
                <div class="message success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <h2 style="margin-top: 30px; margin-bottom: 15px;">➕ Nova Tarefa</h2>
            <form method="POST">
                <input type="hidden" name="action" value="create_task">
                <div class="form-group">
                    <label>Nome da Tarefa:</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Descrição:</label>
                    <textarea name="description" required></textarea>
                </div>
                <button type="submit">Criar Tarefa</button>
            </form>

            <h2 style="margin-top: 30px; margin-bottom: 15px;">📝 Minhas Tarefas</h2>
            <?php if (count($tasks) > 0): ?>
                <?php foreach ($tasks as $task): ?>
                    <div class="task-item <?php echo $task['status'] === 'Concluída' ? 'completed' : ''; ?>">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div>
                                <h3><?php echo htmlspecialchars($task['name']); ?></h3>
                                <p><?php echo htmlspecialchars($task['description']); ?></p>
                                <small style="color: #999;"><?php echo $task['created_at']; ?></small><br>
                                <span class="task-status status-<?php echo strtolower(str_replace('á', 'a', $task['status'])); ?>">
                                    <?php echo $task['status']; ?>
                                </span>
                            </div>
                        </div>
                        <div class="task-actions">
                            <?php if ($task['status'] !== 'Concluída'): ?>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="complete_task">
                                    <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                    <button type="submit" class="complete-btn">✓ Concluir</button>
                                </form>
                            <?php endif; ?>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="delete_task">
                                <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                <button type="submit" class="delete-btn">🗑️ Deletar</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: #999;">Nenhuma tarefa criada ainda.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>