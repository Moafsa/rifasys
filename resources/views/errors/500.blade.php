<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro Interno - RAFE</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 60px 40px;
            text-align: center;
            max-width: 600px;
            width: 100%;
        }
        
        .error-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }
        
        .error-code {
            font-size: 3rem;
            font-weight: bold;
            color: #dc3545;
            margin-bottom: 10px;
        }
        
        .error-title {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 15px;
        }
        
        .error-message {
            color: #666;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        .error-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: left;
        }
        
        .error-details h3 {
            color: #dc3545;
            margin-bottom: 10px;
        }
        
        .error-details p {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }
        
        .error-details code {
            background: #e9ecef;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 0.8rem;
        }
        
        .actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: #667eea;
            color: white;
        }
        
        .btn-primary:hover {
            background: #5a6fd8;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        
        .support-info {
            background: #e3f2fd;
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
            border-left: 4px solid #2196f3;
        }
        
        .support-info h3 {
            color: #1976d2;
            margin-bottom: 10px;
        }
        
        .support-info p {
            color: #666;
            font-size: 0.9rem;
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 40px 20px;
            }
            
            .actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-icon">⚠️</div>
        <div class="error-code">500</div>
        <h1 class="error-title">Erro Interno do Servidor</h1>
        <p class="error-message">
            Ops! Algo deu errado no nosso servidor. Nossa equipe foi notificada 
            e está trabalhando para resolver o problema.
        </p>
        
        @if(isset($error) && config('app.debug'))
            <div class="error-details">
                <h3>🔍 Detalhes do Erro (Modo Debug)</h3>
                <p><strong>Erro:</strong> <code>{{ $error }}</code></p>
                <p><strong>Timestamp:</strong> {{ $timestamp ?? now()->toDateTimeString() }}</p>
                <p><strong>Ambiente:</strong> {{ config('app.env') }}</p>
            </div>
        @endif
        
        <div class="actions">
            <button class="btn btn-primary" onclick="retryRequest()">🔄 Tentar Novamente</button>
            <a href="/" class="btn btn-secondary">🏠 Voltar ao Início</a>
        </div>
        
        <div class="support-info">
            <h3>🆘 Precisa de Ajuda?</h3>
            <p>
                Se o problema persistir, entre em contato conosco pelo WhatsApp 
                ou envie um email para suporte@rafe.com
            </p>
        </div>
    </div>
    
    <script>
        function retryRequest() {
            // Try to reload the page
            window.location.reload();
        }
        
        // Auto-retry after 10 seconds
        setTimeout(() => {
            if (confirm('Deseja tentar carregar a página novamente?')) {
                window.location.reload();
            }
        }, 10000);
    </script>
</body>
</html>