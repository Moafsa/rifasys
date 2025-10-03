# 🎯 RAFE - Plataforma de Rifas Solidárias

Uma plataforma completa para criação, gerenciamento e participação em rifas solidárias, desenvolvida com Laravel e Docker.

## 🚀 Funcionalidades Principais

### ✨ Para Participantes
- **Marketplace de Rifas**: Explore e filtre rifas por localização, preço e categoria
- **Seleção Inteligente**: Sistema de seleção individual e em grupo de números
- **Carrinho de Compras**: Gerencie suas compras antes do checkout
- **Verificação por Email**: Sistema seguro de verificação Gmail
- **Recuperação de Senha**: Reset de senha com links seguros

### 🏢 Para Organizadores
- **Criação de Rifas**: Interface completa para criar rifas personalizadas
- **Gestão de Números**: Controle total sobre disponibilidade de números
- **Relatórios**: Acompanhe vendas e progresso das rifas
- **Perfil Completo**: Mostre credibilidade e histórico

### 🛡️ Segurança
- **Autenticação Robusta**: Login seguro com verificação obrigatória
- **Links de Verificação**: Sistema de links com expiração de 3 minutos
- **Validação de Dados**: Verificação completa de entrada de dados
- **Middleware de Segurança**: Proteção contra ataques comuns

## 🏗️ Tecnologias Utilizadas

- **Backend**: Laravel 11
- **Frontend**: Blade Templates + Tailwind CSS
- **Banco de Dados**: PostgreSQL
- **Containerização**: Docker & Docker Compose
- **Email**: Gmail SMTP
- **Autenticação**: Laravel Auth + Verificação por Email

## 📦 Instalação e Configuração

### Pré-requisitos
- Docker e Docker Compose
- Git

### 1. Clone o Repositório
```bash
git clone https://github.com/Moafsa/rifasys.git
cd rifasys
```

### 2. Configuração do Ambiente
```bash
# Copie o arquivo de exemplo
cp .env.example .env

# Configure as variáveis de ambiente (veja seção abaixo)
```

### 3. Inicialização com Docker
```bash
# Inicie os serviços
docker-compose up -d

# Execute as migrações
docker-compose exec app php artisan migrate

# Execute os seeders
docker-compose exec app php artisan db:seed

# Limpe os caches
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
```

### 4. Acesse a Aplicação
```
http://localhost:8082
```

## ⚙️ Configuração de Email

Para usar o sistema de verificação por email, configure no `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-de-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="seu-email@gmail.com"
MAIL_FROM_NAME="RAFE - Plataforma de Rifas"
```

**Importante**: Use uma senha de aplicativo do Gmail, não sua senha regular.

## 🎮 Como Usar

### Para Participantes

1. **Cadastro**: Crie sua conta na plataforma
2. **Verificação**: Verifique seu email através do link enviado
3. **Explorar**: Navegue pelo marketplace de rifas
4. **Selecionar**: Use a seleção em grupo para números (ex: 130-140, 150-200)
5. **Comprar**: Finalize sua compra no carrinho

### Para Organizadores

1. **Criar Rifa**: Acesse o painel organizador
2. **Configurar**: Defina preços, prêmios e regras
3. **Gerenciar**: Acompanhe vendas e progresso
4. **Finalizar**: Conduza o sorteio quando necessário

## 🗂️ Estrutura do Projeto

```
rifasys/
├── app/
│   ├── Http/Controllers/     # Controllers da aplicação
│   ├── Models/              # Models Eloquent
│   └── Middleware/          # Middlewares personalizados
├── database/
│   ├── migrations/          # Migrações do banco
│   └── seeders/            # Seeders com dados iniciais
├── resources/views/         # Templates Blade
├── routes/                 # Definição de rotas
├── docker/                 # Configurações Docker
└── public/                 # Arquivos públicos
```

## 🔧 Funcionalidades Técnicas

### Seleção de Números em Grupo
- **Formato**: `130-140, 150-200, 300`
- **Validação**: Verifica limites da rifa e números vendidos
- **Interface**: Sistema tipo cinema para seleção visual

### Sistema de Verificação
- **Links Seguros**: Expiração automática em 3 minutos
- **Confirmação**: Interface "É você?" para validação
- **Integração**: Gmail SMTP para entrega confiável

### Filtros Avançados
- **Localização**: Estados e cidades do Brasil
- **Preço**: Faixas de valor personalizáveis
- **Categoria**: Filtros por tipo de rifa

## 🤝 Contribuição

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📝 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para detalhes.

## 📞 Suporte

Para suporte ou dúvidas:
- Abra uma [Issue](https://github.com/Moafsa/rifasys/issues)
- Entre em contato através do sistema de contato da plataforma

## 🎯 Roadmap

- [ ] Sistema de pagamento integrado
- [ ] Dashboard avançado para organizadores
- [ ] Sistema de notificações push
- [ ] API REST para integração
- [ ] App mobile
- [ ] Sistema de avaliações
- [ ] Chat em tempo real

---

**Desenvolvido com ❤️ para conectar pessoas através de rifas solidárias**