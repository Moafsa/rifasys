<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muitas Solicitações - RAFE</title>
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
            max-width: 500px;
            width: 100%;
        }
        
        .error-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }
        
        .error-code {
            font-size: 3rem;
            font-weight: bold;
            color: #667eea;
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
        
        .retry-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        
        .retry-info h3 {
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .retry-info p {
            color: #666;
            font-size: 0.9rem;
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
        
        .countdown {
            font-size: 1.2rem;
            font-weight: bold;
            color: #667eea;
            margin-top: 20px;
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
        <div class="error-icon">⏰</div>
        <div class="error-code">429</div>
        <h1 class="error-title">Muitas Solicitações</h1>
        <p class="error-message">
            Você fez muitas solicitações em um curto período de tempo. 
            Por favor, aguarde um momento antes de tentar novamente.
        </p>
        
        <div class="retry-info">
            <h3>⏳ Aguarde um momento</h3>
            <p>Para proteger nosso sistema, limitamos o número de solicitações por minuto. 
            Tente novamente em alguns segundos.</p>
        </div>
        
        <div class="actions">
            <button class="btn btn-primary" onclick="retryRequest()">🔄 Tentar Novamente</button>
            <a href="/" class="btn btn-secondary">🏠 Voltar ao Início</a>
        </div>
        
        <div class="countdown" id="countdown">
            Você pode tentar novamente em: <span id="timer">60</span> segundos
        </div>
    </div>
    
    <script>
        let timeLeft = 60;
        const timerElement = document.getElementById('timer');
        const countdownElement = document.getElementById('countdown');
        
        const countdown = setInterval(() => {
            timeLeft--;
            timerElement.textContent = timeLeft;
            
            if (timeLeft <= 0) {
                clearInterval(countdown);
                countdownElement.innerHTML = '✅ Você pode tentar novamente agora!';
                countdownElement.style.color = '#28a745';
            }
        }, 1000);
        
        function retryRequest() {
            if (timeLeft <= 0) {
                window.location.reload();
            } else {
                alert('Aguarde ' + timeLeft + ' segundos antes de tentar novamente.');
            }
        }
        
        // Auto-retry when countdown reaches 0
        setTimeout(() => {
            if (timeLeft <= 0) {
                window.location.reload();
            }
        }, 60000);
    </script>
</body>
</html>
