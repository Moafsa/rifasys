<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de Email - RAFE</title>
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
            padding: 20px;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #8b5cf6 0%, #3b82f6 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        
        .logo {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        
        .tagline {
            font-size: 16px;
            opacity: 0.9;
            font-weight: 300;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .welcome {
            font-size: 28px;
            color: #1f2937;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
        }
        
        .message {
            font-size: 16px;
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .code-container {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
            border: 2px solid #e2e8f0;
        }
        
        .code-label {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 15px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .verification-code {
            font-size: 48px;
            font-weight: bold;
            color: #8b5cf6;
            letter-spacing: 8px;
            margin: 20px 0;
            text-shadow: 0 2px 4px rgba(139, 92, 246, 0.2);
            background: linear-gradient(135deg, #8b5cf6, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .instructions {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            margin: 30px 0;
            border-radius: 8px;
        }
        
        .instructions h3 {
            color: #92400e;
            font-size: 16px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .instructions ul {
            color: #78350f;
            font-size: 14px;
            line-height: 1.5;
            padding-left: 20px;
        }
        
        .instructions li {
            margin-bottom: 5px;
        }
        
        .security-notice {
            background: #f3f4f6;
            border-radius: 10px;
            padding: 20px;
            margin: 30px 0;
            text-align: center;
        }
        
        .security-notice .icon {
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .security-notice .text {
            font-size: 14px;
            color: #6b7280;
            font-weight: 500;
        }
        
        .footer {
            background: #f8fafc;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        
        .footer-text {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 15px;
        }
        
        .social-links {
            margin: 20px 0;
        }
        
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #8b5cf6;
            text-decoration: none;
            font-weight: 500;
        }
        
        .copyright {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 20px;
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 15px;
            }
            
            .header, .content, .footer {
                padding: 20px;
            }
            
            .verification-code {
                font-size: 36px;
                letter-spacing: 6px;
            }
            
            .welcome {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">🎯 RAFE</div>
            <div class="tagline">Plataforma de Rifas Solidárias</div>
        </div>
        
        <div class="content">
            <h1 class="welcome">Bem-vindo à RAFE!</h1>
            
            <p class="message">
                Olá <strong>{{ $user->name }}</strong>!<br>
                Obrigado por se cadastrar em nossa plataforma. Para ativar sua conta e começar a participar das melhores rifas do Brasil, você precisa verificar seu email.
            </p>
            
            <div class="code-container">
                <div class="code-label">Código de Verificação</div>
                <div class="verification-code">{{ $verificationCode }}</div>
                <div class="code-label">Digite este código na página de verificação</div>
            </div>
            
            <div class="instructions">
                <h3>📋 Como verificar seu email:</h3>
                <ul>
                    <li>Volte para a página de verificação do RAFE</li>
                    <li>Digite o código <strong>{{ $verificationCode }}</strong> no campo indicado</li>
                    <li>Clique em "Verificar Email"</li>
                    <li>Pronto! Sua conta estará ativa</li>
                </ul>
            </div>
            
            <div class="security-notice">
                <div class="icon">🔒</div>
                <div class="text">
                    <strong>Importante:</strong> Este código expira em 3 minutos por segurança.<br>
                    Não compartilhe este código com ninguém.
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p class="footer-text">
                <strong>RAFE - Plataforma de Rifas Solidárias</strong><br>
                Conectando pessoas através de rifas seguras e confiáveis
            </p>
            
            <div class="social-links">
                <a href="#">📱 App Mobile</a>
                <a href="#">💬 Suporte</a>
                <a href="#">📞 Contato</a>
            </div>
            
            <div class="copyright">
                © 2024 RAFE. Todos os direitos reservados.<br>
                Este é um email automático, não responda.
            </div>
        </div>
    </div>
</body>
</html>