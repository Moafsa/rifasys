<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Email - RAFE</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
            padding: 20px;
        }
        
        .email-container {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: #8b5cf6;
            padding: 30px 20px;
            text-align: center;
            color: white;
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 8px;
        }
        
        .tagline {
            font-size: 14px;
            opacity: 0.9;
            font-weight: 300;
        }
        
        .content {
            padding: 30px 20px;
            text-align: center;
        }
        
        .title {
            font-size: 20px;
            color: #1f2937;
            margin-bottom: 16px;
            font-weight: 600;
        }
        
        .message {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.5;
            margin-bottom: 24px;
        }
        
        .button-container {
            margin: 24px 0;
        }
        
        .verify-button {
            display: inline-block;
            background: #8b5cf6;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            transition: background 0.2s ease;
        }
        
        .verify-button:hover {
            background: #7c3aed;
        }
        
        .notice {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 6px;
            padding: 16px;
            margin: 20px 0;
            text-align: left;
        }
        
        .notice-title {
            color: #92400e;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .notice-text {
            color: #78350f;
            font-size: 13px;
            line-height: 1.4;
        }
        
        .footer {
            background: #f8fafc;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        
        .footer-text {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 8px;
        }
        
        .copyright {
            font-size: 11px;
            color: #9ca3af;
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
            }
            
            .header, .content, .footer {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">RAFE</div>
            <div class="tagline">Plataforma de Rifas</div>
        </div>
        
        <div class="content">
            <h1 class="title">Bem-vindo à RAFE!</h1>
            
            <p class="message">
                Olá <strong>{{ $user->name }}</strong>!<br>
                Clique no botão abaixo para verificar seu email e ativar sua conta.
            </p>
            
            <div class="button-container">
                <a href="{{ $verificationLink }}" class="verify-button">
                    Verificar Email
                </a>
            </div>
            
            <div class="notice">
                <div class="notice-title">Importante</div>
                <div class="notice-text">
                    Este link expira em 3 minutos por segurança. Se você não se cadastrou na RAFE, ignore este email.
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p class="footer-text">
                RAFE - Plataforma de Rifas Solidárias
            </div>
            
            <div class="copyright">
                © 2024 RAFE. Todos os direitos reservados.
            </div>
        </div>
    </div>
</body>
</html>