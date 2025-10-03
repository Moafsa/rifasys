# Plataforma de Rifas Solidárias Inteligente - Plano de Desenvolvimento

**Versão:** 1.0  
**Data:** 01 de outubro de 2025  
**Stack Tecnológica:** Laravel (PHP) + PostgreSQL + Tailwind CSS + Docker + Wuzapi

---

## 📋 Sumário Executivo

Sistema SaaS completo para criação e gerenciamento de rifas online com foco em causas sociais. A plataforma oferece fluxos financeiros distintos para CPF (custódia) e CNPJ (split payment), com uso intensivo de IA para automação e conformidade legal.

### Tecnologias Principais
- **Backend:** Laravel 11.x (PHP 8.3+)
- **Banco de Dados:** PostgreSQL 16
- **Frontend:** Blade + Alpine.js + Tailwind CSS 3.x
- **Mensageria:** Wuzapi (WhatsApp API Open Source)
- **Pagamentos:** Asaas API
- **IA:** OpenAI GPT-4 API
- **Infraestrutura:** Docker + Docker Compose

---

## 🎯 FASE 1: Preparação e Estrutura Inicial (Semana 1-2)

### Passo 1.1: Configuração do Ambiente Docker

**Objetivo:** Criar ambiente de desenvolvimento isolado e replicável.

#### Arquivos a Criar:

**1.1.1. `docker-compose.yml` (Raiz do Projeto)**
```yaml
version: '3.8'

services:
  # PostgreSQL Database
  postgres:
    image: postgres:16-alpine
    container_name: rifassys_postgres
    restart: unless-stopped
    environment:
      POSTGRES_DB: ${DB_DATABASE}
      POSTGRES_USER: ${DB_USERNAME}
      POSTGRES_PASSWORD: ${DB_PASSWORD}
    volumes:
      - postgres_data:/var/lib/postgresql/data
    ports:
      - "${DB_PORT:-5432}:5432"
    networks:
      - rifassys_network

  # Laravel Application
  app:
    build:
      context: .
      dockerfile: docker/Dockerfile
    container_name: rifassys_app
    restart: unless-stopped
    working_dir: /var/www
    volumes:
      - ./:/var/www
      - ./docker/php/local.ini:/usr/local/etc/php/conf.d/local.ini
    environment:
      - PHP_IDE_CONFIG=serverName=rifassys
    depends_on:
      - postgres
      - redis
    networks:
      - rifassys_network

  # Nginx Web Server
  nginx:
    image: nginx:alpine
    container_name: rifassys_nginx
    restart: unless-stopped
    ports:
      - "${APP_PORT:-8080}:80"
    volumes:
      - ./:/var/www
      - ./docker/nginx/conf.d:/etc/nginx/conf.d
    depends_on:
      - app
    networks:
      - rifassys_network

  # Redis Cache & Queue
  redis:
    image: redis:alpine
    container_name: rifassys_redis
    restart: unless-stopped
    ports:
      - "${REDIS_PORT:-6379}:6379"
    networks:
      - rifassys_network

  # Wuzapi WhatsApp API
  wuzapi:
    image: revolucent/wuzapi:latest
    container_name: rifassys_wuzapi
    restart: unless-stopped
    ports:
      - "${WUZAPI_PORT:-8081}:8081"
    volumes:
      - wuzapi_data:/app/data
    environment:
      - WUZAPI_PORT=8081
    networks:
      - rifassys_network

  # Laravel Queue Worker
  queue:
    build:
      context: .
      dockerfile: docker/Dockerfile
    container_name: rifassys_queue
    restart: unless-stopped
    working_dir: /var/www
    volumes:
      - ./:/var/www
    command: php artisan queue:work --tries=3
    depends_on:
      - postgres
      - redis
    networks:
      - rifassys_network

  # Laravel Scheduler (Cron)
  scheduler:
    build:
      context: .
      dockerfile: docker/Dockerfile
    container_name: rifassys_scheduler
    restart: unless-stopped
    working_dir: /var/www
    volumes:
      - ./:/var/www
    command: sh -c "while true; do php artisan schedule:run --verbose --no-interaction & sleep 60; done"
    depends_on:
      - postgres
      - redis
    networks:
      - rifassys_network

networks:
  rifassys_network:
    driver: bridge

volumes:
  postgres_data:
  wuzapi_data:
```

**1.1.2. `docker/Dockerfile`**
```dockerfile
FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    libzip-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user
RUN useradd -G www-data,root -u 1000 -d /home/rifassys rifassys
RUN mkdir -p /home/rifassys/.composer && \
    chown -R rifassys:rifassys /home/rifassys

# Set user
USER rifassys

# Expose port 9000
EXPOSE 9000

CMD ["php-fpm"]
```

**1.1.3. `docker/nginx/conf.d/app.conf`**
```nginx
server {
    listen 80;
    index index.php index.html;
    error_log  /var/log/nginx/error.log;
    access_log /var/log/nginx/access.log;
    root /var/www/public;

    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass app:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
    }

    location / {
        try_files $uri $uri/ /index.php?$query_string;
        gzip_static on;
    }
}
```

**1.1.4. `docker/php/local.ini`**
```ini
upload_max_filesize=40M
post_max_size=40M
memory_limit=512M
max_execution_time=600
```

**1.1.5. `.env.example`**
```env
# Application
APP_NAME="Rifas Solidárias"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8080
APP_PORT=8080

# Database
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=rifassys
DB_USERNAME=rifassys_user
DB_PASSWORD=rifassys_secure_password

# Cache & Queue
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

# Redis
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

# Wuzapi WhatsApp API
WUZAPI_URL=http://wuzapi:8081
WUZAPI_PORT=8081

# Asaas Payment Gateway
ASAAS_API_URL=https://sandbox.asaas.com/api/v3
ASAAS_API_KEY=your_asaas_api_key_here
ASAAS_ENVIRONMENT=sandbox

# OpenAI API
OPENAI_API_KEY=your_openai_api_key_here
OPENAI_MODEL=gpt-4

# Mail
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@rifassys.com"
MAIL_FROM_NAME="${APP_NAME}"
```

**1.1.6. `.dockerignore`**
```
.git
.env
node_modules
vendor
storage/logs/*
storage/framework/cache/*
storage/framework/sessions/*
storage/framework/views/*
bootstrap/cache/*
```

---

### Passo 1.2: Instalação do Laravel

**Comandos para execução:**

```bash
# 1. Criar diretório do projeto (se ainda não existir)
mkdir rifassys
cd rifassys

# 2. Instalar Laravel via Composer (sem Docker ainda)
composer create-project laravel/laravel .

# 3. Copiar arquivos Docker criados no passo 1.1

# 4. Configurar .env
cp .env.example .env

# 5. Iniciar containers Docker
docker-compose up -d

# 6. Instalar dependências dentro do container
docker-compose exec app composer install

# 7. Gerar chave da aplicação
docker-compose exec app php artisan key:generate

# 8. Rodar migrations
docker-compose exec app php artisan migrate

# 9. Instalar Node.js dependencies (para Tailwind)
docker-compose exec app npm install

# 10. Compilar assets
docker-compose exec app npm run dev
```

---

### Passo 1.3: Instalação de Pacotes Essenciais

**1.3.1. Pacotes Laravel (Composer)**

```bash
# Autenticação e autorização
docker-compose exec app composer require laravel/breeze --dev
docker-compose exec app php artisan breeze:install blade

# Slugs para URLs amigáveis
docker-compose exec app composer require spatie/laravel-sluggable

# Permissões e Roles (ACL)
docker-compose exec app composer require spatie/laravel-permission

# API HTTP Client (para Asaas e OpenAI)
docker-compose exec app composer require guzzlehttp/guzzle

# Geração de QR Code PIX
docker-compose exec app composer require mpdf/qrcode

# Laravel IDE Helper (desenvolvimento)
docker-compose exec app composer require --dev barryvdh/laravel-ide-helper

# Laravel Debugbar (desenvolvimento)
docker-compose exec app composer require --dev barryvdh/laravel-debugbar

# Formatação de datas em português
docker-compose exec app composer require nesbot/carbon

# UUID para identificadores únicos
docker-compose exec app composer require ramsey/uuid
```

**1.3.2. Pacotes Frontend (NPM)**

```bash
# Tailwind CSS já vem com Breeze, mas adicionar plugins úteis
docker-compose exec app npm install -D @tailwindcss/forms @tailwindcss/typography @tailwindcss/aspect-ratio

# Alpine.js (já vem com Breeze)

# Chart.js para gráficos do dashboard
docker-compose exec app npm install chart.js

# SweetAlert2 para modais bonitos
docker-compose exec app npm install sweetalert2

# Bibliotecas utilitárias
docker-compose exec app npm install axios lodash
```

---

## 🗄️ FASE 2: Modelagem do Banco de Dados (Semana 2-3)

### Passo 2.1: Estrutura de Entidades e Relacionamentos

**Principais Entidades:**

1. **users** - Usuários da plataforma (organizadores)
2. **user_profiles** - Perfil estendido (CPF/CNPJ)
3. **raffles** - Rifas criadas
4. **raffle_numbers** - Números de cada rifa
5. **raffle_purchases** - Compras realizadas
6. **raffle_participants** - Participantes (compradores)
7. **raffle_winners** - Ganhadores dos sorteios
8. **transactions** - Transações financeiras
9. **delivery_confirmations** - Confirmações de entrega (CPF)
10. **chatbot_conversations** - Histórico do chatbot
11. **ai_generated_contents** - Conteúdos gerados pela IA
12. **admin_exceptions** - Exceções para ação manual

---

### Passo 2.2: Migrations do Banco de Dados

**2.2.1. Migration: Create Users Table (já existe, modificar)**

```bash
docker-compose exec app php artisan make:migration modify_users_table --table=users
```

```php
// database/migrations/XXXX_XX_XX_modify_users_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('document_type')->after('email'); // CPF or CNPJ
            $table->string('document_number')->unique()->after('document_type');
            $table->string('phone')->nullable()->after('document_number');
            $table->enum('status', ['pending', 'active', 'suspended', 'blocked'])->default('pending');
            $table->boolean('is_admin')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'document_type',
                'document_number',
                'phone',
                'status',
                'is_admin',
                'verified_at'
            ]);
            $table->dropSoftDeletes();
        });
    }
};
```

**2.2.2. Migration: Create User Profiles Table**

```bash
docker-compose exec app php artisan make:migration create_user_profiles_table
```

```php
// database/migrations/XXXX_XX_XX_create_user_profiles_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // CPF Data
            $table->string('cpf')->nullable()->unique();
            $table->string('pix_key')->nullable();
            $table->enum('pix_key_type', ['cpf', 'email', 'phone', 'random'])->nullable();
            
            // CNPJ Data
            $table->string('cnpj')->nullable()->unique();
            $table->string('company_name')->nullable();
            $table->string('trading_name')->nullable();
            $table->string('asaas_wallet_id')->nullable();
            $table->string('asaas_account_id')->nullable();
            
            // Address
            $table->string('zip_code')->nullable();
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city')->nullable();
            $table->string('state', 2)->nullable();
            
            // Additional Info
            $table->text('logo_url')->nullable();
            $table->text('description')->nullable();
            $table->json('social_links')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
```

**2.2.3. Migration: Create Raffles Table**

```bash
docker-compose exec app php artisan make:migration create_raffles_table
```

```php
// database/migrations/XXXX_XX_XX_create_raffles_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raffles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('prize_description');
            
            // Images & Media
            $table->json('images')->nullable(); // Array of image URLs
            $table->string('featured_image')->nullable();
            $table->string('video_url')->nullable();
            
            // Numbers Configuration
            $table->integer('total_numbers');
            $table->decimal('number_price', 10, 2);
            $table->integer('min_numbers_per_purchase')->default(1);
            $table->integer('max_numbers_per_purchase')->default(10);
            
            // Draw Configuration
            $table->timestamp('draw_date');
            $table->string('draw_type')->default('automatic'); // automatic, manual
            $table->string('lottery_reference')->nullable(); // e.g., "federal", "mega-sena"
            
            // Regulation & Terms
            $table->longText('regulation')->nullable();
            $table->boolean('regulation_ai_generated')->default(false);
            
            // Status & Control
            $table->enum('status', [
                'draft',
                'active',
                'completed',
                'drawn',
                'prize_delivered',
                'cancelled'
            ])->default('draft');
            
            $table->timestamp('published_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('drawn_at')->nullable();
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            
            // Stats (cache)
            $table->integer('sold_numbers_count')->default(0);
            $table->integer('participants_count')->default(0);
            $table->decimal('total_revenue', 12, 2)->default(0);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('status');
            $table->index('draw_date');
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raffles');
    }
};
```

**2.2.4. Migration: Create Raffle Numbers Table**

```bash
docker-compose exec app php artisan make:migration create_raffle_numbers_table
```

```php
// database/migrations/XXXX_XX_XX_create_raffle_numbers_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raffle_numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raffle_id')->constrained()->onDelete('cascade');
            $table->foreignId('raffle_purchase_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('number');
            $table->enum('status', ['available', 'reserved', 'sold'])->default('available');
            $table->timestamp('reserved_at')->nullable();
            $table->timestamp('sold_at')->nullable();
            $table->boolean('is_winner')->default(false);
            
            $table->timestamps();
            
            // Indexes
            $table->unique(['raffle_id', 'number']);
            $table->index(['raffle_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raffle_numbers');
    }
};
```

**2.2.5. Migration: Create Raffle Participants Table**

```bash
docker-compose exec app php artisan make:migration create_raffle_participants_table
```

```php
// database/migrations/XXXX_XX_XX_create_raffle_participants_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raffle_participants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cpf');
            $table->string('phone');
            $table->string('email')->nullable();
            
            $table->timestamps();
            
            // Index for quick lookups
            $table->index('cpf');
            $table->index('phone');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raffle_participants');
    }
};
```

**2.2.6. Migration: Create Raffle Purchases Table**

```bash
docker-compose exec app php artisan make:migration create_raffle_purchases_table
```

```php
// database/migrations/XXXX_XX_XX_create_raffle_purchases_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raffle_purchases', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('raffle_id')->constrained()->onDelete('cascade');
            $table->foreignId('raffle_participant_id')->constrained()->onDelete('cascade');
            
            // Purchase Details
            $table->json('numbers'); // Array of selected numbers
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_amount', 10, 2);
            
            // Payment
            $table->enum('payment_status', [
                'pending',
                'reserved',
                'confirmed',
                'failed',
                'refunded'
            ])->default('pending');
            
            $table->string('payment_method')->default('pix');
            $table->string('asaas_payment_id')->nullable()->unique();
            $table->text('pix_qrcode')->nullable();
            $table->text('pix_qrcode_image')->nullable();
            $table->string('pix_key')->nullable();
            
            // Timestamps for payment flow
            $table->timestamp('payment_confirmed_at')->nullable();
            $table->timestamp('payment_expires_at')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('payment_status');
            $table->index(['raffle_id', 'payment_status']);
            $table->index('asaas_payment_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raffle_purchases');
    }
};
```

**2.2.7. Migration: Create Raffle Winners Table**

```bash
docker-compose exec app php artisan make:migration create_raffle_winners_table
```

```php
// database/migrations/XXXX_XX_XX_create_raffle_winners_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raffle_winners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raffle_id')->constrained()->onDelete('cascade');
            $table->foreignId('raffle_participant_id')->constrained()->onDelete('cascade');
            $table->foreignId('raffle_number_id')->constrained()->onDelete('cascade');
            
            $table->integer('winning_number');
            $table->timestamp('drawn_at');
            
            // Prize Delivery (for CPF raffles)
            $table->enum('delivery_status', [
                'pending',
                'marked_as_delivered',
                'confirmed_by_winner',
                'disputed',
                'completed'
            ])->default('pending');
            
            $table->timestamp('marked_delivered_at')->nullable();
            $table->timestamp('winner_confirmed_at')->nullable();
            $table->text('delivery_notes')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->unique('raffle_id'); // One winner per raffle
            $table->index('delivery_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raffle_winners');
    }
};
```

**2.2.8. Migration: Create Transactions Table**

```bash
docker-compose exec app php artisan make:migration create_transactions_table
```

```php
// database/migrations/XXXX_XX_XX_create_transactions_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('raffle_id')->constrained()->onDelete('cascade');
            $table->foreignId('raffle_purchase_id')->constrained()->onDelete('cascade');
            
            $table->enum('type', ['payment', 'refund', 'split', 'custody_release']);
            $table->decimal('amount', 12, 2);
            $table->decimal('net_amount', 12, 2); // Amount after fees
            $table->decimal('platform_fee', 10, 2)->default(0);
            $table->decimal('gateway_fee', 10, 2)->default(0);
            
            // Status
            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'failed',
                'refunded',
                'held' // For CPF custody
            ])->default('pending');
            
            // External References
            $table->string('asaas_transaction_id')->nullable();
            $table->string('asaas_split_id')->nullable();
            
            // For CPF: money held until delivery confirmation
            $table->boolean('is_held')->default(false);
            $table->timestamp('held_until')->nullable();
            $table->timestamp('released_at')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'status']);
            $table->index(['raffle_id', 'status']);
            $table->index('asaas_transaction_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
```

**2.2.9. Migration: Create Delivery Confirmations Table**

```bash
docker-compose exec app php artisan make:migration create_delivery_confirmations_table
```

```php
// database/migrations/XXXX_XX_XX_create_delivery_confirmations_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_confirmations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raffle_winner_id')->constrained()->onDelete('cascade');
            $table->foreignId('raffle_id')->constrained()->onDelete('cascade');
            
            // WhatsApp Confirmation Flow
            $table->string('confirmation_token')->unique();
            $table->string('whatsapp_message_id')->nullable();
            $table->enum('status', [
                'pending',
                'message_sent',
                'message_failed',
                'confirmed',
                'denied',
                'expired',
                'escalated'
            ])->default('pending');
            
            $table->timestamp('message_sent_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('denied_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            
            // Winner Response
            $table->text('winner_response')->nullable();
            $table->text('denial_reason')->nullable();
            
            // Retry Logic
            $table->integer('attempts')->default(0);
            $table->timestamp('last_attempt_at')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('confirmation_token');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_confirmations');
    }
};
```

**2.2.10. Migration: Create Chatbot Conversations Table**

```bash
docker-compose exec app php artisan make:migration create_chatbot_conversations_table
```

```php
// database/migrations/XXXX_XX_XX_create_chatbot_conversations_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chatbot_conversations', function (Blueprint $table) {
            $table->id();
            $table->uuid('session_id')->index();
            $table->foreignId('raffle_id')->nullable()->constrained()->onDelete('cascade');
            
            $table->string('visitor_ip')->nullable();
            $table->string('visitor_identifier')->nullable(); // Can be email, phone, etc.
            
            $table->enum('message_type', ['user', 'bot']);
            $table->text('message');
            $table->text('bot_response')->nullable();
            
            // AI Context
            $table->json('context')->nullable(); // Store conversation context
            $table->string('intent')->nullable(); // Detected intent
            $table->decimal('confidence_score', 5, 2)->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['session_id', 'created_at']);
            $table->index('raffle_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chatbot_conversations');
    }
};
```

**2.2.11. Migration: Create AI Generated Contents Table**

```bash
docker-compose exec app php artisan make:migration create_ai_generated_contents_table
```

```php
// database/migrations/XXXX_XX_XX_create_ai_generated_contents_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_generated_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('raffle_id')->nullable()->constrained()->onDelete('cascade');
            
            $table->enum('content_type', [
                'regulation',
                'description',
                'meta_description',
                'social_media_post',
                'email_template'
            ]);
            
            $table->text('prompt_used');
            $table->longText('generated_content');
            $table->longText('final_content')->nullable(); // After user edits
            
            $table->string('ai_model')->default('gpt-4');
            $table->integer('tokens_used')->nullable();
            $table->decimal('generation_cost', 8, 4)->nullable();
            
            $table->boolean('was_edited')->default(false);
            $table->boolean('is_active')->default(false);
            
            $table->timestamps();
            
            // Indexes
            $table->index(['raffle_id', 'content_type']);
            $table->index('content_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_generated_contents');
    }
};
```

**2.2.12. Migration: Create Admin Exceptions Table**

```bash
docker-compose exec app php artisan make:migration create_admin_exceptions_table
```

```php
// database/migrations/XXXX_XX_XX_create_admin_exceptions_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_exceptions', function (Blueprint $table) {
            $table->id();
            $table->enum('exception_type', [
                'delivery_confirmation_failed',
                'delivery_disputed',
                'payment_issue',
                'refund_request',
                'user_complaint',
                'technical_error'
            ]);
            
            $table->enum('severity', ['low', 'medium', 'high', 'critical'])->default('medium');
            
            // Related Entities
            $table->foreignId('raffle_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('raffle_winner_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('delivery_confirmation_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('title');
            $table->text('description');
            $table->json('metadata')->nullable(); // Additional context data
            
            // Resolution
            $table->enum('status', [
                'open',
                'in_progress',
                'resolved',
                'closed',
                'escalated'
            ])->default('open');
            
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->text('resolution_notes')->nullable();
            $table->timestamp('resolved_at')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['status', 'severity']);
            $table->index('exception_type');
            $table->index(['raffle_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_exceptions');
    }
};
```

**2.2.13. Migration: Create Activity Log Table (Auditoria)**

```bash
docker-compose exec app php artisan make:migration create_activity_log_table
```

```php
// database/migrations/XXXX_XX_XX_create_activity_log_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_log', function (Blueprint $table) {
            $table->id();
            $table->string('log_name')->nullable();
            $table->text('description');
            $table->nullableMorphs('subject', 'subject');
            $table->nullableMorphs('causer', 'causer');
            $table->json('properties')->nullable();
            $table->string('event')->nullable();
            $table->timestamp('created_at');
            
            $table->index('log_name');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_log');
    }
};
```

---

### Passo 2.3: Executar Migrations

```bash
# Executar todas as migrations
docker-compose exec app php artisan migrate

# Se precisar reverter
docker-compose exec app php artisan migrate:rollback

# Resetar completamente (CUIDADO!)
docker-compose exec app php artisan migrate:fresh
```

---

## 🏗️ FASE 3: Arquitetura Backend - Models e Relationships (Semana 3-4)

### Passo 3.1: Criar Models com Eloquent

**3.1.1. Model: User**

```bash
# O model User já existe, vamos modificá-lo
```

```php
// app/Models/User.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'document_type',
        'document_number',
        'phone',
        'status',
        'is_admin',
        'verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    // Relationships
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function raffles()
    {
        return $this->hasMany(Raffle::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCpf($query)
    {
        return $query->where('document_type', 'CPF');
    }

    public function scopeCnpj($query)
    {
        return $query->where('document_type', 'CNPJ');
    }

    // Accessors & Mutators
    public function isCpf(): bool
    {
        return $this->document_type === 'CPF';
    }

    public function isCnpj(): bool
    {
        return $this->document_type === 'CNPJ';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
```

**3.1.2. Model: UserProfile**

```bash
docker-compose exec app php artisan make:model UserProfile
```

```php
// app/Models/UserProfile.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'cpf',
        'pix_key',
        'pix_key_type',
        'cnpj',
        'company_name',
        'trading_name',
        'asaas_wallet_id',
        'asaas_account_id',
        'zip_code',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'logo_url',
        'description',
        'social_links',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getFullAddressAttribute(): string
    {
        return "{$this->street}, {$this->number} - {$this->neighborhood}, {$this->city}/{$this->state}";
    }

    public function hasAsaasIntegration(): bool
    {
        return !empty($this->asaas_wallet_id) && !empty($this->asaas_account_id);
    }

    public function hasPixKey(): bool
    {
        return !empty($this->pix_key);
    }
}
```

**3.1.3. Model: Raffle**

```bash
docker-compose exec app php artisan make:model Raffle
```

```php
// app/Models/Raffle.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Raffle extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'prize_description',
        'images',
        'featured_image',
        'video_url',
        'total_numbers',
        'number_price',
        'min_numbers_per_purchase',
        'max_numbers_per_purchase',
        'draw_date',
        'draw_type',
        'lottery_reference',
        'regulation',
        'regulation_ai_generated',
        'status',
        'published_at',
        'completed_at',
        'drawn_at',
        'meta_title',
        'meta_description',
        'sold_numbers_count',
        'participants_count',
        'total_revenue',
    ];

    protected $casts = [
        'images' => 'array',
        'draw_date' => 'datetime',
        'published_at' => 'datetime',
        'completed_at' => 'datetime',
        'drawn_at' => 'datetime',
        'regulation_ai_generated' => 'boolean',
        'number_price' => 'decimal:2',
        'total_revenue' => 'decimal:2',
    ];

    // Sluggable
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function numbers()
    {
        return $this->hasMany(RaffleNumber::class);
    }

    public function purchases()
    {
        return $this->hasMany(RafflePurchase::class);
    }

    public function winner()
    {
        return $this->hasOne(RaffleWinner::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function chatbotConversations()
    {
        return $this->hasMany(ChatbotConversation::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('draw_date', '>', now());
    }

    // Accessors & Methods
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function hasBeenDrawn(): bool
    {
        return !is_null($this->drawn_at);
    }

    public function getAvailableNumbersCount(): int
    {
        return $this->numbers()->where('status', 'available')->count();
    }

    public function getSoldNumbersCount(): int
    {
        return $this->numbers()->where('status', 'sold')->count();
    }

    public function getProgressPercentage(): float
    {
        if ($this->total_numbers == 0) return 0;
        return ($this->sold_numbers_count / $this->total_numbers) * 100;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
```

**3.1.4. Model: RaffleNumber**

```bash
docker-compose exec app php artisan make:model RaffleNumber
```

```php
// app/Models/RaffleNumber.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaffleNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'raffle_id',
        'raffle_purchase_id',
        'number',
        'status',
        'reserved_at',
        'sold_at',
        'is_winner',
    ];

    protected $casts = [
        'reserved_at' => 'datetime',
        'sold_at' => 'datetime',
        'is_winner' => 'boolean',
    ];

    // Relationships
    public function raffle()
    {
        return $this->belongsTo(Raffle::class);
    }

    public function purchase()
    {
        return $this->belongsTo(RafflePurchase::class, 'raffle_purchase_id');
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeSold($query)
    {
        return $query->where('status', 'sold');
    }

    public function scopeReserved($query)
    {
        return $query->where('status', 'reserved');
    }

    // Methods
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isSold(): bool
    {
        return $this->status === 'sold';
    }

    public function reserve(): void
    {
        $this->update([
            'status' => 'reserved',
            'reserved_at' => now(),
        ]);
    }

    public function markAsSold(): void
    {
        $this->update([
            'status' => 'sold',
            'sold_at' => now(),
        ]);
    }
}
```

**3.1.5. Model: RaffleParticipant**

```bash
docker-compose exec app php artisan make:model RaffleParticipant
```

```php
// app/Models/RaffleParticipant.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaffleParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cpf',
        'phone',
        'email',
    ];

    // Relationships
    public function purchases()
    {
        return $this->hasMany(RafflePurchase::class);
    }

    public function wins()
    {
        return $this->hasMany(RaffleWinner::class);
    }

    // Methods
    public function getFormattedPhoneAttribute(): string
    {
        // Format: (XX) XXXXX-XXXX
        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        if (strlen($phone) === 11) {
            return '(' . substr($phone, 0, 2) . ') ' . 
                   substr($phone, 2, 5) . '-' . 
                   substr($phone, 7);
        }
        return $this->phone;
    }

    public function getFormattedCpfAttribute(): string
    {
        // Format: XXX.XXX.XXX-XX
        $cpf = preg_replace('/[^0-9]/', '', $this->cpf);
        if (strlen($cpf) === 11) {
            return substr($cpf, 0, 3) . '.' . 
                   substr($cpf, 3, 3) . '.' . 
                   substr($cpf, 6, 3) . '-' . 
                   substr($cpf, 9);
        }
        return $this->cpf;
    }
}
```

**Continuando com os demais Models...**

Por questões de espaço, vou resumir os próximos models com suas estruturas principais. Você pode criar cada um seguindo o padrão acima.

**3.1.6. Model: RafflePurchase**
**3.1.7. Model: RaffleWinner**
**3.1.8. Model: Transaction**
**3.1.9. Model: DeliveryConfirmation**
**3.1.10. Model: ChatbotConversation**
**3.1.11. Model: AiGeneratedContent**
**3.1.12. Model: AdminException**

---

## 🔐 FASE 4: Autenticação e Autorização (Semana 4-5)

### Passo 4.1: Configurar Laravel Breeze

```bash
# Já instalado no Passo 1.3.1
docker-compose exec app php artisan breeze:install blade
docker-compose exec app npm install
docker-compose exec app npm run build
```

### Passo 4.2: Configurar Spatie Permissions

```bash
# Publicar configuração
docker-compose exec app php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

# Rodar migrations do pacote
docker-compose exec app php artisan migrate
```

### Passo 4.3: Criar Seeder de Roles e Permissions

```bash
docker-compose exec app php artisan make:seeder RolesAndPermissionsSeeder
```

```php
// database/seeders/RolesAndPermissionsSeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Raffle permissions
            'create raffles',
            'edit raffles',
            'delete raffles',
            'view raffles',
            'manage own raffles',
            
            // Purchase permissions
            'view purchases',
            'refund purchases',
            
            // Financial permissions
            'view financial reports',
            'manage transactions',
            
            // Admin permissions
            'access admin panel',
            'manage users',
            'manage all raffles',
            'resolve exceptions',
            'view system logs',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $organizer = Role::create(['name' => 'organizer']);
        $organizer->givePermissionTo([
            'create raffles',
            'edit raffles',
            'delete raffles',
            'view raffles',
            'manage own raffles',
            'view purchases',
            'view financial reports',
        ]);

        $viewer = Role::create(['name' => 'viewer']);
        $viewer->givePermissionTo([
            'view raffles',
            'view purchases',
        ]);
    }
}
```

```bash
# Executar seeder
docker-compose exec app php artisan db:seed --class=RolesAndPermissionsSeeder
```

---

## 🎨 FASE 5: Frontend - Layout e Componentes Base (Semana 5-6)

### Passo 5.1: Configurar Tailwind CSS

O Tailwind já vem configurado com Breeze, mas vamos customizar.

```javascript
// tailwind.config.js
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import aspectRatio from '@tailwindcss/aspect-ratio';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.blade.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'agro-green': {
                    50: '#f0fdf4',
                    100: '#dcfce7',
                    200: '#bbf7d0',
                    300: '#86efac',
                    400: '#4ade80',
                    500: '#22c55e',
                    600: '#16a34a',
                    700: '#15803d',
                    800: '#166534',
                    900: '#14532d',
                    950: '#052e16',
                },
            },
        },
    },

    plugins: [forms, typography, aspectRatio],
};
```

### Passo 5.2: Criar Layout Principal

```blade
{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Rifas Solidárias') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="bg-green-50 border-l-4 border-green-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="bg-red-50 border-l-4 border-red-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{ $slot }}
        </main>

        <!-- Footer -->
        @include('layouts.footer')
    </div>

    @stack('scripts')
</body>
</html>
```

---

## 🔌 FASE 6: Integrações com Serviços Externos (Semana 6-8)

### Passo 6.1: Integração com Asaas (Pagamentos)

```bash
docker-compose exec app php artisan make:service AsaasService
```

```php
// app/Services/AsaasService.php
<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class AsaasService
{
    protected Client $client;
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.asaas.api_key');
        $this->baseUrl = config('services.asaas.url');
        
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'access_token' => $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * Create PIX payment
     */
    public function createPixPayment(array $data): ?array
    {
        try {
            $response = $this->client->post('/payments', [
                'json' => [
                    'customer' => $data['customer'],
                    'billingType' => 'PIX',
                    'value' => $data['value'],
                    'dueDate' => $data['dueDate'],
                    'description' => $data['description'],
                    'externalReference' => $data['externalReference'] ?? null,
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('Asaas PIX Payment Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get PIX QR Code
     */
    public function getPixQrCode(string $paymentId): ?array
    {
        try {
            $response = $this->client->get("/payments/{$paymentId}/pixQrCode");
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('Asaas Get QR Code Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create customer
     */
    public function createCustomer(array $data): ?array
    {
        try {
            $response = $this->client->post('/customers', [
                'json' => $data,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('Asaas Create Customer Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Check payment status
     */
    public function getPaymentStatus(string $paymentId): ?array
    {
        try {
            $response = $this->client->get("/payments/{$paymentId}");
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('Asaas Payment Status Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create split payment for CNPJ
     */
    public function createSplitPayment(array $data): ?array
    {
        try {
            $response = $this->client->post('/payments', [
                'json' => array_merge($data, [
                    'split' => [
                        [
                            'walletId' => $data['walletId'],
                            'fixedValue' => $data['organizerAmount'],
                        ],
                    ],
                ]),
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('Asaas Split Payment Error: ' . $e->getMessage());
            return null;
        }
    }
}
```

### Passo 6.2: Integração com Wuzapi (WhatsApp)

```bash
docker-compose exec app php artisan make:service WuzapiService
```

```php
// app/Services/WuzapiService.php
<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class WuzapiService
{
    protected Client $client;
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.wuzapi.url');
        
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * Send text message
     */
    public function sendMessage(string $phone, string $message): ?array
    {
        try {
            $response = $this->client->post('/api/send-message', [
                'json' => [
                    'phone' => $this->formatPhone($phone),
                    'message' => $message,
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('Wuzapi Send Message Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Send message with buttons (delivery confirmation)
     */
    public function sendButtonMessage(string $phone, string $message, array $buttons): ?array
    {
        try {
            $response = $this->client->post('/api/send-buttons', [
                'json' => [
                    'phone' => $this->formatPhone($phone),
                    'message' => $message,
                    'buttons' => $buttons,
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('Wuzapi Send Button Message Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Check connection status
     */
    public function getConnectionStatus(): ?array
    {
        try {
            $response = $this->client->get('/api/connection-status');
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('Wuzapi Connection Status Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Format phone number for WhatsApp (55DDD9XXXXXXXX)
     */
    protected function formatPhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Add country code if not present
        if (!str_starts_with($phone, '55')) {
            $phone = '55' . $phone;
        }
        
        return $phone;
    }
}
```

### Passo 6.3: Integração com OpenAI (IA)

```bash
docker-compose exec app php artisan make:service OpenAIService
```

```php
// app/Services/OpenAIService.php
<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    protected Client $client;
    protected string $apiKey;
    protected string $model;

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
        $this->model = config('services.openai.model', 'gpt-4');
        
        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Generate raffle regulation
     */
    public function generateRegulation(array $raffleData): ?string
    {
        $prompt = $this->buildRegulationPrompt($raffleData);
        
        return $this->completion($prompt);
    }

    /**
     * Chatbot response
     */
    public function chatbotResponse(string $userMessage, array $context = []): ?string
    {
        $systemPrompt = $this->buildChatbotSystemPrompt($context);
        
        return $this->chatCompletion($systemPrompt, $userMessage);
    }

    /**
     * Generic completion
     */
    public function completion(string $prompt, int $maxTokens = 2000): ?string
    {
        try {
            $response = $this->client->post('chat/completions', [
                'json' => [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'max_tokens' => $maxTokens,
                    'temperature' => 0.7,
                ],
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result['choices'][0]['message']['content'] ?? null;
        } catch (GuzzleException $e) {
            Log::error('OpenAI Completion Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Chat completion with system prompt
     */
    public function chatCompletion(string $systemPrompt, string $userMessage): ?string
    {
        try {
            $response = $this->client->post('chat/completions', [
                'json' => [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userMessage],
                    ],
                    'max_tokens' => 1000,
                    'temperature' => 0.8,
                ],
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result['choices'][0]['message']['content'] ?? null;
        } catch (GuzzleException $e) {
            Log::error('OpenAI Chat Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Build regulation prompt
     */
    protected function buildRegulationPrompt(array $data): string
    {
        return <<<EOT
Você é um especialista em legislação brasileira de rifas e sorteios. Gere um regulamento completo e juridicamente válido para uma rifa com as seguintes informações:

Título: {$data['title']}
Descrição do Prêmio: {$data['prize_description']}
Quantidade de Números: {$data['total_numbers']}
Valor por Número: R$ {$data['number_price']}
Data do Sorteio: {$data['draw_date']}
Organizador: {$data['organizer_name']} ({$data['document_type']}: {$data['document_number']})

O regulamento deve incluir:
1. Identificação do organizador
2. Descrição detalhada do prêmio
3. Regras de participação
4. Forma de sorteio
5. Prazo de validade
6. Responsabilidades
7. Disposições gerais
8. Base legal (Lei nº 5.768/71 e decretos relacionados)

Formate o texto de forma profissional e clara.
EOT;
    }

    /**
     * Build chatbot system prompt
     */
    protected function buildChatbotSystemPrompt(array $context): string
    {
        $contextInfo = '';
        
        if (!empty($context['raffle'])) {
            $raffle = $context['raffle'];
            $contextInfo = <<<EOT
Informações sobre a rifa:
- Título: {$raffle['title']}
- Prêmio: {$raffle['prize_description']}
- Valor do número: R$ {$raffle['number_price']}
- Data do sorteio: {$raffle['draw_date']}
- Total de números: {$raffle['total_numbers']}
- Números vendidos: {$raffle['sold_numbers_count']}
EOT;
        }

        return <<<EOT
Você é um assistente virtual especializado em rifas solidárias. Seu objetivo é ajudar os visitantes a entender como funciona a plataforma e responder dúvidas sobre rifas específicas.

{$contextInfo}

Diretrizes:
- Seja amigável, claro e objetivo
- Responda em português brasileiro
- Se não souber a resposta, seja honesto e sugira entrar em contato com o suporte
- Incentive a participação em causas sociais
- Explique os processos de forma simples

Nunca forneça informações sobre pagamentos sensíveis ou dados pessoais de outros participantes.
EOT;
    }
}
```

---

## 📊 FASE 7: Lógica de Negócio Core (Semana 8-11)

### Passo 7.1: Controller - Raffle Management

```bash
docker-compose exec app php artisan make:controller RaffleController --resource
```

### Passo 7.2: Controller - Purchase Flow

```bash
docker-compose exec app php artisan make:controller PurchaseController
```

### Passo 7.3: Jobs para Processamento Assíncrono

```bash
# Job para processar pagamento confirmado
docker-compose exec app php artisan make:job ProcessConfirmedPayment

# Job para executar sorteio automático
docker-compose exec app php artisan make:job ExecuteRaffleDraw

# Job para enviar confirmação de entrega via WhatsApp
docker-compose exec app php artisan make:job SendDeliveryConfirmation

# Job para liberar fundos após confirmação (CPF)
docker-compose exec app php artisan make:job ReleaseCustodyFunds
```

### Passo 7.4: Commands para Tarefas Agendadas

```bash
# Command para verificar e executar sorteios pendentes
docker-compose exec app php artisan make:command DrawPendingRaffles

# Command para expirar reservas de números
docker-compose exec app php artisan make:command ExpireReservedNumbers

# Command para verificar pagamentos pendentes
docker-compose exec app php artisan make:command CheckPendingPayments
```

---

## 🎯 FASE 8: Páginas Públicas (Semana 11-13)

### Passo 8.1: Home Page (/)
### Passo 8.2: Raffle Landing Page (/rifa/{slug})
### Passo 8.3: Checkout Modal com PIX
### Passo 8.4: Chatbot Integration

---

## 🎛️ FASE 9: Dashboard do Organizador (Semana 13-15)

### Passo 9.1: Dashboard Principal
### Passo 9.2: Gerenciamento de Rifas
### Passo 9.3: Criação de Rifas (Wizard com IA)
### Passo 9.4: Lista de Clientes
### Passo 9.5: Relatórios Financeiros
### Passo 9.6: Gestão de Entrega (CPF)

---

## 👨‍💼 FASE 10: Painel Administrativo (Semana 15-16)

### Passo 10.1: Dashboard Admin
### Passo 10.2: Gerenciamento de Usuários
### Passo 10.3: Supervisão de Rifas
### Passo 10.4: Sistema de Exceções

---

## ✅ FASE 11: Testes e Validação (Semana 16-17)

### Passo 11.1: Testes Unitários
### Passo 11.2: Testes de Integração
### Passo 11.3: Testes End-to-End
### Passo 11.4: Validação de Segurança

---

## 🚀 FASE 12: Deploy e Produção (Semana 18)

### Passo 12.1: Preparar para Produção
### Passo 12.2: Configurar Coolify
### Passo 12.3: Deploy Inicial
### Passo 12.4: Monitoramento e Logs

---

## 📈 Análise de Escalabilidade e Manutenibilidade

### Pontos Fortes da Arquitetura:

1. **Separação de Responsabilidades**: Models, Services, Jobs e Controllers bem definidos
2. **Processamento Assíncrono**: Uso de queues para operações pesadas
3. **Cache e Performance**: Redis para cache e sessões
4. **Banco de Dados Robusto**: PostgreSQL com índices otimizados
5. **Containerização**: Docker facilita deploy e escalabilidade horizontal

### Possíveis Melhorias Futuras:

1. **Load Balancer**: Para múltiplas instâncias do app
2. **CDN**: Para assets estáticos e imagens
3. **Database Replication**: Read replicas para queries pesadas
4. **Microserviços**: Separar IA e WhatsApp em serviços independentes
5. **Event Sourcing**: Para auditoria completa de transações financeiras
6. **API REST/GraphQL**: Para futuras integrações (app mobile, parceiros)

---

## 🔒 Considerações de Segurança

1. **Sanitização de Inputs**: Validação rigorosa em todos os formulários
2. **CSRF Protection**: Tokens CSRF em todas as requisições POST
3. **Rate Limiting**: Limitar tentativas de compra e API calls
4. **Criptografia**: Dados sensíveis criptografados no banco
5. **HTTPS**: Obrigatório em produção
6. **Logs de Auditoria**: Rastreamento de todas as ações críticas
7. **Backup Automático**: Backup diário do banco de dados
8. **2FA para Admin**: Autenticação de dois fatores para administradores

---

## 📝 Próximos Passos Recomendados

1. **Iniciar com a Fase 1**: Montar ambiente Docker completo
2. **Validar Integrações**: Testar Asaas e Wuzapi em sandbox
3. **Desenvolver MVP**: Focar primeiro no fluxo completo de uma rifa CPF
4. **Iterar com Feedback**: Testar com usuários reais antes de expandir
5. **Documentar APIs**: Documentação Swagger/OpenAPI para integrações futuras

---

**Documento criado em:** 01/10/2025  
**Última atualização:** 01/10/2025  
**Autor:** CONEXT Development Team


