<!-- Estrutura HTML5 com declaração de idioma português -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Configurações de codificação e responsividade -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Teste</title>
    
    <!-- Estilos CSS para layout e aparência visual -->
    <style>
        /* Body em flexbox centralizado, altura 100% da viewport, gradiente de fundo */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        /* Container centralizado com fundo branco, padding e sombra */
        .container {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        /* Título com cor cinza escuro */
        h1 {
            color: #333;
            margin: 0;
        }
        
        /* Parágrafo com cor cinza e fonte maior */
        p {
            color: #666;
            font-size: 18px;
        }
        
        /* Botão estilizado */
        .btn-follow {
            margin-top: 20px;
            padding: 10px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .btn-follow:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<!-- Body renderiza a página com a mensagem e saudação personalizadas -->
<body>
    <div class="container">
        <h1><?php echo isset($message) ? $message : "Bem-vindo"; ?></h1>
        <p><?php echo isset($name) ? "Olá, " . $name . "!" : "Olá, visitante!"; ?></p>
        <button class="btn-follow" onclick="window.location.href='AppTask.php'">Seguir</button>
    </div>
</body>
</html>