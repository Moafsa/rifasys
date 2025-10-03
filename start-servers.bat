@echo off
REM Rifassys - Start Servers Script for Windows
REM This script starts all Docker containers for the Rifassys platform

echo ========================================
echo   RIFASSYS - Starting Docker Services
echo ========================================
echo.

REM Check if Docker is running
docker info >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERROR] Docker is not running!
    echo Please start Docker Desktop and try again.
    pause
    exit /b 1
)

echo [OK] Docker is running
echo.

REM Check if .env file exists
if not exist .env (
    echo [WARNING] .env file not found!
    echo Creating .env from .env.example...
    copy .env.example .env >nul
    echo [OK] .env file created
    echo Please edit the .env file with your configurations
    echo.
)

REM Stop any running containers
echo [INFO] Stopping existing containers...
docker-compose down >nul 2>&1
echo [OK] Previous containers stopped
echo.

REM Build and start containers
echo [INFO] Building and starting containers...
docker-compose up -d --build

if %errorlevel% neq 0 (
    echo.
    echo [ERROR] Failed to start containers!
    pause
    exit /b 1
)

echo.
echo [OK] All containers started successfully!
echo.

REM Wait for database to be ready
echo [INFO] Waiting for database to be ready...
timeout /t 5 /nobreak >nul
echo [OK] Database should be ready
echo.

REM Check if vendor directory exists
if not exist vendor (
    echo [INFO] Installing Composer dependencies...
    docker-compose exec -T app composer install
    echo [OK] Composer dependencies installed
    echo.
)

REM Check if node_modules exists
if not exist node_modules (
    echo [INFO] Installing NPM dependencies...
    docker-compose exec -T app npm install
    echo [OK] NPM dependencies installed
    echo.
)

REM Check if APP_KEY is set
findstr /C:"APP_KEY=base64:" .env >nul
if %errorlevel% neq 0 (
    echo [INFO] Generating application key...
    docker-compose exec -T app php artisan key:generate
    echo [OK] Application key generated
    echo.
)

REM Run migrations if needed
echo [INFO] Running database migrations...
docker-compose exec -T app php artisan migrate --force
echo [OK] Migrations completed
echo.

REM Display running containers
echo ========================================
echo   RUNNING SERVICES
echo ========================================
docker-compose ps
echo.

REM Display access information
echo ========================================
echo   ACCESS INFORMATION
echo ========================================
echo.
echo  Frontend:  http://localhost:8080
echo  Dashboard: http://localhost:8080/dashboard
echo  Admin:     http://localhost:8080/admin
echo  Wuzapi:    http://localhost:8081
echo.
echo ========================================
echo   USEFUL COMMANDS
echo ========================================
echo.
echo  View logs:          docker-compose logs -f app
echo  Stop servers:       docker-compose down
echo  Restart servers:    docker-compose restart
echo  Access shell:       docker-compose exec app bash
echo  Run artisan:        docker-compose exec app php artisan [command]
echo.
echo ========================================
echo   STATUS: READY!
echo ========================================
echo.

pause


