<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinição de Senha - RAFE</title>
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
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
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
        
        .title {
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
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
            border: 2px solid #fecaca;
        }
        
        .code-label {
            font-size: 14px;
            color: #991b1b;
            margin-bottom: 15px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .reset-code {
            font-size: 48px;
            font-weight: bold;
            color: #ef4444;
            letter-spacing: 8px;
            margin: 20px 0;
            text-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);
            background: linear-gradient(135deg, #ef4444, #dc2626);
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
        
        .instructions ol {
            color: #78350f;
            font-size: 14px;
            line-height: 1.5;
            padding-left: 20px;
        }
        
        .instructions li {
            margin-bottom: 8px;
        }
        
        .warning-notice {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 20px;
            margin: 30px 0;
            text-align: center;
        }
        
        .warning-notice .icon {
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .warning-notice .title {
            color: #991b1b;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .warning-notice .text {
            font-size: 14px;
            color: #7f1d1d;
            line-height: 1.5;
        }
        
        .security-info {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 10px;
            padding: 20px;
            margin: 30px 0;
        }
        
        .security-info h4 {
            color: #0369a1;
            font-size: 16px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .security-info ul {
            color: #075985;
            font-size: 14px;
            line-height: 1.5;
            padding-left: 20px;
        }
        
        .security-info li {
            margin-bottom: 5px;
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
        
        .support-info {
            background: #f3f4f6;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            font-size: 14px;
            color: #6b7280;
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
            
            .reset-code {
                font-size: 36px;
                letter-spacing: 6px;
            }
            
            .title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">🔐 RAFE</div>
            <div class="tagline">Redefinição de Senha</div>
        </div>
        
        <div class="content">
            <h1 class="title">Redefinir sua Senha</h1>
            
            <p class="message">
                Olá <strong>{{ $user->name }}</strong>!<br>
                Recebemos uma solicitação para redefinir a senha da sua conta RAFE. Se você fez esta solicitação, use o código abaixo.
            </p>
            
            <div class="code-container">
                <div class="code-label">Código de Redefinição</div>
                <div class="reset-code">{{ $resetCode }}</div>
                <div class="code-label">Digite este código na página de redefinição</div>
            </div>
            
            <div class="instructions">
                <h3>📋 Como redefinir sua senha:</h3>
                <ol>
                    <li>Acesse a página de redefinição de senha do RAFE</li>
                    <li>Digite seu email: <strong>{{ $user->email }}</strong></li>
                    <li>Digite o código: <strong>{{ $resetCode }}</strong></li>
                    <li>Crie uma nova senha segura</li>
                    <li>Confirme a nova senha</li>
                    <li>Clique em "Redefinir Senha"</li>
                </ol>
            </div>
            
            <div class="warning-notice">
                <div class="icon">⚠️</div>
                <div class="title">Importante</div>
                <div class="text">
                    Este código expira em <strong>3 minutos</strong> por segurança.<br>
                    Se você não solicitou esta redefinição, ignore este email.
                </div>
            </div>
            
            <div class="security-info">
                <h4>🛡️ Dicas de Segurança:</h4>
                <ul>
                    <li>Use uma senha com pelo menos 8 caracteres</li>
                    <li>Combine letras maiúsculas, minúsculas, números e símbolos</li>
                    <li>Não use informações pessoais na senha</li>
                    <li>Não compartilhe sua senha com ninguém</li>
                </ul>
            </div>
        </div>
        
        <div class="footer">
            <p class="footer-text">
                <strong>RAFE - Plataforma de Rifas Solidárias</strong><br>
                Sua segurança é nossa prioridade
            </p>
            
            <div class="support-info">
                <strong>Precisa de ajuda?</strong><br>
                Se você não solicitou esta redefinição ou está com dificuldades, entre em contato conosco através do suporte.
            </div>
            
            <div class="copyright">
                © 2024 RAFE. Todos os direitos reservados.<br>
                Este é um email automático, não responda.
            </div>
        </div>
    </div>
</body>
</html>