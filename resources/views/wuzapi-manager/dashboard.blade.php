@extends('layouts.app')

@section('title', 'WuzAPI Manager - Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fab fa-whatsapp text-success"></i>
                        WuzAPI Manager
                    </h1>
                    <p class="text-muted">Gerencie suas instâncias do WhatsApp</p>
                </div>
                <div>
                    <a href="{{ route('wuzapi-manager.instructions') }}" class="btn btn-info mr-2">
                        <i class="fas fa-question-circle"></i> Como Usar
                    </a>
                    <a href="{{ route('wuzapi-manager.instances.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Nova Instância
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $stats['total_instances'] }}</h4>
                            <p class="mb-0">Total de Instâncias</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-server fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $stats['active_instances'] }}</h4>
                            <p class="mb-0">Instâncias Ativas</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $stats['total_messages_today'] }}</h4>
                            <p class="mb-0">Mensagens Hoje</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-paper-plane fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $stats['successful_messages_today'] }}</h4>
                            <p class="mb-0">Enviadas com Sucesso</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-thumbs-up fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Instances List -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Suas Instâncias</h5>
                </div>
                <div class="card-body">
                    @if($instances->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Status</th>
                                        <th>Telefone</th>
                                        <th>Última Conexão</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($instances as $instance)
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong>{{ $instance->name }}</strong>
                                                    @if($instance->description)
                                                        <br><small class="text-muted">{{ $instance->description }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge {{ $instance->getStatusBadgeClass() }}">
                                                    {{ ucfirst($instance->getConnectionStatus()) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($instance->phone_number)
                                                    <i class="fab fa-whatsapp text-success"></i>
                                                    {{ $instance->phone_number }}
                                                @else
                                                    <span class="text-muted">Não conectado</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($instance->last_connected_at)
                                                    {{ $instance->last_connected_at->diffForHumans() }}
                                                @else
                                                    <span class="text-muted">Nunca</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('wuzapi-manager.instances.show', $instance) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-outline-success" 
                                                            onclick="testConnection({{ $instance->id }})">
                                                        <i class="fas fa-sync"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-server fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Nenhuma instância encontrada</h5>
                            <p class="text-muted">Crie sua primeira instância para começar</p>
                            <a href="{{ route('wuzapi-manager.instances.create') }}" class="btn btn-success">
                                <i class="fas fa-plus"></i> Criar Instância
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Atividade Recente</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @forelse($recentWebhooks as $webhook)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">
                                            <span class="badge {{ $webhook->getEventTypeBadgeClass() }}">
                                                {{ $webhook->event_type }}
                                            </span>
                                        </h6>
                                        <small class="text-muted">
                                            {{ $webhook->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <span class="badge {{ $webhook->getStatusBadgeClass() }}">
                                        {{ $webhook->status_code ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-3">
                                <i class="fas fa-history fa-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0">Nenhuma atividade recente</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Mensagens Recentes</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @forelse($recentMessages as $message)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">
                                            <i class="fab fa-whatsapp text-success"></i>
                                            {{ $message->phone_number }}
                                        </h6>
                                        <small class="text-muted">
                                            {{ $message->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <span class="badge {{ $message->getStatusBadgeClass() }}">
                                        {{ ucfirst($message->status) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-3">
                                <i class="fas fa-paper-plane fa-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0">Nenhuma mensagem recente</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function testConnection(instanceId) {
    fetch(`/wuzapi-manager/instances/${instanceId}/test-connection`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Teste de conexão realizado com sucesso!');
            location.reload();
        } else {
            alert('Erro no teste de conexão: ' + data.error);
        }
    })
    .catch(error => {
        alert('Erro ao testar conexão: ' + error);
    });
}
</script>
@endsection
