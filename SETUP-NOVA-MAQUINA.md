# 🖥️ Setup em Nova Máquina

## 📋 Checklist para Começar a Trabalhar

### 1. Pré-requisitos
- [ ] Docker Desktop instalado
- [ ] Git instalado
- [ ] Editor de código (VS Code recomendado)

### 2. Clone do Repositório
```bash
git clone https://github.com/Moafsa/rifasys.git
cd rifasys
```

### 3. Configuração do Ambiente
```bash
# Copie o arquivo de exemplo
cp .env.example .env

# Edite o .env com suas configurações locais
# (veja seção de configuração abaixo)
```

### 4. Inicialização dos Serviços
```bash
# Inicie o Docker
docker-compose up -d

# Aguarde os serviços subirem (pode demorar alguns minutos)
docker-compose ps
```

### 5. Configuração do Banco de Dados
```bash
# Execute as migrações
docker-compose exec app php artisan migrate

# Execute os seeders (dados iniciais)
docker-compose exec app php artisan db:seed

# Limpe os caches
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
```

### 6. Verificação
```bash
# Acesse a aplicação
http://localhost:8082

# Verifique se está funcionando
curl http://localhost:8082
```

## ⚙️ Configuração do .env

### Configurações Essenciais
```env
APP_NAME="RAFE"
APP_ENV=local
APP_KEY=base64:SUA_APP_KEY_AQUI
APP_DEBUG=true
APP_URL=http://localhost:8082

# Banco de dados (já configurado para Docker)
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=rifassys
DB_USERNAME=postgres
DB_PASSWORD=postgres

# Email (configure com suas credenciais)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-de-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="seu-email@gmail.com"
MAIL_FROM_NAME="RAFE - Plataforma de Rifas"
```

## 🚀 Comandos Úteis

### Desenvolvimento
```bash
# Ver logs em tempo real
docker-compose logs -f app

# Entrar no container da aplicação
docker-compose exec app bash

# Executar comandos Artisan
docker-compose exec app php artisan [comando]

# Rebuild dos containers
docker-compose down
docker-compose up -d --build
```

### Git
```bash
# Verificar status
git status

# Pull das últimas mudanças
git pull origin main

# Criar nova branch
git checkout -b feature/nova-funcionalidade

# Commit e push
git add .
git commit -m "Descrição da mudança"
git push origin feature/nova-funcionalidade
```

## 🔧 Troubleshooting

### Problema: Container não sobe
```bash
# Verifique se Docker está rodando
docker --version

# Limpe containers antigos
docker-compose down
docker system prune -f
docker-compose up -d
```

### Problema: Erro de permissão
```bash
# No Linux/Mac, ajuste permissões
sudo chown -R $USER:$USER .
chmod -R 755 storage bootstrap/cache
```

### Problema: Banco não conecta
```bash
# Verifique se PostgreSQL está rodando
docker-compose ps postgres

# Reinicie o banco
docker-compose restart postgres
```

### Problema: Cache antigo
```bash
# Limpe todos os caches
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
```

## 📝 Workflow de Desenvolvimento

### 1. Antes de Começar
```bash
git pull origin main
```

### 2. Criar Nova Feature
```bash
git checkout -b feature/minha-feature
```

### 3. Desenvolver e Testar
- Faça suas alterações
- Teste localmente em `http://localhost:8082`
- Execute testes se necessário

### 4. Commit e Push
```bash
git add .
git commit -m "feat: descrição da feature"
git push origin feature/minha-feature
```

### 5. Pull Request
- Vá para GitHub
- Crie Pull Request
- Aguarde review e merge

## 🎯 Estrutura de Branches

- `main`: Branch principal (produção)
- `feature/*`: Novas funcionalidades
- `bugfix/*`: Correções de bugs
- `hotfix/*`: Correções urgentes

## 📞 Suporte

Se encontrar problemas:
1. Verifique este documento
2. Consulte o README.md principal
3. Abra uma issue no GitHub
4. Entre em contato com a equipe

---

**Boa sorte no desenvolvimento! 🚀**
