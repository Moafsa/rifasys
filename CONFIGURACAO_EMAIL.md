# 📧 Configuração de Email - Sistema RAFE

## 🎯 **Conta Gmail Criada para o Sistema**

**Email:** `rafe.sistema@gmail.com`  
**Senha:** [Será configurada pelo usuário]

## 📋 **Passos para Configuração**

### **1. Criar Senha de Aplicativo no Gmail**

1. **Acesse sua conta Google:**
   - Vá para [myaccount.google.com](https://myaccount.google.com)
   - Faça login com `rafe.sistema@gmail.com`

2. **Ative a Verificação em 2 Etapas:**
   - Vá em **Segurança** → **Verificação em duas etapas**
   - Siga as instruções para ativar

3. **Crie uma Senha de Aplicativo:**
   - Vá em **Segurança** → **Senhas de aplicativo**
   - Selecione **Outro (nome personalizado)**
   - Digite: `RAFE Sistema`
   - Clique em **Gerar**
   - **COPIE a senha gerada** (16 caracteres)

### **2. Configurar o Arquivo .env**

No arquivo `.env` do projeto, configure:

```env
# Mail Configuration (Gmail SMTP)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=rafe.sistema@gmail.com
MAIL_PASSWORD=SUA_SENHA_DE_APLICATIVO_AQUI
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="rafe.sistema@gmail.com"
MAIL_FROM_NAME="RAFE - Plataforma de Rifas"
```

### **3. Testar o Envio de Email**

Execute no terminal:
```bash
docker-compose exec app php artisan tinker
```

No tinker:
```php
Mail::raw('Teste de email RAFE', function ($message) {
    $message->to('seu-email@gmail.com')
            ->subject('Teste RAFE');
});
```

## 🔧 **Funcionalidades Implementadas**

### **✅ Verificação de Email**
- **Cadastro:** Usuário recebe email de verificação
- **Login:** Bloqueado até verificar email
- **Reenvio:** Possível reenviar email de verificação
- **Expiração:** Link expira em 24 horas

### **✅ Recuperação de Senha**
- **Solicitação:** Formulário "Esqueceu a senha?"
- **Email:** Link de redefinição enviado por email
- **Segurança:** Link expira em 1 hora
- **Validação:** Senha forte obrigatória

### **✅ Templates de Email**
- **Verificação:** Design responsivo com branding RAFE
- **Recuperação:** Instruções claras e seguras
- **Mobile:** Otimizado para dispositivos móveis

## 🛡️ **Segurança**

- **Tokens únicos** para cada verificação/reset
- **Expiração automática** dos links
- **Validação de Gmail** obrigatória
- **Senhas fortes** obrigatórias
- **HTTPS** recomendado em produção

## 📱 **Fluxo do Usuário**

### **Cadastro:**
1. Usuário se cadastra
2. Recebe email de verificação
3. Clica no link do email
4. Email é verificado
5. Pode fazer login normalmente

### **Recuperação de Senha:**
1. Usuário clica "Esqueceu a senha?"
2. Digita seu email
3. Recebe link de redefinição
4. Cria nova senha
5. Pode fazer login com nova senha

## 🚀 **Próximos Passos**

1. **Configurar a senha de aplicativo Gmail**
2. **Atualizar o arquivo .env**
3. **Testar envio de emails**
4. **Verificar funcionalidades em produção**

---

**⚠️ Importante:** Mantenha a senha de aplicativo segura e nunca a compartilhe!

