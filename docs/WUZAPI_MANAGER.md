# WuzAPI Manager - Sistema de Gerenciamento

## Visão Geral

O WuzAPI Manager é um sistema completo de gerenciamento de instâncias WuzAPI, similar ao `wuzapidiv.conext.click`, mas específico para o projeto de rifas. Ele permite gerenciar múltiplas instâncias do WhatsApp, monitorar webhooks, logs de mensagens e analytics.

## Funcionalidades

### 🏠 **Dashboard Principal**
- Visão geral de todas as instâncias
- Estatísticas em tempo real
- Atividade recente
- Status de conexão

### 🔧 **Gerenciamento de Instâncias**
- Criar novas instâncias
- Configurar tokens de acesso
- Testar conexões
- Gerenciar configurações
- Excluir instâncias

### 📊 **Monitoramento e Analytics**
- Logs de webhooks
- Logs de mensagens
- Estatísticas de uso
- Gráficos de performance

### 🔗 **Webhook Management**
- Configuração automática de webhooks
- Validação de assinaturas
- Logs detalhados de eventos

## Estrutura do Sistema

### **Modelos**
- `WuzapiInstance` - Instâncias do WuzAPI
- `WuzapiWebhookLog` - Logs de webhooks
- `WuzapiMessageLog` - Logs de mensagens

### **Controllers**
- `WuzapiManagerController` - Controller principal
- `WuzapiInstancePolicy` - Políticas de autorização

### **Views**
- Dashboard principal
- Lista de instâncias
- Criação de instâncias
- Detalhes da instância
- Logs e analytics

## Configuração

### 1. **Executar Migrations**

```bash
php artisan migrate
```

### 2. **Configurar Variáveis de Ambiente**

```env
# WuzAPI Manager Configuration
WUZAPI_MANAGER_URL=https://wuzapidiv.conext.click
WUZAPI_MANAGER_TOKEN=your_manager_token
WUZAPI_MANAGER_INSTANCE_ID=your_instance_id
WUZAPI_MANAGER_WEBHOOK_SECRET=your_webhook_secret
```

### 3. **Acessar o Sistema**

```
https://seudominio.com/wuzapi-manager
```

## Uso do Sistema

### **Criando uma Nova Instância**

1. Acesse `/wuzapi-manager/instances/create`
2. Preencha os dados:
   - Nome da instância
   - Token de acesso
   - URL do webhook
   - Chave secreta
3. Clique em "Criar Instância"

### **Testando Conexão**

1. Na lista de instâncias, clique no botão de teste
2. O sistema verificará a conexão
3. Se conectado, mostrará o QR code para WhatsApp

### **Enviando Mensagens de Teste**

1. Acesse os detalhes da instância
2. Use a seção "Teste de Mensagens"
3. Escolha o tipo de mensagem
4. Envie para um número de teste

## API Endpoints

### **Instâncias**
- `GET /wuzapi-manager/instances` - Listar instâncias
- `POST /wuzapi-manager/instances` - Criar instância
- `GET /wuzapi-manager/instances/{id}` - Ver instância
- `DELETE /wuzapi-manager/instances/{id}` - Excluir instância

### **Testes**
- `GET /wuzapi-manager/instances/{id}/test-connection` - Testar conexão
- `POST /wuzapi-manager/instances/{id}/test-message` - Enviar mensagem de teste

### **Logs e Analytics**
- `GET /wuzapi-manager/instances/{id}/webhook-logs` - Logs de webhook
- `GET /wuzapi-manager/instances/{id}/message-logs` - Logs de mensagens
- `GET /wuzapi-manager/instances/{id}/analytics` - Analytics

## Integração com Rifas

### **Notificações Automáticas**
- Confirmação de compras
- Notificações de sorteio
- Avisos para ganhadores
- Lembretes de rifas

### **Webhooks Personalizados**
- Eventos específicos de rifas
- Processamento de respostas
- Integração com sistema de pagamentos

## Segurança

### **Autenticação**
- Login obrigatório para acessar
- Políticas de autorização por usuário
- Tokens seguros para API

### **Validação de Webhooks**
- Assinatura HMAC obrigatória
- Validação de IP (opcional)
- Rate limiting automático

## Monitoramento

### **Health Checks**
- Verificação automática de conexão
- Alertas por email
- Logs de erro detalhados

### **Métricas**
- Taxa de sucesso das mensagens
- Tempo de resposta
- Uso de webhooks
- Performance geral

## Troubleshooting

### **Problemas Comuns**

1. **Instância não conecta**
   - Verificar token de acesso
   - Confirmar URL do WuzAPI
   - Verificar logs de erro

2. **Webhooks não funcionam**
   - Verificar URL do webhook
   - Confirmar chave secreta
   - Verificar logs de webhook

3. **Mensagens não são enviadas**
   - Verificar status da instância
   - Confirmar número de telefone
   - Verificar logs de mensagem

### **Logs Importantes**
- `storage/logs/laravel.log` - Logs gerais
- `wuzapi_webhook_logs` - Logs de webhook
- `wuzapi_message_logs` - Logs de mensagens

## Desenvolvimento

### **Adicionando Novos Tipos de Mensagem**
1. Atualizar `WuzapiService`
2. Adicionar método no controller
3. Criar interface na view

### **Personalizando Analytics**
1. Modificar queries no controller
2. Atualizar views de analytics
3. Adicionar novos gráficos

## Suporte

Para suporte técnico:
- Verificar logs do sistema
- Consultar documentação da WuzAPI
- Verificar configurações de rede
- Testar com instâncias simples

## Roadmap

### **Próximas Funcionalidades**
- [ ] Interface de chat em tempo real
- [ ] Templates de mensagens
- [ ] Agendamento de mensagens
- [ ] Integração com CRM
- [ ] Relatórios avançados
- [ ] API pública
- [ ] Webhooks personalizados
- [ ] Integração com outros serviços
