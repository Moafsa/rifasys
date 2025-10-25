@extends('layouts.app')

@section('title', 'WuzAPI Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fab fa-whatsapp text-success"></i>
                        WuzAPI Dashboard
                    </h3>
                </div>
                <div class="card-body">
                    <!-- Connection Status -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">Status da Conexão</h5>
                                    <div id="connection-status">
                                        @if($isConnected)
                                            <span class="badge badge-success">Conectado</span>
                                        @else
                                            <span class="badge badge-danger">Desconectado</span>
                                        @endif
                                    </div>
                                    <button class="btn btn-sm btn-primary mt-2" onclick="testConnection()">
                                        <i class="fas fa-sync"></i> Testar Conexão
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">QR Code</h5>
                                    <div id="qr-code-container">
                                        @if($qrCode)
                                            <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code" class="img-fluid" style="max-width: 200px;">
                                        @else
                                            <p class="text-muted">QR Code não disponível</p>
                                        @endif
                                    </div>
                                    <button class="btn btn-sm btn-info mt-2" onclick="refreshQRCode()">
                                        <i class="fas fa-qrcode"></i> Atualizar QR
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Test Messages -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Teste de Mensagens</h5>
                                </div>
                                <div class="card-body">
                                    <form id="test-message-form">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="test-phone">Telefone (formato: 5511999999999)</label>
                                                    <input type="text" class="form-control" id="test-phone" placeholder="5511999999999" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="test-message">Mensagem</label>
                                                    <input type="text" class="form-control" id="test-message" placeholder="Mensagem de teste" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <button type="submit" class="btn btn-success btn-block">
                                                        <i class="fas fa-paper-plane"></i> Enviar Mensagem
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Test Raffle Messages -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Teste de Mensagens de Rifas</h5>
                                </div>
                                <div class="card-body">
                                    <form id="test-raffle-form">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="raffle-phone">Telefone</label>
                                                    <input type="text" class="form-control" id="raffle-phone" placeholder="5511999999999" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="raffle-type">Tipo de Mensagem</label>
                                                    <select class="form-control" id="raffle-type" required>
                                                        <option value="verification">Verificação</option>
                                                        <option value="help">Ajuda</option>
                                                        <option value="menu">Menu</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <button type="submit" class="btn btn-warning btn-block">
                                                        <i class="fas fa-ticket-alt"></i> Enviar Mensagem de Rifa
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Configuration Info -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Informações de Configuração</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>Configuração Atual:</h6>
                                            <ul class="list-unstyled">
                                                <li><strong>URL:</strong> {{ config('services.wuzapi.url') }}</li>
                                                <li><strong>Token:</strong> {{ config('services.wuzapi.api_token') ? 'Configurado' : 'Não configurado' }}</li>
                                                <li><strong>Instance ID:</strong> {{ config('services.wuzapi.instance_id') ?: 'Não configurado' }}</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Webhook:</h6>
                                            <ul class="list-unstyled">
                                                <li><strong>URL:</strong> {{ config('services.wuzapi.webhook_url') }}</li>
                                                <li><strong>Secret:</strong> {{ config('services.wuzapi.webhook_secret') ? 'Configurado' : 'Não configurado' }}</li>
                                            </ul>
                                            <button class="btn btn-sm btn-info" onclick="checkWebhookStatus()">
                                                <i class="fas fa-link"></i> Verificar Webhook
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function testConnection() {
    fetch('/admin/wuzapi/test-connection')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const statusElement = document.getElementById('connection-status');
                if (data.connected) {
                    statusElement.innerHTML = '<span class="badge badge-success">Conectado</span>';
                } else {
                    statusElement.innerHTML = '<span class="badge badge-danger">Desconectado</span>';
                }
                alert('Teste de conexão realizado com sucesso!');
            } else {
                alert('Erro no teste de conexão: ' + data.error);
            }
        })
        .catch(error => {
            alert('Erro ao testar conexão: ' + error);
        });
}

function refreshQRCode() {
    fetch('/admin/wuzapi/qr-code')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.qr_code) {
                const qrContainer = document.getElementById('qr-code-container');
                qrContainer.innerHTML = `<img src="data:image/png;base64,${data.qr_code}" alt="QR Code" class="img-fluid" style="max-width: 200px;">`;
            } else {
                alert('QR Code não disponível');
            }
        })
        .catch(error => {
            alert('Erro ao obter QR code: ' + error);
        });
}

function checkWebhookStatus() {
    fetch('/admin/wuzapi/webhook-status')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Webhook configurado corretamente!');
            } else {
                alert('Erro na configuração do webhook: ' + data.message);
            }
        })
        .catch(error => {
            alert('Erro ao verificar webhook: ' + error);
        });
}

// Test message form
document.getElementById('test-message-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const phone = document.getElementById('test-phone').value;
    const message = document.getElementById('test-message').value;
    
    fetch('/admin/wuzapi/test-message', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ phone, message })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Mensagem enviada com sucesso!');
        } else {
            alert('Erro ao enviar mensagem: ' + data.message);
        }
    })
    .catch(error => {
        alert('Erro ao enviar mensagem: ' + error);
    });
});

// Test raffle form
document.getElementById('test-raffle-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const phone = document.getElementById('raffle-phone').value;
    const type = document.getElementById('raffle-type').value;
    
    fetch('/admin/wuzapi/test-raffle-message', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ phone, type })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Mensagem de rifa enviada com sucesso!');
        } else {
            alert('Erro ao enviar mensagem de rifa: ' + data.message);
        }
    })
    .catch(error => {
        alert('Erro ao enviar mensagem de rifa: ' + error);
    });
});
</script>
@endsection
