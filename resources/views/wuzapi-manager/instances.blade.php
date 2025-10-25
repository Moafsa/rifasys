@extends('layouts.app')

@section('title', 'Instâncias - WuzAPI Manager')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-server text-primary"></i>
                        Instâncias WuzAPI
                    </h1>
                    <p class="text-muted">Gerencie suas instâncias do WhatsApp</p>
                </div>
                <div>
                    <a href="{{ route('wuzapi-manager.instances.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Nova Instância
                    </a>
                    <a href="{{ route('wuzapi-manager.dashboard') }}" class="btn btn-outline-primary ml-2">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Instances Table -->
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
                                <th>Webhooks</th>
                                <th>Mensagens</th>
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
                                        <span class="badge badge-info">{{ $instance->webhook_logs_count }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">{{ $instance->message_logs_count }}</span>
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
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Ver Detalhes">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-success" 
                                                    onclick="testConnection({{ $instance->id }})"
                                                    title="Testar Conexão">
                                                <i class="fas fa-sync"></i>
                                            </button>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('wuzapi-manager.instances.webhook-logs', $instance) }}">
                                                        <i class="fas fa-list"></i> Logs de Webhook
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('wuzapi-manager.instances.message-logs', $instance) }}">
                                                        <i class="fas fa-paper-plane"></i> Logs de Mensagens
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('wuzapi-manager.instances.analytics', $instance) }}">
                                                        <i class="fas fa-chart-bar"></i> Analytics
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-danger" 
                                                       href="#" 
                                                       onclick="deleteInstance({{ $instance->id }})">
                                                        <i class="fas fa-trash"></i> Excluir
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $instances->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-server fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">Nenhuma instância encontrada</h4>
                    <p class="text-muted">Crie sua primeira instância para começar a usar o WuzAPI</p>
                    <a href="{{ route('wuzapi-manager.instances.create') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-plus"></i> Criar Primeira Instância
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir esta instância?</p>
                <p class="text-danger"><strong>Esta ação não pode ser desfeita!</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function testConnection(instanceId) {
    const button = event.target.closest('button');
    const originalIcon = button.innerHTML;
    
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    button.disabled = true;
    
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
    })
    .finally(() => {
        button.innerHTML = originalIcon;
        button.disabled = false;
    });
}

function deleteInstance(instanceId) {
    const form = document.getElementById('deleteForm');
    form.action = `/wuzapi-manager/instances/${instanceId}`;
    $('#deleteModal').modal('show');
}
</script>
@endsection
