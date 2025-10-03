# Lista de Tarefas - Rifassys

**Última atualização:** 01/10/2025

Este documento acompanha o progresso do desenvolvimento da Plataforma de Rifas Solidárias.

---

## 📊 Progresso Geral

- ✅ **Planejamento:** 100% (Concluído)
- ⏳ **Setup Inicial:** 0% (Pendente)
- ⏳ **Backend:** 0% (Pendente)
- ⏳ **Frontend:** 0% (Pendente)
- ⏳ **Integrações:** 0% (Pendente)
- ⏳ **Testes:** 0% (Pendente)
- ⏳ **Deploy:** 0% (Pendente)

---

## 📋 FASE 1: Preparação e Estrutura Inicial

### 1.1 Ambiente Docker
- [ ] Criar `docker-compose.yml`
- [ ] Criar `Dockerfile` para PHP
- [ ] Configurar Nginx
- [ ] Configurar PostgreSQL
- [ ] Configurar Redis
- [ ] Adicionar Wuzapi
- [ ] Testar todos os containers

### 1.2 Instalação Laravel
- [ ] Instalar Laravel 11.x
- [ ] Configurar `.env`
- [ ] Gerar APP_KEY
- [ ] Testar conexão com banco de dados
- [ ] Testar conexão com Redis

### 1.3 Pacotes Essenciais
- [ ] Instalar Laravel Breeze (autenticação)
- [ ] Instalar Spatie Sluggable
- [ ] Instalar Spatie Permissions
- [ ] Instalar Guzzle HTTP
- [ ] Instalar bibliotecas para QR Code
- [ ] Configurar Tailwind CSS
- [ ] Instalar Alpine.js
- [ ] Instalar Chart.js

---

## 📊 FASE 2: Modelagem do Banco de Dados

### 2.1 Migrations Core
- [ ] Modificar tabela `users`
- [ ] Criar tabela `user_profiles`
- [ ] Criar tabela `raffles`
- [ ] Criar tabela `raffle_numbers`
- [ ] Criar tabela `raffle_participants`
- [ ] Criar tabela `raffle_purchases`
- [ ] Criar tabela `raffle_winners`

### 2.2 Migrations Transacionais
- [ ] Criar tabela `transactions`
- [ ] Criar tabela `delivery_confirmations`

### 2.3 Migrations IA e Admin
- [ ] Criar tabela `chatbot_conversations`
- [ ] Criar tabela `ai_generated_contents`
- [ ] Criar tabela `admin_exceptions`
- [ ] Criar tabela `activity_log`

### 2.4 Executar e Validar
- [ ] Executar todas as migrations
- [ ] Verificar índices
- [ ] Testar relacionamentos
- [ ] Criar diagrama ER

---

## 🏗️ FASE 3: Models e Relacionamentos

### 3.1 Models Principais
- [ ] Criar/modificar Model `User`
- [ ] Criar Model `UserProfile`
- [ ] Criar Model `Raffle`
- [ ] Criar Model `RaffleNumber`
- [ ] Criar Model `RaffleParticipant`
- [ ] Criar Model `RafflePurchase`
- [ ] Criar Model `RaffleWinner`

### 3.2 Models Transacionais
- [ ] Criar Model `Transaction`
- [ ] Criar Model `DeliveryConfirmation`

### 3.3 Models IA e Admin
- [ ] Criar Model `ChatbotConversation`
- [ ] Criar Model `AiGeneratedContent`
- [ ] Criar Model `AdminException`

### 3.4 Relationships e Scopes
- [ ] Definir todos os relacionamentos
- [ ] Criar scopes úteis
- [ ] Criar accessors e mutators
- [ ] Testar relacionamentos

---

## 🔐 FASE 4: Autenticação e Autorização

### 4.1 Laravel Breeze
- [ ] Instalar e configurar Breeze
- [ ] Customizar views de login/registro
- [ ] Adicionar campo de tipo de documento (CPF/CNPJ)
- [ ] Implementar validação de CPF/CNPJ

### 4.2 Spatie Permissions
- [ ] Criar roles (admin, organizer)
- [ ] Criar permissions
- [ ] Criar seeder de roles e permissions
- [ ] Implementar middleware de autorização

### 4.3 Políticas
- [ ] Criar RafflePolicy
- [ ] Criar UserPolicy
- [ ] Criar TransactionPolicy
- [ ] Aplicar policies nos controllers

---

## 🎨 FASE 5: Frontend Base

### 5.1 Layout e Componentes
- [ ] Configurar Tailwind com paleta agro-green
- [ ] Criar layout principal (`layouts/app.blade.php`)
- [ ] Criar layout dashboard
- [ ] Criar layout admin
- [ ] Criar componentes reutilizáveis (button, input, card, modal)

### 5.2 Navegação
- [ ] Criar menu principal
- [ ] Criar menu dashboard
- [ ] Criar menu admin
- [ ] Implementar breadcrumbs
- [ ] Adicionar indicadores de status

---

## 🔌 FASE 6: Integrações

### 6.1 Asaas (Pagamentos)
- [ ] Criar AsaasService
- [ ] Implementar criação de clientes
- [ ] Implementar criação de cobranças PIX
- [ ] Implementar geração de QR Code
- [ ] Implementar split payment (CNPJ)
- [ ] Implementar consulta de status
- [ ] Configurar webhooks
- [ ] Testar em sandbox

### 6.2 Wuzapi (WhatsApp)
- [ ] Criar WuzapiService
- [ ] Implementar envio de mensagens
- [ ] Implementar mensagens com botões
- [ ] Configurar webhooks
- [ ] Criar templates de mensagens
- [ ] Testar conexão

### 6.3 OpenAI (IA)
- [ ] Criar OpenAIService
- [ ] Implementar geração de regulamentos
- [ ] Implementar chatbot
- [ ] Criar sistema de prompts
- [ ] Implementar rastreamento de custos
- [ ] Testar com casos reais

---

## 🎯 FASE 7: Lógica de Negócio

### 7.1 Services
- [ ] Criar RaffleService (CRUD)
- [ ] Criar NumberGeneratorService
- [ ] Criar PurchaseService
- [ ] Criar DrawService
- [ ] Criar PaymentService
- [ ] Criar CustodyService (CPF)
- [ ] Criar SplitPaymentService (CNPJ)
- [ ] Criar DeliveryConfirmationService
- [ ] Criar ChatbotService
- [ ] Criar RegulationGeneratorService

### 7.2 Jobs
- [ ] Criar ProcessConfirmedPayment
- [ ] Criar ExecuteRaffleDraw
- [ ] Criar SendDeliveryConfirmation
- [ ] Criar ReleaseCustodyFunds
- [ ] Criar SendPurchaseConfirmation
- [ ] Criar GenerateRaffleNumbers
- [ ] Criar UpdateRaffleStats
- [ ] Configurar queues no Redis

### 7.3 Commands
- [ ] Criar DrawPendingRaffles
- [ ] Criar ExpireReservedNumbers
- [ ] Criar CheckPendingPayments
- [ ] Criar ProcessDeliveryConfirmations
- [ ] Configurar scheduler

### 7.4 Events e Listeners
- [ ] Criar PaymentConfirmed event
- [ ] Criar RaffleDrawn event
- [ ] Criar PrizeDelivered event
- [ ] Criar DeliveryConfirmed event
- [ ] Implementar listeners correspondentes

---

## 🌐 FASE 8: Páginas Públicas

### 8.1 Home (/)
- [ ] Criar view da home
- [ ] Implementar grid de rifas ativas
- [ ] Criar seção "Como Funciona"
- [ ] Criar seção "Quem Somos"
- [ ] Criar seção de contato
- [ ] Otimizar performance (cache)

### 8.2 Landing Page de Rifa (/rifa/{slug})
- [ ] Criar view da landing page
- [ ] Implementar galeria de imagens
- [ ] Criar contador regressivo
- [ ] Criar grade de números interativa
- [ ] Implementar seleção de múltiplos números
- [ ] Criar bloco de compra
- [ ] Exibir descrição e regulamento
- [ ] Implementar animação de sorteio
- [ ] Exibir ganhador após sorteio

### 8.3 Checkout
- [ ] Criar modal de checkout
- [ ] Implementar formulário de dados
- [ ] Validar CPF
- [ ] Gerar QR Code PIX
- [ ] Implementar timer de expiração
- [ ] Polling de status de pagamento
- [ ] Página de confirmação

### 8.4 Chatbot
- [ ] Criar widget flutuante
- [ ] Implementar interface de chat
- [ ] Conectar com OpenAI
- [ ] Implementar contexto da rifa
- [ ] Adicionar FAQ automático
- [ ] Salvar histórico de conversas

---

## 📊 FASE 9: Dashboard do Organizador

### 9.1 Dashboard Principal (/dashboard)
- [ ] Criar view do dashboard
- [ ] Implementar cards de resumo
- [ ] Criar gráfico de vendas
- [ ] Exibir rifas ativas
- [ ] Exibir últimas compras
- [ ] Implementar filtros

### 9.2 Minhas Rifas (/dashboard/rifas)
- [ ] Criar lista de rifas
- [ ] Implementar filtros e busca
- [ ] Adicionar badges de status
- [ ] Links para ações (ver, editar, deletar)
- [ ] Botão "Criar Nova Rifa"

### 9.3 Criar Rifa (/dashboard/rifas/criar)
- [ ] Criar wizard multi-step
- [ ] Passo 1: Informações Básicas
- [ ] Passo 2: Upload de Imagens
- [ ] Passo 3: Configuração de Números
- [ ] Passo 4: Geração de Regulamento com IA
- [ ] Passo 5: Revisão e Publicação
- [ ] Validações em cada passo
- [ ] Salvar rascunho automático

### 9.4 Lista de Clientes (/dashboard/rifas/{id}/clientes)
- [ ] Criar tabela de participantes
- [ ] Implementar filtros
- [ ] Adicionar exportação CSV/Excel
- [ ] Exibir estatísticas

### 9.5 Relatório Financeiro (/dashboard/rifas/{id}/financeiro)
- [ ] Criar extrato de transações
- [ ] Implementar filtros por data
- [ ] Calcular totalizadores
- [ ] Diferenciar CPF (custódia) e CNPJ (split)
- [ ] Adicionar exportação

### 9.6 Gestão de Entrega (/dashboard/rifas/{id}/entrega)
- [ ] Criar view de entrega (apenas CPF)
- [ ] Exibir dados do ganhador
- [ ] Botão "Marcar como Entregue"
- [ ] Acompanhar status de confirmação
- [ ] Exibir histórico

### 9.7 Configurações (/dashboard/configuracoes)
- [ ] Criar formulário de perfil
- [ ] Campos específicos para CPF (Chave PIX)
- [ ] Campos específicos para CNPJ (Wallet Asaas)
- [ ] Upload de logo
- [ ] Links de redes sociais

---

## 👨‍💼 FASE 10: Painel Admin

### 10.1 Dashboard Admin (/admin/dashboard)
- [ ] Criar view do dashboard admin
- [ ] Métricas gerais da plataforma
- [ ] Gráficos de crescimento
- [ ] Alertas de exceções
- [ ] Estatísticas em tempo real

### 10.2 Gestão de Usuários (/admin/usuarios)
- [ ] Criar lista de usuários
- [ ] Implementar busca e filtros
- [ ] Ver detalhes de usuário
- [ ] Editar usuário
- [ ] Suspender/ativar usuário
- [ ] Ver histórico de atividades

### 10.3 Supervisão de Rifas (/admin/rifas)
- [ ] Criar lista de todas as rifas
- [ ] Implementar filtros avançados
- [ ] Ver detalhes completos
- [ ] Cancelar rifa (casos críticos)
- [ ] Ver logs de mudanças

### 10.4 Relatório Financeiro (/admin/financeiro)
- [ ] Criar dashboard financeiro geral
- [ ] Gráficos de receita
- [ ] Transações recentes
- [ ] Taxas cobradas
- [ ] Exportações avançadas

### 10.5 Sistema de Exceções (/admin/excecoes)
- [ ] Criar lista de exceções
- [ ] Filtrar por tipo e severidade
- [ ] Ver detalhes da exceção
- [ ] Interface de resolução
- [ ] Atribuir a outros admins
- [ ] Adicionar notas
- [ ] Histórico de resoluções

---

## 🧪 FASE 11: Testes

### 11.1 Testes Unitários
- [ ] Testar Models (relationships, scopes)
- [ ] Testar Services (métodos isolados)
- [ ] Testar Helpers e Traits
- [ ] Cobertura mínima: 70%

### 11.2 Testes de Integração
- [ ] Testar fluxo de cadastro completo
- [ ] Testar criação de rifa end-to-end
- [ ] Testar compra completa (CPF e CNPJ)
- [ ] Testar sorteio automático
- [ ] Testar confirmação de entrega
- [ ] Testar webhooks Asaas
- [ ] Testar webhooks Wuzapi

### 11.3 Testes de API
- [ ] Testar endpoints públicos
- [ ] Testar endpoints autenticados
- [ ] Testar rate limiting
- [ ] Testar validações

### 11.4 Testes de Performance
- [ ] Load test com 1000 rifas
- [ ] Load test com 100 compras simultâneas
- [ ] Testar geração de números em massa
- [ ] Otimizar queries lentas (< 100ms)

### 11.5 Testes de Segurança
- [ ] Testar CSRF protection
- [ ] Testar SQL injection
- [ ] Testar XSS
- [ ] Testar autorização em todas as rotas
- [ ] Pen testing básico

---

## 🚀 FASE 12: Deploy e Produção

### 12.1 Preparação
- [ ] Configurar variáveis de produção
- [ ] Otimizar assets
- [ ] Configurar cache agressivo
- [ ] Configurar logs
- [ ] Configurar monitoring

### 12.2 Docker para Produção
- [ ] Criar `docker-compose.prod.yml`
- [ ] Otimizar Dockerfile
- [ ] Configurar volumes persistentes
- [ ] Configurar restart policies
- [ ] Testar build de produção

### 12.3 Coolify
- [ ] Criar projeto no Coolify
- [ ] Configurar variáveis de ambiente
- [ ] Configurar domínio
- [ ] Configurar SSL/HTTPS
- [ ] Configurar backups automáticos

### 12.4 Pós-Deploy
- [ ] Executar migrations em produção
- [ ] Executar seeders (dados iniciais)
- [ ] Criar usuário admin
- [ ] Testar todas as funcionalidades
- [ ] Configurar monitoring (Sentry, etc.)
- [ ] Configurar alertas

---

## 📚 FASE 13: Documentação

### 13.1 Documentação Técnica
- [x] Plano de Desenvolvimento
- [x] Estrutura de Módulos
- [x] README.md
- [x] Guia de Início Rápido
- [ ] API Documentation (Swagger)
- [ ] Guia de Contribuição
- [ ] Changelog

### 13.2 Documentação de Usuário
- [ ] Manual do Organizador
- [ ] Manual do Administrador
- [ ] FAQ
- [ ] Vídeos tutoriais

---

## 🎉 FASE 14: Lançamento

### 14.1 Pré-Lançamento
- [ ] Beta testing com usuários reais
- [ ] Coletar feedback
- [ ] Ajustar baseado no feedback
- [ ] Marketing e comunicação

### 14.2 Lançamento
- [ ] Go live em produção
- [ ] Monitorar erros
- [ ] Suporte ativo
- [ ] Coletar métricas

### 14.3 Pós-Lançamento
- [ ] Análise de métricas
- [ ] Plano de melhorias
- [ ] Roadmap futuro

---

## 🔮 Roadmap Futuro (Pós v1.0)

### Features Futuras
- [ ] App Mobile (React Native)
- [ ] Sistema de afiliados
- [ ] Rifas recorrentes
- [ ] Múltiplos prêmios
- [ ] Rifas em equipe
- [ ] Sistema de vouchers/cupons
- [ ] Integração com redes sociais
- [ ] Live streaming dos sorteios
- [ ] Gamificação
- [ ] Programa de fidelidade

### Melhorias Técnicas
- [ ] Migração para microserviços
- [ ] Implementar Event Sourcing
- [ ] GraphQL API
- [ ] WebSockets para atualizações em tempo real
- [ ] Machine Learning para detecção de fraudes
- [ ] CDN para imagens
- [ ] Database replication

---

## 📝 Notas

### Convenções
- ✅ = Concluído
- ⏳ = Em andamento
- ⚠️ = Bloqueado/Com problema
- [ ] = Pendente

### Prioridades
- 🔴 Alta
- 🟡 Média
- 🟢 Baixa

### Última Revisão
- **Data:** 01/10/2025
- **Revisor:** Moacir Ferreira
- **Versão do Documento:** 1.0

---

**Atualize este documento conforme o progresso do projeto!**


