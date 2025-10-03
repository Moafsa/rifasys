# Guia de Início Rápido - Rifassys

Este guia irá ajudá-lo a configurar e executar o projeto Rifassys em poucos minutos.

## ⚡ Início Rápido (5 minutos)

### Passo 1: Pré-requisitos

Certifique-se de ter instalado:
- ✅ Docker Desktop (rodando)
- ✅ Git

### Passo 2: Clone e Configure

```bash
# Clone o repositório
git clone https://github.com/seu-usuario/rifassys.git
cd rifassys

# Copie o arquivo de ambiente
cp .env.example .env
```

### Passo 3: Configure Variáveis Mínimas

Edite o arquivo `.env` e configure pelo menos estas variáveis:

```env
# OpenAI (obrigatório para IA)
OPENAI_API_KEY=sk-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

# Asaas (obrigatório para pagamentos)
ASAAS_API_KEY=seu_api_key_aqui
ASAAS_ENVIRONMENT=sandbox
```

> 💡 **Dica:** Para testes iniciais, você pode usar chaves de sandbox/teste.

### Passo 4: Inicie os Servidores

**Windows:**
```bash
start-servers.bat
```

**Linux/Mac:**
```bash
chmod +x start-servers.sh
./start-servers.sh
```

### Passo 5: Acesse a Aplicação

Aguarde alguns segundos e acesse:
- 🌐 **Frontend:** http://localhost:8080
- 📊 **Dashboard:** http://localhost:8080/dashboard
- 👨‍💼 **Admin:** http://localhost:8080/admin

---

## 🔑 Credenciais Padrão

Após executar os seeders, você terá estas contas de teste:

### Administrador
- **Email:** admin@rifassys.com
- **Senha:** password

### Organizador CPF
- **Email:** organizador.cpf@teste.com
- **Senha:** password

### Organizador CNPJ
- **Email:** organizador.cnpj@teste.com
- **Senha:** password

---

## 📋 Checklist de Configuração Completa

Para ter todas as funcionalidades operacionais:

### 1. Asaas (Pagamentos) ✅

1. Acesse https://sandbox.asaas.com/
2. Crie uma conta de teste
3. Vá em **Integrações** → **API**
4. Copie sua **API Key**
5. Cole no `.env`:
   ```env
   ASAAS_API_KEY=sua_api_key_aqui
   ASAAS_ENVIRONMENT=sandbox
   ```

### 2. OpenAI (IA) ✅

1. Acesse https://platform.openai.com/
2. Crie uma conta ou faça login
3. Vá em **API Keys**
4. Crie uma nova chave
5. Cole no `.env`:
   ```env
   OPENAI_API_KEY=sk-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
   OPENAI_MODEL=gpt-4
   ```

### 3. Wuzapi (WhatsApp) 📱

1. Acesse http://localhost:8081 após iniciar os containers
2. Escaneie o QR Code com o WhatsApp:
   - Abra o WhatsApp no celular
   - Vá em **Configurações** → **Aparelhos Conectados**
   - Toque em **Conectar um aparelho**
   - Escaneie o QR Code
3. Aguarde a conexão

> ⚠️ **Importante:** Use um número de teste, não seu número pessoal!

### 4. E-mail (Opcional)

Para testes locais, use Mailtrap ou MailHog:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=seu_username
MAIL_PASSWORD=sua_password
```

---

## 🧪 Testando o Sistema

### Teste 1: Criar uma Rifa

1. Faça login como organizador
2. Vá em **Dashboard** → **Criar Nova Rifa**
3. Preencha:
   - Título: "Rifa de Teste"
   - Descrição: "Teste do sistema"
   - Upload uma imagem
   - Total de números: 100
   - Valor por número: R$ 5,00
   - Data do sorteio: Amanhã às 20h
4. Clique em **Gerar Regulamento com IA** (se configurou OpenAI)
5. Publique a rifa

### Teste 2: Comprar um Número

1. Abra uma aba anônima
2. Acesse a landing page da rifa: http://localhost:8080/rifa/rifa-de-teste
3. Selecione alguns números
4. Clique em **Comprar Agora**
5. Preencha os dados:
   - Nome: Teste Silva
   - CPF: 111.111.111-11 (qualquer CPF válido para testes)
   - WhatsApp: (11) 99999-9999
6. Copie o código PIX
7. No Asaas Sandbox, simule o pagamento

### Teste 3: Simular Pagamento no Asaas Sandbox

1. Acesse https://sandbox.asaas.com/
2. Faça login
3. Vá em **Cobranças**
4. Localize a cobrança criada
5. Clique em **Simular Pagamento**
6. Confirme

O webhook será disparado e os números serão confirmados!

### Teste 4: Chatbot

1. Na landing page da rifa, clique no ícone do chat (canto inferior direito)
2. Digite: "Qual é o prêmio?"
3. A IA responderá com base nas informações da rifa

---

## 🛠️ Comandos Úteis

### Ver Logs em Tempo Real

```bash
# Logs da aplicação
docker-compose logs -f app

# Logs do queue worker
docker-compose logs -f queue

# Logs do nginx
docker-compose logs -f nginx
```

### Executar Comandos Artisan

```bash
# Limpar cache
docker-compose exec app php artisan cache:clear

# Executar migrations
docker-compose exec app php artisan migrate

# Executar seeders
docker-compose exec app php artisan db:seed

# Criar um usuário admin manualmente
docker-compose exec app php artisan make:admin
```

### Acessar o Container

```bash
# Acessar bash do container PHP
docker-compose exec app bash

# Acessar PostgreSQL
docker-compose exec postgres psql -U rifassys_user -d rifassys
```

### Queue Worker

```bash
# Iniciar worker manualmente (para debug)
docker-compose exec app php artisan queue:work --verbose

# Ver jobs pendentes
docker-compose exec app php artisan queue:monitor
```

---

## 🐛 Solucionando Problemas Comuns

### Problema: Erro 500 ao acessar a aplicação

**Solução:**
```bash
# Limpar cache e recompilar
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan view:clear
docker-compose exec app composer dump-autoload
```

### Problema: "Access denied for user" no banco de dados

**Solução:**
```bash
# Verifique as credenciais no .env
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=rifassys
DB_USERNAME=rifassys_user
DB_PASSWORD=rifassys_secure_password

# Recrie os containers
docker-compose down -v
docker-compose up -d
```

### Problema: Permissão negada em storage

**Solução:**
```bash
docker-compose exec app chmod -R 775 storage bootstrap/cache
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
```

### Problema: Assets não carregam (CSS/JS)

**Solução:**
```bash
# Recompilar assets
docker-compose exec app npm run build

# Ou para desenvolvimento
docker-compose exec app npm run dev
```

### Problema: Wuzapi não conecta

**Soluções:**
1. Verifique se o container está rodando:
   ```bash
   docker-compose ps wuzapi
   ```
2. Acesse http://localhost:8081 e escaneie o QR Code novamente
3. Reinicie o container:
   ```bash
   docker-compose restart wuzapi
   ```

### Problema: Jobs não são processados

**Solução:**
```bash
# Verifique se o queue worker está rodando
docker-compose ps queue

# Reinicie o queue worker
docker-compose restart queue

# Ou processe jobs manualmente
docker-compose exec app php artisan queue:work
```

---

## 📊 Dados de Demonstração

Para popular o sistema com dados de exemplo:

```bash
# Executar seeder de demonstração
docker-compose exec app php artisan db:seed --class=DemoRaffleSeeder
```

Isso criará:
- 5 rifas de exemplo
- 50 participantes fictícios
- 200 compras simuladas
- Estatísticas realistas

---

## 🎯 Próximos Passos

Após ter o sistema rodando localmente:

1. **Leia a Documentação Completa**
   - [Plano de Desenvolvimento](PLANO-DESENVOLVIMENTO-RIFASSYS.md)
   - [Estrutura de Módulos](estrutura-modulos.md)

2. **Customize o Sistema**
   - Altere as cores em `tailwind.config.js`
   - Personalize os e-mails em `resources/views/emails`
   - Ajuste as taxas em `config/services.php`

3. **Prepare para Produção**
   - Configure domínio personalizado
   - Configure SSL/HTTPS
   - Configure backups automáticos
   - Configure monitoramento

4. **Integre com Serviços Reais**
   - Migre Asaas para ambiente de produção
   - Configure e-mail profissional (SMTP)
   - Configure WhatsApp Business oficial (opcional)

---

## 💡 Dicas Importantes

### Segurança

- ⚠️ **NUNCA** commite o arquivo `.env` no Git
- ⚠️ Troque todas as senhas padrão em produção
- ⚠️ Use chaves API de produção apenas em produção
- ⚠️ Habilite 2FA para contas admin

### Performance

- ✅ Use Redis para cache e sessões
- ✅ Configure CDN para assets estáticos
- ✅ Otimize imagens antes do upload
- ✅ Configure cache de queries

### Backup

- ✅ Configure backup automático do banco de dados
- ✅ Faça backup das imagens em storage
- ✅ Mantenha backups offsite
- ✅ Teste a restauração regularmente

---

## 📞 Precisa de Ajuda?

### Documentação
- [README.md](README.md) - Documentação principal
- [PLANO-DESENVOLVIMENTO-RIFASSYS.md](PLANO-DESENVOLVIMENTO-RIFASSYS.md) - Plano completo
- [estrutura-modulos.md](estrutura-modulos.md) - Estrutura detalhada

### Suporte
- **Email:** suporte@rifassys.com
- **WhatsApp:** (XX) XXXXX-XXXX

### Comunidade
- GitHub Issues: Reporte bugs e solicite features
- Discussions: Faça perguntas e compartilhe ideias

---

**Desenvolvido com ❤️ para causas sociais**


