@extends('layouts.app')

@section('content')
<!-- Header Section -->
<section class="relative gradient-purple-blue py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6">
                Métodos de Pagamento
            </h1>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                Escolha como deseja pagar pelos seus números da rifa
            </p>
        </div>
    </div>
</section>

<!-- Payment Methods -->
<section class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Purchase Summary -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Resumo da Compra</h2>
                
                <!-- Raffle Info -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $raffle->title }}</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Números selecionados:</span>
                            <span class="font-semibold text-gray-900">{{ count($pendingPurchase['selected_numbers']) }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Preço por número:</span>
                            <span class="font-semibold text-gray-900">R$ {{ number_format($raffle->price_per_ticket, 2, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Selected Numbers -->
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-900 mb-3">Seus Números:</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($pendingPurchase['selected_numbers'] as $number)
                            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                                {{ $number }}
                            </span>
                        @endforeach
                    </div>
                </div>
                
                <!-- Total -->
                <div class="border-t border-gray-200 pt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-semibold text-gray-900">Total:</span>
                        <span class="text-3xl font-bold text-purple-600">
                            R$ {{ number_format($pendingPurchase['total_price'], 2, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Payment Methods -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Escolha o Método de Pagamento</h2>
                
                <form id="paymentForm" class="space-y-4">
                    @csrf
                    
                    <!-- PIX Payment -->
                    <div class="payment-method-option border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-purple-500 transition-colors" 
                         data-method="pix">
                        <div class="flex items-center gap-4">
                            <input type="radio" name="payment_method" value="pix" id="pix" class="sr-only">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <span class="text-2xl">🏦</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900">PIX</h3>
                                <p class="text-gray-600 text-sm">Pagamento instantâneo via PIX</p>
                            </div>
                            <div class="text-right">
                                <span class="text-sm text-gray-500">Sem taxas</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Credit Card Payment -->
                    <div class="payment-method-option border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-purple-500 transition-colors" 
                         data-method="credit_card">
                        <div class="flex items-center gap-4">
                            <input type="radio" name="payment_method" value="credit_card" id="credit_card" class="sr-only">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <span class="text-2xl">💳</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900">Cartão de Crédito</h3>
                                <p class="text-gray-600 text-sm">Visa, Mastercard, Elo</p>
                            </div>
                            <div class="text-right">
                                <span class="text-sm text-gray-500">Taxa: 2.5%</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Button -->
                    <button type="submit" id="payButton" 
                            class="w-full bg-gradient-to-r from-purple-500 to-blue-500 text-white py-4 rounded-lg font-semibold hover:from-purple-600 hover:to-blue-600 transition-all duration-300 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled>
                        <span id="payButtonText">Selecione um método de pagamento</span>
                    </button>
                </form>
                
                <!-- Security Info -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex items-center gap-3 text-sm text-gray-600 mb-2">
                        <span class="text-green-500">🔒</span>
                        <span>Pagamento 100% seguro</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-600">
                        <span class="text-blue-500">⚡</span>
                        <span>Processamento instantâneo</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentOptions = document.querySelectorAll('.payment-method-option');
    const payButton = document.getElementById('payButton');
    const payButtonText = document.getElementById('payButtonText');
    const paymentForm = document.getElementById('paymentForm');

    // Handle payment method selection
    paymentOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove active class from all options
            paymentOptions.forEach(opt => {
                opt.classList.remove('border-purple-500', 'bg-purple-50');
                opt.classList.add('border-gray-200');
            });
            
            // Add active class to selected option
            this.classList.remove('border-gray-200');
            this.classList.add('border-purple-500', 'bg-purple-50');
            
            // Select radio button
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;
            
            // Update button
            const method = this.dataset.method;
            if (method === 'pix') {
                payButtonText.textContent = 'Pagar com PIX';
                payButton.disabled = false;
            } else if (method === 'credit_card') {
                payButtonText.textContent = 'Pagar com Cartão';
                payButton.disabled = false;
            }
        });
    });

    // Handle form submission
    paymentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        // Show loading state
        payButton.disabled = true;
        payButtonText.innerHTML = '<span class="animate-spin">⏳</span> Processando pagamento...';
        
        // Submit payment
        fetch('{{ route("payment.process") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (window.showNotification) {
                    showNotification(data.message, 'success');
                } else {
                    alert(data.message);
                }
                
                // Redirect to success page
                if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                }
            } else {
                if (window.showNotification) {
                    showNotification(data.error || 'Erro ao processar pagamento', 'error');
                } else {
                    alert(data.error || 'Erro ao processar pagamento');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (window.showNotification) {
                showNotification('Erro ao processar pagamento', 'error');
            } else {
                alert('Erro ao processar pagamento');
            }
        })
        .finally(() => {
            // Restore button state
            payButton.disabled = false;
            const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
            if (selectedMethod) {
                if (selectedMethod.value === 'pix') {
                    payButtonText.textContent = 'Pagar com PIX';
                } else if (selectedMethod.value === 'credit_card') {
                    payButtonText.textContent = 'Pagar com Cartão';
                }
            }
        });
    });
});
</script>
@endsection
