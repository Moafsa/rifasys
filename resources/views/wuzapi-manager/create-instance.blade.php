@extends('layouts.app')

@section('title', 'Criar Nova Instância - WuzAPI Manager')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus-circle text-success"></i>
                        Criar Nova Instância
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('wuzapi-manager.instances.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nome da Instância *</label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           placeholder="Ex: Rifa Principal"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="api_token">Token de Acesso *</label>
                                    <input type="text" 
                                           class="form-control @error('api_token') is-invalid @enderror" 
                                           id="api_token" 
                                           name="api_token" 
                                           value="{{ old('api_token') }}" 
                                           placeholder="Seu token de acesso"
                                           required>
                                    @error('api_token')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Token usado para autenticar suas requisições à API
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Descrição</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3" 
                                      placeholder="Descrição opcional da instância">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="webhook_url">URL do Webhook</label>
                                    <input type="url" 
                                           class="form-control @error('webhook_url') is-invalid @enderror" 
                                           id="webhook_url" 
                                           name="webhook_url" 
                                           value="{{ old('webhook_url', config('app.url') . '/api/webhooks/whatsapp') }}" 
                                           placeholder="https://seudominio.com/api/webhooks/whatsapp">
                                    @error('webhook_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        URL para receber eventos do WhatsApp
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="webhook_secret">Chave Secreta do Webhook</label>
                                    <input type="text" 
                                           class="form-control @error('webhook_secret') is-invalid @enderror" 
                                           id="webhook_secret" 
                                           name="webhook_secret" 
                                           value="{{ old('webhook_secret') }}" 
                                           placeholder="Sua chave secreta">
                                    @error('webhook_secret')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Chave para validar a autenticidade dos webhooks
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Advanced Settings -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h6 class="card-title mb-0">
                                    <a data-toggle="collapse" href="#advancedSettings" role="button" aria-expanded="false">
                                        <i class="fas fa-cog"></i> Configurações Avançadas
                                    </a>
                                </h6>
                            </div>
                            <div class="collapse" id="advancedSettings">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="timeout">Timeout (segundos)</label>
                                                <input type="number" 
                                                       class="form-control" 
                                                       id="timeout" 
                                                       name="timeout" 
                                                       value="30" 
                                                       min="5" 
                                                       max="300">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="retry_attempts">Tentativas de Retry</label>
                                                <input type="number" 
                                                       class="form-control" 
                                                       id="retry_attempts" 
                                                       name="retry_attempts" 
                                                       value="3" 
                                                       min="1" 
                                                       max="10">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="rate_limit">Limite de Taxa (msg/min)</label>
                                                <input type="number" 
                                                       class="form-control" 
                                                       id="rate_limit" 
                                                       name="rate_limit" 
                                                       value="100" 
                                                       min="1" 
                                                       max="1000">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="auto_connect" 
                                       name="auto_connect" 
                                       value="1" 
                                       checked>
                                <label class="form-check-label" for="auto_connect">
                                    Conectar automaticamente após criação
                                </label>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-plus"></i> Criar Instância
                            </button>
                            <a href="{{ route('wuzapi-manager.dashboard') }}" class="btn btn-secondary ml-2">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Card -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-question-circle text-info"></i> Como obter o Token de Acesso?
                    </h6>
                </div>
                <div class="card-body">
                    <ol>
                        <li>Acesse o painel do WuzAPI Manager</li>
                        <li>Faça login com suas credenciais</li>
                        <li>Vá para a seção "API Tokens"</li>
                        <li>Clique em "Gerar Novo Token"</li>
                        <li>Copie o token gerado e cole no campo acima</li>
                    </ol>
                    <div class="alert alert-info mt-3">
                        <i class="fas fa-info-circle"></i>
                        <strong>Dica:</strong> Mantenha seu token seguro e não o compartilhe com terceiros.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
